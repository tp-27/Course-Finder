<?php
    $url = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Group 104 - Documentation</title>
    <link rel="shortcut icon" type="image/x-icon" href="../../media/favicon.ico"/>

    <!-- <link rel="stylesheet" href="styles.css"> -->
    <style>
      /* Global styles */
      body {
        font-family: Arial, sans-serif;
        margin: 10;
        padding: 0;
      }

      header {
        background-color: #333;
        color: #fff;
        padding: 20px;
      }

      h1 {
        font-size: 30px;
        margin-bottom: 20px;
      }

      main {
        padding: 20px;
      }

      section {
        margin-bottom: 30px;
      }

      h2 {
        font-size: 25px;
        margin: 0 0 15px 0;
      }

      p {
        margin: 0 0 10px 0;
      }

      /* API documentation specific styles */
      code,
      pre {
        font-family: Consolas, monospace;
      }

      pre {
        background-color: #f5f5f5;
        padding: 10px;
        overflow-x: auto;
      }

      .nav {
        height: 150px;
      }

      .nav img {
        margin-left: 70px;
        margin-top: 50px;
      }

      .endpoint {
        margin-bottom: 15px;
        padding: 10px;
        background-color: #f5f5f5;
        border-radius: 5px;
      }

      .endpoint h3 {
        font-size: 18px;
        margin: 0 0 10px 0;
      }

      .endpoint p {
        margin: 0;
      }

      .endpoint.collapsible {
        cursor: pointer;
      }

      .endpoint.collapsed .content {
        display: none;
      }

      .endpoint.collapsible::after {
        content: "▼";
        margin-left: 5px;
      }

      .endpoint.collapsed::after {
        content: "►";
      }

      /* Table of Contents */
      ul {
        list-style-type: none;
        padding-left: 10px;
      }

      ul li {
        margin-bottom: 10px;
      }

      ul li a {
        color: #333;
        text-decoration: none;
      }

      ul li a:hover {
        text-decoration: underline;
      }

      table {
        border-collapse: collapse;
        width: 100%;
      }

      th {
        background-color: #f5f5f5;
        padding: 8px;
        text-align: left;
        font-weight: normal;
        border: 1px solid #ccc;
      }

      td {
        padding: 8px;
        border: 1px solid #ccc;
      }

      img {
        max-width: 500px;
        margin: 50px;
      }
    </style>
  </head>

  <body>
    <header style="display:flex; align-items:center; justify-content: flex-start; gap:25px;">
      <a href="" id="redirectHome"><img src="../../media/backarrow.svg" height="25" width="25"/></a>
      <h1>Group 104 - Documentation</h1>
    </header>
    <main>
      <section id="TableofContents">
        <h1>Table of Contents</h1>
        <hr /><br />

        <p>This documentation covers the following subject areas:</p>
        <ul>
          <li><a href="#API_Endpoints">API Endpoints</a></li>
          <li><a href="#Frontend_Application">Frontend Application</a></li>
          <li><a href="#Prerequisite_Tree">Subject-Based Prerequisite Tree</a></li>
          <li><a href="#Database_Design">Database Design</a></li>
        </ul>
        <hr />
      </section><br/>

      <section id="API_Endpoints">
        <h1>API Endpoints</h1>
        <hr /><br />

        <h1>Course.php</h1><br/>
        <h2>POST</h2>

        <p>
          This endpoint is used by the API Frontend to fetch all of the courses to be displayed in the course selector table 
          for the user to select their courses.
        </p>
        <div class="endpoint collapsible">
          <p>Get All Courses</p><br/>

          <div class="content">
            <code>
              POST <?php echo str_replace('/pages/ApiDoc/', '', $url) . '/api/Course/Course.php' ?>
            </code>

            <br /> <br /> <hr /> <br /> <br />
            <p>Request Body:</p>
            <pre>
              <code>
                {
                  
                }
              </code>
            </pre>

            <br /> <br /> <hr /> <br /> <br />
            <p>The response is an array of course objects from the database: </p>
            <pre>
              <code>
                [
                  {
                    "courseCode": "CIS*1300",
                    "courseName": "Programming",
                    "courseDesc": "  This  course  examines  the  applied  and  conceptual  aspects  of  programming.  Topics  may  include  data  and  control  structures|  program  design|  problem  solving  and  algorithm  design|  operating  systems  concepts|  and  fundamental  programming  skills.  This  course  is  intended  for  students  who  plan  to  take  later  CIS  courses.  If  your  degree  does  not  require  further  CIS  courses  consider  CIS*1500  Introduction  to  Programming.",
                    "credits": 0.5,
                    "location": "Guelph",
                    "restrictions": "  CIS*1500.  This  is  a  Priority  Access  Course.  Enrolment  may  be  restricted  to  particular  programs  or  specializations.  See  department  for  more  information."
                  }, 
                  .
                  .
                  .
                ]
              </code>
            </pre>
          </div>
        </div><br />

        <h1>getPossibleCourses.php</h1><br/>
        <h2>POST</h2>

        <p>
          This endpoint is used by the API Frontend to fetch all of the courses the user can take in the future based on:
          <p>
            - Completed Courses <br/><br/>
            - Completed Credits <br/><br/>
            - Cumulative Average <br/><br/> 
          </p>
        </p>
        <div class="endpoint collapsible">
          <p>Get Possible Courses</p><br/>

          <div class="content">
            <code>
              POST <?php echo str_replace('/pages/ApiDoc/', '', $url) . '/api/Course/getPossibleCourses.php' ?>
            </code>

            <br /> <br /> <hr /> <br /> <br />
            <p>Request Body:</p>
            <pre>
              <code>
                {
                  coursesTaken: ["CIS*1300", "CIS*1910", "CIS*2500", ...], // Array of course codes for the courses the user has completed
                  average: 80.5, // cumulative average
                  credits: 1.5 // total completed credits
                }
              </code>
            </pre>

            <br /> <br /> <hr /> <br /> <br />
            <p>The response is an array of course objects, representing the courses that the user is eligible to take in the future:</p>
            <pre>
              <code>
                [
                  {
                    courseCode: "CIS*2520",
                    courseDesc: "This  course  is  a  study  of  basic  data  structures,  such  as  lists,  stacks,  queues,  trees,  and  tables.  Topics  which  will  be  examined  include  abstract  data  types,  sequential  and  linked  representations,  and  an  introduction  to  algorithm  analysis;  various  traversal,  search,  insertion,  removal,  and  sorting  algorithms.",
                    courseName: "Data  Structures",
                    credits: "0.50",
                    location: "Guelph",
                    restrictions: ""
                  },
                  .
                  .
                  .
                ]
              </code>
            </pre>
          </div>
        </div><br/>

        <h1>getSubjects.php</h1><br/>
        <h2>GET</h2>

        <p>
          This endpoint is used by the Subject-Based Prerequisite Tree to fetch all of the course subjects offered by the university.
        </p>
        <div class="endpoint collapsible">
          <p>Get Subjects</p><br/>

          <div class="content">
            <code>
              GET <?php echo str_replace('/pages/ApiDoc/', '', $url) . '/api/getSubjects/getSubjects.php' ?>
            </code>
            <br /> <br /> <hr /> <br /> <br />
            <p>The response is an array of course subjects:</p>
            <pre>
              <code>
                [
                  {
                    Subject: "CIS"
                  }, 
                  .
                  .
                  .
                ]
              </code>
            </pre>
          </div>
        </div><br/>

        <h1>loadcourses.php</h1><br/>
        <p>
          This endpoint is used to initialize the database by creating the tables and populating them with course data.
        </p><br/>

        <hr />
      </section><br/>

      <section id="Frontend_Application">
        <h1>Frontend Application</h1>
        <hr /><br />

        <p>
          This application allows a user to select the courses that they have completed:
        </p>
        <img src="./media/select_courses.png" alt="select_courses">
        
        <p>
          And enter in the grade they achieved for that course:
        </p>
        <img src="./media/enter_grade.png" alt="enter_grade">
        <img src="./media/display_completed_courses.png" alt="display_completed_courses">

        <p>
          Then, by clicking "generate", the list of courses they can take in the future is displayed in a table:
        </p>
        <img src="./media/display_possible_courses.png" alt="display_possible_courses">

        <hr />
      </section><br/>

      <section id="Prerequisite_Tree">
        <h1>Subject-Based Prerequisite Tree</h1>
        <hr /><br />

        <p>
          This application allows a user to select a subject offered by the university:
        </p>
        <img src="./media/select_subject.png" alt="select_subject">

        <p>
          And it displays the prerequisite tree of courses based on that subject:
        </p>
        <img src="./media/prerequisite_tree.png" alt="prerequisite_tree">

        <p>
          Note that courses with a prerequisite outside the selected subject aren't displayed. For example, if the selected subject is "CIS", then for CIS*2520, MATH*2000 won't be shown as a prerequisite.
        </p><br/>

        <hr />
      </section><br/>

      <section id="Database_Design">
        <h1>Database Design</h1>
        <hr /><br />

        <p>
          ER-Design model for the courses database:
        </p>
        <img src="./media/er_diagram.png" alt="er_diagram">

        <p>
          The courses database has the following schema:
        </p>

        <h4>Courses table:</h4>
        <table>
          <thead>
            <tr>
              <th>Field</th>
              <th>Type</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>courseCode (PRIMARY KEY)</td>
              <td>VARCHAR(20)</td>
            </tr>
            <tr>
              <td>courseName</td>
              <td>TEXT</td>
            </tr>
            <tr>
              <td>courseDesc</td>
              <td>TEXT</td>
            </tr>
            <tr>
              <td>credits</td>
              <td>TEXT</td>
            </tr>
            <tr>
              <td>location</td>
              <td>TEXT</td>
            </tr>
            <tr>
              <td>restrictions</td>
              <td>TEXT</td>
            </tr>
          </tbody>
        </table>

        <h4>Prerequisites table:</h4>
        <table>
          <thead>
            <tr>
              <th>Field</th>
              <th>Type</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>courseCode (FOREIGN KEY)</td>
              <td>VARCHAR(20)</td>
            </tr>
            <tr>
              <td>description</td>
              <td>TEXT</td>
            </tr>
          </tbody>
        </table>

        <br /><br /><br /><br />
        <p>Courses can have 0-n prerequisites mapped in a join table.</p>
        <br /><hr />
      </section><br/>
    </main>

    <script>
      // home page redirect
      const homeBtn = document.getElementById("redirectHome");

      homeBtn?.addEventListener("click", () => {
        const urlHome = window.location.href.replace(/\/pages\/.*/, ''); // Get url of api directory
        homeBtn.href = urlHome;
      });

      // JavaScript for collapsible endpoints
      const endpoints = document.querySelectorAll(".endpoint.collapsible");

      // Make endpoints collapsable by default
      endpoints.forEach((endpoint) => endpoint.classList.add("collapsed"));

      endpoints.forEach((endpoint) => {
        endpoint.addEventListener("click", () => {
          endpoint.classList.toggle("collapsed");

          const content = endpoint.querySelector(".content");
          content.style.display =
            content.style.display === "none" ? "block" : "none";
        });
      });
    </script>
  </body>
</html>
