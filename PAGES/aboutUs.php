<?php 
session_start();
if(isset($_SESSION['username']) && isset($_SESSION['fullname']) && $_SESSION['role'] == 'student')
{
  include '../php/db-connection.php';

  $sql = "SELECT first_name, last_name, username, email, profile_image FROM users";
  $result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fira+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Francois+One&family=IBM+Plex+Serif:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&family=Inter:wght@100..900&family=Kameron:wght@400..700&family=Marko+One&family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Preahvihear&family=Sanchez:ital@0;1&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Francois+One&family=IBM+Plex+Serif:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&family=Inter:wght@100..900&family=Kameron:wght@400..700&family=Marko+One&family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Preahvihear&display=swap" rel="stylesheet">
    <title>About Us</title>
    <link rel="stylesheet" href="../CSS/styles.css">
    <style>
        body {
          margin: 0;
          padding: 0;
          box-sizing: border-box;
          background-image: url("../images/background_about.jpg");
          background-size: cover;
          background-position: center;
          position: relative;
      }

      .container {
          width: 100%;
          margin: auto;
          text-align: center;
      }

      .hero {
          padding: 100px 0;
          color: white;
      }

      .hero-content {
          display: inline-block;
          padding: 20px;
          border-radius: 10px;
      }

      .hero-content h1 {
          color: #320943e3;
          text-align: center;
          font-family: Nexa;
          font-size: 36px;
          font-style: normal;
          font-weight: 700;
          line-height: normal;
      }

      .hero-content p {
          color: #696969;
          text-align: center;
          font-family: "IBM Plex Serif";
          font-size: 40px;
          font-style: normal;
          font-weight: 700;
          line-height: normal;
          width: 1300px;
      }

      .features {
          display: flex;
          justify-content: center;
          padding: 50px 0;
          gap: 40px;
      }
      

      .card {
          margin: 20px;
          text-align: center;
          display: grid;
          align-items: center;
          justify-items: center;
          cursor: pointer;
      }

      .card1 {
          background-image: url("../images/card1.jpg");
          background-size: cover;
          width: 350px;
          height: 450px;
          border-radius: 10px;
          padding: 20px;
          margin: 20px;
          box-shadow: 0 0 20px rgba(0, 0, 0, 0.171);
          color: #000000;
          text-align: center;
          display: grid;
          align-items: center;
          justify-items: center;
          cursor: pointer;
      }

      .card2 {
          background-image: url("../images/card2.jpg");
          background-size: cover;
          width: 350px;
          height: 450px;
          border-radius: 10px;
          padding: 20px;
          margin: 20px;
          box-shadow: 0 0 20px rgba(0, 0, 0, 0.171);
          color: #000000;
          text-align: center;
          display: grid;
          align-items: center;
          justify-items: center;
          cursor: pointer;
      }

      .card3 {
          background-image: url("../images/card3.jpg");
          background-size: cover;
          width: 350px;
          height: 450px;
          border-radius: 10px;
          padding: 20px;
          margin: 20px;
          box-shadow: 0 0 20px rgba(0, 0, 0, 0.171);
          color: #000000;
          text-align: center;
          display: grid;
          align-items: center;
          justify-items: center;
          cursor: pointer;
      }

      .card:hover {
            transform: scale(1.1);
            transition: 0.5s;
          }

      .card .icon img {
          width: 40px;
          height: 40px;
      }

      .card h2 {
        color: #000;
        text-align: center;
        font-family: "Francois One";
        font-size: 20px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        cursor: text;
        margin-top: 150px;
      }
      
      .card p {
        cursor: text;
        color: #000;
        text-align: center;
        font-family: "Fira Sans";
        font-size: 13px;
        font-style: normal;
        font-weight: 450;
        line-height: normal;
        width: 205px;
      }
    </style>
  </head>
  <body> 
    <nav style="background: #e9e3ffa9;">
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
      <img src="../images/profile.png" onclick="ToggleMenu()" class="user-pic">
  
      <div class="sub-menu-wrap" id="subMenu">
        <div class="sub-menu">
        <div class="user-info">
            <?php if(isset($_SESSION['profile_image'])): ?>
        <img src="data:image/jpeg;base64,<?php echo $_SESSION['profile_image']; ?>">
        <?php endif; ?>
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

    <div class="container">
      <section class="hero" style="background: #e9e3ffa9;">
        <div class="hero-content">
          <h1>Who We Are</h1>
          <p>
            Our platform offers a holistic approach to learning, seamlessly
            integrating registration, account management, material organization,
            smart summarization, quiz generation, and calendar functionalities.
          </p>
        </div>
      </section>
      <section class="features" style="background: #e9e3ffa9;">
        <div class="feature">
          <div class="card">
            <div class="card1">
              <h2>Efficient Learning Journey</h2>
              <p>Embark on an educational journey like never before with our seamless platform. From registration to quiz generation, we're here to propel you towards academic success.</p>
            </div>
        </div>
        </div>
        <div class="feature">
          <div class="card">
            <div class="card2">
              <h2>Innovative Learning Solutions</h2>
              <p>Illuminate your mind with innovative learning solutions. Our platform fosters creativity and sparks ideas, empowering you to unlock your full learning potential.</p>
            </div>
        </div>
        </div>
        <div class="feature">
          <div class="card">
            <div class="card3">
              <h2>Comprehensive Learning Experience</h2>
              <p>Experience learning from every angle with our comprehensive platform. From 360-degree summaries to personalized quizzes, we offer a holistic approach to education.</p>
            </div>
        </div>        
      </div>
      </section>
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
  </body>
</html>
<?php 
  $conn->close();
} else {
  header("Location: index.php");
  exit();
} 
?>