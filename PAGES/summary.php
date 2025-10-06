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
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Preahvihear&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="../CSS/styles.css" />
    <title>Summary</title>
    <style>
      .loading-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1000;
}

.spinner {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    border: 4px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top: 4px solid #ffffff;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% {
        transform: translate(-50%, -50%) rotate(0deg);
    }
    100% {
        transform: translate(-50%, -50%) rotate(360deg);
    }
}

    .main-content5 {
      width: 900px;
      height: 550px;
      padding: 40px;
      margin: 0 auto;
      margin-top: 30px;
      margin-bottom: 88px;
      color: #333;
      border-radius: 30px;
      justify-content: center;
      background: #B39CD0;
      box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
      font-family: "Preahvihear", sans-serif;
    }

    .tabs {
      display: flex;
      justify-content: center;
      margin-bottom: 20px;
      gap: 80px;
    }

    .tabcontent {
      display: none;
    }

    .tabcontent.active {
      display: block;
    }

    .tablinks {
      font-family: "Preahvihear", sans-serif;
      background-color: #ffffff;
      border: none;
      cursor: pointer;
      padding: 10px 20px;
      border-radius: 50px;
      width: 150px;
      box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
      font-size: 20px;
    }

    .tablinks.active {
      background-color: #320943e3;
      color: white;
      border-radius: 50px;
      width: 150px;
      box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
    }

    .tabcontent {
      text-align: center;
    }

    #url input {
      font-family: "Preahvihear", sans-serif;
      font-size: 15px;
      width: 80%;
      padding: 10px;
      border-radius: 20px;
      border: 1px solid #320943e3;
      background-color: #ffffff;
      margin: 10px 0;
      margin-top: 50px;
      box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
    }

    .tabcontent input:focus {
      outline: none;
    }

    #video input {
      width: 80%;
      padding: 10px;
      border-radius: 20px;
      border: 1px solid #320943e3;
      background-color: #ffffff;
      margin: 10px 0;
      box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
    }

    .btn-summrize {
      display: flex;
      justify-content: center;
    }

    .btn-summrize button {
      font-family: "Preahvihear", sans-serif;
      width: 370px;
      padding: 10px 20px;
      color: white;
      cursor: pointer;
      border-radius: 15px;
      background: #320943e3;
      box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
      font-size: 15px;
      border: none;
    }

    .btn-summrize button:hover {
      background: #e8ebf2;
      color: #000000;
      border: #320943e3;
    }

    .uploadVideo label,
    .uploadFile label {
      position: absolute;
      top: 43%;
      left: 49.4%;
      transform: translate(-47%, -65%);
      color: #ffffff00;
      padding: 100px 190px;
      cursor: pointer;
      border-radius: 10px;
    }

    .uploadVideo input,
    .uploadFile input {
      display: none;
    }

    .uploadVideo img,
    .uploadFile img {
      width: 400px;
      border-radius: 10px;
      box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
      border-radius: 56px;
      border: 1px solid #320943e3;
      background: #dbcfcf;
      opacity: 0.5;
    }
  </style>
  </head>

  <body>
  <div class="loading-overlay" id="loadingOverlay">
    <div class="spinner"></div>
