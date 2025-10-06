<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
    integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kameron:wght@400..700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia">

  <link rel="stylesheet" href="../CSS/styles.css" />
  <link rel="stylesheet" href="../CSS/calendar.css" />

  <title>Dashboard</title>
  <style>
    .main-content {
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
      background: url('../images/Picture.jpg')  no-repeat center center/cover;
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
      font-family: 'Arial Narrow Bold', sans-serif;
      cursor: pointer;
      border-radius: 24px;
      background: #F5C754;
      box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
    }

    </style>

</head>
<body>
    <div class="main-content">

        <div class="background-image">
          <h2>Welcome, Your Name</h2><br>
          <p>The only thing that overcomes hard luck is hard work.” - Harry Golden.</p>
          <button><a href="course.php" style="text-decoration: none;color: #000000;">Study now</a></button>
        </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
              const texts = [
                { title: "Welcome, Your Name", quote: " luck is hard work.” - Harry Golden." },
                { title: "Welcome, Your Name", quote: "overcomes hard luck is hard work.” - Harry Golden." },
                { title: "Welcome, Your Name", quote: "The only thing work.” - Harry Golden." },
                { title: "Welcome, Your Name", quote: "The only thing that overcomes hard luck is hard work.” - Harry Golden." },
                { title: "Welcome, Your Name", quote: "The only .” - Harry Golden." }
              ];
              const images = [
                "../images/Picture1.jpg",
                "../images/Picture1.jpg",
                "../images/Picture1.jpg",
                "../images/Picture1.jpg",
                "../images/Picture2.jpg"
              ];
          
              let index = 0;
              const background = document.querySelector(".background-image");
              const h2 = background.querySelector("h2");
              const p = background.querySelector("p");
          
              function changeContent() {
                h2.textContent = texts[index].title;
                p.textContent = texts[index].quote;
                background.style.backgroundImage = `url('${images[index]}')`;
          
                index = (index + 1) % texts.length; 
              }
          
              setInterval(changeContent, 5000);
            });
          </script>
          
</body>
</html>