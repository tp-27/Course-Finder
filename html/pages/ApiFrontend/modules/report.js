export function downloadReport(userCourses,possibleCourses,credits,avg) {
    var reportContent = '<html><head><title>Course Report</title>';
    reportContent +=`<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }
    h1 {
        color: #333;
        font-size: 24px;
        margin-bottom: 10px;
    }

    h2 {
        color: #555;
        font-size: 20px;
        margin-bottom: 10px;
    }

    p {
        color: #777;
        font-size: 16px;
        margin-bottom: 8px;
    }
</style>`;
    reportContent += '</head><body>';
    reportContent += '<h1>Course Report</h1>';
    reportContent += `<h2>Your completed courses: (Total Credits: ${credits}, Average: ${avg.toFixed(2)})<h2>`;
    userCourses.forEach((userCourse, index) => {
        reportContent += `<p>${index + 1}) ${userCourse.courseCode} - ${userCourse.courseName} - Grade: ${userCourse.grade}<p>`;
    })
    reportContent += '<h2>Eligible Courses:<h2>'
    reportContent += `<table>
    <thead>
      <tr class="courseTableHeader">
        <th scope="col">Code</th>
        <th scope="col">Name</th>
        <th scope="col">Description</th>
        <th scope="col">Credits</th>
        <th scope="col">Location</th>
        <th scope="col">Restrictions</th>
      </tr>
    </thead>
    <tbody>`
    possibleCourses.forEach((possibleCourse,index) => {
        reportContent += `<tr>
        <td>${possibleCourse['courseCode']}</td>
        <td>${possibleCourse['courseName']}</td>
        <td>${possibleCourse['courseDesc']}</td>
        <td>${possibleCourse['credits']}</td>
        <td>${possibleCourse['location']}</td>
        <td>${possibleCourse['restrictions']}</td>
    </tr>`;
    })
    reportContent += `
    </tbody>
    </table>`
    reportContent += '</body></html>';
    var blob = new Blob([reportContent], { type: 'text/html' });
    var link = document.createElement('a');
    link.href = window.URL.createObjectURL(blob);
    link.download = 'course_report.html';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}