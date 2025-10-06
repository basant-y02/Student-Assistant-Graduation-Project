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
        <link href="https://fonts.googleapis.com/css?family=Londrina Solid" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
        <link rel="stylesheet" href="../CSS/styles.css" />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <title>Quiz</title>
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

            .container1,
            .container2 {
                width: 95%;
                margin-left: auto;
                margin-right: auto;
                color: #333;
                border-radius: 30px;
                background: #8560b9b6;
                box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
                justify-content: center;
                text-align: center;
                margin-top: 90px;
                margin-bottom: 88px;
            }

            .container1 {
                height: 850px;
            }

            .container2 {
                height: auto;
            }

            .container1 img {
                margin-top: -50px;
            }

            .imgs {
                display: flex;
                justify-content: center;
                margin-top: -70px;
            }

            .imgs .img1 {
                margin-right: 1000px;
            }

            .container1 p {
                color: #000;
                text-align: center;
                font-feature-settings: "dlig" on;
                font-family: "Londrina Solid";
                font-size: 40px;
                font-style: normal;
                font-weight: 400;
                line-height: 144.243%;
                margin-bottom: 80px;
            }

            .create {
                display: flex;
                justify-content: center;
            }

            .create .createQuiz1 {
                margin-right: 500px;
                position: relative;
            }

            .create .createQuiz1 img {
                width: 469.83px;
                height: 215px;
                border-radius: 50px;
                cursor: pointer;
            }

            .createQuiz1 label {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -60%);
                color: rgba(255, 255, 255, 0.089);
                padding: 100px 230px;
                cursor: pointer;
                border-radius: 10px;
            }

            .createQuiz1 input {
                display: none;
            }

            .createQuiz2 img {
                width: 469.83px;
                height: 215px;
                border-radius: 50px;
                cursor: pointer;
            }

            .container2 img {
                margin-top: -50px;
                margin-bottom: 20px;
            }

            .container2 table {
                width: 90%;
                height: 100%;
                border-collapse: collapse;
                border-spacing: 0;
                border-radius: 30px;
                background: #320943e3;
                box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
                margin-left: auto;
                margin-right: auto;
                font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            }

            .container2 table th {
                color: #fff;
                font-size: 20px;
                padding: 10px 20px;
                text-align: center;
                padding: 20px;
            }

            .container2 table td {
                color: #e2e2e2;
                font-size: 18px;
                padding: 10px 20px;
                text-align: center;
                margin: 0 auto;
                padding: 20px;
            }

            .container2 table tr {
                border-bottom: 1px solid #d4d4d462;
            }

            .container2 table td:last-child {
                text-align: center;
            }

            .delete-button {
                background-color: #dc3545;
                color: white;
                border: none;
                padding: 8px 16px;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            .delete-button:hover {
                background-color: #c82333;
            }

            .popup-container {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 999;
            }

            .popup-content {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background-color: white;
                padding: 10px;
                border-radius: 10px;
                box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
                width: 80%;
                max-width: 500px;
                max-height: 400px;
                overflow: auto;
            }

            .popup-content object {
                width: 100%;
                height: 100%;
            }

            .content {
                width: 90%;
                max-width: 1200px;
                padding: 20px;
                text-align: center;
                color: #333;
                border-radius: 15px;
                margin: 20px auto;
            }

            .pdf {
                display: inline-block;
                margin: 10px;
                padding: 10px;
                border: none;
                border-radius: 10px;
                background: #ffffff;
                box-shadow: 0 0 5px hsla(0, 0%, 0%, 0.1);
                cursor: pointer;
            }

            .pdf:hover {
                scale: 1.1;
                transition-delay: 0.5ms;
            }

            .popup-buttons {
                text-align: center;
                margin-top: 20px;
            }

            .popup-buttons button {
                padding: 10px 20px;
                margin: 0 10px;
                cursor: pointer;
                background-color: #007bff;
                color: white;
                border: none;
                border-radius: 5px;
            }

            .popup-buttons button:hover {
                background-color: #0056b3;
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
        <div class="main-conten">
            <div class="container1">
                <div class="cloud">
                    <img src="../images/cloudQ.png" />
                </div>
                <div class="imgs">
                    <div class="img1">
                        <img src="../images/Q.png" />
                    </div>
                    <div class="img2">
                        <img src="../images/Boy thinking about the question.png" />
                    </div>
                </div>
                <p>
                    Ready to turn your study materials into engaging quizzes? <br />This
                    is the place!
                </p>

                <div class="create">
                    <div class="createQuiz1">
                        <img src="../images/1fMaterial.jpg" />
                        <label for="input-file">+</label>
                        <input type="file" accept=".pdf, .doc, .docx" id="input-file" />
                    </div>
                    <div class="createQuiz2">
                        <img src="../images/fSummary.png" id="createQuiz2Image" />
                    </div>
                </div>
            </div>
            <div class="container2">
                <div class="cloud">
                    <img src="../images/cloudH.png" />
                </div>
                <div class="table">
                    <table>
                        <tr>
                            <th>Quiz ID</th>
                            <th>Name</th>
                            <th>Taken date</th>
                            <th>Grade</th>
                            <th>Review</th>
                            <th>Delete</th>
                        </tr>
                        <tr>
                            <td>2502</td>
                            <td>Binary and Logic Gates</td>
                            <td>Jan 25, 2024</td>
                            <td>7/10</td>
                            <td><a href="#">view</a></td>
                            <td><button class="delete-button" onclick="deleteQuizRow(this)">Delete</button></td>
                        </tr>
                        <tr>
                            <td>5678</td>
                            <td>Algorithmic Strategies for Problem Solving</td>
                            <td>Feb 12, 2024</td>
                            <td>9/10</td>
                            <td><a href="#">view</a></td>
                            <td><button class="delete-button" onclick="deleteQuizRow(this)">Delete</button></td>
                        </tr>
                        <tr>
                            <td>1234</td>
                            <td>Introduction to Python Programming</td>
                            <td>Mar 10, 2024</td>
                            <td>8/10</td>
                            <td><a href="#">view</a></td>
                            <td><button class="delete-button" onclick="deleteQuizRow(this)">Delete</button></td>
                        </tr>
                        <tr>
                            <td>7890</td>
                            <td>Data Structures and Algorithms</td>
                            <td>Apr 5, 2024</td>
                            <td>5/10</td>
                            <td><a href="#">view</a></td>
                            <td><button class="delete-button" onclick="deleteQuizRow(this)">Delete</button></td>
                        </tr>
                        <tr>
                            <td>4567</td>
                            <td>Machine Learning Fundamentals</td>
                            <td>May 1, 2024</td>
                            <td>9/10</td>
                            <td><a href="#">view</a></td>
                            <td><button class="delete-button" onclick="deleteQuizRow(this)">Delete</button></td>
                        </tr>
                    </table>
                </div>
                <br />
            </div>

            <div class="popup-container">
                <div class="popup-content">
                    <div id="summary-list">
                        <!-- Summaries will be dynamically loaded here -->
                    </div>
                    <div class="popup-buttons">
                        <button id="submit-btn">Submit</button>
                        <button id="cancel-btn">Cancel</button>
                    </div>
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
        <script>

            
document.addEventListener("DOMContentLoaded", function() {
    var createQuiz2Image = document.getElementById("createQuiz2Image");
    var popupContainer = document.querySelector(".popup-container");
    var cancelBtn = document.getElementById("cancel-btn");
    var submitBtn = document.getElementById("submit-btn");
    var summaryList = document.getElementById("summary-list");

    createQuiz2Image.addEventListener("click", function() {
        fetchSummariesFromDatabase()
            .then(summaries => {
                renderSummaries(summaries);
                popupContainer.style.display = "block";
            })
            .catch(error => {
                console.error("Error fetching summaries:", error);
                // Handle error, maybe show an alert or message
            });
    });

    cancelBtn.addEventListener("click", function() {
        popupContainer.style.display = "none";
    });

    submitBtn.addEventListener("click", function() {
        popupContainer.style.display = "none";
        var selectedSummary = document.querySelector('input[name="summary"]:checked');
        if (selectedSummary) {
            var summaryName = selectedSummary.getAttribute("data-name");
            var summaryContent = selectedSummary.getAttribute("data-content");

            Swal.fire({
                title: 'Enter Quiz Name',
                input: 'text',
                inputPlaceholder: 'Quiz name',
                showCancelButton: true,
                inputValidator: (value) => {
                    if (!value) {
                        return 'You need to write something!'
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    loadingOverlay.style.display = "block";
                    var quizName = result.value;
                    var userId = "<?php echo $_SESSION['user_id']; ?>";  // Get user ID from session

                    var jsonData = {
                        summarized_text: summaryContent,
                    };
                    const formData = new FormData();
                    formData.append('Data', JSON.stringify(jsonData));
                    formData.append('Quiz_name', quizName);
                    formData.append('User_ID', userId);
                    
                    fetch('http://127.0.0.1:5005/GeneratingQuiz', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => {
                            if (!response.ok) {
                                loadingOverlay.style.display = "none";
                                return response.json().then(errorData => {
                                    throw new Error(errorData.error || 'Failed to submit quiz');
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            loadingOverlay.style.display = "none";
                            Swal.fire({
                                icon: 'success',
                                title: 'Get Ready!',
                                text: 'Quiz generated successfully\nMoving to quiz ...',
                                timer: 3000,
                                timerProgressBar: true,
                                willClose: () => {
                                    window.location.href = 'take-quiz.php';
                                }
                            });
                        })
                        .catch(error => {
                            loadingOverlay.style.display = "none";
                            console.error('Error submitting data:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: error.message,
                            });
                        });
                }
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please select a summary to submit!',
            });
        }
    });

    function fetchSummariesFromDatabase() {
        return new Promise((resolve, reject) => {
            // AJAX request to fetch summaries from PHP endpoint
            fetch('../php/fetch-summaries.php')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    resolve(data); // Resolve with fetched summaries
                })
                .catch(error => {
                    reject(error); // Handle errors
                });
        });
    }

    function renderSummaries(summaries) {
        summaryList.innerHTML = '';
        summaries.forEach((summary, index) => {
            var summaryHtml = `
            <div class="summary-item" style="background-color:#f7faf8; padding:5px; border:2px solid #cbd1cd; border-radius:10px; margin:5px;">
                <input type="radio" name="summary" id="summary${index}" 
                    data-name="${summary.name}" data-content="${summary.content}">
                <label for="summary${index}" style="font-size:20px; font-family:Londrina Solid;">${summary.name}</label>
            </div>
        `;
            summaryList.insertAdjacentHTML('beforeend', summaryHtml);
        });
    }
});



document.addEventListener("DOMContentLoaded", function() {
    var inputFile = document.getElementById("input-file");

    inputFile.addEventListener("change", function(event) {
        var file = event.target.files[0];

        if (file) {
            Swal.fire({
                title: 'Enter Quiz Name',
                input: 'text',
                inputPlaceholder: 'Quiz name',
                showCancelButton: true,
                inputValidator: (value) => {
                    if (!value) {
                        return 'You need to write something!';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    loadingOverlay.style.display = "block";
                    var quizName = result.value;
                    var userId = "<?php echo $_SESSION['user_id']; ?>"; // Get user ID from session

                    var formData = new FormData();
                    formData.append('file', file);
                    formData.append('Quiz_name', quizName);
                    formData.append('User_ID', userId);

                    fetch('http://127.0.0.1:5005/GeneratingQuiz', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => {
                            if (!response.ok) {
                                loadingOverlay.style.display = "none";
                                return response.json().then(errorData => {
                                    throw new Error(errorData.error || 'Failed to submit quiz');
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            loadingOverlay.style.display = "none";
                            Swal.fire({
                                icon: 'success',
                                title: 'Get Ready!',
                                text: 'Quiz generated successfully\nMoving to quiz ...',
                                timer: 5000,
                                timerProgressBar: true,
                                willClose: () => {
                                    window.location.href = 'quizView.php';
                                }
                            });
                        })
                        .catch(error => {
                            loadingOverlay.style.display = "none";
                            console.error('Error submitting data:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: error.message,
                            });
                        });
                }
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please select a file to create a quiz!',
            });
        }
    });
});


            function deleteQuizRow(button) {
                var row = button.parentNode.parentNode;
                var confirmation = confirm("Are you sure you want to delete this quiz?");
                if (confirmation) {
                    row.parentNode.removeChild(row);
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