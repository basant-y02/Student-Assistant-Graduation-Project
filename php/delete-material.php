<?php
include '../php/db-connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $materialId = $_GET['course_material_id'];

    $sql = "DELETE FROM coursematerial WHERE course_material_id = '$materialId'";

    if ($conn->query($sql) === TRUE) {
        echo "Material deleted successfully";
    } else {
        echo "Error deleting material: " . $conn->error;
    }

    $conn->close();
}
?>
