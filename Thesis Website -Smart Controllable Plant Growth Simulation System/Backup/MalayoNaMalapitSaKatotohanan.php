<!DOCTYPE HTML>
<html>
  <head>
  <title>Plant page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="icon" href="data:,">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="Style/plant.css">
    <script src="jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <style>
      html {font-family: Arial; display: inline-block; text-align: center;}
      p {font-size: 1.2rem;}
      h4 {font-size: 0.8rem;}
      h3{color: white;}
      body {margin: 0;}
      .topnav {overflow: hidden; background-color: #0c6980; color: white; font-size: 1.2rem;}
      .content {padding: 5px; }
      .card {background-color: white; box-shadow: 0px 0px 10px 1px rgba(140,140,140,.5); border: 1px solid #0c6980; border-radius: 15px;}
      .card.header {background-color: #5F7161; color: white; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px; border-top-right-radius: 12px; border-top-left-radius: 12px;}
      .cards {max-width: 700px; margin: 0 auto; display: grid; grid-gap: 3rem; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));}
      .reading {font-size: 1.3rem;}
      .packet {color: #bebebe;}
      .temperatureColor {color: #fd7e14;}
      .humidityColor {color: #1b78e2;}
      .statusreadColor {color: #702963; font-size:12px;}
      .LEDColor {color: #183153;}
      
      /* ----------------------------------- Toggle Switch */
      
      /* ----------------------------------- */
    </style>
  </head>
  <body>
  <?php
  ob_start();

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



  $mintempErr="";
  $maxtempErr="";
  $sethumErr="";

  session_start();

  if($_SERVER['REQUEST_METHOD'] == "POST"){
    $mintemp = $_POST['ESP32_01_Min_Temp_Update'];
    $maxtemp = $_POST['ESP32_01_Max_Temp_Update'];
    $sethum = $_POST['ESP32_01_Hum_Update'];

    $_SESSION['mintemp'] = $mintemp;
    $_SESSION['maxtemp'] = $maxtemp;
    $_SESSION['sethum'] = $sethum;

    if ($mintemp < 24){
        $mintempErr = "Temperature must be set between 24 to 29 degrees celsius only"; 
        if ($mintemp > 29){
          $mintempErr = "Temperature must be set between 15 to 30 degrees celsius only"; 
        }
      }elseif ($maxtemp < $mintemp ){
        $maxtempErr = "Maximum temperature must be greater than minimum temperature"; 
      }
      
      if($sethum < 70){
        $sethumErr = "Humidity level must be set between 70 to 80 percent only"; 
        if ($sethum > 80){
          $sethumErr = "Humidity level must be set between 70 to 80 percent only"; 
        }
      }
      echo '<script type="text/javascript">sweetAlert("'.$mintempErr.'\n'.$maxtempErr.'\n'.$sethumErr.'");</script>';
  }
  ?>

  
  <div class="w3-top">
  <div class="w3-bar w3-white w3-card" id="myNavbar">
    <a href="index.php" class="w3-bar-item w3-button w3-wide">FOLIA</a>
    <!-- Right-sided navbar links -->
    <div class="w3-right w3-hide-small">
      <a href="index.php" class="w3-bar-item w3-button">HOME</a>
      <a href="#plant" class="w3-bar-item w3-button">PLANT</a>
      <a href="growth.php" class="w3-bar-item w3-button">GROWTH</a>
      <a href="loginpage.php" class="w3-bar-item w3-button"><i class="fa fa-th"></i> SIGNOUT</a>
    </div> 
    <!-- Hide right-floated links on small screens and replace them with a menu icon -->

    <a href="javascript:void(0)" class="w3-bar-item w3-button w3-right w3-hide-large w3-hide-medium" onclick="w3_open()">
      <i class="fa fa-bars"></i>
    </a>
  </div>
</div>
    
    <br>
    <br>
    <br>
    <br>
    
    <!-- __ DISPLAYS MONITORING AND CONTROLLING ____________________________________________________________________________________________ -->
    <div class="content">
      <div class="cards">
        
        <!-- == MONITORING ======================================================================================== -->
        <div class="card">
          <div class="card header">
            <h3 style="font-size: 1rem;">MONITORING</h3>
          </div>
          
          <!-- Displays the humidity and temperature values received from ESP32. *** -->
          <h4 class="temperatureColor"><i class="fas fa-thermometer-half"></i> TEMPERATURE</h4>
          <p class="temperatureColor"><span class="reading"><span id="ESP32_01_Temp"></span> &deg;C</span></p>
          <h4 class="humidityColor"><i class="fas fa-tint"></i> HUMIDITY</h4>
          <p class="humidityColor"><span class="reading"><span id="ESP32_01_Humd"></span> &percnt;</span></p>
          <!-- *********************************************************************** -->
          
        </div>
        <!-- ======================================================================================================= -->
        <div class="card">
          <div class="card header">
            <h3 style="font-size: 1rem;">PLANT</h3>
          </div>
          
          <div id="snakeplant2">
    <li class=<?php echo $plant; ?>></li>
    <li class="w3-padding-16">
      <h2 class="w3-wide"> <?php echo $plant; ?> </h2>
      <span class="w3-opacity"><?php echo $sciname; ?></span>
    </li>
</div>
          <!-- *********************************************************************** -->
          
        </div>
        
        <!-- == CONTROLLING ======================================================================================== -->
        <form id="update" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <div class="card">
          <div class="card header">
            <h3 style="font-size: 1rem;">CONTROLLING</h3>
          </div>
          
          <!-- Buttons for controlling the LEDs on Slave 2. ************************** -->
         
          <h4 class="temperatureColor"><i class="fas fa-thermometer-half"></i> MINIMUM TEMPERATURE</h4>
            <<input type="text" placeholder="numbers only"id="ESP32_01_Min_Temp_Update" name="ESP32_01_Min_Temp_Update" required pattern="[0-9]+">

            <h4 class="temperatureColor"><i class="fas fa-thermometer-half"></i> MAXIMUM TEMPERATURE</h4>
            <<input type="text" placeholder="numbers only"id="ESP32_01_Max_Temp_Update" name="ESP32_01_Max_Temp_Update" required pattern="[0-9]+">

            <h4 class="humidityColor"><i class="fas fa-tint"></i> HUMIDITY</h4>
            <<input type="text" placeholder="numbers only"id="ESP32_01_Hum_Update" name="ESP32_01_Hum_Update" required pattern="[0-9]+">
            <br>
            <input type="submit" value="submit" name="submit" class="submit">
          
          <!-- *********************************************************************** -->
        </div>
        </form>
        <!-- ======================================================================================================= -->
        
      </div>
    </div>
    
    <br>
    
    <div class="content">
      <div class="cards">
        <div class="card header" style="border-radius: 15px;">
            <h3 style="font-size: 0.7rem;">LAST TIME RECEIVED DATA FROM ESP32 [ <span id="ESP32_01_LTRD"></span> ]</h3>
            <button onclick="window.open('recordtable_temp_humd.php', '_blank');">Open DHT11 Table</button>
            <button onclick="window.open('min_max_temp_hum.php', '_blank');">Open Temp and Hum Updates Table</button>
            <h3 style="font-size: 0.7rem;"></h3>
        </div>
      </div>
    </div>
    <!-- ___________________________________________________________________________________________________________________________________ -->
    
    <script>
      //------------------------------------------------------------
      document.getElementById("ESP32_01_Temp").innerHTML = "NN"; 
      document.getElementById("ESP32_01_Humd").innerHTML = "NN";
      document.getElementById("ESP32_01_LTRD").innerHTML = "NN";
      //------------------------------------------------------------
      
      Get_Data("1");
      
      setInterval(myTimer, 5000);
      
      //------------------------------------------------------------
      function myTimer() {
        Get_Data("1");
      }
      //------------------------------------------------------------
      
      //------------------------------------------------------------
      function Get_Data(id) {
				if (window.XMLHttpRequest) {
          // code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp = new XMLHttpRequest();
        } else {
          // code for IE6, IE5
          xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            const myObj = JSON.parse(this.responseText);
            if (myObj.id == "1") {
              document.getElementById("ESP32_01_Temp").innerHTML = myObj.temperature;
              document.getElementById("ESP32_01_Humd").innerHTML = myObj.humidity;
              document.getElementById("ESP32_01_LTRD").innerHTML = "Time : " + myObj.ls_time + " | Date : " + myObj.ls_date + " (dd-mm-yyyy)";
              document.getElementById("ESP32_01_Min_Temp_Update").innerHTML = myObj.MIN_TEMP;
              document.getElementById("ESP32_01_Max_Temp_Update").innerHTML = myObj.MAX_TEMP;
              document.getElementById("ESP32_01_Hum_Update").innerHTML = myObj.SET_HUMIDITY;
            }
          }
        };
        xmlhttp.open("POST","getdata.php",true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("id="+id);
			}
      //------------------------------------------------------------
      
      //------------------------------------------------------------
      //------------------------------------------------------------
      
      //------------------------------------------------------------
      //------------------------------------------------------------
    </script>

<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database = "esp32_mc_db";

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn){
    die("Connection failed: " . mysqli_connect_error());
}

if(isset($_POST['submit'])){
    if($mintempErr==""&&
    $maxtempErr==""&&
    $sethumErr==""){
        $mintemp = $_POST['ESP32_01_Min_Temp_Update'];
        $maxtemp = $_POST['ESP32_01_Max_Temp_Update'];
        $sethum = $_POST['ESP32_01_Hum_Update'];

        $sql = "UPDATE esp32_table_temp_hum_update SET MIN_TEMP = $mintemp, MAX_TEMP = $maxtemp, SET_HUMIDITY = $sethum WHERE id = 1";

        if (mysqli_query($conn, $sql)){
            echo '<script type="text/javascript">sweetAlert("New minimum and maximum temp and humidity level is set.");</script>';
        } else{
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }     
    }
}

?>

<?php


if(isset($_POST['submit4'])){
  if($ErrMsg1==""&&
  $ErrMsg2==""&&
  $ErrMsg3==""){
    
    $serverName="LAPTOP-KMPHCVG3\SQLEXPRESS";
    $connectionOptions=[
        "Database"=>"DLSU",
        "Uid"=>"",
        "PWD"=>""
    ];
  
  $conn=sqlsrv_connect($serverName, $connectionOptions);
      if($conn==false)
          die(print_r(sqlsrv_errors(),true));
  
  
  $sql1= "UPDATE PLANT SET MIN_TEMP ='$mintemp',
  MAX_TEMP = '$maxtemp',
  HUMIDITY = '$humidity'
  WHERE 
  PLANT_ID = 1";
  
  $sql2= "UPDATE PLANT SET MIN_TEMP ='$mintemp',
  MAX_TEMP = '$maxtemp',
  HUMIDITY = '$humidity'
  WHERE 
  PLANT_ID = 2";
  
  $sql3= "UPDATE PLANT SET MIN_TEMP ='$mintemp',
  MAX_TEMP = '$maxtemp',
  HUMIDITY = '$humidity'
  WHERE 
  PLANT_ID = 3";
  
  $result1=sqlsrv_query($conn,$sql1);
  $result2=sqlsrv_query($conn,$sql2);
  $result3=sqlsrv_query($conn,$sql3);
  if($result1 && $result2 && $result3){
    $success = "Set Temperature and Humidity Success!";
    echo '<script type="text/javascript">sweetAlert("'.$success.'");</script>';
  }else
    echo "Error!";
  }  

echo '<script type="text/javascript">sweetAlert("'.$ErrMsg1.'\n'.$ErrMsg2.'\n'.$ErrMsg3.'");</script>';

}


?>
  </body>
</html>