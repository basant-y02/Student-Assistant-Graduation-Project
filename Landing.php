<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia">
    <link rel="stylesheet" href="CSS/styles.css">
    <style>
        ul {
            display: flex;
            justify-content: center;
            list-style: none;
            margin-left: 90px;
        }

        nav .button {
            justify-content: center;
            align-items: center;
            display: flex;
            gap: 20px;
        }

        nav .btn-S {
            width: 84px;
            height: 40px;
            border: none;
            font-family: 'Arial Narrow Bold', sans-serif;
            color: white;
            cursor: pointer;
            border-radius: 24px;
            background: #8A5CFA;
            box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
        }

        nav .btn-G {
            width: 116.734px;
            height: 40px;
            border: none;
            font-family: 'Arial Narrow Bold', sans-serif;
            color: rgb(0, 0, 0);
            cursor: pointer;
            border-radius: 24px;
            background: #F2F0F5;
            box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
        }

        .main-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-top: 30px;
        }

        .background-image {
            width: 925px;
            height: 450px;
            display: flex;
            flex-direction: column;
            border-radius: 10px;
            background: url('images/Landing.png') no-repeat center;
            color: white;
            box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
            margin-bottom: 40px;
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
            font-family: 'Arial Narrow Bold', sans-serif;
            cursor: pointer;
        }

        .background-image .button .btn-SF {
            color: white;
            border-radius: 24px;
            background: #8A5CFA;
            box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
        }

        .background-image .button .btn-L {
            color: rgb(0, 0, 0);
            border-radius: 24px;
            background: #F2F0F5;
            box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
            margin: 0 0 0 20px;
        }

        .background-image .button .btn-SF:hover {
            color: white;
            border-radius: 51px;
            background: #3b2e2e;
        }

        #items {
            margin-bottom: 100px;
        }

        section h1 {
            color: #121217;
            text-align: center;
            font-feature-settings: 'dlig' on;
            font-size: 58px;
            font-family: "Sofia", sans-serif;
            font-weight: 400;
            line-height: 24px;
            letter-spacing: 0.5px;
            margin-bottom: 40px;
            margin-top: 40px;
        }

        section .item1,
        .item2,
        .item3 {
            justify-content: center;
            align-items: center;
            display: flex;
            gap: 150px;
        }

        section .item1 p,
        .item2 p,
        .item3 p {
            font-family: 'Arial Narrow Bold', sans-serif;
            font-size: 30px;
            text-shadow: 3px 3px 3px #ababab;

        }

        section #tools {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            margin-top: 80px;
            gap: 20px;
            text-align: center;
            font-style: bold;
            font-family: "Sofia", sans-serif;
            font-size: 20px;
            text-shadow: 3px 3px 3px #ababab;
            margin-bottom: 150px;
        }

        section .button .btn-SF {
            color: white;
            border-radius: 24px;
            background: #8A5CFA;
            box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
            width: 150px;
            height: 50px;
            margin-left: 400px;
            margin-top: 50px;
            margin-bottom: 50px;
            border: none;
            font-size: 20px;
            cursor: pointer;
        }

        section .button .btn-SF:hover {
            color: white;
            border-radius: 51px;
            background: #3b2e2e;
        }

        section .text {
            font-family: 'Arial Narrow Bold', sans-serif;
            font-size: 25px;
            text-shadow: 3px 3px 3px #ababab;

        }
    </style>
</head>

<body>
    <nav>
        <div class="logo2">
            <img src="images/logo.png" class="logo">
            <div class="logo-text">
                <p>Student Assistant</p>
            </div>
        </div>

        <div class="link">
            <ul>
                <li><a href="Landing.php" class="active">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="feature">Feature</a></li>
                <li><a href="contact.php">Contant Us</a></li>
            </ul>
        </div>

        <div class="button">
            <button href="index.php" class="btn-S" onclick="go()">Sign Up</button>
            <button href="index.php"class="btn-G" onclick="go()">Get Started</button>
        </div>
    </nav>

    <div class="main-content">
        <div class="background-image">
            <h2>Get more done with AI-powered tools</h2>
            <p>Create quizzes, generate video summaries, and much more. All for free.</p>
            <div class="button">
                <button href="index.php" class="btn-SF" onclick="go()" >Start for free</button>
                <button class="btn-L">Learn more</button>
            </div>
        </div>

        <section id="items" class="hidden">
            <h1>Our goal is to help students</h1>
            <div class="item1">
                <p class="split-word">Manage their time</p>
                <img src="images/Manage.png">
            </div>
            <div class="item2">
                <img src="images/Understand.png">
                <p class="split-word">Understand complex topics</p>
            </div>
            <div class="item3">
                <p class="split-word">Create engaging content</p>
                <img src="images/Create.png">
            </div>
        </section>

        <section id="tool">
            <h1>AI-powered productivity tools for students</h1>
            <div id="tools">
                <div class="tool1">
                    <img src="images/summary.png">
                    <p>Summarize any video <br> in seconde</p>
                </div>
                <div class="tool2">
                    <img src="images/organize.png">
                    <p>Organize your<br> courses material</p>
                </div>
                <div class="tool3">
                    <img src="images/schedule.png">
                    <p>Schedule your study<br> plan</p>
                </div>
                <div class="tool4">
                    <img src="images/generate.png">
                    <p>Generate quizzes from<br> any online material</p>
                </div>
                <div class="tool5">
                    <img src="images/calculate.png">
                    <p>Calculate your GPA<br> instantly</p>
                </div>
            </div>
        </section>


        <section class="text-end">
            <h1>Ready to get started</h1>
            <p class="text">All our tools are free to use. Sign up now and start creating engaging content in minutes.
            </p>
            <div class="button">
                <button onclick="go()" class="btn-SF">Start for free</button>
            </div>
        </section>

    </div>

    <footer>
        <div class="row">
          <div class="col">
            <img src="images/logo.png" class="logo-footer">
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
      </footer> <script>
    function go() {
        window.location.href = "index.php";
    }           
</script>
</body>

</html>