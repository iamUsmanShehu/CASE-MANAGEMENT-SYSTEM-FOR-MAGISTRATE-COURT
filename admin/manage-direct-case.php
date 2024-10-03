<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

include 'conn.php';

// Handle Delete Request
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $deleteQuery = $conn->prepare("DELETE FROM `direct_complaints` WHERE id=?");
    $deleteQuery->bind_param("i", $id);
    if ($deleteQuery->execute()) {
        $_SESSION['message'] = "Record deleted successfully";
    } else {
        $_SESSION['message'] = "Error deleting record: " . $conn->error;
    }
    header("Location: direct_complaints.php");
    exit();
}

// SQL query to retrieve data
$sql = "SELECT `id`, `plaintiff_name`, `defendant_name`, `direction_number`, `file_number`, `court_directed`, `nature_of_claim`, `statement`, `submission_date` FROM `direct_complaints` WHERE 1";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
    <!-- My CSS -->
    <link rel="stylesheet" href="style.css">

    <title>Case Management System</title>

    <style>
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
        <!-- NAVBAR -->
        <nav>
            <i class='bx bx-menu'></i>
            <form action="#">
                <div class="form-input">
                    <!-- <button type="hidden" class="search-btn"><i class='bx bx-search'></i></button> -->
                </div>
            </form>
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
            <a href="#" class="profile">
                <?= $_SESSION['fullname'] ?>
            </a>
        </nav>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Account: <?= $_SESSION['username'] ?></h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Dashboard</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="#">Home</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="table-data">
                <div class="order">
                    <h2>Direct Complaints Records</h2>

                    <?php
                    if ($result->num_rows > 0) {
                        echo "<table id='complaintsTable' class='display'>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Plaintiff Name</th>
                                        <th>Defendant Name</th>
                                        <th>Direction Number</th>
                                        <th>File Number</th>
                                        <th>Court Directed</th>
                                        <th>Nature of Claim</th>
                                        <th>Statement</th>
                                        <th>Submission Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>";
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row["id"] . "</td>
                                    <td>" . $row["plaintiff_name"] . "</td>
                                    <td>" . $row["defendant_name"] . "</td>
                                    <td>" . $row["direction_number"] . "</td>
                                    <td>" . $row["file_number"] . "</td>
                                    <td>" . $row["court_directed"] . "</td>
                                    <td>" . $row["nature_of_claim"] . "</td>
                                    <td>" . $row["statement"] . "</td>
                                    <td>" . $row["submission_date"] . "</td>
                                    <td class='action-buttons'>
                                        <a href='edit_complaint.php?id=" . $row['id'] . "'><i class='bx bxs-edit'></i></a>
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
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <!-- DataTables Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <!-- Initialize DataTables with Buttons -->
    <script>
        $(document).ready(function() {
            $('#complaintsTable').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "info": true,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
</body>
</html>
