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
    $sql = "SELECT CITIZEN_ID FROM VACCINE WHERE CITIZEN_ID=(SELECT IDENT_CURRENT('VACCINE'))";
    $results=sqlsrv_query($conn,$sql);

    $userid=sqlsrv_fetch_array($results);
?>

<DOCTYPE html>

    <html lang="en" xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <html lang="en" dir="ltr">
    <title>Registration Successful</title>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="css/stylesrp.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    
    <body>
    <div class="topic-text">
        <h1 align="center">Registration Successful</h1>
        <h2 align="center">Your USERID is: <?php echo $userid['CITIZEN_ID']; ?> </h2>
    </div>

    <div class="container">
    <div class="content">
      <div class="right-side">
        <form id="login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" >
        <p>Complete your login credentials.</p>
        <div class="input-box">
        <label for="userid">USERID:</label><br>   <input type="text" class="userid" id="userid" name="userid" value="<?php echo $userid['CITIZEN_ID']?>">
        </div><br>
        <div class="input-box">
        <label for="password">New Password:</label>  <input type="password" id="password" name="password">
        </div><br>
        <div class="input-box">
        <label for="password2">Re-type New Password:</label>   <input type="password" id="password2" name="password2">
        </div><br>
        <input type="submit" name="submit" class="submit" value="Submit"><br><br>
      </form>
      <button onClick="goBackFunction()" class="button1"> Go back to Login Page</button>
        <script>
            function goBackFunction(){
                window.location.href="login.php";
            }
            </script>
    </div>
    </div>
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
        if($password==$password2){
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
            $useridstr=$userid['CITIZEN_ID'];
            $passwordhash=md5($password);

            $sql = "INSERT INTO ACCOUNTS (CITIZEN_ID, PASSWORD) VALUES ('$useridstr','$passwordhash') ";
            $results=sqlsrv_query($conn,$sql);
        
            if($results){
            echo 'Login Created';
            }else{
            echo 'Error Occured! Kindly repeat.';
            }
        }else{
            echo 'password did not match';
        }
    }
?>