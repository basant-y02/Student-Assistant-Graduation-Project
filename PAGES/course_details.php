<?php
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['fullname']) && $_SESSION['role'] == 'student') {
  include '../php/db-connection.php';
  $courseId = $_GET['course_id'];
  $studentId = $_GET['student_id'];

  $sql = "SELECT course_name, course_picture FROM course WHERE course_id = '$courseId' AND student_id = '$studentId'";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $courseName = $row['course_name'];
  $courseImage = base64_encode($row['course_picture']);



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
  
  $conn->close();
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Kameron:wght@400..700&family=Marko+One&family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Preahvihear&display=swap" rel="stylesheet" />
    <title>Course Details</title>
    <link rel="stylesheet" href="../CSS/styles.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <style>
    .main-content {
      width: 90%;
      max-width: 1200px;
      padding: 20px;
      text-align: center;
      color: #333;
      border-radius: 15px;
      background: #B39CD0;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      margin: 20px auto;
      margin-bottom: 30px;
      min-height: 523px;
      bottom: 0%;
    }

    .main-content img {
      width: 100%;
      max-width: 400px;
      height: 100%;
      max-height: 300px;
      margin: 20px 0;
      border-radius: 15px;
      margin-bottom: 30px;
    }

    .main-content h1 {
      color: #000;
      text-align: center;
      font-feature-settings: "dlig" on;
      text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25),
        0px 4px 4px rgba(0, 0, 0, 0.25);
      font-family: "Marko One";
      font-size: 48px;
      font-style: normal;
      font-weight: 400;
      line-height: 21px;
      margin-bottom: 30px;
    }

    .section {
      background: #8560b9b6;
      border-radius: 15px;
      margin: 20px 0;
      padding: 20px;
      border: 1px #000 solid;
    }

    .section h2 {
      color: #000;
      font-feature-settings: "dlig" on;
      text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25),
        0px 4px 4px rgba(0, 0, 0, 0.25);
      font-family: Martel;
      font-size: 35px;
      font-style: normal;
      font-weight: 300;
      line-height: 21px;
      text-decoration-line: underline;
    }

    .file-list,
    .video-list,
    .quiz-list {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-around;
      list-style-type: none;
      padding: 0;
    }

    .file-item,
    .video-item,
    .quiz-item {
      width: 100px;
      margin: 10px;
      text-align: center;
      position: relative;
    }
    .item-name{
      font-size: 17px;
      font-weight: 700;
      position: relative;
      top: 10px;
      right: 12px;

    }

    .file-item img,
    .video-item img,
    .quiz-item img {
      width: 100%;
      height: auto;
      max-width: 100px;
    }

    .file-item p,
    .video-item p,
    .quiz-item p {
      margin: 5px 0 0 0;
    }

    .list {
      display: flex;
      justify-content: space-between;
    }

    .add-btn {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 2px;
      color: #000;
      font-family: Merriweather;
      font-size: 10px;
      font-style: normal;
      background: #8560b900;
      border: none;
      cursor: pointer;
    }

    .add-btn img {
      justify-content: center;
      width: 30px;
      height: 30px;
      margin: 0;
    }

    .remove-btn {
      position: relative;
      top: -105px;
      right: 5px;
      background: #ff0000;
      color: #fff;
      border: none;
      border-radius: 50%;
      width: 20px;
      height: 20px;
      cursor: pointer;
      font-size: 14px;
    }

    dialog {
      width: 350px;
      height: 300px;
      padding: 20px;
      border: 1px solid #000;
      border-radius: 15px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      background: #B39CD0;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 1000;
    }

    dialog form {
      display: flex;
      flex-direction: column;
      gap: 10px;
      margin-top: 50px;
    }

    dialog input {
      padding: 10px;
      border: 1px solid #000;
      border-radius: 5px;
    }

    dialog menu {
      display: flex;
      justify-content: space-between;
    }

    dialog button {
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .cancel {
      padding: 10px 20px;
      background-color: #6c757d;
      color: #fff;
      border: none;
      cursor: pointer;
      border-radius: 5px;
      margin-top: 10%;
    }

    .submit {
      padding: 10px 20px;
      background-color: #320943e3;
      color: #fff;
      border: none;
      cursor: pointer;
      border-radius: 5px;
      margin-top: 10%;
    }

    .submit:hover {
      background: #8560b9b6;
      color: #fff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    dialog::backdrop {
      background: rgba(0, 0, 0, 0.5);
    }

    #materialLink {
      display: none;
    }

    .back-btn {
      background: #320943e3;
      color: #fff;
      border: none;
      border-radius: 5px;
      padding: 10px 20px;
      cursor: pointer;
      margin-top: 20px;
      margin-left: 1000px;
      width: 100px;
      font-weight: 700;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);

    }

    .back-btn:hover {
      background: #000;
      color: #fff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
        <li><a href="course.php" class="active">Courses</a></li>
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
              <img src="<?php echo $ProfileImage ? 'data:image/png;base64,' . $ProfileImage : '../images/profile.png'; ?>" >

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
      <a><img id="courseImage" src="data:image/png;base64,<?php echo $courseImage; ?>" alt="Course Image" /></a>
      <h1 id="courseName"><?php echo $courseName; ?></h1>

      <div class="section">
        <div class="list">
          <h2>Material</h2>
          <button class="add-btn" onclick="uploadMaterial('lecture')">
            <img src="../images/Add File.png" alt="Add Material" />
            New Material
          </button>
        </div>
        <ul class="file-list" id="file-list">
        </ul>
      </div>

      <div class="section">
        <div class="list">
          <h2>Videos</h2>
          <button class="add-btn" onclick="uploadMaterial('video')">
            <img src="../images/Add File.png" alt="Add Video" />
            New Video
          </button>
        </div>
        <ul class="video-list" id="video-list">
        </ul>
      </div>

      <div class="section">
        <div class="list">
          <h2>Quizzes</h2>
          <button class="add-btn" onclick="uploadMaterial('quiz')">
            <img src="../images/Add File.png" alt="Add Quiz" />
            New Quiz
          </button>
        </div>
        <ul class="quiz-list" id="quiz-list">
        </ul>
      </div>
      <button class="back-btn" onclick="window.location.href='course.php'">back</button>
    </div>


    <dialog id="material-dialog">
    <p style='text-align:center; font-size:35px;'>Material Details</p>
  <form id="material-form">
    <input type="text" id="material-name" placeholder="Material Name" required />
    <input type="file" id="material-file" accept=".pdf, .doc, .docx" required />
    <input type="hidden" id="material-type" />
    <menu>
      <button class="cancel" type="button" onclick="document.getElementById('material-dialog').close()">Cancel</button>
      <button class="submit" type="submit">Submit</button>
    </menu>
  </form>
</dialog>

<dialog id="video-dialog">
  <p style='text-align:center; font-size:35px;'>Video Details</p>
  <form id="video-form">
    <input type="text" id="video-name" placeholder="Video Name" required />
    <input type="url" id="video-link" placeholder="Video Link" required />
    <input type="hidden" id="video-type" />
    <menu>
      <button class="cancel" type="button" onclick="document.getElementById('video-dialog').close()">Cancel</button>
      <button class="submit" type="submit">Submit</button>
    </menu>
  </form>
</dialog>

<dialog id="quiz-dialog">
  <p style='text-align:center; font-size:35px;'>Quiz Details</p>
  <form id="quiz-form">
    <input type="text" id="quiz-name" placeholder="Quiz Name" required />
    <input type="file" id="quiz-file" accept=".pdf, .doc, .docx" required />
    <input type="hidden" id="quiz-type" />
    <menu>
      <button class="cancel" type="button" onclick="document.getElementById('quiz-dialog').close()">Cancel</button>
      <button class="submit" type="submit">Submit</button>
    </menu>
  </form>
</dialog>
    <footer>
      <div class="row">
        <div class="col">
          <img src="../images/logo.png" class="logo-footer" >
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
        fetchCourseMaterials();
      });

      function uploadMaterial(type) {
  if (type === 'lecture') {
    document.getElementById('material-dialog').showModal();
    document.getElementById('material-type').value = type;
  } else if (type === 'video') {
    document.getElementById('video-dialog').showModal();
    document.getElementById('video-type').value = type;
  } else if (type === 'quiz') {
    document.getElementById('quiz-dialog').showModal();
    document.getElementById('quiz-type').value = type;
  }
}