</div>

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
        <li><a href="summary.php" class="active">Summary</a></li>
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
    <div class="main-content5">
      <div class="tabs">
        <button class="tablinks active" onclick="openTab(event, 'url')">
          URL
        </button>
        <button class="tablinks" onclick="openTab(event, 'video')">
          Video
        </button>
        <button class="tablinks" onclick="openTab(event, 'file')">
          File
        </button>
      </div>

      <div id="url" class="tabcontent active">
        <input type="text" id="urlInput" placeholder="Paste your link here ..." />
        <div class="btn-summrize">
          <button onclick="summarizeLink()" style="margin-top: 258px">
            Summarize
          </button>
        </div>
      </div>

      <div id="video" class="tabcontent">
        <div class="uploadVideo">
          <img src="../images/upload.jpg" />
          <label for="videoInput">+</label>
          <input type="file" id="videoInput" accept="video/mp4, video/x-m4v" />
        </div>
        <div class="btn-summrize">
          <button onclick="summarizeVideo()" style="margin-top: 122px">
            Summarize
          </button>
        </div>
      </div>

      <div id="file" class="tabcontent">
        <div class="uploadFile">
          <img src="../images/upload.jpg" />
          <label for="fileInput">+</label>
          <input type="file" id="fileInput" accept=".pdf, .doc, .docx, .ppt, .pptx" />
        </div>
        <div class="btn-summrize">
          <button onclick="summarizeFile()" style="margin-top: 122px">
            Summarize
          </button>
        </div>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
      function openTab(event, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
          tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
          tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(tabName).style.display = "block";
        event.currentTarget.className += " active";
      }

      async function summarizeLink() {
        var urlInputValue = document.getElementById("urlInput").value;
    const formData = new FormData();
    formData.append('link', document.getElementById("urlInput").value);
    const { value: summaryName } = await Swal.fire({
        title: "Input summary name",
        input: "text",
        inputLabel: "Summary Name",
        inputPlaceholder: "Enter summary name"
    });
    if (urlInputValue.trim() !== "") {
        if (summaryName !== undefined && summaryName.trim() !== "") {
          loadingOverlay.style.display = "block";
            formData.append('user_id', <?php echo $_SESSION['user_id']; ?>);
            formData.append('summary_name', summaryName);
            fetch('http://127.0.0.1:5055/processing', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
              loadingOverlay.style.display = "none";
                Swal.fire({
                    text: `Summary '${summaryName}' created successfully!`,
                    icon: 'success'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "summaryView.php";
                    }
                });
            })
            .catch(error => {
              loadingOverlay.style.display = "none";
                console.error('Error:', error);
                Swal.fire({
                    text: "Failed to summarize. Please try again later.",
                    icon: 'error'
                });
            });
        } else {
            Swal.fire({
                text: "Please enter a valid summary name!",
                icon: 'error'
            });
        }
    } else {
        Swal.fire({
            text: "Please enter a valid URL!",
            icon: 'error'
        });
    }
}


async function summarizeVideo() {
    const formData = new FormData();
    formData.append('file', document.getElementById('videoInput').files[0]);
    const { value: summaryName } = await Swal.fire({
        title: "Input summary name",
        input: "text",
        inputLabel: "Summary Name",
        inputPlaceholder: "Enter summary name"
    });

    if (summaryName !== undefined && summaryName.trim() !== "") {
      loadingOverlay.style.display = "block";

        formData.append('user_id', <?php echo $_SESSION['user_id']; ?>);
        formData.append('summary_name', summaryName);

        fetch('http://127.0.0.1:5055/processing', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
          loadingOverlay.style.display = "none";

            Swal.fire({
                text: `Summary '${summaryName}' created successfully!`,
                icon: 'success'
            }).then((result) => {
              loadingOverlay.style.display = "none";
                if (result.isConfirmed) {
                    window.location.href = "summaryView.php";
                }
            });
        })
        .catch(error => {
          loadingOverlay.style.display = "none";
            console.error('Error:', error);
            Swal.fire({
                text: "Failed to summarize video. Please try again later.",
                icon: 'error'
            });
        });
    } else {
      loadingOverlay.style.display = "none";

        Swal.fire({
            text: "Please enter a valid summary name!",
            icon: 'error'
        });
    }
}


async function summarizeFile() {
    const formData = new FormData();
    formData.append('file', document.getElementById('fileInput').files[0]);
    const { value: summaryName } = await Swal.fire({
        title: "Input summary name",
        input: "text",
        inputLabel: "Summary Name",
        inputPlaceholder: "Enter summary name"
    });

    if (summaryName !== undefined && summaryName.trim() !== "") {
      loadingOverlay.style.display = "block";

        formData.append('user_id', <?php echo $_SESSION['user_id']; ?>);
        formData.append('summary_name', summaryName);


        fetch('http://127.0.0.1:5055/processing', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
          loadingOverlay.style.display = "none";

            Swal.fire({
                text: `Summary '${summaryName}' created successfully!`,
                icon: 'success'
            }).then((result) => {
              loadingOverlay.style.display = "none";

                if (result.isConfirmed) {
                    window.location.href = "summaryView.php";
                }
            });
        })
        .catch(error => {
          loadingOverlay.style.display = "none";

            console.error('Error:', error);
            Swal.fire({
                text: "Failed to summarize file. Please try again later.",
                icon: 'error'
            });
        });
    } else {
      loadingOverlay.style.display = "none";

        Swal.fire({
            text: "Please enter a valid summary name!",
            icon: 'error'
        });
    }
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