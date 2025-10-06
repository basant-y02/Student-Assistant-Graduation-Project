<?php 
session_start();
if(isset($_SESSION['username']) && isset($_SESSION['fullname']) && $_SESSION['role'] == 'admin')
{
    include '../php/db-connection.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Feedback</title>
    <link rel="stylesheet" href="../CSS/style2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <style>
        .main_content p {
            color: #717579;
            margin-bottom: 20px;
        }

        .tabcontent {
            display: none;
        }

        .tab {
            margin-bottom: 15px;
        }

        .tabcontent.active {
            display: block;
        }

        .tablinks {
            font-size: large;
        }

        .tab button {
            border: none;
            outline: none;
            cursor: pointer;
            padding: 10px 20px;
            font-size: 18px;
            border-radius: 10px;
            margin-right: 10px;
            background: #E5E8EB;
            color: #000;
            
            }
            
            .tab button.active {
                background: #000;
                color: #E5E8EB;
                border-radius: 10px;
                box-shadow:  5px 5px 20px #e0e0e0,
                            -5px -5px 20px #ffffff;

        }

        .tabcontent {
            margin-top: 15px;
        }

        .tabcontent1,
        .tabcontent2 {
            margin-bottom: 10px;
            padding: 10px;
            cursor: pointer;
        }

        .tabcontent1:hover,
        .tabcontent2:hover {
            background: #c8cbce88;
            border-radius: 10px;
        }

        .tabcontent1 span,
        .tabcontent2 span {
            float: right;
            margin-right: 20px;
            margin-top: -40px;
            font-size: 20px;
            color: #717579;
            width: 44px;
        }

        .tabcontent1 img,
        .tabcontent2 img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }

        .tabcontent1 h3,
        .tabcontent2 h3 {
            margin-left: 70px;
            margin-top: -45px;
            font-size: 15px;
        }

        .tabcontent1 p,
        .tabcontent2 p {
            margin-left: 70px;
            margin-top: 10px;
            font-size: 12px;
            color: #717579;
        }

        .tabcontent1 h6 {
            margin-left: 150px;
            margin-top: -35px;
            font-size: 12px;
            color: #008000;
            border: 1px solid green;
            padding: 3px;
            border-radius: 5px;
            width: 40px;
        }

        .tabcontent2 h6 {
            margin-left: 150px;
            margin-top: -35px;
            font-size: 12px;
            color: #CC0F0F;
            border: 1px solid #CC0F0F;
            padding: 3px;
            border-radius: 5px;
            width: 50px;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            border-radius: 10px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .modal textarea {
            width: 100%;
            height: 100px;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .modal button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .modal button:hover {
            background-color: #45a049;
        }

        .success-message {
            color: green;
            display: none;
        }
    </style>
</head>

<body>

    <div class="wrapper">
        <div class="sidebar">
            <div class="head">
                <img src="../images/profile.png" alt="img">
                <h3><?php echo $_SESSION['fullname']; ?></h3>
            </div>
            <ul>
                <li><a href="dashboardAdmin.php"><img src="../images/dashboard.png">Dashboard</a></li>
                <li><a href="StudentInfo.php"><img src="../images/student.png">Students</a></li>
                <li id="active"><a href="FeedbackAdmin.php"><img src="../images/feedbacka.png">Feedback</a></li>
                <li ><a href="SettingsAdmin.php"><img src="../images/settings.png">Settings</a></li>
                <li class="logout"><a href="../php/logout.php"><img src="../images/logout1.png">Logout</a></li>
            </ul>
        </div>
        <div class="main_content">
            <h1>Feedback</h1>
            <p>Read and respond to student feedback</p>
            <div class="tab">
                <button class="tablinks active" onclick="openTab(event, 'all')">All</button>
                <button class="tablinks" onclick="openTab(event, 'unread')">Unread</button>
                <button class="tablinks" onclick="openTab(event, 'read')">Read</button>
            </div>
            <hr>

            <div id="all" class="tabcontent active">
                <div class="tabcontent1" data-status="Read" onclick="openModal(this, 'Error on lesson 1.2', 'Feb 12, 2022', 'Read', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.')">
                    <img src="../images/profile.png" alt="feedback">
                    <h3>Error on lesson 1.2</h3>
                    <p>Feb 12, 2022</p>
                    <h6 class="status">Read</h6>
                    <span>></span>
                </div>
                <div class="tabcontent2" data-status="Unread" onclick="openModal(this, 'Question about the final project', 'Feb 13, 2022', 'Unread', 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.')">
                    <img src="../images/profile.png" alt="feedback">
                    <h3>Question about the final project</h3>
                    <p>Feb 13, 2022</p>
                    <h6 class="status">Unread</h6>
                    <span>></span>
                </div>
                <div class="tabcontent2" data-status="Unread" onclick="openModal(this, 'Comment on lesson 2.1', 'Feb 14, 2022', 'Unread', 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.')">
                    <img src="../images/profile.png" alt="feedback">
                    <h3>Comment on lesson 2.1</h3>
                    <p>Feb 14, 2022</p>
                    <h6 class="status">Unread</h6>
                    <span>></span>
                </div>
            </div>

            <div id="unread" class="tabcontent">
            </div>

            <div id="read" class="tabcontent">
            </div>
        </div>
    </div>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 id="modal-title"></h2>
            <p id="modal-date"></p>
            <p id="modal-message"></p>
            <textarea id="reply-message" placeholder="Type your reply here..."></textarea>
            <button onclick="sendReply()">Send Reply</button>
            <p class="success-message" id="success-message">Reply sent successfully!</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var allMessages = document.querySelectorAll('#all > div');
            var unreadTab = document.getElementById('unread');
            var readTab = document.getElementById('read');

            allMessages.forEach(function (message) {
                var status = message.getAttribute('data-status');
                if (status === 'Unread') {
                    unreadTab.appendChild(message.cloneNode(true));
                } else if (status === 'Read') {
                    readTab.appendChild(message.cloneNode(true));
                }
            });
        });

        function openTab(evt, tabName) {
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
            evt.currentTarget.classList.add("active");
        }

        function openModal(element, title, date, status, message) {
            document.getElementById('modal-title').innerText = title;
            document.getElementById('modal-date').innerText = date;
            document.getElementById('modal-message').innerText = message;
            document.getElementById('myModal').style.display = "block";
            document.getElementById('success-message').style.display = "none";

            if (status === 'Unread') {
                var statusElements = document.querySelectorAll('.tabcontent1[data-status="Unread"] h3, .tabcontent2[data-status="Unread"] h3');
                statusElements.forEach(function (statusElement) {
                    if (statusElement.innerText === title) {
                        var parent = statusElement.parentElement;
                        parent.querySelector('.status').innerText = 'Read';
                        parent.querySelector('.status').style.color = '#008000';
                        parent.querySelector('.status').style.border = '1px solid green';
                        parent.querySelector('.status').style.width = '40px';
                        parent.setAttribute('data-status', 'Read');
                    }
                });

                var unreadTab = document.getElementById('unread');
                var elementToRemove = Array.from(unreadTab.children).find(
                    el => el.querySelector('h3').innerText === title
                );
                if (elementToRemove) {
                    unreadTab.removeChild(elementToRemove);
                }

                var readTab = document.getElementById('read');
                var clone = element.cloneNode(true);
                clone.onclick = element.onclick;
                readTab.appendChild(clone);
            }
        }

        function closeModal() {
            document.getElementById('myModal').style.display = "none";
        }

        function sendReply() {
            setTimeout(() => {
                document.getElementById('success-message').style.display = "block";
            }, 500);
        }

        window.onclick = function (event) {
            if (event.target == document.getElementById('myModal')) {
                document.getElementById('myModal').style.display = "none";
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