function removeMaterial(button) {
    let materialId = button.dataset.materialId;
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('../php/delete-material.php?course_material_id=' + materialId, {
                method: 'DELETE'
            })
            .then(response => {
                if (response.ok) {
                    button.parentNode.remove();
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Material deleted successfully.",
                        showConfirmButton: false,
                        timer: 3200
                    });
                } else {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Error deleting material",
                        showConfirmButton: false,
                        timer: 3200
                    });
                }
            })
            .catch(error => {
                console.error('Error deleting material:', error);
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "Error deleting material: " + error,
                    showConfirmButton: false,
                    timer: 3200
                });
            });
        }
    });
}

      function saveMaterial(type, formData) {
        const type_name = type.charAt(0).toUpperCase() + type.slice(1);
  fetch('../php/save-material.php', {
      method: 'POST',
      body: formData
    })
    .then(response => {
      if (response.ok) {
        // Refresh the material list
        fetchCourseMaterials();
        document.querySelector('dialog[open]').close();
        Swal.fire({
          position: "center",
          icon: "success",
          title: type_name +" saved successfully.",
          showConfirmButton: false,
          timer: 3200
        });
        exit();

      } else {
        Swal.fire({
          position: "center",
          icon: "error",
          title: "Error saving material",
          showConfirmButton: false,
          timer: 3200
        });
        exit();
      }
    })
    
}

