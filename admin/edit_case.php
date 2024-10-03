<?php
session_start();
include 'conn.php';
// Get case data based on ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM `cases` WHERE id=$id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

// Handle form submission for updates
if (isset($_POST['update'])) {
    $plaintiff_name = $_POST['plaintiff_name'];
    $defendant_name = $_POST['defendant_name'];
    $direction_number = $_POST['direction_number'];
    $file_number = $_POST['file_number'];
    $court = $_POST['court'];
    $offence = $_POST['offence'];
    $registration_date = $_POST['registration_date'];

    $updateQuery = "UPDATE `cases` SET 
                    `plaintiff_name`='$plaintiff_name', 
                    `defendant_name`='$defendant_name',
                    `direction_number`='$direction_number',
                    `file_number`='$file_number',
                    `court`='$court',
                    `offence`='$offence',
                    `registration_date`='$registration_date'
                    WHERE id=$id";

    if ($conn->query($updateQuery) === TRUE) {
        echo "Record updated successfully!";
        header('Location: manage-criminal-case.php'); // Redirect to the table page
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Close connection
$conn->close();
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

        input[type=text], input[type=password], select, input[type=date] {
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
                  <h2>Edit Criminal Case</h2>
                <form method="POST" action="">
                    <label for="plaintiff_name">Plaintiff Name</label>
                    <input type="text" name="plaintiff_name" value="<?php echo $row['plaintiff_name']; ?>" required><br>

                    <label for="defendant_name">Defendant Name</label>
                    <input type="text" name="defendant_name" value="<?php echo $row['defendant_name']; ?>" required><br>

                    <label for="direction_number">Direction Number</label>
                    <input type="text" name="direction_number" value="<?php echo $row['direction_number']; ?>" required><br>

                    <label for="file_number">File Number</label>
                    <input type="text" name="file_number" value="<?php echo $row['file_number']; ?>" required><br>

                    <label for="court">Court</label>
                    <input type="text" name="court" value="<?php echo $row['court']; ?>" required><br>

                    <label for="offence">Offence</label>
                    <input type="text" name="offence" value="<?php echo $row['offence']; ?>" required><br>

                    <label for="registration_date">Registration Date</label>
                    <input type="date" name="registration_date" value="<?php echo $row['registration_date']; ?>" required><br>

                    <button type="submit" name="update" class="registerbtn">Update</button>
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