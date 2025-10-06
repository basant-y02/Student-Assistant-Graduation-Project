<?php
include('db-connection.php');
session_start();

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if (password_verify($password, $row['password'])) {
            if ($role === $row['role']) {
                $_SESSION['fullname'] = $row['first_name'] . " " . $row['last_name'];
                $_SESSION['role'] = $row['role'];
                $_SESSION['user_id'] = $row['id'];
				$_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['profile_photo'] = base64_encode($row['profile_image']);
				
                
                if ($role === 'admin') {
					header("Location: ../index.php?success=Login Successfull!&ddH9fb06YHOOLPlrdH9fb06YHOO9fb06YHOOLPlrh9fb06YHOOLPlrhraVraV&susername=$username&spassword=$password&role=$role&rolesignin=$role");
                    exit();
                } elseif ($role === 'student') {
					header("Location: ../index.php?success=Login Successfull!&zlQ3m6ClOnRAUzsTzlQ3m6ClOnRAUzsTyNppyNpzlQ3m6ClOnRAUzsTyNpppzlQ3m6ClOnRAUzsTyNpp&susername=$username&spassword=$password&role=$role&rolesignin=$role");
                    exit();
                }
            } else {
                header("Location: ../index.php?error=Invalid role for this user!&susername=$username&spassword=$password&role=$role");
                exit();
            }
        } else {
            header("Location: ../index.php?error=Invalid username or password!&susername=$username&spassword=$password&role=$role");
            exit();
        }

        
        
} else {
    header("Location: ../index.php");
    exit();
}
?>
