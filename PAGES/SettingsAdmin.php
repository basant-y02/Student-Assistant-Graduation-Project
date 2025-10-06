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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/style2.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kameron:wght@400..700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Settings</title>
    <style>
        .form-container {
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            margin-top: 90px;
        }

        .form-container h2 {
            font-family: 'Kameron', serif;
            font-size: 44px;
            margin-bottom: 30px;
            text-align: center;
        }

        .form-container form {
            display: flex;
            flex-direction: column;
        }

        .form-container form .form-group {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .form-container form label {
            font-family: 'Kameron', serif;
            margin-right: 230px;
            margin-bottom: 20px;
            min-width: 210px;
            font-size: 25px;

        }
        
        .form-container form input, .form-container form select {
            padding: 10px;
            margin-bottom: 20px;
            flex: 1;
            border: none;
            border-radius: 5px;
            background: #E5E8EB;
            max-width: 600px;
            cursor: pointer;
        }

        .form-container form button {
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #409FE4;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            width: 100px;
            margin:30px auto 0 600px;
            font-family: 'Kameron', serif;
        }

        .form-container form button:hover {
            background-color: #0056b3;
            transition: 250ms;
            transform: scale(1.1);
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
                <li><a href="dashboardAdmin.php"><img src="../images/dashboard.png">Dashboard</a></li>
                <li><a href="StudentInfo.php"><img src="../images/student.png">Students</a></li>
                <li><a href="FeedbackAdmin.php"><img src="../images/feedback.png">Feedback</a></li>
                <li id="active"><a href="SettingsAdmin.php"><img src="../images/settingsa.png">Settings</a></li>
                <li class="logout"><a href="../php/logout.php"><img src="../images/logout1.png">Logout</a></li>
            </ul>
        </div>
        <div class="main_content">
            <h1>Settings</h1>
            <div class="form-container">
                <h2>Add User</h2>
                <form id="add-admin-form" method="post" action="../php/sign-upAdmin.php">
                    <div class="form-group">
                        <label for="first-name">First Name:</label>
                        <input type="text" id="first-name" name="first_name">
                    </div>
                    <div class="form-group">
                        <label for="last-name">Last Name:</label>
                        <input type="text" id="last-name" name="last_name">
                    </div>
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password">
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Confirm Password:</label>
                        <input type="password" id="confirmPassword" name="confirmPassword">
                    </div>
                    <div class="form-group">
                        <label for="user-type">User Type:</label>
                        <select id="user-type" name="user_type">
                            <option value="admin">Admin</option>
                            <option value="student">Student</option>
                        </select>
                    </div>
                    <button type="submit" name="submit">Add</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('add-admin-form').addEventListener('submit', function(event) {
            event.preventDefault();

            const userType = document.getElementById('user-type').value;
            const firstName = document.getElementById('first-name').value;
            const lastName = document.getElementById('last-name').value;
            const username = document.getElementById('username').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            if (firstName && lastName && username && email && password && confirmPassword) {
                if (password !== confirmPassword) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Passwords do not match.',
                    });
                    return;
                }

                const formData = new FormData();
                formData.append('first_name', firstName);
                formData.append('last_name', lastName);
                formData.append('username', username);
                formData.append('email', email);
                formData.append('password', password);
                formData.append('confirmPassword', confirmPassword);
                formData.append('user_type', userType);

                fetch('php/sign-upAdmin.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: data.message,
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Username or Email already exists!',
                    });
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please fill in all fields.',
                });
            }
        });
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
