<?php 
session_start();
if(isset($_SESSION['username']) && isset($_SESSION['fullname']) && $_SESSION['role'] == 'student')
{
  include '../php/db-connection.php';

  // Retrieve profile image
  $sql = "SELECT profile_image FROM users WHERE id = ?;";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo "Error preparing statement: " . mysqli_error($conn);
  } else {
    mysqli_stmt_bind_param($stmt, "s", $_SESSION['user_id']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $ProfileImage = base64_encode($row['profile_image']);
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>GPA Calculator</title>
    <link rel="stylesheet" href="../CSS/styles.css">

    <style>
      .container {
        width: 1500px;
        height: auto;
        padding: 40px;
        margin: 0 auto;
        margin-bottom: 88px;
        color: #ffffff;
        border-radius: 30px;
        background: #B39CD0;
        box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
        justify-content: center;
      }

      .header {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 30px;
        margin-bottom: -40px;
      }

      .gpa-display {
        text-align: center;
      }

      .progress-container {
        position: relative;
        width: 120px;
        height: 120px;
      }

      .progress {
        position: absolute;
        top: 0;
        left: 0;
        width: 150%;
        height: 150%;
        border-radius: 50%;
        background: conic-gradient(#320943e3 var(--progress), #e0e0e0 0);
        display: flex;
        justify-content: center;
        align-items: center;
      }

      .progress .progress-text {
        width: 90%;
        height: 90%;
        border-radius: 50%;
        background: #ffffff;
        border: 1px solid rgb(209, 209, 209);
        font-size: 24px;
        color: #000000;
        line-height: 120px;
        text-align: center;
        position: absolute;
        top: 5%;
        left: 5%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: bold;
      }

      .head {
        display: flex;
        margin-bottom: 20px;
        gap: 1100px;
      }

      .head h2 {
        color: #000;
        text-align: center;
        font-feature-settings: "dlig" on;
        text-shadow: 0px 4px 4px #00000040;
        font-family: "kameron";
        font-style: normal;
        font-weight: 700;
        line-height: 21px;
        letter-spacing: 0.21px;
      }

      .semester {
        margin-bottom: 20px;
      }

      table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 10px;
      }

      th,
      td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
        color: #000000;
      }

      tbody tr {
        text-align: center;
      }

      thead th {
        color: #ffffff;
        text-shadow: 0px 4px 4px #00000040;
      }

      input[type="text"] {
        padding: 10px;
        margin: 10px 0;
        border: none;
        box-sizing: border-box;
        cursor: pointer;
        border-radius: 7px;
        background: #ffffff;
        box-shadow: 0px 4px 4px #00000040;
      }

      input[type="text"]:focus {
        outline: 3px solid #858484;
      }

      .grade,
      .credits {
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #000000;
        box-sizing: border-box;
        cursor: pointer;
        border-radius: 7px;
        background: #ffffff;
        box-shadow: 0px 4px 4px #00000040;
        border: none;
      }

      .grade:focus,
      .credits:focus {
        outline: 3px solid #858484;
      }

      .credits,
      .grade{
        width: 100px;
        margin-left: 20px;
      }

      .calculate-gpa,
      .add-course {
        padding: 10px 20px;
        margin: 10px 0;
        border: none;
        color: #ffffff;
        cursor: pointer;
        border-radius: 7px;
        background: #320943e3;
        box-shadow: 0px 4px 4px #00000040;
      }

      .calculate-gpa:hover,
      .add-course:hover {
        background: #eee;
        color: #320943e3;
      }

      .delete-course {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #ff2f2f;
        color: white;
        cursor: pointer;
        border: none;
        box-shadow: 0px 4px 4px #00000040;
      }

      #add-semester {
        width: 150px;
        padding: 10px 20px;
        flex-shrink: 0;
        border-radius: 7px;
        background-color: #6be440;
        color: white;
        font-size: 15px;
        font-weight: bold;
        cursor: pointer;
        border: none;
      }

      #add-semester:hover {
        background-color: #28a745;
      }
    </style>
  </head>
  <body>
    <nav>
      <div class="logo2">
        <img src="../images/logo.png" class="logo">
        <div class="logo-text">
          <p>Student Assistant</p>
        </div>
      </div>
      <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="course.php">Courses</a></li>
        <li><a href="quiz.php">Quizzes</a></li>
        <li><a href="summary.php">Summary</a></li>
        <li><a href="GPA.php" class="active">GPA Calculator</a></li>
      </ul>
      <div class="notification" onclick="toggleNotifi()">
        <img src="../images/notification.jpg" alt=""> <span>2</span>
      </div>
      <div class="notifi-box" id="notificationBox">
        <div class="notifi-item">
          <img src="../images/profile.png">
          <div class="text">
            <h4>Student Assistant</h4>
            <p>Feb 12, 2022</p>
            <p>Welcome to Student Assistant, we wish you all the best on your journey!</p>
          </div>
        </div>
        <div class="notifi-item" onclick="openModal()">
          <img src="../images/profile.png">
          <div class="text">
            <h4>Ali Ahmed</h4>
            <p>Feb 12, 2022</p>
          </div>
        </div>
      </div>
      <img src="<?php echo $ProfileImage ? 'data:image/png;base64,' . $ProfileImage : '../images/profile.png'; ?>" onclick="ToggleMenu()" class="user-pic">
  
      <div class="sub-menu-wrap" id="subMenu">
        <div class="sub-menu">
