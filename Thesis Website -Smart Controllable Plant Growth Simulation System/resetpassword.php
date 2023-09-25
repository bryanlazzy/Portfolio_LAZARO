<DOCTYPE html>
    <html lang="en" xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <link rel="stylesheet" href="reportpagestyles.css">
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reset Password</title>
        <link rel="stylesheet" href="Style/Styles.css">
        <script src="jquery-3.3.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    </head>
    
    <body>

    <?php

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

$userErr="";
$olduserErr="";
$passErr="";


if($_SERVER['REQUEST_METHOD'] =="POST"){

if (empty($_POST['username'])){
    $userErr = "Username is required";   
}else{
$username=$_POST['username'];
$sql = "SELECT PASSWORD FROM USERS WHERE USER_NAME='$username'";
$results=sqlsrv_query($conn,$sql);
$oldpassword=sqlsrv_fetch_array($results);
$password = $_POST['password'];

        ob_start();
        echo($oldpassword[0]);
        $str = ob_get_clean();

        if(empty($oldpassword[0])){
            $olduserErr="Username does not exist. Try again";
        }

        if(empty($_POST['password']) || empty($_POST['password2'])){
            $passErr="Please enter your new password.";
        }
}
    echo '<script type="text/javascript">sweetAlert("'.$userErr.'\n'.$olduserErr.'\n'.$passErr.'");</script>';
}

?>

    <div class="center">
    <form id="reset" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">  
        <h1>Reset Password</h1>
    <div class="txt_field">
    <label for="username">Username:</label><input type="text" class="username" id="username" name="username"><br> 
    </div>
    <br>
    <div class="txt_field">
    <label for="password">Password:</label><input type="text" id="password" name="password"><br>
    </div>
    <br>
    <div class="txt_field">
    <label for="password2">Re-type Password:</label>   <input type="text" id="password2" name="password2"><br>
    </div>
    <br>
    <input type="submit" name="submit" value="Submit" class="submit"> 
    <br>
    </form>
    <form align="center" action="loginpage.php">
        <input type="submit"value="Back">
        </form>
    </div>
    <?php

  
if(isset($_POST['password'])){

    $password = $_POST['password'];

}else{

    $password = "";

}

if(isset($_POST['password2'])){

    $password2 = $_POST['password2'];

}else{

    $password2 = "";

}

if(isset($_POST['submit'])) {  
    if(($password==$password2) && 
    ($userErr=="" &&
    $olduserErr=="" &&
    $passErr=="")){

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

      
        $passwordhash=md5($password);

        $sql1 = "UPDATE USERS SET PASSWORD = REPLACE(PASSWORD,'$str','$passwordhash') 
        WHERE USER_NAME = '$username'";

        $result=sqlsrv_query($conn,$sql1);
    
        if($result){
        echo '<script type="text/javascript">sweetAlert("Reset Password Successful");</script>';
        }else{
        echo 'Error Occured! Kindly repeat.';
        }
    }
}
?>

