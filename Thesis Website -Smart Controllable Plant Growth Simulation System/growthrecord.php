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

<!-- PHP  -->
<?php

session_start();


$user = $_SESSION['user'];

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
    $sql = " SELECT * FROM GROWTH_RECORD WHERE USER_NAME = '$user'";
    $results=sqlsrv_query($conn,$sql);
   


?>

<!-- PHP  -->

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

  
<br><br><br><br>
        
        <table border="1px" style="width:800px; line-height:20px;" align="center">
            <thead>
                <tr>
                    <th>UPDATE ID</th>
                    <th>USER NAME</th>
                    <th>PLANT NAME</th>
                    <th>PLANT SIZE</th>
                    <th>DAY</th>
                    <th>DATE CREATED</th>
                    <th>DATE UPDATED</th>
                </tr>
            </thead>
            
                <?php
                    while($rows = sqlsrv_fetch_array($results)){
                    
                            $fieldname1=$rows['UPDATE_ID'];
                            $fieldname2=$rows['USER_NAME'];
                            $fieldname3=$rows['PLANT_NAME'];
                            $fieldname4=$rows['PLANT_SIZE'];
                            $fieldname5=$rows['DAY'];
                            $fieldname6=$rows['DATE_CREATED'];
                            $fieldname7=$rows['DATE_UPDATED'];
                            
                        echo '<tr>
                         <td>'.$fieldname1.'</td>
                         <td>'.$fieldname2.'</td>
                         <td>'.$fieldname3.'</td>
                         <td>'.$fieldname4.'</td>
                         <td>'.$fieldname5.'</td>
                         <td>'.$fieldname6.'</td>
                         <td>'.$fieldname7.'</td>
                       </tr>';
                    }
                    ?>
                
                 
            
        </table>
        <br>          
             
 </body>
</html>