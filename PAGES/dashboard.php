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
    if ($row['profile_image'] ==null) {
      $ProfileImage = 0;
    }else {
    $ProfileImage = base64_encode($row['profile_image']);}
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Kameron:wght@400..700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia">
  <link rel="stylesheet" href="../CSS/styles.css" />
  <link rel="stylesheet" href="../CSS/Cal1endar.css" />
  <title>Dashboard</title>
  <style>
    .main-content0 {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      margin-top: 30px;
    }
    .background-image {
      width: 1070px;
      height: 512px;
      display: flex;
      flex-direction: column;
      border-radius: 10px;
      background: url('../images/Picture.jpg') no-repeat center center/cover;
      color: rgb(0, 0, 0);
      box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
      margin-bottom: 100px;
    }
    .background-image h2 {
      font-size: 40px;
      margin-top: 230px;
      margin-left: 50px;
    }
    .background-image p {
      margin-left: 50px;
    }

    .background-image button {
      width: 150px;
      height: 50px;
      margin-left: 50px;
      margin-top: 50px;
      border: none;
      font-size: 20px;
      font-weight: 600;
      font-family: 'Arial Narrow Bold', sans-serif;
      cursor: pointer;
      border-radius: 24px;
      background: #B39CD0;
      box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
    }
    .background-image button:hover {
      box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
      background: #320943e3;
      color: #ffffff;
    }
    .slider {
      margin-bottom: 90px;
      text-align: center;
    }
    .slider p {
      font-size: 60px;
      font-family: "kameron", sans-serif;
      margin-right: 810px;
    }
    .slider-container {
      position: relative;
      width: 100%;
      max-width: 1000px;
      margin: auto;
      overflow: hidden;
      margin-bottom: 40px;
      margin-top: 60px;
    }
    .slider-img {
      display: flex;
      transition: transform 0.5s ease;
    }
    .slider-img a {
      position: relative;
      display: block;
    }
    .slider-img a img {
      width: 315px;
      height: auto;
      margin: 10px;
      background: #B39CD0;
      border-radius: 10px;
    }
    .slider-img a .hover-text {
      position: absolute;
      bottom: 10px;
      left: 10px;
      right: 10px;
      background: rgba(0, 0, 0, 0.5);
      color: white;
      padding: 10px;
      border-radius: 10px;
      text-align: center;
      opacity: 0;
      transition: opacity 0.3s ease;
    }
    .slider-img a:hover .hover-text {
      opacity: 1;
    }
    #controls1 {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      width: 100%;
      display: flex;
      justify-content: space-between;
      pointer-events: none;
    }
    #controls1 button {
      background: #00000080;
      color: white;
      border: none;
      cursor: pointer;
      font-size: 16px;
      border-radius: 50px;
      padding: 10px 15px;
      pointer-events: all;
    }
    #controls1 button:hover {
      background: rgba(0, 0, 0, 0.7);
    }
    #p-calendar {
      font-size: 60px;
      font-family: "kameron", sans-serif;
      margin-bottom: 40px;
      margin-right: 650px;
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
      <li><a href="dashboard.php" class="active">Dashboard</a></li>
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
    <img src="<?php echo $ProfileImage ? 'data:image/png;base64,' . $ProfileImage : '../images/profile.png'; ?>"onclick="ToggleMenu()" class="user-pic">

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
  <div class="main-content0">
    <div class="background-image">
    <h2>Welcome, <?php echo $_SESSION['fullname']; ?></h2><br>
    <p>The only thing that overcomes hard luck is hard work.” - Harry Golden.</p>
      <button onclick="window.location.href = 'course.php'">Study now</button>
    </div>
    <div class="slider">
      <p>Features</p>
      <div class="slider-container">
        <div class="slider-img">
          <a href="course.php">
            <img src="../images/coursed.png" alt="Image 1">
            <div class="hover-text">Course Management</div>
          </a>
          <a href="quiz.php">
            <img src="../images/quizd.png" alt="Image 3">
            <div class="hover-text">Create Quiz</div>
          </a>
          <a href="summary.php">
            <img src="../images/summaryd.png" alt="Image 2">
            <div class="hover-text">Summary</div>
          </a>
          <a href="GPA.php">
            <img src="../images/gpad.png" alt="Image 4">
            <div class="hover-text">GPA Calculator</div>
          </a>
        </div>
        <div id="controls1">
          <button id="prev1">&#10094;</button>
          <button id="next1">&#10095;</button>
        </div>
      </div>
    </div>
    <p id="p-calendar"> Your Calendar</p>
    <div class="container">
      <div class="left">
        <div class="calendar">
          <div class="month">
            <i class="fas fa-angle-left prev"></i>
            <div class="date">December 2015</div>
            <i class="fas fa-angle-right next"></i>
          </div>
          <div class="weekdays">
            <div>Sun</div>
            <div>Mon</div>
            <div>Tue</div>
            <div>Wed</div>
            <div>Thu</div>
            <div>Fri</div>
            <div>Sat</div>
          </div>
          <div class="days"></div>
          <div class="goto-today">
            <div class="goto">
              <input type="text" placeholder="mm/yyyy" class="date-input" />
              <button class="goto-btn">Go</button>
            </div>
            <button class="today-btn">Today</button>
          </div>
        </div>
      </div>
      <div class="right">
        <div class="today-date">
          <div class="event-day">Wed</div>
          <div class="event-date">12th December 2022</div>
        </div>
        <div class="events"></div>
        <div class="add-event-wrapper">
          <div class="add-event-header">
            <div class="title">Add Event</div>
            <i class="fas fa-times close"></i>
          </div>
          <div class="add-event-body">
            <div class="add-event-input">
              <input type="text" placeholder="Event Name" class="event-name" />
            </div>
            <div class="add-event-input">
              <input type="text" placeholder="Event Time From" class="event-time-from" />
            </div>
            <div class="add-event-input">
              <input type="text" placeholder="Event Time To" class="event-time-to" />
            </div>
          </div>
          <div class="add-event-footer">
            <button class="add-event-btn">Add Event</button>
          </div>
        </div>
      </div>
      <button class="add-event">
        <i class="fas fa-plus"></i>
      </button>
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

  <script>
    const sliderContainer = document.querySelector('.slider-container');
    const sliderImages = document.querySelector('.slider-img');
    const prevBtn = document.getElementById('prev1');
    const nextBtn = document.getElementById('next1');

    const slidesNumber = sliderImages.children.length;
    const slideWidth = sliderContainer.clientWidth / 3;

    let currentIndex = 0;

    function moveToNextSlide() {
        if (currentIndex < slidesNumber - 3) {
            currentIndex++;
        } else {
            currentIndex = 0;
        }
        sliderImages.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
    }

    function moveToPrevSlide() {
        if (currentIndex > 0) {
            currentIndex--;
        } else {
            currentIndex = slidesNumber - 3;
        }
        sliderImages.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
    }

    nextBtn.addEventListener('click', moveToNextSlide);
    prevBtn.addEventListener('click', moveToPrevSlide);
  </script>
  <script src="../JS/main.js"></script>
  <script src="../JS/calendar.js"></script>
</body>
</html>
<?php 
  $conn->close();
} else {
  header("Location: index.php");
  exit();
} 
?>