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
    <link href='https://fonts.googleapis.com/css?family=Londrina Solid' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../CSS/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <title>Quiz</title>
    <style>
    body {
      font-family: "Inter", sans-serif;
      margin: 0;
      padding: 0;
    }

    .container4 {
      max-width: 800px;
      margin: 30px auto;
      padding: 20px;
    }

    .table {
      display: flex;
      justify-content: center;
      margin-top: 10px;
    }

    .time_table {
      text-align: center;
      background: #320943e3;
      padding: 40px;
      border: none;
      border-radius: 7px;
      box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
      width: 40%;
    }

    .timer {
      font-size: 20px;
      margin-bottom: 20px;
      margin-top: 20px;
      color: #fff;
    }

    .question-number {
      display: inline-block;
      width: 40px;
      height: 40px;
      line-height: 40px;
      text-align: center;
      margin: 0px 4px;
      border: 1px solid #000;
      border-radius: 7px;
      background: #fff;
      font-size: 20px;
      font-weight: bold;
      color: #000;
    }

    .question-number.answered {
      background-color: #85b6eb;
    }

    .question {
      margin-bottom: 20px;
    }

    .question p {
      font-size: 18px;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .options label {
      display: block;
      padding: 10px;
      background: #f9f9f9;
      border: 1px solid #ddd;
      border-radius: 5px;
      margin-bottom: 10px;
      cursor: pointer;
    }

    .options input[type="radio"] {
      display: none;
    }

    .options input[type="radio"]:checked + label {
      background-color: #85b6eb;
    }

    .options label.correct {
      background-color: #85c694;
    }

    .options label.incorrect {
      background-color: #e72424e1;
    }

    button {
      display: block;
      width: 100%;
      padding: 10px;
      background-color: #320943e3;
      color: white;
      border: none;
      cursor: pointer;
      font-size: 16px;
      border-radius: 7px;
      margin-top: 20px;
      font-family: "Inter", sans-serif;
    }

    button:hover {
      background-color: #B39CD0;
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
          <li><a href="quiz.php" class="active">Quizzes</a></li>
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
            <a href="php/logout.php" class="sub-menu-link">
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
  <div class="container6">
      <div class="table">
    <div class="time_table">
      <div id="timer" class="timer">Time Left: 10:00</div> <p id="score" style="position: relative; bottom:10px; font-size: larger; font-weight: 600; color: #f9f9f9; "></p>
      <div id="questionNumbers"></div>
    </div>
  </div>
  <div class="container4">
    <form id="quizForm"></form>
    <button id="submitButton" onclick="submitQuiz()">Submit</button>
  </div>
  </div>
    <footer>
        <div class="row">
            <div class="col">
                <img src="../images/Logo.png" class="logo-footer">
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
    async function fetchQuizData() {
      const response = await fetch("../API/quiz_data.json");
      const data = await response.json();
      return data;
    }

    const answers = {};
    const quizForm = document.getElementById("quizForm");
    const questionNumbers = document.getElementById("questionNumbers");
    const timerElement = document.getElementById("timer");

    async function loadQuiz() {
      const quizData = await fetchQuizData();
      const questions = quizData.Questions;
      const answersList = quizData.Answers;

      answersList.forEach((answer, index) => {
        answers[index + 1] = answer;
      });

      questions.forEach((question, index) => {
        const questionElement = document.createElement("div");
        questionElement.className = "question";

        if (index >= questions.length - 5) {
          // For the last 5 questions, which are True/False
          questionElement.innerHTML = `
            <p>${question.split('\n\n')[0]}</p>
            <div class="options">
              <input type="radio" id="q${index + 1}o1" name="question${index + 1}" value="True" onchange="markAnswered(${index + 1})">
              <label for="q${index + 1}o1">True</label>
              <input type="radio" id="q${index + 1}o2" name="question${index + 1}" value="False" onchange="markAnswered(${index + 1})">
              <label for="q${index + 1}o2">False</label>
            </div>
          `;
        } else {
          // Extract the question text and the choices using double newline as a separator
          const [questionText, choicesText] = question.split('\n\n');
          const choices = choicesText.split('\n');

          questionElement.innerHTML = `
            <p>${questionText}</p>
            <div class="options">
              ${choices.map((choice, i) => `
                <input type="radio" id="q${index + 1}o${i}" name="question${index + 1}" value="${choice.trim().charAt(0)}" onchange="markAnswered(${index + 1})">
                <label for="q${index + 1}o${i}">${choice.trim()}</label>
              `).join('')}
            </div>
          `;
        }

        quizForm.appendChild(questionElement);

        const questionNumberElement = document.createElement("span");
        questionNumberElement.className = "question-number";
        questionNumberElement.id = `questionNumber${index + 1}`;
        questionNumberElement.textContent = index + 1;
        questionNumbers.appendChild(questionNumberElement);
      });
    }

    let timer;
    function startTimer(duration) {
      let time = duration;
      timer = setInterval(() => {
        const minutes = Math.floor(time / 60);
        const seconds = time % 60;
        timerElement.textContent = `Time Left: ${minutes}:${seconds < 10 ? "0" + seconds : seconds}`;
        time--;
        if (time < 0) {
          clearInterval(timer);
          submitQuiz();
        }
      }, 1000);
    }

    function markAnswered(questionNumber) {
      const questionNumberElement = document.getElementById(`questionNumber${questionNumber}`);
      questionNumberElement.classList.add("answered");
    }

    function submitQuiz() {
      clearInterval(timer);
      const formData = new FormData(quizForm);
      let score = 0;

      formData.forEach((value, key) => {
        const questionNumber = key.replace("question", "");
        const correctAnswer = answers[questionNumber];

        const selectedInput = document.querySelector(`input[name="${key}"]:checked`);
        const selectedLabel = selectedInput.nextElementSibling;
        const correctLabel = document.querySelector(`input[name="${key}"][value="${correctAnswer}"]`).nextElementSibling;

        if (value === correctAnswer) {
          score++;
          selectedLabel.classList.add("correct");
          selectedLabel.style.backgroundColor = "#85c694";
        } else {
          selectedLabel.classList.add("incorrect");
          selectedLabel.style.backgroundColor = "#e72424e1";
        }

        document.querySelectorAll(`input[name="${key}"]`).forEach(input => {
          input.disabled = true;
        });

        const questionNumberElement = document.getElementById(`questionNumber${questionNumber}`);
        if (value === correctAnswer) {
          questionNumberElement.style.backgroundColor = "#85c694"; 
        } else {
          questionNumberElement.style.backgroundColor = "#e72424e1"; 
        }
      });

      Swal.fire({
        icon: 'info',
        title: 'Good job!',
        text: `Your score is ${score} out of ${Object.keys(answers).length}`,
      });

      const quizResultElement = document.getElementById(`score`);
      quizResultElement.textContent = `Score : ${score} \\ ${Object.keys(answers).length}`;


      const submitButton = document.getElementById("submitButton");
      submitButton.textContent = "Back";
      submitButton.setAttribute("onclick", "redirectToCourses()");
    }

    function redirectToCourses() {
      window.location.href = "quiz.php";
    }

    loadQuiz();
    startTimer(10 * 60);
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