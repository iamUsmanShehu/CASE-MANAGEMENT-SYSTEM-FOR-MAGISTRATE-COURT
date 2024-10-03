<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

// Database connection settings
$servername = "localhost";  // Your database server
$username = "root";  // Your database username
$password = "";  // Your database password
$dbname = "case_management_system";  // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $plaintiff_name = $_POST['plaintiff_name'];
    $defendant_name = $_POST['defendant_name'];
    $direction_number = $_POST['direction_number'];
    $file_number = $_POST['file_number'];
    $court_directed = $_POST['court_directed'];
    $nature_of_claim = $_POST['nature_of_claim'];
    $statement = $_POST['statement'];
    
    // SQL query to insert data into the database
    $sql = "INSERT INTO direct_complaints (plaintiff_name, defendant_name, direction_number, file_number, court_directed, nature_of_claim, statement)
            VALUES ('$plaintiff_name', '$defendant_name', '$direction_number', '$file_number', '$court_directed', '$nature_of_claim', '$statement')";
    
    // Check if the query executes successfully
    if ($conn->query($sql) === TRUE) {
        $message = "Complaint submitted successfully!";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="style.css">

	<title>Case Management System</title>
	<style type="text/css">
		.search-btn{
			display: none;
		}

		.container {
		  padding: 16px;
		  background-color: white;
		}

		input[type=text], input[type=password], select, textarea {
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
			<i class='bx bx-menu' ></i>
			<!-- <a href="#" class="nav-link">Categories</a> -->
			<form action="#">
				<div class="form-input">
					<!-- <input type="search" placeholder="Search..."> -->
					<!-- <button type="hidden" class="search-btn"><i class='bx bx-search' ></i></button> -->
				</div>
			</form>
			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label>
			
			<a href="#" class="profile">
				<?=$_SESSION['fullname']?>
			</a>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Account: <?=$_SESSION['username']?></h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Home</a>
						</li>
					</ul>
				</div>
				<!-- <a href="#" class="btn-download">
					<i class='bx bxs-cloud-download' ></i>
					<span class="text">Download PDF</span>
				</a> -->
			</div>

			<div class="table-data">
				<div class="order">
					<!-- HTML Form Code -->
					<form action="" method="POST">
						<?php if (isset($message)) {echo $message."<br>";} ?>
					  <div class="container">
					    <h1><b><center><i>DIRECT COMPLAIN FORM</i></center></b></h1>
					    <hr><hr>

					    <label for="plaintiff_name"><b>PLAINTIFF NAME</b></label>
					    <input type="text" placeholder="ENTER PLAINTIFF NAME" name="plaintiff_name" required>
					    <br>

					    <label for="defendant_name"><b>DEFENDANT NAME</b></label>
					    <input type="text" placeholder="ENTER DEFENDANT NAME" name="defendant_name" required>

					    <label for="direction_number"><b>DIRECTION NUMBER</b></label>
					    <input type="text" placeholder="ENTER DIRECTION NUMBER" name="direction_number" required>

					    <label for="file_number"><b>FILE NUMBER</b></label>
					    <input type="text" placeholder="ENTER FILE NUMBER" name="file_number" required>

					    <label for="court_directed"><b>SELECT THE COURT DIRECTED :</b></label>
					    <select name="court_directed">
					        <option value="C.M.C 1 NOMANSLAND">C.M.C 1 NOMANSLAND</option>
					        <!-- Add other court options as needed -->
					    </select>

					    <label for="nature_of_claim"><b>SELECT THE NATURE OF CLAIM :</b></label>
					    <select name="nature_of_claim">
					        <option value="POSSESSION ONLY">POSSESSION ONLY</option>
					        <!-- Add more options as needed -->
					    </select>

					    <label for="statement"><b>STATEMENT OF COMPLAINT</b></label>
					    <textarea name="statement" placeholder="Write your complaint here..." required></textarea>

					    <button type="submit" class="submit registerbtn">Submit</button>
					  </div>
					</form>

				</div>
			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="script.js"></script>
</body>
</html>