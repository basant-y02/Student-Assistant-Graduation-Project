<?php
include '../php/db-connection.php';
session_start();

if (isset($_FILES['profilePic']) && isset($_POST['user_id'])) {
    $userId = mysqli_real_escape_string($conn, $_POST['user_id']);
    $imageData = file_get_contents($_FILES['profilePic']['tmp_name']);

    $sql = "UPDATE users SET profile_image = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $imageData, $userId); // "s" for string (image data), "b" for blob data type

    if ($stmt->execute()) {
        header("Location: ../PAGES/editProfile.php?success=Profile picture changed successfully!");
    } else {
        header("Location: ../PAGES/editProfile.php?error=Failed to add profile picture! " . $conn->error);
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../PAGES/editProfile.php?error=Mandatory fields are missing!");
    exit();
}
?>


