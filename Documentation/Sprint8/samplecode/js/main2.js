document.addEventListener('DOMContentLoaded', async function () {
    var container = document.getElementById('mynetwork');
    var nodes = new vis.DataSet();
    var edges = new vis.DataSet();

    var options = {
        layout: {
            hierarchical: {
                direction: 'UD', // or 'LR' for left-to-right
                sortMethod: 'directed',
                shakeTowards: 'roots',
                levelSeparation: 200, // Increase if nodes are on top of each other
                nodeSpacing: 200,
                treeSpacing: 200
            }
        },
        edges: {
            arrows: 'to'
        },
        physics: {
            enabled: true,
            solver: "forceAtlas2Based",
            stabilization: {
              enabled: false // This is here just to see what's going on from the very beginning.
            }
          },
        interaction: {
            navigationButtons: true,
            keyboard: true
        },
    };

    var network = new vis.Network(container, { nodes, edges }, options);
    nodeTracker = {};
    knownEdges = {};
    const subject = 'CIS'; // Change this to the subject you want to visualize
    await getAllCoursesAndBuildTree(subject, nodes, edges);
    // console.log('testing',edges.get({from: "CIS*3760", to: 'CIS*4820'}))

    
});


async function getAllCoursesAndBuildTree(subject, nodes, edges) {
    // console.log("test\n");
    const response = await fetch(`http://localhost/f23_cis3760_104/html/api/Course/Course.php?id=${subject}*&preq=`);
    const coursesArray = await response.json();

    // Check if the fetched data is an array
    if (!Array.isArray(coursesArray)) {
        console.error('Expected an array of courses, but received:', coursesArray);
        return; // Exit the function if the data is not in the expected format
    }

    // Iterate over the courses and build the tree
    for (const courseData of coursesArray) {
        // if(courseData.courseCode === 'CIS*4820'){
        //     console.log("matches!!!");
        // }
        // Check if the course starts with the subject
        if (courseData.courseCode.startsWith(subject)) {
            // Check if prerequisites is null or an empty array
            if (courseData.prerequisites === null) {
                // Add the course as a root node if it has no prerequisites
                addNode(courseData, nodes);
            } else {
                // Process prerequisites to build the hierarchy
                for (let prerequisiteOption of courseData.prerequisites) {
                    // Ensure prerequisiteOption is a string before attempting to match
                    if (typeof prerequisiteOption === 'string') {
                        const prereqOptions = prerequisiteOption.match(/([a-zA-Z]*\*\d+)/g);
                        if (prereqOptions) {
                            for (const prereq of prereqOptions) {
                                const cleanPrerequisite = prereq.trim();
                                if (cleanPrerequisite.startsWith(subject)) {
                                    // Recursive call to process the matched prerequisite
                                    addNode(courseData,nodes);                                                   // JUST ADDED THISSDSSSSSSSSSSSSSSSS
                                    await getPrerequisites(cleanPrerequisite, nodes, edges, courseData.courseCode);
                                    // if(courseData.courseCode === 'CIS*4820'){
                                    //     console.log("penis poop");
                                    // }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}

function addNode(courseData, nodes) {
    const nodeId = courseData.courseCode;
    if (!nodeTracker[nodeId]) {
        nodes.add({
            id: nodeId,
            label: `${courseData.courseCode}`,
            title: courseData.courseDesc
        });
        nodeTracker[nodeId] = true;
    }
}

async function getPrerequisites(courseCode, nodes, edges, childNodeId = null) {
    try {
        const response = await fetch(`http://localhost/f23_cis3760_104/html/api/Course/Course.php?id=${courseCode}&preq=`);
        const courseDataArray = await response.json();
        // console.log("API Response:", courseDataArray);
        const courseData = courseDataArray[0];

        const response2 = await fetch(`http://localhost/f23_cis3760_104/html/api/Course/Course.php?id=${childNodeId}&preq=`);
        const courseDataArray2 = await response2.json();
        // console.log("API Response:", courseDataArray);
        const courseData2 = courseDataArray2[0];

        const nodeId = courseData.courseCode;
        if(nodeId === 'CIS*4820'){
            console.log("oksdsd");
        }
        // console.log(courseData);
        if(!nodeTracker[nodeId]){

            nodes.add({
                id: nodeId,
                label: `${courseData.courseCode}`,
                title: courseData.courseDesc
            });
            nodeTracker[nodeId] = true;
        }

        // if(!nodeTracker[childNodeId]){
        //     nodes.add({
        //         id: childNodeId,
        //         label: `${courseData2.courseCode}`,
        //         title: courseData2.courseDesc
        //     });
        //     nodeTracker[childNodeId] = true;                       dasadasjdasj JUST COMMENTED THIS OUT
        // }

        if (childNodeId) {

            if(!knownEdges[nodeId]){
                knownEdges[nodeId] = {};
            }
            if(!knownEdges[nodeId][childNodeId]){
            const newEdge = edges.add({ from: nodeId, to: childNodeId });
            knownEdges[nodeId][childNodeId] = String(newEdge[0]);
            }

            // console.log(nodeTracker[nodeId], 'check');
        }

        const courseSubject = courseCode.match(/^[a-zA-Z]*/)[0];

        for (let prerequisiteOption of courseData.prerequisites) {
            // Match all course codes in the prerequisites list
            const prereqOptions = prerequisiteOption.match(/([a-zA-Z]*\*\d+)/g);
    
            if (prereqOptions) {
                // If the prerequisite list starts with a digit and 'of', it's an "n of" list
                const isNOfList = /^\d+ of/.test(prerequisiteOption);
    
                // Find all courses that start with the same subject and are in the "n of" list
                const matchedPrerequisites = prereqOptions.filter(prereq => 
                    prereq.startsWith(courseSubject) && (!isNOfList || prerequisiteOption.includes(prereq))
                );
    
                for (const matchedPrereq of matchedPrerequisites) {
                    const cleanPrerequisite = matchedPrereq.trim();
    
                    // Check if we already added this node to avoid duplicate work
                    if (!nodeTracker[cleanPrerequisite]) {
                        if(nodeId === 'CIS*4820'){
                            console.log('test');
                        }
                        await getPrerequisites(cleanPrerequisite, nodes, edges, nodeId);
                    } else if (!knownEdges[cleanPrerequisite][nodeId]) {
                        // We add the edge even if the node was already processed because this is a new relationship
                        edges.add({ from: cleanPrerequisite, to: nodeId });
                    }
                    
                }
            }
        }
    } catch (error) {
        console.error('Fetching prerequisites failed:', error);
    }
}