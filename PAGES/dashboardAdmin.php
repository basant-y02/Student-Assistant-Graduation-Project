<?php 
session_start();
if(isset($_SESSION['username']) && isset($_SESSION['fullname']) && $_SESSION['role'] == 'admin')
{
    include '../php/db-connection.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Dashboard</title>
    <link rel="stylesheet" href="../CSS/style2.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
      .stats {
        display: flex;
        justify-content: space-evenly;
        margin: 40px 0px 40px -160px;
      }

      .stat {
        background-color: #F0F2F5;
        box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
        padding: 20px;
        text-align: center;
        border-radius: 8px;
        width: 20%;
      }

      .stat img {
        margin-right: 210px;
        width: 40px;

      }

      .stat p {
        margin-top: -40px;
        color: #8E8E8E;
      }

      .stat h3 {
        margin-top: 10px;
      }

      .stat p , .stat h3{
        font-family: Kameron;
      }

      .statMessages {
        background-color: #000000;
        box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
        color: #fff;
        cursor: pointer;
        text-align: left;
        border-radius: 8px;
        width: 20%;
        padding: 20px;
      }

      .statMessages a {
        text-decoration: none;
        color: #fff;
        padding: 20px 195px 30px;
        font-size: 15px;
      }

      .statMessages img {
        margin-left: 180px;
        margin-top: -30px;
        width: 40px;
      }

      .statMessages span {
        background-color: #FF4C4C;
        border-radius: 50%;
        color: #fff;
        padding: 5px 10px;
        position: relative;
        top: -32px;
        left: 250px;
      }

      .statMessages .animation:hover {
        transition: transform 0.5s;
        transform: translateX(20px);
      }

      .charts {
        display: flex;
        justify-content: space-around;
      }

      .chart {
        width: 45%;
      }

        .chart h3 {
            margin-left: -35px;
        }

      /* New styles for the rectangles */
      .new-stats {
        display: flex;
        flex-wrap: wrap; /* Allow wrapping to 3 rectangles per row */
        justify-content: space-between;
        margin: 40px 0;
        
      }

      .new-stat {
        background-color: #fff;
        box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
        padding: 20px;
        text-align: center;
        border-radius: 8px;
        width: 30%; /* Adjust width for 3 rectangles per row */
        height: 150px; /* Fixed height for consistent look */
        color: #fff;
        font-family: 'Roboto', sans-serif; /* Premium font */
        margin-bottom: 20px;
      }

      .new-stat.user-count { background-color: #2980b9; } /* Blue */
      .new-stat.avg-score { background-color: #f1c40f; } /* Yellow */
      .new-stat.quiz-count { background-color: #2ecc71; } /* Green */
      .new-stat.summary-count { background-color: #e74c3c; } /* Red */
      .new-stat.admin-count { background-color: #9b59b6; } /* Purple */
      .new-stat.active-users { background-color: #3498db; } /* Light Blue */

      .new-stat h3 {
        font-weight: bold;
        font-size: 2.5rem; /* Adjust font size as needed */
        margin-top: 10px;
      }

      .new-stat p {
        margin-top: 5px;
        font-size: 1.5rem; /* Adjust font size as needed */
      }

    </style>
  </head>
  <body>
    <div class="wrapper">
      <div class="sidebar">
        <div class="head">
          <img src="../images/profile.png" alt="img" />
          <h3><?php echo $_SESSION['fullname']; ?></h3>
          </div>
        <ul>
          <li id="active"><a href="dashboardAdmin.php"><img src="../images/dashboarda.png">Dashboard</a></li>
          <li><a href="StudentInfo.php"><img src="../images/student.png">Students</a></li>
          <li ><a href="FeedbackAdmin.php"><img src="../images/feedback.png">Feedback</a></li>
          <li ><a href="SettingsAdmin.php"><img src="../images/settings.png">Settings</a></li>
          <li class="logout"><a href="../php/logout.php"><img src="../images/logout1.png">Logout</a></li>
        </ul>
      </div>

      <div class="main_content">
        <h1>Dashboard</h1>
        <section class="stats">
          <div class="stat">
            <img src="../images/bar-chart.png" />
            <p>Average Rating</p>
            <h3>8/10</h3>
          </div>
          <div class="stat">
            <img src="../images/trend.png" />
            <p>Active tasks</p>
            <h3>12 tasks</h3>
          </div>
          <div class="statMessages">
            <div class="animation">
            <a href="FeedbackAdmin.php">
              <p>You have new messages!</p>
              <img src="../images/arrow.png" />
              <span>1</span>
            </a>
            </div>
          </div>
        </section>
        <section class="charts">
          <div class="chart" id="weekly-chart">
            <h3>This Week</h3>
          </div>
          <div class="chart" id="activities-chart">
            <h3>Activities</h3>
          </div>
        </section>

        <!-- New section for the rectangles -->
        <section class="new-stats">
          <?php
          // Fetch data from the database
          $sql_user_count = "SELECT COUNT(*) FROM users WHERE role = 'student'";
          $result_user_count = $conn->query($sql_user_count);
          $user_count = $result_user_count->fetch_assoc()['COUNT(*)'];

          $sql_avg_score = "SELECT AVG(grade) FROM quiz";
          $result_avg_score = $conn->query($sql_avg_score);
          $avg_score = $result_avg_score->fetch_assoc()['AVG(grade)'];

          $sql_quiz_count = "SELECT COUNT(*) FROM quiz";
          $result_quiz_count = $conn->query($sql_quiz_count);
          $quiz_count = $result_quiz_count->fetch_assoc()['COUNT(*)'];

          $sql_summary_count = "SELECT COUNT(*) FROM summary";
          $result_summary_count = $conn->query($sql_summary_count);
          $summary_count = $result_summary_count->fetch_assoc()['COUNT(*)'];

          $sql_admin_count = "SELECT COUNT(*) FROM users WHERE role = 'admin'";
          $result_admin_count = $conn->query($sql_admin_count);
          $admin_count = $result_admin_count->fetch_assoc()['COUNT(*)'];

          // Simulate last seen users (replace with actual logic)
          $active_users = 5; 

          ?>

          <div class="new-stat user-count">
            <h3><?php echo $user_count; ?></h3>
            <p>Registered Students</p>
          </div>
          <div class="new-stat avg-score">
            <h3><?php echo number_format($avg_score, 2); ?></h3>
            <p>Average Quiz Score</p>
          </div>
          <div class="new-stat quiz-count">
            <h3><?php echo $quiz_count; ?></h3>
            <p>Total Quizzes</p>
          </div>
          <div class="new-stat summary-count">
            <h3><?php echo $summary_count; ?></h3>
            <p>Total Summaries</p>
          </div>
          <div class="new-stat admin-count">
            <h3><?php echo $admin_count; ?></h3>
            <p>Total Admins</p>
          </div>
          <div class="new-stat active-users">
            <h3><?php echo $active_users; ?></h3>
            <p>Active Users</p>
          </div>
        </section>
      </main>
    </div>
  </body>
</html>
<?php 
  $conn->close();
} else {
  header("Location: index.php");
  exit();
} 
?>