<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Login Page</title>
    <html lang="en" dir="ltr">
    <meta charset="UTF-8">

    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
if($conn==false)
die(print_r(sqlsrv_errors(),true));

$usernameErr="";
$passwordErr="";

if($_SERVER['REQUEST_METHOD'] == "POST"){
$username=$_POST['username'];
if(empty($_POST['username'])){
    $usernameErr="Please enter your username <br>";
    echo $usernameErr;
}
else{
    $username=$_POST['username'];
    $sql="SELECT USERNAME FROM ADMIN";
    $stmt=sqlsrv_query($conn,$sql);
    while ($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)){
        if( $row['USERNAME'] == $username) {
            $usernameErr = "";
        }else{
            $usernameErr = "Wrong Username. Please enter again <br>";
            echo $usernameErr;
        }
    }
}


if(empty($_POST['password'])){
    $passwordErr="Please enter your password <br>";
    echo $passwordErr;
}
else{
    $password=$_POST['password'];
    $sql2="SELECT ADMIN_PASSWORD FROM ADMIN";
    $stmt2=sqlsrv_query($conn,$sql2);
    while ($row = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC)){
        if( $row['ADMIN_PASSWORD'] == $password) {
            $passwordErr = "";
        }else{
            $passwordErr = "Wrong Password. Please enter again <br>";
            echo $passwordErr;
        }
    }
}






}

?>


    <div class="container2">
    <div class="content">
      <div class="right-side">
        <div class="topic-text">ADMIN LOGIN</div>
        <p>Please input your details to log in.</p>
       <form id="admin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <div class="input-box">
          <input type="text" id="username" name="username" placeholder="Username">
        </div>
        <div class="input-box">
          <input type="password" id="password" name="password" placeholder="Password">
        </div>
        <input type="submit" name="submit" class="submit" value="Login"><br><br>
      </form>
    </div>
    </div>
  </div>

<?php
if(isset($_POST['submit'])){
    if($usernameErr=="" &&
        $passwordErr==""){

$result=sqlsrv_query($conn,$sql);
$result2=sqlsrv_query($conn,$sql2);
if (($result) && ($result2)){
    header("Location: vaccinationreport.php");
    exit();
    echo'Login Success';
}else{
    echo'Error';
}


    }
}
?>
</body>