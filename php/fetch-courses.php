<?php
include '../php/db-connection.php';
session_start();

$courses = [];

$sql = "SELECT course_name, course_picture , course_id FROM course WHERE student_id = '$_SESSION[user_id]'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $courseName = $row['course_name'];
    $courseImage = base64_encode($row['course_picture']); 
    $courseId = $row['course_id']; 

    $courses[] = array(
      'name' => $courseName,
      'image' => $courseImage,
      'id' => $courseId
    );
  }
} else {
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($courses);
?>