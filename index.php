<?php
session_start();

$servername = "localhost";  
$username = "root";         
$password = "";             
$dbname = "case_management_system";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_username_email = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM users WHERE username = '$input_username_email' OR email = '$input_username_email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['password_hash'])) {
            $_SESSION['user_id'] = $row['id'];          
            $_SESSION['fullname'] = $row['fullname'];   
            $_SESSION['username'] = $row['username'];   
            header("Location: admin/");
            exit();
        } else {
            $message = "Invalid password. Please try again.";
        }

    } else {
        $message = "No account found with that username or email.";
    }
}

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
    .td1{width: 70%;}
    .td2{width: 30%; background: #ffffff0d;padding: 20px;}
    .form {
      background: #ffffff36;
      padding: 20px;
      box-shadow: inset 0px 0px 15px 9px #bbb, inset 0 4px 6px -2px rgb(0 0 0 / 5%);
    }
    .form input{
      padding: 16px 32px;
      width: 100%;
      margin-bottom: 5px; 
      border-radius: 5px;
    }
    img{
      width: 100%;
    }
</style>
</head>
<body bgcolor="green"><br>
<div class="topnav" id="myTopnav">
  <a href="" class="cms">CASE MANAGEMENT SYSTEM FOR MAGISTRATE COURT</a>
  <a href="index.php" class="active">Home</a>
  <a href="#news">NEWS</a>
  <a href="#contact">CONTACT US</a>
  <a href="#about">ABOUT US</a>
  <a href="admin/register.php">Register</a>
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
          <img src="rule.html.jpg">
          <div class="text">Caption Text</div>
        </div>
        
        <div class="mySlides fade">
          <div class="numbertext">2 / 5</div>
          <img src="court1.html.jpg">
          <div class="text">Caption Two</div>
        </div>
        
        <div class="mySlides fade">
          <div class="numbertext">3 / 5</div>
          <img src="court2.html.jpg">
          <div class="text">Caption Three</div>
        </div>

        <div class="mySlides fade">
          <div class="numbertext">4 / 5</div>
          <img src="courtii.html.jpg">
          <div class="text">Caption Four</div>
        </div>

        <div class="mySlides fade">
          <div class="numbertext">5/ 5</div>
          <img src="ODER.HTML.jpg">
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
        <h2>Login</h2>
          <form method="POST">
              <?php if (isset($message)) {echo "<br>" . $message;}?>
            <input type="text" name="username" placeholder="Username or email"><br>
            <input type="password" name="password" placeholder="password"><br>
            <input type="submit" name="submit" value="Login">
          </form>
        </div>
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
