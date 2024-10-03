<?php
include "conn.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['psw']); 
    $password_repeat = mysqli_real_escape_string($conn, $_POST['psw-repeat']); 
    
    // Check if passwords match
    if ($password != $password_repeat) {
        $message = "Passwords do not match.";
    }

    // Hash the password before storing (Using bcrypt)
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    // SQL query to insert user data
    $sql = "INSERT INTO users (fullname, username, email, password_hash) 
            VALUES ('$fullname', '$username', '$email', '$password_hash')";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        $message = "New Staff created successfully";
    } else {
        $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Close the connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../../cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

.topnav {
  overflow: hidden;
  background-color: #333;
}

.topnav a {
  float: left;
  display: block;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  background-color: #ddd;
  color: black;
}

.topnav a.active {
  background-color: #4CAF50;
  color: white;
}

.topnav .icon {
  display: none;
}

@media screen and (max-width: 600px) {
  .topnav a:not(:first-child) {display: none;}
  .topnav a.icon {
    float: right;
    display: block;
  }
}

@media screen and (max-width: 600px) {
  .topnav.responsive {position: relative;}
  .topnav.responsive .icon {
    position: absolute;
    right: 0;
    top: 0;
  }
  .topnav.responsive a {
    float: none;
    display: block;
    text-align: left;
  }
}
    * {box-sizing: border-box}
    body {font-family: Verdana, sans-serif; margin:0}
    .mySlides {display: none}
    img {vertical-align: middle;}
    
    /* Slideshow container */
    .slideshow-container {
      max-width: 100%;
      max-height: 20%!important;
      position: relative;
      margin: auto;
    }
    
    /* Next & previous buttons */
    .prev, .next {
      cursor: pointer;
      position: absolute;
      top: 50%;
      width: auto;
      padding: 16px;
      margin-top: -22px;
      color: white;
      font-weight: bold;
      font-size: 18px;
      transition: 0.6s ease;
      border-radius: 0 3px 3px 0;
      user-select: none;
    }
    
    /* Position the "next button" to the right */
    .next {
      right: 0;
      border-radius: 3px 0 0 3px;
    }
    
    /* On hover, add a black background color with a little bit see-through */
    .prev:hover, .next:hover {
      background-color: rgba(0,0,0,0.8);
    }
    
    /* Caption text */
    .text {
      color: #f2f2f2;
      font-size: 15px;
      padding: 8px 12px;
      position: absolute;
      bottom: 8px;
      width: 100%;
      text-align: center;
    }
    
    /* Number text (1/3 etc) */
    .numbertext {
      color: #f2f2f2;
      font-size: 12px;
      padding: 8px 12px;
      position: absolute;
      top: 0;
    }
    
    /* The dots/bullets/indicators */
    .dot {
      cursor: pointer;
      height: 15px;
      width: 15px;
      margin: 0 2px;
      background-color: #bbb;
      border-radius: 50%;
      display: inline-block;
      transition: background-color 0.6s ease;
    }
    
    .active, .dot:hover {
      background-color: #717171;
    }
    
    /* Fading animation */
    .fade {
      -webkit-animation-name: fade;
      -webkit-animation-duration: 1.5s;
      animation-name: fade;
      animation-duration: 1.5s;
    }
    
    @-webkit-keyframes fade {
      from {opacity: .4} 
      to {opacity: 1}
    }
    
    @keyframes fade {
      from {opacity: .4} 
      to {opacity: 1}
    }
    
    /* On smaller screens, decrease text size */
    @media only screen and (max-width: 300px) {
      .prev, .next,.text {font-size: 11px}
    }
    .cms{
      background-color: #008000;
      color: white;
      float: left;
      display: block;
      color: #f2f2f2;
      text-align: center;
      padding: 14px 16px;
      text-decoration: none;
      font-size: 20px!important;
      padding-right: 100px!important;
    }
    table{width: 100%;}
    .td1{width: 65%;}
    .td2{width: 35%; background: #ffffff0d;padding: 20px;}
    .form {
      background: #ffffff36;
      padding: 20px;
      box-shadow: inset 0px 0px 15px 9px #bbb, inset 0 4px 6px -2px rgb(0 0 0 / 5%);
    }
   
    img{
      width: 100%;
    }
    .form input{
      padding: 16px 32px;
      width: 100%;
      margin-bottom: 5px; 
      border-radius: 5px;
    }
    * {box-sizing: border-box}

/* Full-width input fields */
  input[type=text], input[type=password], input[type=email] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: none;
  background: #f1f1f1;
}

input[type=text]:focus, input[type=password], input[type=email]:focus {
  background-color: #ddd;
  outline: none;
}

hr {
  border: 1px solid #f1f1f1;
  margin-bottom: 25px;
}

/* Set a style for all buttons */
button {
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
}

button:hover {
  opacity:1;
}

/* Extra styles for the cancel button */
.cancelbtn {
  padding: 14px 20px;
  background-color: #f44336;
}

/* Float cancel and signup buttons and add an equal width */
.cancelbtn, .signupbtn {
  float: left;
  width: 50%;
}

/* Add padding to container elements */
.container {
  padding: 16px;
  background: #ffffffad;
}

/* Clear floats */
.clearfix::after {
  content: "";
  clear: both;
  display: table;
}

/* Change styles for cancel button and signup button on extra small screens */
@media screen and (max-width: 300px) {
  .cancelbtn, .signupbtn {
    width: 100%;
  }
}
</style>
</head>
<body bgcolor="green"><br>
<div class="topnav" id="myTopnav">
  <a href="" class="cms">CASE MANAGEMENT SYSTEM FOR MAGISTRATE COURT</a>
  <a href="../index.php" class="active">Home</a>
  <a href="#news">NEWS</a>
  <a href="#contact">CONTACT US</a>
  <a href="#about">ABOUT US</a>
  <a href="register.php">Register</a>
  <!-- <a href="#about">Login</a> -->
 </div></a>
  <a href="#about"><div class="custom-select" style="width:200px;">
   
 </div></a></a>
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
  </div>
  <br><br>
  <table>
    <tr>
      <td class="td1">
            
      <div class="slideshow-container">
        
        <div class="mySlides fade">
          <div class="numbertext">1 / 5</div>
          <img src="../rule.html.jpg">
          <div class="text">Caption Text</div>
        </div>
        
        <div class="mySlides fade">
          <div class="numbertext">2 / 5</div>
          <img src="../court1.html.jpg">
          <div class="text">Caption Two</div>
        </div>
        
        <div class="mySlides fade">
          <div class="numbertext">3 / 5</div>
          <img src="../court2.html.jpg">
          <div class="text">Caption Three</div>
        </div>

        <div class="mySlides fade">
          <div class="numbertext">4 / 5</div>
          <img src="../courtii.html.jpg">
          <div class="text">Caption Four</div>
        </div>

        <div class="mySlides fade">
          <div class="numbertext">5/ 5</div>
          <img src="../ODER.HTML.jpg">
          <div class="text">Caption Five</div>
        </div>
        
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
        
        </div>
        <br>
        
        <div style="text-align:center">
          <span class="dot" onclick="currentSlide(1)"></span> 
          <span class="dot" onclick="currentSlide(2)"></span> 
          <span class="dot" onclick="currentSlide(3)"></span>
          <span class="dot" onclick="currentSlide(4)"></span>
          <span class="dot" onclick="currentSlide(5)"></span> 
        </div>
        
        </body>
      </div>
      </td>
      <td class="td2">
        <div class="form">
          <form method="POST" style="border:1px solid #ccc">
            <div class="container">
              <h1>Sign Up</h1>
              <p>Please fill in this form to create an account.</p>
              <?php if (isset($message)) {echo "<br>" . $message;}?>
              <hr>

              <label for="fullname"><b>Full Name</b></label>
              <input type="text" placeholder="Enter Fullname" name="fullname" required>

              <label for="username"><b>Username</b></label>
              <input type="text" placeholder="Enter Username" name="username" required>

              <label for="email"><b>Email</b></label>
              <input type="email" placeholder="Enter Email" name="email" required>

              <label for="psw"><b>Password</b></label>
              <input type="password" placeholder="Enter Password" name="psw" required>

              <label for="psw-repeat"><b>Repeat Password</b></label>
              <input type="password" placeholder="Repeat Password" name="psw-repeat" required>

              <div class="clearfix">
                <a href="../index.php" class="cancelbtn">Cancel</a>
                <button type="submit" class="signupbtn">Sign Up</button>
              </div>
            </div>
          </form>
      </td>
    </tr>
  </table>
<script>
var slideIndex  = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";  
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
}

function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}
</script>

</body>

<!-- Mirrored from www.w3schools.com/howto/tryit.asp?filename=tryhow_js_topnav by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 27 Jan 2020 02:38:46 GMT -->
</html>
