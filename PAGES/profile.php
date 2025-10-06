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

  // Retrieve courses count
  $sql = "SELECT COUNT(*) AS course_count FROM course WHERE student_id = ?";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo "Error preparing statement: " . mysqli_error($conn);
  } else {
    mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $coursesCount = $row['course_count'];
  }

  // Retrieve courses details
  $sql = "SELECT course_name, course_picture FROM course WHERE student_id = ?";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo "Error preparing statement: " . mysqli_error($conn);
  } else {
    mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $courses = mysqli_fetch_all($result, MYSQLI_ASSOC);
  }

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../CSS/styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <title>Profile</title>
  <style>
    .profile {
      display: flex;
      margin: auto;
      margin-top: 50px;
      width: 60%;
    }

    .profile-pic {
      margin-right: 20px;
    }

    .profile-pic img {
      width: 150px;
      height: 150px;
      border-radius: 50%;
    }

    .profile-info h1 {
    width:max-content;
      font-size: 25px;
      margin: 0;
      margin-top: 40px;
      margin-left: 20px;
    }

    .profile-info p {
      font-size: 15px;
      margin: 10px 0;
      color: #4F6696;
      margin-left: 20px;
    }

    .profile-details {
      margin: auto;
      margin-top: 50px;
      width: 80%;
    }

    .profile-details h2 {
      margin: 0;
      margin-left: 180px;
      font-size: 30px;
      font-family: 'kameron', serif;
    }

    .edit {
      color: rgb(0, 0, 0);
      padding: 14px 20px;
      border: none;
      cursor: pointer;
      width: 110px;
      margin: 60px;
      margin-left: 650px;
      border-radius: 12px;
      background: #E8EBF2;
      box-shadow: 0px 4px 4px 0px #00000040;
    }

    .edit:hover {
      background: #3B2E2E;
      color: white;
    }

    .course {
      display: flex;
      align-items: center;
      margin-bottom: 20px; /* Add spacing between courses */
    }

    .course a {
      text-decoration: none;
      color: black;
    }

    .course img {
      width: 60px;
      height: 60px;
      margin-right: 20px; /* Add space between image and text */
      border-radius: 10px;
    }

    .course h1 {
      margin: 0;
      font-size: 20px;
    }

    .show-btn {
      color: rgb(0, 0, 0);
      padding: 14px 20px;
      border: none;
      cursor: pointer;
      width: 110px;
      margin: auto;
      margin-right: auto;
      margin-left: auto;
      margin-top: 30px;
      margin-bottom: 90px;
      display: block;
      border-radius: 12px;
      background: #E8EBF2;
      box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
    }

    .show-btn:hover {
      background: #3B2E2E;
      color: white;
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
      <li><a href="GPA.php">GPA Calculator</a></li>
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
        <span class="close">×</span>
        <h4>Ail Ahmed</h4>
        <p>Date: 12-12-2023</p>
        <p>Hi, Can i fix you?</p>
        <textarea id="responseMessage" placeholder="Write your response here..."></textarea>
        <button id="sendResponseBtn">Send Response</button>
        <p id="successMessage" class="success-message">Response sent successfully!</p>
      </div>
    </div>
  </nav>

  <div class="main-content">
    <div class="profile">
      <div class="profile-pic">
        <img src="<?php echo $ProfileImage ? 'data:image/png;base64,' . $ProfileImage : '../images/profile.png'; ?>">
      </div>
      <div class="profile-info">
      <h1><?php echo $_SESSION['fullname']; ?></h1>
      <p><?php echo $_SESSION['username']; ?></p>
      <p><?php echo $_SESSION['email']; ?></p>
      <p style="width: max-content;">Have <?php echo $coursesCount; ?> Courses</p>
      </div>
      <div class="edit-btn">
        <a href="editProfile.php"><button type="button" class="edit">Edit Profile</button></a>
      </div>
    </div>
    <div class="profile-details">
      <h2>Courses</h2>
      <br>
      <?php foreach ($courses as $course): ?>
      <div class="course" style="left: 180px; position: relative;">
        <img src="data:image/jpeg;base64,<?php echo base64_encode($course['course_picture']); ?>" alt="<?php echo $course['course_name']; ?>">
        <h1><?php echo $course['course_name']; ?></h1>
      </a>
      </div>
      <?php endforeach; ?>
      <button type="button" class="show-btn">Show More</button>
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
      let showMore = true;

      document.querySelector(".show-btnn").addEventListener("click", function () {
        if (showMore) {
          // Replace with your actual course data
          var newCourses = `
            <div class="course">
                <img src="data:image/jpeg;base64,YOUR_COURSE_IMAGE_1" alt="Course Name 1">
                <h1>Course Name 1</h1>
              </a>
            </div>
            <div class="course">
                <img src="data:image/jpeg;base64,YOUR_COURSE_IMAGE_2" alt="Course Name 2">
                <h1>Course Name 2</h1>
              </a>
            </div>
          `;
          this.parentElement.insertAdjacentHTML("beforebegin", newCourses);
          this.textContent = "Show Less";
        } else {
          var course = document.querySelector(".course:last-of-type");
          if (course) {
            course.remove();
          }
          this.textContent = "Show More";
        }
        showMore = !showMore;
      });
    });
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