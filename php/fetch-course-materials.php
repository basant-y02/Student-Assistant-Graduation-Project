<?php
include '../php/db-connection.php';
$courseId = $_GET['course_id']; 

$sql = "SELECT * FROM coursematerial WHERE course_id = '$courseId'";
$result = $conn->query($sql);

$courseMaterials = array(
  'lectures' => array(),
  'videos' => array(),
  'quizzes' => array()
);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $material = array(
      'course_material_id' => $row['course_material_id'],
      'material_name' => $row['material_name'],
      'link' => $row['link'],
      'type' => $row['type']
    );
    
    if ($row['type'] === 'lecture') {
      $courseMaterials['lectures'][] = $material;
    } else if ($row['type'] === 'video') {
      $courseMaterials['videos'][] = $material;
    } else if ($row['type'] === 'quiz') {
      $courseMaterials['quizzes'][] = $material;
    }
  }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($courseMaterials);