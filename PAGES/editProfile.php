<?php
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['fullname']) && $_SESSION['role'] == 'student') {
  include '../php/db-connection.php';
  $sql = "SELECT profile_image FROM users WHERE id = ?;";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kameron:wght@400..700&family=Preahvihear&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" href="../CSS/styles.css">
    <style>
      .back {
        width: 100%;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .card {
        width: 900px;
        height: 750px;
        padding: 40px;
        text-align: center;
        color: #333;
        border-radius: 60px;
        background: #B39CD0;
        box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
      }

      .card h1 {
        font-weight: 500;
        color: #000;
        font-family: "kameron", sans-serif;
      }

      .card img {
        width: 250px;
        height: 250px;
        border-radius: 50%;
        object-fit: contain;
        margin-top: 40px;
        margin-bottom: 30px;
        background: #e0e0e0;
        box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
      }

      .btn1 {
        position: relative;
        width: 176px;
        height: 57.6px;
        border: none;
        border-radius: 3rem;
        cursor: pointer;
        font-size: 1.2rem;
        font-weight: 550;
        font-family: sans-serif;
        letter-spacing: 1px;
        transition: all 0.3s;
        background: #E8EBF2;
        box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
      }

      .btn1::before {
        content: "";
        position: absolute;
        top: -2px;
        left: -2px;
        border-radius: 3rem;
        width: 100%;
        height: 100%;
        padding: 2px;
        background: #320943e3;
        z-index: -1;
      }

      .btn1:hover {
        background: linear-gradient(145deg, #f1f1f1, #dddddd);
        font-size: 1.25rem;
      }

      .btn1:active {
        border-radius: 50px;
        background: #cfcfcf;
        box-shadow: inset 19px 19px 35px #aeaeae,
          inset -19px -19px 35px #f0f0f0;
      }

      label {
        display: block;
        width: 176px;
        height: 57.6px;
        background: #320943e3;
        color: #000000;
        padding: 15px;
        margin: 10px auto;
        margin-right: 420px;
        border-radius: 3rem;
        font-size: 1.2rem;
        font-weight: 550;
        font-family: sans-serif;
        color: #d1d1d1;
        cursor: pointer;
        box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
      }

      label:active {
        border-radius: 50px;
        background: #cfcfcf;
        box-shadow: inset 19px 19px 35px #aeaeae,
          inset -19px -19px 35px #f0f0f0;
      }

      input {
        display: none;
      }

      .delete_btn {
        position: absolute;
        width: 176px;
        height: 57.6px;
        margin: 10px auto;
        margin-left: 20px;
        margin-top: -68px;
        border: none;
        border-radius: 3rem;
        cursor: pointer;
        font-size: 1.2rem;
        font-weight: 550;
        font-family: sans-serif;
        letter-spacing: 1px;
        transition: all 0.3s;
        background: #E8EBF2;
        box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
      }

      .delete_btn:active {
        border-radius: 50px;
        background: #cfcfcf;
        box-shadow: inset 19px 19px 35px #aeaeae,
          inset -19px -19px 35px #f0f0f0;
      }

      .delete_btn::before {
        content: "";
        position: absolute;
        top: -2px;
        left: -2px;
        border-radius: 3rem;
        width: 100%;
        height: 100%;
        padding: 2px;
        background: linear-gradient(145deg, #d1d1d1, #dddddd);
        z-index: -1;
      }

      .delete_btn:hover {
        background: linear-gradient(145deg, #f1f1f1, #dddddd);
        font-size: 1.25rem;
      }

      .input-group {
        display: flex;
        padding: 40px;
      }

      table {
        width: 100%;
        border-collapse: collapse;
      }

      th {
        text-align: right;
        padding: 10px;
        font-weight: 500;
        color: #000;
        margin: 10px;
      }

      td {
        text-align: left;
        padding: 10px;
        font-weight: 500;
        color: #000;
        margin: 10px;
      }

      td {
        text-align: center;
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

    <div class="back">
      <div class="card">
        <h1>Edit Profile</h1>
        <img src="<?php echo $ProfileImage ? 'data:image/png;base64,' . $ProfileImage : '../images/profile.png'; ?>" id="profile-pic">
        <h2><?php echo $_SESSION["fullname"] ?></h2>

        <label for="input-file">Upload image</label>
        <form method="post" action="../php/save-prof-pic.php" enctype="multipart/form-data">
          <input name="profilePic" type="file" accept="image/jpeg, image/png, image/jpg" id="input-file">
          <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
          <button type="button" class="delete_btn">Delete</button>
          <div class="input-group">

          </div>

          <button type="submit" class="btn1" onclick="showConfirmation()">Save</button>
        </form>
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
      const image = document.querySelector('#profile-pic'),
        input = document.querySelector('#input-file'),
        deleteBtn = document.querySelector('.delete_btn');

      const defaultImageSrc = '../images/profile.png';

      input.addEventListener('change', function() {
        image.src = URL.createObjectURL(input.files[0]);
      });

      function showConfirmation() {
    
        setTimeout(function() {
          $('#profile-pic').attr('src', 'data:image/png;base64,<?php echo $ProfileImage ?>');
        }, 100);
      }

      deleteBtn.addEventListener('click', () => {
        // Reset the image source to the default
        image.src = defaultImageSrc;

        // Reset the input field by triggering a change event
        input.value = '../images/profile.png'; // Clear the input value
        input.dispatchEvent(new Event('change')); // Trigger the change event
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

} else {
  header("Location: index.php");
  exit();
}
?>