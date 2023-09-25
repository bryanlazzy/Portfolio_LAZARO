<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Login Page</title>
    <link rel="stylesheet" href="Style/Styles.css">
    <script src="jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- Para makita ni User ininput nya na password -->

    <!-- gang dito -->

</div>
  </head>
  <body>
    <!-- For loading Animation -->
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


$userErr="";
$pwErr="";

session_start();

if($_SERVER['REQUEST_METHOD'] =="POST"){
$user=$_POST['username'];
$_SESSION['user'] = $user;

if (empty($_POST['username'])){
    $userErr = "Username is required";

}else{
    $user=$_POST['username'];
    $sql = "SELECT USER_NAME FROM USERS WHERE USER_NAME='$user'";
    $checker = "SELECT USER_NAME FROM USERS";
        $checker1=sqlsrv_query($conn,$checker);
        while ($row1 = sqlsrv_fetch_array( $checker1, SQLSRV_FETCH_ASSOC)){
            $a=array($row1['USER_NAME']);
            echo array_search($user,$a);
            if($a != $user){
            $userErr="Wrong username";
        }
    }
    $stmt1=sqlsrv_query($conn,$sql);
    while ($row = sqlsrv_fetch_array( $stmt1, SQLSRV_FETCH_ASSOC)){
        if( $row['USER_NAME'] == $user) {
            $userErr="";
        }else{
            $userErr="Wrong Username";
        }
    }
}



$password=$_POST['password'];
if (empty($_POST['password'])){
    $pwErr = "Password is required";

}else{
    $password=$_POST['password'];
    $pwhash=md5($password);
    $sql1 = "SELECT PASSWORD FROM USERS WHERE USER_NAME='$user'";
    if($userErr){
        $stmt=null;
    }else{
        $stmt=sqlsrv_query($conn,$sql1);
        while ($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)){
            if( $row['PASSWORD'] == $pwhash) {
                $pwErr="";
            }else{
                $pwErr="Wrong Password";
            }
        }
    
    }

}
    echo '<script type="text/javascript">sweetAlert("'.$userErr.'\n'.$pwErr.'");</script>';
}



?>

    <div class="center">
    <form id="loginpage" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
      <h1>User Login</h1>
        <div class="txt_field">
        <label for="username">Username: </label>
        <br>
          <input type="text" id="username" name="username">
        </div>
        <br>
        <div class="txt_field">
        <label>Password: </label>
        <br>
           <input type="password" id="password" name="password">
        </div>
        <div>
        <input type="checkbox" id="toggle-password" />
        <label style="color:#5F7161" for="toggle-password">Show Password</label>
        </div>
        <br>
        <div class="forgot_pass">
          <a href="resetpassword.php">Forgot your password?</a>
        </div>
        <br>
        <input type="submit" value="Login" name="submit">
      </form>
        <br>
        <div align="center" class="signup_link">
          Did not register yet? <a href="registrationform.php">Signup</a>
        </div>
        <br>
        </div>
 

    
<script>
const password = document.getElementById("password");
    const togglePassword = document.getElementById("toggle-password");
    togglePassword.addEventListener("click", toggleClicked);
    function toggleClicked() {
      password.classList.toggle("visible");
      if (this.checked) {
        password.type = "text";
      } else {
        password.type = "password";
      }
    }
</script>
        <?php
        

if(isset($_POST['submit'])){
    if($userErr==""&&
    $pwErr==""){


if($stmt1){
    header("Location: loadingtoindex.php");
    exit();
    echo "Login Successful";
}else{
    echo "Error!";
}
    
}
}
?>     
    </html>
