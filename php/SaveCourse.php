<?php
include '../php/db-connection.php';
session_start();

if (isset($_POST['courseName']) && isset($_FILES['courseImage'])) {
    $courseName = mysqli_real_escape_string($conn, $_POST['courseName']);
    $userId = mysqli_real_escape_string($conn, $_POST['user_id']);
    $owner = mysqli_real_escape_string($conn, $_POST['owner']);

    $imageData = file_get_contents($_FILES['courseImage']['tmp_name']);

    $sql = "INSERT INTO course (course_name, student_id, owner_name, course_picture) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $courseName, $userId, $owner, $imageData);

    if ($stmt->execute()) {
        header("Location: ../PAGES/course.php?success=Course added successfully!");
    } else {
        header("Location ../PAGES/course.php?error=Failed to add course! " . $conn->error);
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../PAGES/course.php?error=Mandatory fields are missing!");
    exit();
}
?>