document.getElementById('material-form').addEventListener('submit', function(event) {
  event.preventDefault();
  let formData = new FormData();
  formData.append('materialName', document.getElementById('material-name').value);
  formData.append('materialFile', document.getElementById('material-file').files[0]);
  formData.append('materialType', document.getElementById('material-type').value);
  formData.append('courseId', '<?php echo $courseId; ?>');
  saveMaterial('lecture', formData);
});

document.getElementById('video-form').addEventListener('submit', function(event) {
  event.preventDefault();
  let formData = new FormData();
  formData.append('materialName', document.getElementById('video-name').value);
  formData.append('materialLink', document.getElementById('video-link').value);
  formData.append('materialType', document.getElementById('video-type').value);
  formData.append('courseId', '<?php echo $courseId; ?>');
  saveMaterial('video', formData);
});

document.getElementById('quiz-form').addEventListener('submit', function(event) {
  event.preventDefault();
  let formData = new FormData();
  formData.append('materialName', document.getElementById('quiz-name').value);
  formData.append('materialFile', document.getElementById('quiz-file').files[0]);
  formData.append('materialType', document.getElementById('quiz-type').value);
  formData.append('courseId', '<?php echo $courseId; ?>');
  saveMaterial('quiz', formData);
});

      // Event listener for form submission
      document.getElementById('material-dialog').querySelector('form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting normally
        saveMaterial('lecture');
      });

      document.getElementById('video-dialog').querySelector('form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting normally
        saveMaterial('video');
      });

      document.getElementById('quiz-dialog').querySelector('form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting normally
        saveMaterial('quiz');
      });

      function downloadMaterial(link,trigger) {
        // Get the base64 encoded content
        let content = link.dataset.materialContent;

        // Create a hidden link and trigger download
        let downloadLink = document.createElement('a');
        downloadLink.href = 'data:application/pdf;base64,' + content; // Adjust mime type if needed
        downloadLink.download = link.parentElement.querySelector('p').textContent + '.pdf'; // Adjust extension if needed
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
      }
    

      // Fetch course materials from the server
      function fetchCourseMaterials() {
        fetch('../php/fetch-course-materials.php?course_id=<?php echo $courseId; ?>')
          .then(response => response.json())
          .then(data => {
            // Update the list elements based on fetched data
            updateMaterialList('file-list', data.lectures);
            updateMaterialList('video-list', data.videos);
            updateMaterialList('quiz-list', data.quizzes);
          })
          .catch(error => {
            Swal.fire({
          position: "center",
          icon: "error",
          title: "Error fetching course materials",
          showConfirmButton: false,
          timer: 3200
        });
          });
      }

      // Update the material list on the page
      function updateMaterialList(listId, materials) {
        const listElement = document.getElementById(listId);
        listElement.innerHTML = ''; // Clear the existing list

        materials.forEach(material => {
          let listItem = document.createElement('li');
          listItem.classList.add(material.type + '-item');

          // Create the link element correctly
          let linkElement = document.createElement('a');
          if (material.link) { // If there's a video link, use it
            linkElement.href = material.link;
            linkElement.target = '_blank'; // Open in new tab
          } else { // Otherwise, use '#' (for lectures and quizzes)
            linkElement.href = '#';
          }
          linkElement.dataset.materialContent = material.content || '';
          linkElement.onclick = function() {
            if (material.type === 'lecture' || material.type === 'quiz') {
              downloadMaterial(this);
            }
          };
          linkElement.innerHTML = `<img src="../images/${material.type}.png" alt="${material.type} File" style="width:80px; height:80px;" />`;

          // Create the rest of the list item content
          let nameElement = document.createElement('p');
          nameElement.textContent = material.material_name;
          nameElement.classList.add('item-name');
          let removeButton = document.createElement('button');
          removeButton.classList.add('remove-btn');
          removeButton.dataset.materialId = material.course_material_id;
          removeButton.textContent = 'x';
          removeButton.onclick = function() {
            removeMaterial(this);
          };

          // Append elements to the list item
          listItem.appendChild(nameElement);
          listItem.appendChild(linkElement);
          listItem.appendChild(removeButton);
          listElement.appendChild(listItem);
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