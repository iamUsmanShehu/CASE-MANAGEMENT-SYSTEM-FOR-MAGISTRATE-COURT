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
    $deleteQuery = "DELETE FROM `cases` WHERE id=$id";
    if ($conn->query($deleteQuery) === TRUE) {
        echo "<script>alert('Record deleted successfully');</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// SQL query to retrieve data
$sql = "SELECT `id`, `plaintiff_name`, `defendant_name`, `direction_number`, `file_number`, `court`, `offence`, `registration_date` FROM `cases`";
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
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">

	<!-- Custom CSS -->
	<link rel="stylesheet" href="style.css">

	<title>Case Management System</title>

	<style type="text/css">
		.search-btn {
			display: none;
		}

		.container {
			padding: 16px;
			background-color: white;
		}

		input[type=text], input[type=password], select {
			width: 100%;
			padding: 15px;
			margin: 5px 0 22px 0;
			display: inline-block;
			border: none;
			background: #f1f1f1;
		}

		input[type=text]:focus, input[type=password]:focus {
			background-color: #ddd;
			outline: none;
		}

		/* Overwrite default styles of hr */
		hr {
			border: 1px solid #f1f1f1;
			margin-bottom: 25px;
		}

		/* Set a style for the submit button */
		.registerbtn {
			background-color: #4CAF50;
			color: white;
			padding: 16px 20px;
			margin: 8px 0;
			border: none;
			cursor: pointer;
			width: 100%;
			opacity: 0.9;
		}

		.registerbtn:hover {
			opacity: 1;
		}

		/* Add a blue text color to links */
		a {
			color: dodgerblue;
		}

		.signin {
			background-color: #f1f1f1;
			text-align: center;
		}

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
					<h2>Criminal Case Records</h2>

					<?php
					if ($result->num_rows > 0) {
						// Start table with an ID for DataTables
						echo "<table id='cases_table' class='display'>
								<thead>
									<tr>
										<th>ID</th>
										<th>Plaintiff Name</th>
										<th>Defendant Name</th>
										<th>Direction Number</th>
										<th>File Number</th>
										<th>Court</th>
										<th>Offence</th>
										<th>Registration Date</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>";

						// Output data for each row
						while ($row = $result->fetch_assoc()) {
							echo "<tr>
									<td>" . $row["id"] . "</td>
									<td>" . $row["plaintiff_name"] . "</td>
									<td>" . $row["defendant_name"] . "</td>
									<td>" . $row["direction_number"] . "</td>
									<td>" . $row["file_number"] . "</td>
									<td>" . $row["court"] . "</td>
									<td>" . $row["offence"] . "</td>
									<td>" . $row["registration_date"] . "</td>
									<td class='action-buttons'>
										<a href='edit_case.php?id=" . $row['id'] . "'><i class='bx bxs-edit'></i></a>
										<a href='?delete=" . $row['id'] . "' class='delete' onclick='return confirm(\"Are you sure you want to delete this record?\")'><i class='bx bxs-trash'></i></a>
									</td>
								</tr>";
						}

						// End table
						echo "</tbody></table>";
					} else {
						echo "No results found.";
					}

					// Close the connection
					$conn->close();
					?>

				</div>
			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->

	<!-- JQuery and DataTables JS -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<!-- DataTables JS -->
	<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
	<!-- DataTables Buttons JS -->
	<script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.flash.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>

	<!-- Initialize DataTables -->
	<script>
		$(document).ready(function () {
			$('#cases_table').DataTable({
				dom: 'Bfrtip',
				buttons: [
					'copy', 'csv', 'excel', 'pdf', 'print'
				]
			});
		});
	</script>

	<script src="script.js"></script>
</body>
</html>
