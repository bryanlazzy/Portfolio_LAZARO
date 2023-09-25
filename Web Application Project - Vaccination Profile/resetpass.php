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
    
    $oldstrErr="";
    $useridErr="";
    $passwordErr="";

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(empty($_POST['userid'])){
            $useridErr="Please enter a user ID.";
            echo $useridErr;
        }else{
            $userid=$_POST['userid'];
            $sql = "SELECT PASSWORD FROM ACCOUNTS WHERE CITIZEN_ID = $userid";
            $results=sqlsrv_query($conn,$sql);

            $oldpass=sqlsrv_fetch_array($results);

            $password = $_POST['password'];

            ob_start();
            echo($oldpass[0]);
            $oldstr = ob_get_clean();

            if(empty($oldpass[0])){
                $oldstrErr="User ID does not exist. Try again <br>";
                echo $oldstrErr;
            }

            if(empty($_POST['password'])){
                $passwordErr="Please enter your new password. <br>";
                echo $passwordErr;
            }
        }

    

    }
?>

<DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <html lang="en" dir="ltr">
    <title>Reset Password</title>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="css/stylesrp.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    
    <body>
    <div class="container">
    <div class="content">
      <div class="right-side">
        <div class="topic-text">Reset Password</div>
        <form id="login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" >
        <p>Complete your login credentials.</p>
        <div class="input-box">
        <label for="userid">USERID:</label><br>   <input type="text" class="userid" id="userid" name="userid">
        </div><br>
        <div class="input-box">
        <label for="password">New Password:</label>  <input type="password" id="password" name="password">
        </div><br>
        <div class="input-box">
        <label for="password2">Re-type New Password:</label>   <input type="password" id="password2" name="password2">
        </div><br>
        <input type="submit" name="submit" class="submit" value="Submit"><br><br>
      </form>
    </div>
    </div>
    <button onClick="goBackFunction()" class="button1"> Go back to Login Page</button>
        <script>
            function goBackFunction(){
                window.location.href="login.php";
            }
            </script>
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
        if(($password==$password2) && ($oldstrErr=="" && $useridErr=="" && $passwordErr=="")){
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

            $sql2 = "UPDATE ACCOUNTS SET PASSWORD = REPLACE(PASSWORD,'$oldstr','$passwordhash')";
            $results2=sqlsrv_query($conn,$sql2);
        
            if($results2){
            echo 'New Password is Set';
            }else{
            echo 'Error Occured! Kindly repeat. <br>';
            }
        }else{
            echo 'Password did not match or User ID does not exist';
        }
    }
            
?>