<?php
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['fullname']) && $_SESSION['role'] == 'student') {
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
    <link rel="stylesheet" href="../CSS/styles.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Kameron:wght@400..700&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kameron:wght@400..700&family=Marko+One&family=Preahvihear&display=swap" rel="stylesheet" />
    <title>Courses</title>
    <style>
      .main-content1 {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        margin-bottom: 30px;
        min-height: 523px;
        bottom: 0%;
      }

      .course {
        margin-top: 20px;
      }

      .course-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
      }

      .course-header h1 {
        color: #000;
        text-align: center;
        font-feature-settings: "dlig" on;
        text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25), 0px 4px 4px rgba(0, 0, 0, 0.25);
        font-family: "Marko One";
        font-size: 30px;
        font-style: normal;
        font-weight: 400;
        line-height: 24px;
      }

      .course-header button {
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        cursor: pointer;
        border-radius: 5px;
      }

      .course-header button:hover {
        background-color: #000000;
      }

      .course-content {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-top: 20px;
      }

      .course-card {
        background-color: #B39CD0;
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        text-align: center;
      }

      .course-card:hover {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.493);
      }

      .course-pic {
        margin-bottom: auto;
      }

      .course-pic img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 7px;
      }

      .course-info h2 {
        margin-bottom: 10px;
        margin-top: 10px;
        color: #000;
        text-align: center;
        font-feature-settings: "dlig" on;
        text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25), 0px 4px 4px rgba(0, 0, 0, 0.25);
        font-family: "Marko One";
        font-size: 25px;
        font-style: normal;
        font-weight: 200;
        line-height: 24px;
      }

      .course-info button {
        padding: 10px 20px;
        background-color: #320943e3;
        color: #fff;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        margin-top: 10%;
      }

      .course-info button:hover {
        background-color: #000000;
      }

      #delete-btn {
        background-color: #dc3545;
      }

      #add-btn {
        padding: 10px 20px;
        background-color: #28a745;
        color: #fff;
        border: none;
        cursor: pointer;
        border-radius: 5px;
      }

      .search-container {
        position: absolute;
        display: flex;
        flex-direction: column;
        align-items: center;
        right: 280px;
        top: 31px;
      }

      #search-icon {
        cursor: pointer;
        width: 45px;
        border-radius: 50%;
        margin-right: -100px;
        margin-top: 3px;
      }

      #search-input {
        width: 500px;
        padding: 10px;
        border: 1px solid #320943e3;
        border-radius: 10px;
        display: none;
        position: absolute;
        top: 76px;
        background: #d2bfe9;
        box-shadow: #8b8b8b, -10px -10px 20px #ffffff;
        font-size: large;
      }

        /* Pop-up container */
  .popup-container {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    justify-content: center;
    align-items: center;
    z-index: 1000;
  }

  .popup-content {
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 400px;
    text-align: center;
  }

  .popup-content h2 {
    margin-bottom: 20px;
  }

  .popup-content input {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
  }

  .popup-content button {
    padding: 10px 20px;
    margin: 5px;
    border: none;
    cursor: pointer;
    border-radius: 5px;
  }

  .popup-content .btn-primary {
    background-color: #007bff;
    color: #fff;
  }

  .popup-content .btn-secondary {
    background-color: #6c757d;
    color: #fff;
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
        <li><a href="course.php" class="active">Courses</a></li>
        <li><a href="quiz.php">Quizzes</a></li>
        <li><a href="summary.php">Summary</a></li>
        <li><a href="GPA.php">GPA Calculator</a></li>
      </ul>
      <div class="search-container">
        <img src="../images/search.jpg" id="search-icon" onclick="toggleSearchBar()">
        <input type="text" id="search-input" placeholder="Search for courses...">
      </div>
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

    <div class="main-content1">
      <div class="course">
        <div class="course-header">
          <h1>COURSES</h1>
          <button type="button" id="add-btn" class="btn" aria-label="Add Course" onclick="uploadCourse()">Add Course</button>
        </div>
        <div class="course-content"></div>
      </div>
    </div>

    <div id="addCoursePopup" class="popup-container">
      <form method="post" action="../php/SaveCourse.php" enctype="multipart/form-data" class="popup-content">
        <h2>Add Course</h2>
        <input name="courseName" type="text" id="courseNameInput" placeholder="Enter course name">
        <input name="courseImage" type="file" id="courseImageInput" accept="image/*">
        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
        <input type="hidden" name="owner" value="<?php echo $_SESSION['fullname']; ?>">
        <br>
        <button type="button" class="btn-primary" onclick="validateAndSubmit()">Save</button>
        <button type="button" class="btn-secondary" onclick="closePopup1('addCoursePopup')">Cancel</button>
      </form>
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
      function openPopup(popupId) {
        document.getElementById(popupId).style.display = 'flex';
      }

      function validateAndSubmit() {
        var courseNameInput = document.getElementById('courseNameInput');
        var courseImageInput = document.getElementById('courseImageInput');

        var courseName = courseNameInput.value.trim();
        var courseImage = courseImageInput.files[0];

        if (courseName === "" || !courseImage) {
          Swal.fire({
            position: "center",
            icon: "error",
            title: "Please fill all fields!",
            showConfirmButton: false,
            timer: 3200
          });
          return;
        } else {
          document.querySelector('form').submit();
        }
      }

      function getQueryParam(param) {
        let urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param);
      }

      const error = getQueryParam('error');
      const success = getQueryParam('success');

      if (error) {
        Swal.fire({
          position: "center",
          icon: "error",
          title: error,
          showConfirmButton: false,
          timer: 3200
        });
      }
      if (success) {
        Swal.fire({
          position: "center",
          icon: "success",
          title: success,
          showConfirmButton: false,
          timer: 3200
        });
      }



      function closePopup1(popupId) {
        document.getElementById(popupId).style.display = 'none';
      }

      function uploadCourse() {
        openPopup('addCoursePopup');
      }
      window.onload = function() {
        fetchCourses();
      };

      function fetchCourses() {
        fetch('../php/fetch-courses.php')
          .then(response => response.json())
          .then(coursesData => displayCourses(coursesData))
          .catch(error => console.error('Error fetching courses:', error));
      }

      function displayCourses(coursesData) {
        var courseContent = document.querySelector(".course-content");
        courseContent.innerHTML = "";

        coursesData.forEach(function(course, index) {
          var courseCard = document.createElement("div");
          courseCard.className = "course-card";
          courseCard.innerHTML = `
      <div class="course-pic">
        <img src="data:image/png;base64,${course.image}" alt="${course.name} Image"> 
      </div>
      <div class="course-info">
        <h2>${course.name}</h2>
        <button type="button" class="btn" onclick="viewCourse(${course.id})">View</button> 
        <button type="button" id="delete-btn" class="btn" onclick="deleteCourse(${course.id})">Delete</button> 
      </div>
    `;
          courseContent.appendChild(courseCard);
        });
      }

      function deleteCourse(courseId) {
        Swal.fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!"
        }).then((result) => {
          if (result.isConfirmed) {
            fetch(`../php/delete-course.php?course_id=${courseId}`)
              .then(response => {
                if (response.ok) {
                  Swal.fire({
                    title: "Deleted!",
                    text: "Your course has been deleted.",
                    icon: "success"
                  });
                  fetchCourses();
                } else {
                  Swal.fire({
                    title: "Error!",
                    text: "Failed to delete course.",
                    icon: "error"
                  });
                }
              })
          }
        });
      }

      function viewCourse(courseId) {
        var studentId = "<?php echo $_SESSION['user_id']; ?>";
        window.location.href = `course_details.php?course_id=${courseId}&student_id=${studentId}`;
      }
    </script>
<script>
            function toggleSearchBar() {
            var searchBar = document.getElementById("search-input");
            if (searchBar.style.display === "none" || searchBar.style.display === "") {
                searchBar.style.display = "block";
                searchBar.focus();
            } else {
                searchBar.style.display = "none";
            }
        }

        document.getElementById('search-input').addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                searchFunction();
            }
        });

    function searchFunction() {
        let query = document.getElementById("search-input").value.toLowerCase();
        let courseCards = document.querySelectorAll(".course-card");
        
        courseCards.forEach(courseCard => {
            let courseName = courseCard.querySelector("h2").innerText.toLowerCase(); 
            
            if (courseName.includes(query)) { 
                courseCard.style.display = "block"; 
            } else {
                courseCard.style.display = "none"; 
            }
        });
    }

    document.getElementById('search-input').addEventListener('input', searchFunction); 
  </script>
  </body>

  </html>
<?php

} else {
  header("Location: index.php");
  exit();
}
?>