<?php
ob_start();
session_start();
$serverName="LAPTOP-KMPHCVG3\SQLEXPRESS";
$connectionOptions=[
"Database"=>"DLSU",
"Uid"=>"",
"PWD"=>""
];
$conn=sqlsrv_connect($serverName, $connectionOptions);
if($conn==false)
die(print_r(sqlsrv_errors(),true));

$ErrMsg="";

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $user=$_POST['citizenid'];
    $_SESSION['citizenid'] = $user;

    $sql = "SELECT CITIZEN_ID FROM ACCOUNTS WHERE CITIZEN_ID='$user'";
        $checker = "SELECT CITIZEN_ID FROM ACCOUNTS";
        $checker1=sqlsrv_query($conn,$checker);
        while ($row1 = sqlsrv_fetch_array( $checker1, SQLSRV_FETCH_ASSOC)){
            $a=array($row1['CITIZEN_ID']);
            echo array_search($user,$a);
            if($a != $user){
            $ErrMsg="User ID $user does not exist <br>";
        }
        }
        $stmt1=sqlsrv_query($conn,$sql);
        while ($row = sqlsrv_fetch_array( $stmt1, SQLSRV_FETCH_ASSOC)){

        if( $row['CITIZEN_ID'] == $user) {
            $ErrMsg="";
        }else{
            $ErrMsg="Wrong User ID <br>";
        }


    }
    echo $ErrMsg;
}
?>

<DOCTYPE html>

    <html lang="en" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Report Page</title>
        <html lang="en" dir="ltr">
            <meta charset="UTF-8">
            <link rel="stylesheet" href="css/stylesvr.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
             <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    
    <body>
        <div class="container">
            <div class="content">
              <div class="right-side">
                <div class="topic-text"><h1>Available Reports</h1></div>
        <button onClick="reportpageFunction()" class="button2" > View of All Registered Users</button>
        <script>
            function reportpageFunction(){
                window.location.href="completevaccinereport.php";
            }
            </script>
<br>
<br>


        <br>
<form id="peruser" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    <label for="citizenid">Citizen ID: </label>  <input type="text" id="citizenid" name="citizenid">
    <br>
    <br>
       <input type="submit" value="View Report" name="submit" class="submit">
    </form>
<br>


<form id="percity" action="vaccinecity.php" method="POST">
    <p style="color: mediumblue; "><b>View User Per City/Municipality</b></p>
    <select name="city" id="city">
        <option value="Cavite City">Cavite City</option>
        <option value="Kawit">Kawit</option>
        <option value="Noveleta">Noveleta</option>
        <option value="Rosario">Rosario</option>
        <option value="Bacoor">City of Bacoor</option>
        <option value="Imus">City of Imus</option>
        <option value="Dasma">City of Dasmarinas</option>
        <option value="Carmona">Carmona</option>
        <option value="Silang">Silang</option>
        <option value="GMA">General Mariano Alvarez</option>
        <option value="GenTri">General Trias City</option>
        <option value="Amadeo">Amadeo</option>
        <option value="Indang">Indang</option>
        <option value="Tanza">Tanza</option>
        <option value="Trece">Trece Marites City</option>
        <option value="Tagaytay">Tagaytay City</option>
        <option value="Alfonso">Alfonso</option>
        <option value="GEA">General Emilio Aguinaldo</option>
        <option value="Magallanes">Magallanes</option>
        <option value="Maragondon">Maragondon</option>
        <option value="Mendez">Mendez</option>
        <option value="Naic">Naic</option>
        <option value="Ternate">Ternate</option>
    </select><br>
    <br>
       <input type="submit" value="View Report" name="submit" class="submit"><br><br>
    </form>

    <form id="perbooster" action="booster.php" method="POST">
        <p style="color: mediumblue; "><b>User Record Per Vaccine Status</b></p>
        <input type="radio" id="none" name="booster" value="none" checked><label for="none">Fully Vaccinated only, no booster</label><br>
        <input type="radio" id="once" name="booster" value="once"><label for="once">Fully Vaccinated, boostered once</label><br>
        <input type="radio" id="twice" name="booster" value="twice" ><label for="twice">Fully Vaccinated, boostered twice</label><br>
        <br>
       <input type="submit" value="View Report" name="submit" class="submit"><br><br>
    </form>

    <form id="perbooster" action="vaccinedate.php" method="POST">
        <p style="color: mediumblue; "><b>User Record Per Vaccination Date</b></p>
        <input type="date" id="dosagedate" name="dosagedate" min="1900-01-01" max="2022-12-31"><br>
        <br>
       <input type="submit" value="View Report" name="submit" class="submit"><br>
       <br>
    </form>

    <button onClick="logout()" class="button2" > Log out</button>
        <script>
            function logout(){
                window.location.href="login.php";
            }
            </script>

    <?php
    if((isset($_POST['submit']) && ($ErrMsg==""))){
        header("Location: registereduser.php");
    }
    ?>
</div>
</div>
</div>
</body>
</html>