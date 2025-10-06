<?php
include('db-connection.php');

function validate($data)
{
    $data = trim($data);
    $data = strip_tags($data);
    $data = filter_var($data, FILTER_SANITIZE_STRING);
    return $data;
}

if (isset($_POST['submit'])) {
    $first_name = validate($_POST['first_name']);
    $last_name = validate($_POST['last_name']);
    $username = validate($_POST['username']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $role = "student";
    $profile_image_url = 'https://drive.google.com/file/d/17HpOOjtAVMAYAnKAXfDX7KZiPQd3hy6p/view?usp=drive_link';
    
    $image_data = file_get_contents($profile_image_url);
    $image_base64 = base64_encode($image_data);
	$errorParams = "first_name=$first_name&last_name=$last_name&username=$username&email=$email&password=$password&confirmPassword=$confirmPassword";


    if ($password !== $confirmPassword) {
        header("Location: ../index.php?error=Password and Confirm Password should be the same!&$errorParams");
        exit();
    }
    
    if (empty($first_name) || empty($last_name) || empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
        header("Location: ../index.php?error=All fields cannot be empty!");
        exit();
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../index.php?error=Invalid Email!&$errorParams");
        exit();
    }
    
    if (!preg_match("/^[a-zA-Z0-9]{4,}$/", $password)) {
         header("Location: ../index.php?error=Password should be at least 4 characters!&$errorParams");
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $sql_check = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt_check = mysqli_prepare($conn, $sql_check);
    mysqli_stmt_bind_param($stmt_check, "ss", $username, $email);
    mysqli_stmt_execute($stmt_check);
    mysqli_stmt_store_result($stmt_check);

    if (mysqli_stmt_num_rows($stmt_check) > 0) {
        mysqli_stmt_close($stmt_check);
        header("Location: ../index.php?error=Username or Email already exists!&$errorParams");
        exit();
    }
    
    mysqli_stmt_close($stmt_check);

    $sql_insert = "INSERT INTO users (first_name, last_name, username, email, password, role) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_insert = mysqli_prepare($conn, $sql_insert);

    if ($stmt_insert) {
        mysqli_stmt_bind_param($stmt_insert, "ssssss", $first_name, $last_name, $username, $email, $hashed_password, $role);
        
        if (mysqli_stmt_execute($stmt_insert)) {
            mysqli_stmt_close($stmt_insert);
            mysqli_close($conn);
            header("Location: ../index.php?success=Account Created Successfully!!");
            exit();
        } else {
            mysqli_stmt_close($stmt_insert);
            mysqli_close($conn);
			header("Location: ../index.php?error=Error occurred! Please try again.&$errorParams");
            exit();
        }
    } else {
        mysqli_close($conn);
        header("Location: ../index.php?error=Error occurred! Please try again.&$errorParams");
        exit();
    }
}
?>
