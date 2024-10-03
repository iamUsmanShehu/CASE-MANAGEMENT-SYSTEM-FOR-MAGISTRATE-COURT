<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

include 'conn.php';

// Handle Delete Request
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $deleteQuery = "DELETE FROM `civil_matter_registration` WHERE id=$id";
    if ($conn->query($deleteQuery) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// SQL query to retrieve data
$sql = "SELECT `id`, `plaintiff_name`, `defendant_name`, `direction_number`, `file_number`, `court_directed`, `nature_of_claim`, `created_at` FROM `civil_matter_registration` WHERE 1";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
    <title>Case Management System</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #eee;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .action-buttons a {
            margin-right: 10px;
            text-decoration: none;
            padding: 5px;
            background-color: #4CAF50;
            color: white;
            border-radius: 4px;
        }
        .action-buttons a.delete {
            background-color: red;
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<?php include 'sidebar.php'; ?>
<!-- SIDEBAR -->

<!-- CONTENT -->
<section id="content">
    <nav>
        <i class='bx bx-menu'></i>
        <input type="checkbox" id="switch-mode" hidden>
        <label for="switch-mode" class="switch-mode"></label>
        <a href="#" class="profile">
            <?= $_SESSION['fullname'] ?>
        </a>
    </nav>

    <main>
        <div class="head-title">
            <div class="left">
                <h1>Account: <?= $_SESSION['username'] ?></h1>
                <ul class="breadcrumb">
                    <li><a href="#">Dashboard</a></li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li><a class="active" href="#">Home</a></li>
                </ul>
            </div>
        </div>

        <div class="table-data">
            <div class="order">
                <h2>Civil Case Records</h2>
                <?php
                if ($result->num_rows > 0) {
                    echo "<table id='civil_case_table'>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Plaintiff Name</th>
                                    <th>Defendant Name</th>
                                    <th>Direction Number</th>
                                    <th>File Number</th>
                                    <th>Court Directed</th>
                                    <th>Nature of Claim</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>";
                    
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row["id"] . "</td>
                                <td>" . $row["plaintiff_name"] . "</td>
                                <td>" . $row["defendant_name"] . "</td>
                                <td>" . $row["direction_number"] . "</td>
                                <td>" . $row["file_number"] . "</td>
                                <td>" . $row["court_directed"] . "</td>
                                <td>" . $row["nature_of_claim"] . "</td>
                                <td>" . $row["created_at"] . "</td>
                                <td class='action-buttons'>
                                    <a href='edit_civil_case.php?id=" . $row['id'] . "'><i class='bx bxs-edit'></i></a>
                                    <a href='?delete=" . $row['id'] . "' class='delete' onclick='return confirm(\"Are you sure you want to delete this record?\")'><i class='bx bxs-trash'></i></a>
                                </td>
                            </tr>";
                    }
                    echo "</tbody></table>";
                } else {
                    echo "No results found.";
                }
                $conn->close();
                ?>
            </div>
        </div>
    </main>
</section>

<!-- DataTables Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>
<script>
    $(document).ready(function() {
        $('#civil_case_table').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
</script>

</body>
</html>
