<?php
session_start();
include "conn.php";
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}


$total_criminal = "SELECT COUNT(id) AS 'Total' FROM `cases`";
  $criminal_stmt = $conn->prepare($total_criminal);
  $criminal_stmt->execute();
  $criminal_result = $criminal_stmt->get_result();
  
  if ($criminal_result->num_rows > 0) {
      $total = $criminal_result->fetch_assoc();
      $criminal_total = $total['Total'];
  }

  $total_civil_matter_registration = "SELECT COUNT(id) AS 'Total' FROM `civil_matter_registration`";
  $civil_matter_registration_stmt = $conn->prepare($total_civil_matter_registration);
  $civil_matter_registration_stmt->execute();
  $civil_matter_registration_result = $civil_matter_registration_stmt->get_result();
  
  if ($civil_matter_registration_result->num_rows > 0) {
      $total = $civil_matter_registration_result->fetch_assoc();
      $civil_matter_registration_total = $total['Total'];
  }

  $total_direct_complaints = "SELECT COUNT(id) AS 'Total' FROM `cases`";
  $direct_complaints_stmt = $conn->prepare($total_direct_complaints);
  $direct_complaints_stmt->execute();
  $direct_complaints_result = $direct_complaints_stmt->get_result();
  
  if ($direct_complaints_result->num_rows > 0) {
      $total = $direct_complaints_result->fetch_assoc();
      $direct_complaints_total = $total['Total'];
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

			<ul class="box-info">
				<li>
					<i class='bx bxs-file' ></i>
					<span class="text">
						<h3><?=$criminal_total?></h3>
						<p>Criminal Cases</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-file' ></i>
					<span class="text">
						<h3><?=$civil_matter_registration_total?></h3>
						<p>Civil Cases</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-file' ></i>
					<span class="text">
						<h3><?=$direct_complaints_total?></h3>
						<p>Direct Cases</p>
					</span>
				</li>
			</ul>


			<div class="table-data">
				<div class="order">
					<div class="head">
						<h2>Monthly Data Chart</h2>
					</div>
					<?php include 'chart.php';?>
				</div>
				<div class="todo">
					<div class="head">
						<h2>Weekly Data Chart</h2>
						<i class='bx bx-plus' ></i>
						<i class='bx bx-filter' ></i>
					</div>
					<?php include 'weakly-chart.php';?>
				</div>
			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="script.js"></script>
</body>
</html>