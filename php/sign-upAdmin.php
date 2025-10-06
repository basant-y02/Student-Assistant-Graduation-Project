<?php
include ('db-connection.php');
exit();
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
    $role = "admin";
    $profile_image = "C:/xampp/htdocs/student/../images/profile.png";
    $imageData = file_get_contents($profile_image);
    $imageBase64 = base64_encode($imageData);

    if ($password !== $confirmPassword) {
        header("Location: ../dashboardAdmin.php?error=Password and Confirm Password should be the same!");
        exit();
    }

    if (empty($first_name) || empty($last_name) || empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
        header("Location: ../SettingsAdmin.php?error=All fields cannot be empty!");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../SettingsAdmin.php?error=Invalid Email!");
        exit();
    }

    if (!preg_match("/^[a-zA-Z0-9]{4,}$/", $password)) {
        header("Location: ../SettingsAdmin.php?error=Password should be at least 4 characters!");
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql_check = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt_check = mysqli_prepare($conn, $sql_check);
    mysqli_stmt_bind_param($stmt_check, "ss", $username, $email);
    mysqli_stmt_execute($stmt_check);
    mysqli_stmt_store_result($stmt_check);

    if (mysqli_stmt_num_rows($stmt_check) > 0) {
        header("Location: ../SettingsAdmin.php?error=Username or Email already exists!");
        exit();
    }

    $sql_insert = "INSERT INTO users (first_name, last_name, username, email, password, imageBase64, role) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = mysqli_prepare($conn, $sql_insert);

    if ($stmt_insert) {
        mysqli_stmt_bind_param($stmt_insert, "sssssss", $first_name, $last_name, $username, $email, $hashed_password, $imageBase64, $role);

        if (mysqli_stmt_execute($stmt_insert)) {
            mysqli_stmt_close($stmt_insert);
            mysqli_stmt_close($stmt_check);
            mysqli_close($conn);
            header("Location: ../SettingsAdmin.php?success=Account Created Successfully!!");
            exit();
        } else {
            mysqli_stmt_close($stmt_insert);
            mysqli_stmt_close($stmt_check);
            mysqli_close($conn);
            header("Location: ../SettingsAdmin.php?error=Error occurred! Please try again.");
            exit();
        }
    } else {
        mysqli_stmt_close($stmt_insert);
        mysqli_stmt_close($stmt_check);
        mysqli_close($conn);
        header("Location: ../SettingsAdmin.php?error=Error occurred! Please try again.");
        exit();
    }


}
?>