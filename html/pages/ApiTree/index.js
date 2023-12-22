const api_url = window.location.href.replace(/\/pages\/.*/, '/api/'); // Get url of api directory

function htmlTitle(html) {
 const container = document.createElement("div");
 container.innerHTML = html;
 return container;
}

const subjectsEndpoint = `${api_url}getSubjects/getSubjects.php`;
const getEndpoint = `${api_url}Course/Course.php`;

async function getSubjects() {
 const response = await fetch(subjectsEndpoint, {
     method: "GET",
     mode: "cors",
     headers: {
         "Content-Type": "application/json"
     }
 });
 return response.json();
}

document.addEventListener("DOMContentLoaded", function () {
 const homeBtn = document.getElementById("redirectHome");
 let dropdownMenu = document.querySelector(".dropdown-Subject");
 let dropdownButton = document.querySelector("#dropdownMenuButton");
 let selectedSubjectContainer = document.querySelector("#selectedSubjectContainer");
 let treeContainer = document.querySelector("#treeContainer");
 let networkContainer = document.querySelector("#mynetwork");
 let header = document.querySelector(".header");

 let nodes = new vis.DataSet();
 let edges = new vis.DataSet();
 let network;

 // home page redirect
 homeBtn?.addEventListener("click", () => {
    const urlHome = window.location.href.replace(/\/pages\/.*/, ''); // Get url of api directory
    homeBtn.href = urlHome;
 });

 // List of Subjects listener
 dropdownButton.addEventListener("click", async function () {
     // Toggle the display of the dropdown menuP
     dropdownMenu.style.display = dropdownMenu.style.display === 'none' ? 'block' : 'none';
     
     // Clear existing items before fetching new ones
     dropdownMenu.innerHTML = "";

     const data = await getSubjects();

     data.forEach(subject => {
         const dropdownItem = document.createElement("div");
         dropdownItem.classList.add("dropdown-item");
         dropdownItem.textContent = subject.Subject;

         // Selected course listener
         dropdownItem.addEventListener("click", async function () {
            const selectedSubjectParas = [...document.getElementsByClassName("SelectedSubjectPara")];
            selectedSubjectParas.forEach((selectedSubjectPara) => selectedSubjectPara.remove());

             const selectedSubjectPara = document.createElement("p");
             selectedSubjectPara.className = "SelectedSubjectPara";

             selectedSubjectPara.innerText = "Selected Subject: " + subject.Subject;
             selectedSubjectPara.style.color = "white";
             header.appendChild(selectedSubjectPara);

             const selectedSubject = subject.Subject;
             const updatedEndpoint = `${getEndpoint}`;
            //  console.log("GET courses:", updatedEndpoint);

             // Fetch courses based on the updated endpoint
             const coursesResponse = await fetch(updatedEndpoint, {
                 method: "POST",
                 mode: "cors",
                 headers: {
                     "Content-Type": "application/json"
                 },
                 body: JSON.stringify({
                    "id": selectedSubject + "*",
                    "preq": true
                 })
             });

             const coursesData = await coursesResponse.json();
             console.log(coursesData);

             // Clear existing nodes and edges
             nodes.clear();
             edges.clear();

             // Add nodes for each course with labels
             coursesData.forEach(course => {
                 nodes.add({ id: course.courseCode, label: course.courseCode, title: `${course.courseName}` });
             });

             coursesData.forEach(course => {
                 if (course.prerequisites != null) {
                     course.prerequisites.forEach(prerequisiteCode => {
                         const courseSubject = prerequisiteCode.match(/^[a-zA-Z]*/)[0]; // regex to match single course
                         if (!courseSubject) { // potential 1 of string
                             var oneOfStr = prerequisiteCode.split(' ');
                             if (oneOfStr[0] === "1") { // checking for 1 of string
                                var oneOfOptions = oneOfStr[4].split(','); // split 1 of string to get prereq options

                                oneOfOptions.forEach(opt => { // loop through all options
                                   const optCourseCode = opt.split('*'); // get course code by splitting string
                                   if (optCourseCode[0] === subject.Subject) { // check if course code matches current subject
                                      edges.add({ from: opt, to: course.courseCode, arrows: 'to' }); // if course code matches then make an edge
                                   }
                                });
                             } 
                             return;
                         }

                         // Check if the prerequisiteCode exists in the coursesData
                         const matchingCourse = coursesData.find(c => c.courseCode === prerequisiteCode);

                         // Use matchingCourse instead of c in the following line
                         if (matchingCourse) {
                             edges.add({ from: matchingCourse.courseCode, to: course.courseCode, arrows: 'to' });
                         } 
                     });
                 }
             });

             const treeData = {
                 nodes: nodes,
                 edges: edges
             };

             let options = {
                 layout: {
                     hierarchical: {
                         direction: "UD",
                         sortMethod: "directed",
                         nodeSpacing: 50,  // Reduce node spacing
                         levelSeparation: 375,  // Reduce level separation
                         blockShifting: true,
                         edgeMinimization: true,
                         nodeSpacing: 85,
                     },
                 },
                 nodes: {
                     shape: 'box',
                     size: 10,
                     font: {
                         size: 10,
                         color: '#000'
                     },
                     widthConstraint: {
                         maximum: 200 // Adjust the maximum width as needed
                     }
                 },
                 edges: {
                     smooth: false,
                     arrows: 'to',
                     color: '#1D75DE',
                 },
                 physics: false,
                 navigationButtons: true,
             };

             network = new vis.Network(networkContainer, treeData, options);

             network.on("selectNode", function (params) {

                 const selectedNodeId = params.nodes[0];

                 nodes.forEach(node => {
                     if (node.id === selectedNodeId) {
                         node.color = { background: '#0b2e58', border: '#0b2e58', highlight: { background: '#0b2e58', border: '#0b2e58' } };
                         node.font = { color: '#ffffff' };
                     } else {
                         node.color = { background: '#ffffff', border: '#ccc', highlight: { background: '#eeeeee', border: '#ccc' } };
                         node.font = { color: '#000' };
                     }
                 });

                 edges.forEach(edge => {
                     if (edge.from === selectedNodeId || edge.to === selectedNodeId) {
                         edge.color = { color: '#0b2e58' };

                         // Color the corresponding nodes as well
                         const connectedNodeId = edge.from === selectedNodeId ? edge.to : edge.from;
                         const connectedNode = nodes.get(connectedNodeId);

                         if (connectedNode) {
                             connectedNode.color = { background: '#0b2e58', border: '#0b2e58', highlight: { background: '#0b2e58', border: '#0b2e58' } };
                             connectedNode.font = { color: '#ffffff' };
                         }
                     } else {
                         edge.color = { color: '#ccc' };
                     }
                 });

                 network.setData({
                     nodes: nodes,
                     edges: edges
                 });

                 
             });
             // Hide the dropdown menu once the user selects a subject
             dropdownMenu.style.display = 'none';
         });

         dropdownMenu.appendChild(dropdownItem);
     });
 });
});