<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "case_management_system";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $plaintiff_name = mysqli_real_escape_string($conn, $_POST['plaintiff_name']);
    $defendant_name = mysqli_real_escape_string($conn, $_POST['defendant_name']);
    $direction_number = mysqli_real_escape_string($conn, $_POST['direction_number']);
    $file_number = mysqli_real_escape_string($conn, $_POST['file_number']);
    $court = mysqli_real_escape_string($conn, $_POST['court']);
    $offence = mysqli_real_escape_string($conn, $_POST['offence']);

    // SQL query to insert case registration data into the database
    $sql = "INSERT INTO cases (plaintiff_name, defendant_name, direction_number, file_number, court, offence) 
            VALUES ('$plaintiff_name', '$defendant_name', '$direction_number', '$file_number', '$court', '$offence')";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        $message = "New case registered successfully.";
    } else {
        $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Close the connection
// mysqli_close($conn);
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
					<form method="POST">
  <div class="container">
    <h1><b><center><i>CRIMINAL CASE REGISTRATION FORM</i></center></b></h1>
    <hr><hr>
    <?php if (isset($message)) {echo $message."<br>";} ?>

    <label for="plaintiff_name"><b>PLAINTIFF NAME</b></label>
    <input type="text" placeholder="Enter Plaintiff Name" name="plaintiff_name" required>
    <br>

    <label for="defendant_name"><b>DEFENDANT NAME</b></label>
    <input type="text" placeholder="Enter Defendant Name" name="defendant_name" required>
    <br>

    <label for="direction_number"><b>DIRECTION NUMBER</b></label>
    <input type="text" placeholder="Enter Direction Number" name="direction_number" required>
    <br>

    <label for="file_number"><b>FILE NUMBER</b></label>
    <input type="text" placeholder="Enter File Number" name="file_number" required>
    <br>

    <label for="court"><b>Court Directed</b></label>
	<select name="court" required>
	  <option value="">SELECT THE COURT DIRECTED:</option>
	  <option value="C.M.C 1 NOMANSLAND">C.M.C 1 NOMANSLAND</option>
	  <option value="C.M.C 2 NOMANSLAND">C.M.C 2 NOMANSLAND</option>
	  <option value="C.M.C 4 GYADI-GYADI">C.M.C 4 GYADI-GYADI</option>
	  <option value="C.M.C 5 GYADI-GYADI">C.M.C 5 GYADI-GYADI</option>
	  <option value="C.M.C 6 GWALE">C.M.C 6 GWALE</option>
	  <option value="C.M.C 9 NOMANSLAND">C.M.C 9 NOMANSLAND</option>
	  <option value="C.M.C 10 PANSHEKARA">C.M.C 10 PANSHEKARA</option>
	  <option value="C.M.C 13 GYADI-GYADI">C.M.C 13 GYADI-GYADI</option>
	  <option value="C.M.C 14 HIGH COURT H/Q">C.M.C 14 HIGH COURT H/Q</option>
	  <option value="C.M.C 15V M.A.K.I.A">C.M.C 15V M.A.K.I.A</option>
	  <option value="C.M.C 16 NOMANSLAND">C.M.C 16 NOMANSLAND</option>
	  <option value="C.M.C 18 GYADI-GYADI">C.M.C 18 GYADI-GYADI</option>
	  <option value="C.M.C 19 NOMANSLAND">C.M.C 19 NOMANSLAND</option>
	  <option value="C.M.C 20 BELL">C.M.C 20 BELL</option>
	  <option value="C.M.C 22 KURA">C.M.C 22 KURA</option>
	  <option value="C.M.C 23 NOMANSLAND">C.M.C 23 NOMANSLAND</option>
	  <option value="C.M.C 24 GYADI-GYADI">C.M.C 24 GYADI-GYADI</option>
	  <option value="C.M.C 25 ZUNGERO ROAD">C.M.C 25 ZUNGERO ROAD</option>
	  <option value="C.M.C 26 ZUNGERO ROAD">C.M.C 26 ZUNGERO ROAD</option>
	  <option value="C.M.C 27 GYADI-GYADI">C.M.C 27 GYADI-GYADI</option>
	  <option value="C.M.C 29 NOMANSLAND">C.M.C 29 NOMANSLAND</option>
	  <option value="C.M.C 30 ZUNGERO ROAD/S.C.C NO 1">C.M.C 30 ZUNGERO ROAD/S.C.C NO 1</option>
	  <option value="C.M.C 31 GEZAWA">C.M.C 31 GEZAWA</option>
	  <option value="C.M.C 38 NOMANSLAND">C.M.C 38 NOMANSLAND</option>
	  <option value="S.M.C 33 GYADI-GYADI">S.M.C 33 GYADI-GYADI</option>
	  <option value="S.M.C 34 NOMANSLAND">S.M.C 34 NOMANSLAND</option>
	  <option value="S.M.C 35 NOMANSLAND">S.M.C 35 NOMANSLAND</option>
	  <option value="S.M.C 36 GYADI-GYADI">S.M.C 36 GYADI-GYADI</option>
	  <option value="S.M.C 37 YANKABA">S.M.C 37 YANKABA</option>
	  <option value="S.M.C 41 NOMANSLAND/S.C.C. NO. 4">S.M.C 41 NOMANSLAND/S.C.C. NO. 4</option>
	  <option value="S.M.C 42 NOMANSLAND/SMALL CLAIM COURT NO. 3">S.M.C 42 NOMANSLAND/SMALL CLAIM COURT NO. 3</option>
	  <option value="C.M.C GYADI-GYADI/SMALL CLAIM COURT NO. 2">C.M.C GYADI-GYADI/SMALL CLAIM COURT NO. 2</option>
	</select>
    <br><br>

    <label for="offence"><b>Nature of Offence</b></label>
<select name="offence" required>
  <option value="">SELECT THE NATURE OF OFFENCE:</option>
  <option value="Theft (Section 286)">Theft (Section 286)</option>
  <option value="Theft by Servant (Section 289)">Theft by Servant (Section 289)</option>
  <option value="Petty Theft (Section 290)">Petty Theft (Section 290)</option>
  <option value="Criminal Force and Assault (Sections 262, 264)">Criminal Force and Assault (Sections 262, 264)</option>
  <option value="Intentional Insult (Section 399)">Intentional Insult (Section 399)</option>
  <option value="Public Disturbance (Section 183)">Public Disturbance (Section 183)</option>
  <option value="Criminal Conspiracy and Theft (Sections 96, 282)">Criminal Conspiracy and Theft (Sections 96, 282)</option>
  <option value="Criminal Conspiracy (Section 96)">Criminal Conspiracy (Section 96)</option>
  <option value="Criminal Breach of Trust (Section 311)">Criminal Breach of Trust (Section 311)</option>
  <option value="Drunkenness in a Public Place (Section 401)">Drunkenness in a Public Place (Section 401)</option>
  <option value="Fraud (Section 362)">Fraud (Section 362)</option>
  <option value="Adultery by Man and Woman (Sections 387, 388)">Adultery by Man and Woman (Sections 387, 388)</option>
  <option value="Criminal Mischief (Section 326)">Criminal Mischief (Section 326)</option>
  <option value="Vandalism (Section 335)">Vandalism (Section 335)</option>
  <option value="Robbery (Section 296)">Robbery (Section 296)</option>
  <option value="Murder (Section 220)">Murder (Section 220)</option>
  <option value="Armed Robbery (Section 297)">Armed Robbery (Section 297)</option>
  <option value="Treason (Section 37)">Treason (Section 37)</option>
  <option value="Kidnapping (Section 271)">Kidnapping (Section 271)</option>
  <option value="Rape (Section 282)">Rape (Section 282)</option>
  <option value="Abduction and Forced Labor (Section 280)">Abduction and Forced Labor (Section 280)</option>
  <option value="Extortion (Section 291)">Extortion (Section 291)</option>
  <option value="Brigandage (Section 297)">Brigandage (Section 297)</option>
  <option value="Criminal Misappropriation (Section 308)">Criminal Misappropriation (Section 308)</option>
  <option value="Receiving Stolen Property (Section 316)">Receiving Stolen Property (Section 316)</option>
  <option value="Cheating (Section 320)">Cheating (Section 320)</option>
  <option value="Criminal Trespass (Section 342)">Criminal Trespass (Section 342)</option>
  <option value="Forgery (Section 362)">Forgery (Section 362)</option>
  <option value="Criminal Breach of Contract of Service (Section 381)">Criminal Breach of Contract of Service (Section 381)</option>
  <option value="Criminal Intimidation (Section 396)">Criminal Intimidation (Section 396)</option>
  <option value="Attempts to Commit Offenses (Section 95)">Attempts to Commit Offenses (Section 95)</option>
  <option value="Screening of Offenders (Section 167)">Screening of Offenders (Section 167)</option>
  <option value="Lotteries and Gaming Houses (Section 204)">Lotteries and Gaming Houses (Section 204)</option>
  <option value="Vagabonds (Section 405)">Vagabonds (Section 405)</option>
  <option value="Rioting (Section 105)">Rioting (Section 105)</option>
  <option value="Unlawful Assembly (Section 100)">Unlawful Assembly (Section 100)</option>
  <option value="Administering Unlawful Oath (Section 94)">Administering Unlawful Oath (Section 94)</option>
  <option value="Giving False Evidence (Section 156)">Giving False Evidence (Section 156)</option>
  <option value="Drunkenness in a Private Place (Section 402)">Drunkenness in a Private Place (Section 402)</option>
  <option value="Drinking Alcoholic Drinks (Section 403)">Drinking Alcoholic Drinks (Section 403)</option>
  <option value="Defamation of Character (Section 391)">Defamation of Character (Section 391)</option>
</select>

    <br><br>

    <button type="submit" class="registerbtn">Submit</button>
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