<?php 
session_start();
if(isset($_SESSION['username']) && isset($_SESSION['fullname']) && $_SESSION['role'] == 'student')
{
  include '../php/db-connection.php';

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    
    $sql = "INSERT INTO feedback (fullname, email, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $fullname, $email, $message);

    if ($stmt->execute()) {
      header("Location: contactUs.php?success=Feedback submitted successfully.");
    } else {
      header("Location: contactUs.php?error=Error occurred while submitting feedback. Please try again.");
    }


  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Contact Form</title>
    <link rel="stylesheet" href="../CSS/styles.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <style>
      .contact-form-wrapper {
        display: flex;
        background: #B39CD0;
        padding: 50px;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.171);
        width: 100%;
        width: 777.385px;
        margin: 0 auto;
        margin-top: 50px;
        margin-bottom: 50px;
      }

      .contact-form-container {
        flex: 1;
      }

      .contact-image {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        cursor: pointer;
      }

      .contact-image img {
        max-width: 100%;
        height: auto;
      }

      .gif-image {
        display: none;
        position: absolute;
      }

      .contact-form-container h2 {
        color: #320943e3;
        margin-bottom: 15px;
        font-size: 36px;
      }

      .contact-form-container p {
        color: #320943e3;
        margin-bottom: 80px;
        font-size: 18px;
      }

      form {
        display: flex;
        flex-direction: column;
      }

      label {
        margin-bottom: 15px;
        color: #333;
        font-weight: bold;
        font-size: 15px;
      }

      input,
      textarea {
        margin-bottom: 30px;
        padding: 10px;
        border: 2.5px solid #320943e3;
        border-radius: 5px;
        width: 300px;
      }

      button {
        padding: 15px;
        border: none;
        border-radius: 5px;
        background-color: #6d258be3;
        color: white;
        cursor: pointer;
        transition: background-color 0.3s ease;
        width: 300px;
        font-size: 15px;
      }

      button:hover {
        background-color: #320943e3;
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
  <div class="contact-form-wrapper">
      <div class="contact-form-container">
        <h2>Get in touch</h2>
        <p>We are here for you! How can we help?</p>
        <form id="contactForm" method="POST" action="contactUs.php">
          <label for="name">Name</label>
          <input type="text" id="name" name="fullname" value="<?php echo $_SESSION['fullname']; ?>" readonly />

          <label for="email">Email</label>
          <input type="text" id="email" name="email" value="<?php echo $_SESSION['username']; ?>" readonly />
          <label for="message">Message</label>
          <textarea id="message" name="message" rows="4" required></textarea>

          <button type="submit">Submit</button>
        </form>
      </div>
      <div class="contact-image">
        <img src="../images/Contact us.png" alt="Contact us" class="static-image" />
        <img src="../images/Contact us.gif" alt="Contact us" class="gif-image" />
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
      document.addEventListener('DOMContentLoaded', function() {
        const gifImage = document.querySelector('.gif-image');
        const staticImage = document.querySelector('.static-image');

        document.querySelector('.contact-image').addEventListener('mouseenter', function() {
          gifImage.style.display = 'block';
          staticImage.style.display = 'none';
          gifImage.src = '../images/Contact us.gif' + '?t=' + new Date().getTime();
        });

        document.querySelector('.contact-image').addEventListener('mouseleave', function() {
          gifImage.style.display = 'none';
          staticImage.style.display = 'block';
        });
      });
      function getqueryparam(param) {
        let urlparams = new URLSearchParams(window.location.search);
        return urlparams.get(param);
    }

    const error = getqueryparam('error');
    if (error) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: error,
        });
    }

    const success = getqueryparam('success');
    if (success) {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: success,
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
