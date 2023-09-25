<!DOCTYPE html>
<html>
<head>
<title>Growth Page</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="Style/home.css">
<script src="jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
</head>
<style>
    .Slots{
    margin: 30px;
}

.gitna{
  float: none;
  position: absolute;
  margin-left: 20%;
  width: 60%;
}

.form-container {
  max-width: 300px;
  padding: 10px;
  background-color: white;
}

.form-popup{
  float: none;
  display: none;
  position: absolute;
  text-align: center;
  margin-left: 42%;
  top: 20%;
  border: 3px solid #f1f1f1;
  z-index: 9;
}

/* Set a style for the submit/login button */
.form-container .btn {
  background-color: #04AA6D;
  color: white;
  padding: 10px 20px;
  border: none;
  cursor: pointer;
  width: 100%;
  margin-bottom:10px;
  opacity: 0.8;
}

/* Add a red background color to the cancel button */
.form-container .cancel {
  background-color: red;
}

/* Add some hover effects to buttons */
.form-container .btn:hover, .open-button:hover {
  opacity: 1;
}
</style>

<!-- CONNECT TO SQL DATABASE -->

<?php
ob_start();
// CONNECT TO SQL DATBASE
$serverName="LAPTOP-KMPHCVG3\SQLEXPRESS";
$connectionOptions=[
    "Database"=>"DLSU",
    "Uid"=>"",
    "PWD"=>""
];
$conn=sqlsrv_connect($serverName, $connectionOptions);
if($conn==false){
    die(print_r(sqlsrv_errors(),true));
}

// CONNECT TO SQL DATBASE
session_start();


$user = $_SESSION['user'];

$sql = "SELECT PLANT_NAME FROM USERS WHERE USER_NAME='$user'";
$result=sqlsrv_query($conn,$sql);
$array=sqlsrv_fetch_array($result);
$plant = implode($array);

if ($plant == "SnakePlantSnakePlant"){
    $plant = "SnakePlant";
    $sciname = "Dracaena trifasciata";

}
if ($plant == "CactusCactus"){
    $plant = "Cactus";
    $sciname = "Cactaceae";

}
if ($plant == "AloeVeraAloeVera"){
    $plant = "AloeVera";
    $sciname = "Aloe barbadensis miller";
}


$sql1 = "SELECT PLANT_SIZE FROM PLANT_GROWTH WHERE USER_NAME='$user'";
$result1=sqlsrv_query($conn,$sql1);
$array1=sqlsrv_fetch_array($result1);

$plantsize = $array1['PLANT_SIZE'];

if ($plantsize == NULL){
  $plantsize = '0 cm';
}

$sql2 = "SELECT DAY FROM PLANT_GROWTH WHERE USER_NAME='$user'";
$result2=sqlsrv_query($conn,$sql2);
$array2=sqlsrv_fetch_array($result2);

$age = $array2['DAY'];

if ($age == NULL){
  $age = 0;
}


if($_SERVER['REQUEST_METHOD'] =="POST"){
  $growth = $_POST['growth'];

  $sql3 = "SELECT * FROM PLANT_GROWTH WHERE USER_NAME='$user'";
  $result3=sqlsrv_query($conn,$sql3);
  
  $user=sqlsrv_fetch_array($result3);
  
  $username = $user['USER_NAME'];
  $plantname = $user['PLANT_NAME'];
  $plantsize = $user['PLANT_SIZE'];
  $age = $user['DAY'];
  $datecreated = $user['DATE_CREATED'];
  $dateupdated = $user['DATE_UPDATED'];

}


// To get all the data in PLANT_GROWTH table




?>

<body class="w3-light-grey">
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>

  <!-- Navbar (sit on top) -->
  <div class="w3-top">
    <div class="w3-bar w3-white w3-card" id="myNavbar">
      <a href="index.php" class="w3-bar-item w3-button w3-wide">FOLIA</a>
      <!-- Right-sided navbar links -->
      <div class="w3-right w3-hide-small">
        <a href="index.php" class="w3-bar-item w3-button">HOME</a>
        <a href="plant.php" class="w3-bar-item w3-button">PLANT</a>
        <a href="loginpage.php" class="w3-bar-item w3-button"><i class="fa fa-th"></i> SIGNOUT</a>
