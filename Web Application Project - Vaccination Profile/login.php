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

$useridErr = "";
$passwordErr = "";

session_start();

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $userid=$_POST['userid'];
    $_SESSION['id'] = $userid;
    if(empty($_POST['userid'])){
        $useridErr="Please enter your username <br>";
        echo $useridErr;
    }
    else{
        $userid=$_POST['userid'];
        $sql="SELECT CITIZEN_ID FROM ACCOUNTS WHERE CITIZEN_ID='$userid'";
        $checker = "SELECT CITIZEN_ID FROM ACCOUNTS";
        $checker1=sqlsrv_query($conn,$checker);
        while ($row1 = sqlsrv_fetch_array( $checker1, SQLSRV_FETCH_ASSOC)){
            $a=array($row1['CITIZEN_ID']);
            echo array_search($userid,$a);
            if($a != $userid){
            $useridErr="User ID $userid does not exist <br>";
        }
        }

        $stmt=sqlsrv_query($conn,$sql);
        while ($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)){
            if( $row['CITIZEN_ID'] == $userid) {
                $useridErr = "";
            }else{
                $useridErr = "Wrong User ID. Please enter again <br>";
                echo $useridErr;
            }
        }
        echo $useridErr;
    }



    
    
    if(empty($_POST['password'])){
        $passwordErr="Please enter your password <br>";
        echo $passwordErr;
    }
    else{
        $password=$_POST['password'];
        $passwordhash=md5($password);
        $sql2="SELECT PASSWORD FROM ACCOUNTS WHERE CITIZEN_ID=$userid";
        $stmt2=sqlsrv_query($conn,$sql2);
        while ($row = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC)){
            if( $row['PASSWORD'] == $passwordhash) {
                $passwordErr = "";
            }else{
                $passwordErr = "Wrong password. Please enter the correct password.";
                echo $passwordErr;
            }
        }
    }
}

?>
  <div class="container">
    <div class="content">
      <div class="right-side">
        <div class="topic-text">USER LOGIN</div>
        <p>Please input your details to log in.</p>
       <form id="login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <div class="input-box">
          <input type="text" id="userid" name="userid" placeholder="User ID">
        </div>
        <div class="input-box">
          <input type="password" id="password" name="password" placeholder="Password">
        </div>
        <a href="resetpass.php" class="rp" >Forgot Password?</a><br>
       <p> Haven't registered yet? <a href="registration.php"> Sign Up</a></p><br>
        <input type="submit" name="submit" class="submit" value="Login"><br><br>
      </form>
    </div>
    </div>
    <button onClick="gotoAdminFunction()" class="button1"> Admin Login</button>
        <script>
            function gotoAdminFunction(){
                window.location.href="admin.php";
            }
            </script>
  </div>



<?php
if(isset($_POST['submit'])){
    if($useridErr=="" &&
        $passwordErr==""){

$result=sqlsrv_query($conn,$sql);
$result2=sqlsrv_query($conn,$sql2);
if (($result) && ($result2)){
    header("Location: myrecordpage.php");
    exit();
    echo'Login Success';
}else{
    echo'Error';
}            
    }
}

?>

</body>
</html>