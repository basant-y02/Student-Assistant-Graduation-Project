<?php
include '../php/db-connection.php';

if (isset($_GET['course_id'])) {
    $courseId = $_GET['course_id'];

    $sql = "DELETE FROM course WHERE course_id = '$courseId'"; 

    if ($conn->query($sql) === TRUE) {
        header("Location: ../PAGES/course.php?success=Course deleted successfully!"); // Correct redirect
    } else {
        header("Location: ../PAGES/course.php?error=Failed to delete course! "); // Correct redirect
    }
} else {
    header("Location: ../PAGES/course.php?error=Invalid request");
}

$conn->close();
?>