<script>
function myFunction() {
  var x = document.getElementById("Demo");
  if (x.className.indexOf("w3-show") == -1) { 
    x.className += " w3-show";
  } else {
    x.className = x.className.replace(" w3-show", "");
  }
}
</script>
        </div>
      </div>
      <!-- Hide right-floated links on small screens and replace them with a menu icon -->

      <a href="javascript:void(0)" class="w3-bar-item w3-button w3-right w3-hide-large w3-hide-medium" onclick="w3_open()">
        <i class="fa fa-bars"></i>
      </a>
    </div>
  </div>

  <nav class="w3-sidebar w3-bar-block w3-black w3-card w3-animate-left w3-hide-medium w3-hide-large" style="display:none" id="mySidebar">
    <a href="javascript:void(0)" onclick="w3_close()" class="w3-bar-item w3-button w3-large w3-padding-16">Close ×</a>
    <a href="plant.php" onclick="w3_close()" class="w3-bar-item w3-button">PLANT</a>
    <a href="growth.php" onclick="w3_close()" class="w3-bar-item w3-button">GROWTH</a>
  </nav>


<!-- php codes -->




<!-- php codes -->


<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;"></div>

  <!-- Header -->
  <header class="w3-container" style="padding-top:22px">
    <h1 align="center"><b><i class="fa fa-dashboard"></i> Growth Page</b></h1>
  </header>

    <div class="w3-row-padding">


<div class="w3-third w3-margin-bottom gitna">
  <ul class="w3-ul w3-border w3-center w3-hover-shadow gitna">
    <li class="w3-padding-16"><b>Growth: </b></li>
    <li class="w3-padding-16"> <?php echo $plantsize; ?></li>
    <li class="w3-padding-16"><b>Age: </b> <?php echo $age; ?> day/s</li>
    <li class="w3-padding-16">
      <h2 class="w3-wide">  <?php echo $plant; ?></h2>
      <span class="w3-opacity"><?php echo $sciname; ?></span>

      <div class="form-popup1" id="myForm1">

      <li class="w3-padding-16">
      <button onclick="openForm()">Update Data</button>
      <button onClick="window.open('growthrecord.php', '_blank');" class="button" > Show Growth Record</button>
    </li>
  </ul>
</div>

  <!-- KUNG GUSTO PARIN NG FOOTER ETO CODE
  
  <footer class="w3-center w3-black w3-padding-64">
    <a href="index.php" class="w3-button w3-light-grey"><i class="fa fa-arrow-up w3-margin-right"></i>Back to home</a>
    <div class="w3-xlarge w3-section">
    </div>
    <p> (c) Cruz, Lazaro, Peralta</p>
  </footer>

-->

  <script>
    // Toggle between showing and hiding the sidebar when clicking the menu icon
    var mySidebar = document.getElementById("mySidebar");
    
    function w3_open() {
      if (mySidebar.style.display === 'block') {
        mySidebar.style.display = 'none';
      } else {
        mySidebar.style.display = 'block';
      }
    }
    
    // Close the sidebar with the close button
    function w3_close() {
        mySidebar.style.display = "none";
    }
    </script>


<!-- POP-UP FORM -->


<div class="form-popup" id="myForm">
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="form-container">

    <label>UPDATE GROWTH</label>
    
    <br><br>
      <label for="dataInput">Enter Growth:</label>
      <input type="number" name="growth" id="growth" placeholder="centimeter unit" required>
      <br><br>
    <button id="submit" name="submit" type="submit" class="btn">Submit</button>
    <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
  </form>
</div>


<script>

function first(){
  var value = document.getElementById("plant1").value;
    console.log(value);

  document.getElementById("myForm").style.display = "none";
}


function openForm() {
  document.getElementById("myForm").style.display = "block";
}

function closeForm() {
  document.getElementById("myForm").style.display = "none";
}
</script>
<!-- POP-UP FORM -->


<?php

if(isset($_POST['submit'])){

  $user = $_SESSION['user'];

  $current = date('F d, Y');
  $past = date_create($datecreated);
  $today = date_create($current);
  
  $date=date_diff($past,$today);
  $age = $date->format("%a");


$sql4= "UPDATE PLANT_GROWTH SET PLANT_SIZE = '$growth cm',
DAY = '$age',
DATE_UPDATED = '$current'
WHERE 
USER_NAME = '$user'";

$result4=sqlsrv_query($conn,$sql4);

$sql5="INSERT INTO GROWTH_RECORD (USER_NAME,
PLANT_NAME,
PLANT_SIZE,
DAY,
DATE_CREATED,
DATE_UPDATED) VALUES ('$username',
'$plantname',
'$growth cm',
'$age',
'$datecreated',
'$current')";

$result5=sqlsrv_query($conn,$sql5);


if ($result3 && $result4 && $result5){
  $success = "Data Updated Successfully!";

  echo '<script type="text/javascript">sweetAlert("'.$success.'");</script>';
  
  header( "refresh:2" );
} else {
  echo "ERROR";
}





}


?>
</body>
</html>