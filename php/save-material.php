<?php
  include '../php/db-connection.php';

  // Handle lecture/quiz materials
  if (isset($_POST['materialName']) && isset($_FILES['materialFile']) && isset($_POST['materialType']) && isset($_POST['courseId'])) {
    $materialName = $_POST['materialName'];
    $materialType = $_POST['materialType'];
    $courseId = $_POST['courseId'];

    // Read file content into binary string
    $fileContent = file_get_contents($_FILES['materialFile']['tmp_name']);

    // Save material data to the database
    $sql = "INSERT INTO coursematerial (course_id, material_name, content, type) VALUES ('$courseId', '$materialName', ?, '$materialType')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $fileContent); 
    if ($stmt->execute()) {
      echo "Material saved successfully.";
    } else {
      echo "Error saving material: " . $conn->error;
    }
    $stmt->close();
  }

  // Handle video materials (remains the same)
  if (isset($_POST['materialName']) && isset($_POST['materialLink']) && isset($_POST['materialType']) && isset($_POST['courseId'])) {
    $materialName = $_POST['materialName'];
    $materialType = $_POST['materialType'];
    $materialLink = $_POST['materialLink'];
    $courseId = $_POST['courseId'];

    // Save video data to the database
    $sql = "INSERT INTO coursematerial (course_id, material_name, link, type) VALUES ('$courseId', '$materialName', '$materialLink', '$materialType')";
    if ($conn->query($sql) === TRUE) {
      echo "Material saved successfully.";
    } else {
      echo "Error saving material: " . $conn->error;
    }
  }

  $conn->close();
?>