<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Registration Page </title>
        <link rel="stylesheet" href="Style/Styles1.css">
        <script src="jquery-3.3.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    </head>

    <body>

    <?php

ob_start();

$usernameExist="";

if($_SERVER['REQUEST_METHOD'] =="POST"){



$plantname = $_POST['plant'];


// Connect to Database
$serverName="LAPTOP-KMPHCVG3\SQLEXPRESS";
$connectionOptions=[
    "Database"=>"DLSU",
    "Uid"=>"",
    "PWD"=>""
];
$conn=sqlsrv_connect($serverName, $connectionOptions);


// To get the USERNAME from Database & Compare

$username=$_POST['username'];
$sql="SELECT USER_NAME FROM USERS";
$stmt=sqlsrv_query($conn,$sql);
while ($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)){
    if( $row['USER_NAME'] == $username) {
        $usernameExist= "Username already in use. Please input a new Username.";
    }
}
echo '<script type="text/javascript">sweetAlert("'.$usernameExist.'");</script>';
}
?>

        <div class="wrapper">
        <form id="RegForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <h1 class="Yes1"> Registration Form </h1> 
            <br>
            <br>
            <div class="form">
            <div class="input_field">
            <label for="username">Username: </label><input type="text" id="username" name="username" required > 
            </div> 
            <div class="input_field">
            <label for="firstname">First Name: </label><input type="text" id="firstname" name="firstname" required > 
            </div>
            <div class="input_field">
            <label for="lastname">Last Name: </label><input type="text" id="lastname" name="lastname"  required>
            </div>
            <div class="input_field">
            <label for="password">Password: </label><input type="text" id="password" name="password" required>
            </div>
            <br>
            <h3 class="Yes"> System Setup </h3> 
            <br><br>
            <div class="input_field">
            <label>Choose a plant:</label>
            <select name="plant" id="plant">
            <option value="SnakePlant">Snake plant</option>
            <option value="Cactus">Cactus</option>
            <option value="AloeVera">Aloe Vera</option>
            </select>
            </div>
            <br>
            <div class="input_field">
            <input type="submit" value="Submit" name="submit" class="btn">
            </div>
            <div class="signup_link">
                Already have an account? <a href="loginpage.php">Signin</a>
                </div>
            </div>
            </div>
        </form>

        <?php

if(isset($_POST['submit'])){
    if($usernameExist==""){
        


$serverName="LAPTOP-KMPHCVG3\SQLEXPRESS";
$connectionOptions=[
    "Database"=>"DLSU",
    "Uid"=>"",
    "PWD"=>""
];
$conn=sqlsrv_connect($serverName, $connectionOptions);
if($conn==false)
    die(print_r(sqlsrv_errors(),true));



//variable to hold the values
//INFORMATION
$username=$_POST['username'];
$password=$_POST['password'];
$passwordhash=md5($password);

$firstname=$_POST['firstname'];
$lastname=$_POST['lastname'];



//to insert the values on the table
$sql="INSERT INTO USERS (USER_NAME,
PASSWORD,
FIRST_NAME, 
LAST_NAME,
PLANT_NAME) VALUES ('$username',
'$passwordhash',
'$firstname',
'$lastname',
'$plantname')";

$result=sqlsrv_query($conn,$sql);

$current = date('F d, Y');

$sql2="INSERT INTO PLANT_GROWTH (USER_NAME,
PLANT_NAME, DATE_CREATED) VALUES ('$username',
'$plantname','$current')";

$result2=sqlsrv_query($conn,$sql2);

$sql3="INSERT INTO GROWTH_RECORD (USER_NAME,
PLANT_NAME, DATE_CREATED) VALUES ('$username',
'$plantname','$current')";

$result3=sqlsrv_query($conn,$sql3);




if($result && $result2 && $result3){
echo '<script type="text/javascript">'; 
echo 'alert("Registration Success!");';
echo 'window.location.href = "loginpage.php";';
echo '</script>';
}else 
    echo "Error!";
}
}
?>
</body>
</html>