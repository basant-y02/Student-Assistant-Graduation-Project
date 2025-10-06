<?php 
session_start();
if(isset($_SESSION['username']) && isset($_SESSION['fullname']) && $_SESSION['role'] == 'admin')
{
    include '../php/db-connection.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Student</title>
    <link rel="stylesheet" href="../CSS/style2.css">
    <style>
        input[type=text] {
            width: 98%;
            padding: 12px 20px;
            margin: 8px 0;
            box-sizing: border-box;
            border: 1px solid #E5E8EB;
            border-radius: 10px;
            background: #E5E8EB;
        }
        table {
            width: 98%;
            border-collapse: collapse;
            margin-top: 20px;
            border: solid 2px #ccd0d3;        
        }

        tr {
            border-bottom: 2px solid #ccd0d3;
            margin-top: 50px;
        }
        
        th {
            text-align: left;
            font-size: 15px;
        }

        td {
            font-size: 15px;
            color: #717579;
        }
        
        th, td {
            padding: 10px;
        }

        .delete-btn {
            background-color: #ff4c4c;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .delete-btn:hover {
            background-color: #ff1a1a;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>

    <div class="wrapper">
        <div class="sidebar">
            <div class="head">
                <img src="../images/profile.png" alt="img">
                <h3><?php echo $_SESSION['fullname']; ?></h3>
            </div>
            <ul>
                <li><a href="dashboardAdmin.php"><img src="../images/dashboard.png">Dashboard</a></li>
                <li id="active"><a href="StudentInfo.php"><img src="../images/studenta.png">Students</a></li>
                <li ><a href="FeedbackAdmin.php"><img src="../images/feedback.png">Feedback</a></li>
                <li ><a href="SettingsAdmin.php"><img src="../images/settings.png">Settings</a></li>
                <li class="logout"><a href="../php/logout.php"><img src="../images/logout1.png">Logout</a></li>
            </ul>
        </div>
        <div class="main_content">
            <h1>Students</h1>
            <input type="text" placeholder="Search by name, email, or ID">
            <?php
            include '../php/db-connection.php';
            $sql = "SELECT CONCAT(first_name, ' ', last_name) AS fullname, id, email, created_at , last_seen FROM users WHERE role = 'student'";
            
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
            echo "<table>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Name</th>";
            echo "<th>ID</th>";
            echo "<th>Email</th>";
            echo "<th>Joined</th>";
            echo "<th>Last seen</th>";
            echo "<th>Action</th>";
            echo "</tr>";
            echo "</thead>";
            while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["fullname"] . "</td>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            echo "<td>" . date("M d, Y", strtotime($row["created_at"])) . "</td>";
            echo "<td>" . date("M d, Y H:i:s", strtotime($row["last_seen"])) . "</td>"; 
            echo "<td><button class='delete-btn' onclick='deleteRow(this, " . $row["id"] . ")'>Delete</button></td>";
            echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}
?>
        </div>
    </div>

    <script>
        function searchTable() {
            const input = document.querySelector('input[type="text"]');
            const filter = input.value.toLowerCase();
            const table = document.querySelector('table');
            const tr = table.querySelectorAll('tr');

            tr.forEach((row, index) => {
                if (index === 0) return;
                const td = row.querySelectorAll('td');
                const match = Array.from(td).some(cell => cell.textContent.toLowerCase().includes(filter));
                row.style.display = match ? '' : 'none';
            });
        }

        function deleteRow(btn, id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'php/delete-student.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200 && xhr.responseText === 'success') {
                    const row = btn.parentNode.parentNode;
                    row.parentNode.removeChild(row);
                    Swal.fire(
                        'Deleted!',
                        'The student has been deleted.',
                        'success'
                    )
                } else {
                    Swal.fire(
                        'Error!',
                        'There was an error deleting the student.',
                        'error'
                    )
                }
            };
            xhr.send('id=' + id);
        }
    })
}

document.addEventListener('DOMContentLoaded', () => {
    const input = document.querySelector('input[type="text"]');
    input.addEventListener('keyup', searchTable);
});
    </script>
</body>
</html>
<?php 
  $conn->close();
} else {
  header("Location: index.php");
  exit();
} 
?>
