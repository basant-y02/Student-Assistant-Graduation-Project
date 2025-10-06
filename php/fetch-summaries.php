<?php
include 'db-connection.php'; // Adjust path as necessary
session_start();

$summaries = [];

$sql = "SELECT summary_name, content FROM summary WHERE student_id = '$_SESSION[user_id]'"; 
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $summaryName = $row['summary_name'];
        $summaryContent = $row['content'];

        $summaries[] = array(
            'name' => $summaryName,
            'content' => $summaryContent
        );
    }
} else {
    // No summaries found
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($summaries);
?>