<div class="user-info">
<img src="<?php echo $ProfileImage ? 'data:image/png;base64,' . $ProfileImage : '../images/profile.png'; ?>">
                <h3><?php echo $_SESSION['fullname']; ?></h3>
                </div>
            <hr>
  
          <a href="profile.php" class="sub-menu-link">
            <img src="../images/edit.png">
            <p>Profile</p>
            <span>></span>
          </a>
          <hr>
          <a class="sub-menu-link" id="dark-mode-toggle" style="cursor: pointer;">
            <img src="../images/swich.jpg">
            <p>Swich</p>
          </a>
          <hr>
          <a href="../php/logout.php" class="sub-menu-link">
                <img src="../images/logout.png">
                <p>Logout</p>
                <span>></span>
            </a>
        </div>
      </div>
      <div id="myModal" class="modal">
        <div class="modal-content">
          <span class="close">&times;</span>
          <h4>Ail Ahmed</h4>
          <p>Date: 12-12-2023</p>
          <p>Hi, Can i fix you?</p>
          <textarea id="responseMessage" placeholder="Write your response here..."></textarea>
          <button id="sendResponseBtn">Send Response</button>
          <p id="successMessage" class="success-message">Response sent successfully!</p>
        </div>
      </div>
    </nav>

    <div class="header">
      <div class="gpa-display">
        <div class="progress-container">
          <div class="progress" id="progress">
            <span class="progress-text" id="progress-text">0.0</span>
          </div>
        </div>
      </div>
    </div>
    <div class="container">

      <div id="semesters">
        <div class="semester">
          <div class="head">
            <h2>SEMESTER 1</h2>
            <button id="add-semester">Add Semester</button>
          </div>
          <table>
            <thead>
              <tr>
                <th>#</th>
                <th>Course Name</th>
                <th>Grade</th>
                <th>Credits</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>
                  <input type="text" placeholder="Course Name"/>
                </td>
                <td>
                  <select class="grade">
                    <option value=".."></option>
                    <option value="A+">A+</option>
                    <option value="A">A</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B">B</option>
                    <option value="B-">B-</option>
                    <option value="C+">C+</option>
                    <option value="C">C</option>
                    <option value="C-">C-</option>
                    <option value="D+">D+</option>
                    <option value="D">D</option>
                    <option value="F">F</option>
                  </select>
                </td>
                <td><input type="number" class="credits" min="0" /></td>
                <td><button class="delete-course">X</button></td>
              </tr>
            </tbody>
          </table>
          <button class="add-course">Add Course</button>
          <button class="calculate-gpa">Calculate GPA</button>
          <p>
            Your GPA for this semester is <span class="semester-gpa"></span>
          </p>
        </div>
      </div>
    </div>

    <footer>
      <div class="row">
        <div class="col">
          <img src="../images/logo.png" class="logo-footer">
          <h1>Student Assistant</h1>
          <h4>From study materials to assessments, we've got you covered.</h4>
          <div class="social">
            <i class="fa fa-facebook-f"></i>
            <i class="fa fa-twitter"></i>
            <i class="fa fa-instagram"></i>
            <i class="fa fa-linkedin"></i>
          </div>
        </div>
        <div class="col">
          <h3>Product</h3><br>
          <div class="line">
            <a href="course.php">Course management</a>
            <br>
            <br>
            <a href="quiz.php">Quiz management</a>
            <br>
            <br>
            <a href="summary.php">Summary</a>
            <br>
            <br>
            <a href="GPA.php">GPA Calculator</a>
          </div>
        </div>
        <div class="col">
          <h3>Company</h3><br>
          <div class="line">
            <a href="aboutUs.php">About Us</a>
          </div>
        </div>
        <div class="col">
          <h3>Resources</h3><br>
            <div class="line">
              <a href="contactUs.php">Contact Us</a>
            </div>
        </div>
      <div class="copy">
        <p>Copyright ©2023-2024</p>
    
      </div>
    </footer> 
    
    <script src="../JS/main.js"></script>

    <script>
      document.addEventListener("DOMContentLoaded", function () {
        const addSemesterButton = document.getElementById("add-semester");
        const semestersContainer = document.getElementById("semesters");
        const cumulativeGpaDisplay = document.getElementById("progress-text");
        const progressBar = document.getElementById("progress");
        let semesterCount = 1;

        addSemesterButton.addEventListener("click", function () {
          semesterCount++;
          const newSemester = document.createElement("div");
          newSemester.classList.add("semester");
          newSemester.innerHTML = `
                <div class="head">
                    <h2>SEMESTER ${semesterCount}</h2>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Course Name</th>
                                <th>Grade</th>
                                <th>Credits</th>
                                <th> </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td><input type="text" placeholder="Course Name" required></td>
                                <td>
                                    <select class="grade">
                                        <option value=".."></option>
                                        <option value="A+">A+</option>
                                        <option value="A">A</option>
                                        <option value="A-">A-</option>
                                        <option value="B+">B+</option>
                                        <option value="B">B</option>
                                        <option value="B-">B-</option>
                                        <option value="C+">C+</option>
                                        <option value="C">C</option>
                                        <option value="C-">C-</option>
                                        <option value="D+">D+</option>
                                        <option value="D">D</option>
                                        <option value="F">F</option>
                                    </select>
                                </td>
                                <td><input type="number" class="credits" min="0" /></td>
                                <td><button class="delete-course">X</button></td>
                            </tr>
                        </tbody>
                    </table>
                    <button class="add-course">Add Course</button>
                    <button class="calculate-gpa">Calculate GPA</button>
                    <p>
                        Your GPA for this semester is <span class="semester-gpa"></span>
                    </p>
            `;
          semestersContainer.appendChild(newSemester);
          attachCalculateGpaEvent(newSemester);
          attachAddCourseEvent(newSemester);
          attachDeleteCourseEvent(newSemester);
        });

        function attachCalculateGpaEvent(semesterElement) {
          const calculateGpaButton =
            semesterElement.querySelector(".calculate-gpa");
          calculateGpaButton.addEventListener("click", function () {
            calculateSemesterGpa(semesterElement);
            updateCumulativeGpa();
          });
        }

        function attachAddCourseEvent(semesterElement) {
          const addCourseButton = semesterElement.querySelector(".add-course");
          const tbody = semesterElement.querySelector("tbody");
          addCourseButton.addEventListener("click", function () {
            const courseCount = tbody.querySelectorAll("tr").length + 1;
            const newRow = document.createElement("tr");
            newRow.innerHTML = `
                        <td>${courseCount}</td>
                        <td><input type="text" placeholder="Course Name" required></td>
                        <td>
                            <select class="grade">
                                <option value=".."></option>
                                <option value="A+">A+</option>
                                <option value="A">A</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B">B</option>
                                <option value="B-">B-</option>
                                <option value="C+">C+</option>
                                <option value="C">C</option>
                                <option value="C-">C-</option>
                                <option value="D+">D+</option>
                                <option value="D">D</option>
                                <option value="F">F</option>
                            </select>
                        </td>
                        <td><input type="number" class="credits" min="0" /></td>
                        <td><button class="delete-course">X</button></td>
                    `;
            tbody.appendChild(newRow);
            attachDeleteCourseEvent(newRow);
            reassignCourseIds(semesterElement);
            updateCumulativeGpa();
          });
        }

        function attachDeleteCourseEvent(semesterElement) {
          const deleteCourseButtons =
            semesterElement.querySelectorAll(".delete-course");
          deleteCourseButtons.forEach((button) => {
            button.addEventListener("click", function () {
              const row = button.closest("tr");
              row.remove();
              reassignCourseIds(semesterElement);
              calculateSemesterGpa(semesterElement);
              updateCumulativeGpa();
            });
          });
        }

        function calculateSemesterGpa(semesterElement) {
          const grades = semesterElement.querySelectorAll(".grade");
          const credits = semesterElement.querySelectorAll(".credits");
          let totalPoints = 0;
          let totalCredits = 0;

          grades.forEach((gradeElement, index) => {
            const grade = gradeElement.value.toUpperCase();
            const credit = parseFloat(credits[index].value);
            const gradePoints = getGradePoints(grade);
            if (gradePoints !== null && !isNaN(credit)) {
              totalPoints += gradePoints * credit;
              totalCredits += credit;
            }
          });

          const gpa = totalPoints / totalCredits;
          semesterElement.querySelector(".semester-gpa").textContent =
            gpa.toFixed(2);
        }

        function getGradePoints(grade) {
          const gradeScale = {
            "A+": 4.0,
            A: 3.8,
            "A-": 3.6,
            "B+": 3.4,
            B: 3.2,
            "B-": 3.0,
            "C+": 2.8,
            C: 2.6,
            "C-": 2.4,
            "D+": 2.2,
            D: 2.0,
            F: 0.0,
          };
          return gradeScale[grade] || null;
        }

        function updateCumulativeGpa() {
          const allSemesters = document.querySelectorAll(".semester");
          let totalPoints = 0;
          let totalCredits = 0;

          allSemesters.forEach((semesterElement) => {
            const grades = semesterElement.querySelectorAll(".grade");
            const credits = semesterElement.querySelectorAll(".credits");

            grades.forEach((gradeElement, index) => {
              const grade = gradeElement.value.toUpperCase();
              const credit = parseFloat(credits[index].value);
              const gradePoints = getGradePoints(grade);
              if (gradePoints !== null && !isNaN(credit)) {
                totalPoints += gradePoints * credit;
                totalCredits += credit;
              }
            });
          });

          const cumulativeGpa = totalPoints / totalCredits;
          cumulativeGpaDisplay.textContent = cumulativeGpa.toFixed(2);

          const progressValue = (cumulativeGpa / 4.0) * 100;
          progressBar.style.setProperty("--progress", `${progressValue}%`);
        }

        function reassignCourseIds(semesterElement) {
          const rows = semesterElement.querySelectorAll("tbody tr");
          rows.forEach((row, index) => {
            row.querySelector("td:first-child").textContent = index + 1;
          });
        }

        const firstSemester = document.querySelector(".semester");
        attachCalculateGpaEvent(firstSemester);
        attachAddCourseEvent(firstSemester);
        attachDeleteCourseEvent(firstSemester);
      });

      
    </script>

  </body>
</html>
<?php 
  $conn->close();
} else {
  header("Location: index.php");
  exit();
} 
?>