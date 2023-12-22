document.addEventListener('DOMContentLoaded', function () {
    var container = document.getElementById('mynetwork');
    var nodes = new vis.DataSet();
    var edges = new vis.DataSet();

    var options = {
        layout: {
            hierarchical: {
                direction: 'UD', // From Up to Down
                sortMethod: 'directed', // Ensures it's a directed graph
                levelSeparation: 150,
            }
        },
        edges: {
            arrows: 'to'
        },
        physics: false // Disable physics for static tree layout
    };

    var network = new vis.Network(container, { nodes, edges }, options);
    nodeTracker = {};
    // Start with the final course, which will appear at the bottom
    getPrerequisites('CIS*2750', nodes, edges);
});

function addNode(courseData, nodes) {
    const nodeId = courseData.courseCode;
    if (!nodeTracker[nodeId]) {
        nodes.add({
            id: nodeId,
            label: `${courseData.courseCode}\n${courseData.courseName}`,
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
        // if(courseData.courseCode === 'CIS*3750'){
        //     console.log(courseData);
        // }

        const nodeId = courseData.courseCode;
        // console.log(courseData);
        addNode(courseData, nodes);

        if (childNodeId) {
            edges.add({ from: nodeId, to: childNodeId });
        }


        const courseSubject = courseCode.match(/^[a-zA-Z]*/)[0];
        // console.log(courseSubject);

        for (let prerequisiteOption of courseData.prerequisites) {
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
                        await getPrerequisites(cleanPrerequisite, nodes, edges, nodeId);
                    } else{
                        // We add the edge even if the node was already processed because this is a new relationship
                        edges.add({ from: cleanPrerequisite, to: nodeId });
                        //edges.add({ from: cleanPrerequisite, to: childNodeId });
                    }
                }
            }
        }

    } catch (error) {
        console.error('Fetching prerequisites failed:', error);
    }
}