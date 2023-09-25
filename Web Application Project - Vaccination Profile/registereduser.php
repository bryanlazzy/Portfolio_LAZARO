<?php

ob_start();
session_start();
$firstnameErr="";
$midnameErr="";
$lastnameErr="";
$housenumberErr="";
$streetErr="";
$brgyErr="";
$cityErr="";
$bdayErr="";
$phoneErr="";
$cellErr="";
$emailErr="";
$firstnameenErr="";
$middlenameenErr="";
$lastnameenErr="";
$cellenErr="";
$phoneenErr="";
$celllenErr="";
$phonelenErr="";
$seconddoseErr="";
$emailduplicateErr="";
$cellduplicateErr="";
   
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

   

    $user = $_SESSION['citizenid'];
    $sql = " SELECT * FROM VACCINE WHERE CITIZEN_ID='$user'";
    $results=sqlsrv_query($conn,$sql);

    $userid=sqlsrv_fetch_array($results);



$userid['BIRTHDAY'] = $userid['BIRTHDAY']->format('Y-m-d');
$vax = $userid['VACCINATED'];
$b = $userid['BOOSTER'];
$vaxbrand = $userid['VACCINE_BRAND'];
$vaxbooster = $userid['HOW_MANY'];




if($_SERVER['REQUEST_METHOD'] =="POST"){

    $firstdose = $userid['FIRST_DOSE'];
    $seconddose = $userid['SECOND_DOSE'];
    $firstdosage = $_POST['firstdosage'];
    $seconddosage = $_POST['seconddosage'];


    $boost=$_POST['boost'];

    if ($boost == "twice"){
        $firstdosage = $_POST['firstdosage'];
        $seconddosage = $_POST['seconddosage'];
    }
    if ($boost == "once"){
        $firstdosage < $seconddosage;
        $_POST['seconddosage']=NULL;
        $firstdosage = $_POST['firstdosage'];
        $seconddosage = $_POST['seconddosage'];
    }
    elseif ($boost == "none"){
        $firstdosage > $seconddose;
        $_POST['firstdosage']=NULL;
        $_POST['seconddosage']=NULL;
        $firstdosage = $_POST['firstdosage'];
        $seconddosage = $_POST['seconddosage'];
    }



if (empty($userid['FIRST_NAME'])){
    $firstnameErr = "Firstname is required <br>";
    echo $firstnameErr;
}

$firstname=$userid['FIRST_NAME'];
if (!preg_match ("/^[a-zA-z]*$/", $firstname)) { 
    $firstnameenErr = "Only alphabets and whitespace are allowed in First Name. <br>"; 
    echo $firstnameenErr; 
} 

if (empty($userid['MIDDLE_NAME'])){
    $midnameErr = "Middlename is required <br>";
    echo $midnameErr;
}

$middlename=$userid['MIDDLE_NAME'];
if (!preg_match ("/^[a-zA-z]*$/", $middlename)) { 
    $middlenameenErr = "Only alphabets and whitespace are allowed in Middle Name. <br>"; 
    echo $middlenameenErr; 
}


if (empty($userid['LAST_NAME'])){
    $lastnameErr = "Lastname is required <br>";
    echo $lastnameErr;
}

$lastname=$userid['LAST_NAME'];
if (!preg_match ("/^[a-zA-z]*$/", $lastname)) { 
    $lastnameenErr = "Only alphabets and whitespace are allowed in Last Name. <br>"; 
    echo $lastnameenErr; 
   }


if (empty($userid['BIRTHDAY'])){
    $birthdateErr = "Birthdate is required <br>";
    echo $birthdateErr;
}

// Contact Information
$landline=$userid['CITIZEN_LANDLINE'];
if (empty($userid['CITIZEN_LANDLINE'])){
    $phoneErr = "Landline number is required <br>";
    echo $phoneErr;
}
elseif (!preg_match ("/^[0-9]+$/", $landline)){ 
    $phoneenErr = "Only numeric value is allowed in Telephone number. <br>"; 
    echo $phoneenErr; 
}
elseif(strlen($landline)!=9){
    $phonelenErr = "Landline number should be 9 digits including area code <br>";
    echo $phonelenErr;
}


//check if mobile no. is empty
$cell=$userid['CITIZEN_CELLPHONE'];
if (empty($userid['CITIZEN_CELLPHONE'])){
    $cellErr = "Mobile number is required <br>";
    echo $cellErr;
}
elseif (!preg_match ("/^[0-9]+$/", $cell)){ 
    $cellenErr = "Only numeric value is allowed in Phone number. <br>"; 
    echo $cellenErr; 
}
elseif(strlen($cell)!=11){
    $celllenErr = "Mobile number should be 11 digits <br>";
    echo $celllenErr;
}

if (empty($userid['CITIZEN_EMAIL'])){
    $emailErr = "Email address is required <br>";
    echo $emailErr;
}

if (empty($userid['HOUSE_NUM'])){
    $housenumberErr = "House number is required <br>";
    echo $housenumberErr;
}

if (empty($userid['HOUSE_STREET'])){
    $streetErr = "Street/Subdivision is required <br>";
    echo $streetErr;
}

if (empty($userid['HOUSE_BRGY'])){
    $brgyErr = "Barangay is required <br>";
    echo $brgyErr;
}

$boost=$userid['HOW_MANY'];
if ($boost = "once"){
    $firstdosage < $seconddosage;
}

if ($boost = "none"){
    $firstdosage > $seconddose;
}

// To add conditions on Vaccination Dates
elseif($firstdose < $seconddose){
    if($seconddose < $firstdosage){
        if($firstdosage < $seconddosage){
            $seconddosage=$_POST['seconddosage'];
        }
        else{
            $secondboosterErr = "2nd booster should not be before the 1st booster date";
            echo $secondboosterErr;
        }
    }
    else{
        $boosterErr = "1st booster should not be before the 2nd dose date";
        echo $boosterErr;
    }
}
else {
    $seconddoseErr = "2nd dose should not be before the 1st dose date <br>";
    echo $seconddoseErr;
}


}

?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <link rel="stylesheet" href="css/stylesc.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>User Record</title>
        
    </head>
    
    <body>
<div class="container">
    <div class="content">
      <div class="right-side">
        <div class="topic-text"><h1>User Information</h1></div>
         <form id="vaccine" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <h3>Full Name</h3>
        <label for="firstname">First Name: </label> <?php echo $userid['FIRST_NAME']?> &emsp;&emsp;
        <label for="middlename">Middle Name: </label>  <?php echo $userid['MIDDLE_NAME']?> &emsp;&emsp;
        <label for="lastname">Last Name: </label>  <?php echo $userid['LAST_NAME']?> &emsp;&emsp;<br>
        <br>
        <h3>Address</h3>
        <label for="housenumber">House Number: </label><?php echo $userid['HOUSE_NUM']?> &emsp;&emsp;
        <label for="street">Street/Subdivision: </label><?php echo $userid['HOUSE_STREET']?> &emsp;&emsp;
        <label for="brgy">Brgy: </label><?php echo $userid['HOUSE_BRGY']?> &emsp;&emsp;
        <p>City/Municipality:</p><?php echo $userid['HOUSE_CITY']?> &emsp;&emsp;
        <br>
        <h3>Birthday</h3>
        <label for="bday">Birthday: </label><?php echo $userid['BIRTHDAY']?> <br>
        <br>
        <h3>Contacts</h3>
        <label for="phone">Landline: </label><?php echo $userid['CITIZEN_LANDLINE']?> &emsp;&emsp;<br>
        <label for="cell">Cellphone Number: </label><?php echo $userid['CITIZEN_CELLPHONE']?> &emsp;&emsp;<br>
        <label for="email">Email: </label>  <?php echo $userid['CITIZEN_EMAIL']?> &emsp;&emsp;<br>
        <br>
        <h3>Vaccination Information</h3>
        <label><b>Are you fully vaccinated?</b></label>
        <?php echo $userid['VACCINATED']?>
        <br>
        <label><b>First Dose: </b></label>
        <?php echo $userid['FIRST_DOSE']?> &emsp;&emsp;<br>
        <label><b>Second Dose: </b></label>
        <?php echo $userid['SECOND_DOSE']?> &emsp;&emsp;<br>
        <br>
        <label><b>Brand of Vaccine:</b></label><?php echo $userid['VACCINE_BRAND']?><br>
        <br>
        <label><b>Have you taken a booster vaccine?</b></label><br>
        <input type="radio" id="yes" name="booster" value="yes" <?php echo ($b=='yes')?'checked':''?>><label for="yes"> yes</label><br>
        <input type="radio" id="no" name="booster" value="no" <?php echo ($b=='no')?'checked':''?>><label for="no"> no</label><br>
        <input type="radio" id="none" name="booster" value="none" <?php echo ($b=='none')?'checked':''?>><label for="none"> none</label><br><br>
        <label><b>If yes: Once or Twice?</b></label><br>
        <input type="radio" id="once" name="boost" value="once" <?php echo ($vaxbooster=='once')?'checked':''?>><label for="once"> Once</label><br>
        <input type="radio" id="twice" name="boost" value="twice" <?php echo ($vaxbooster=='twice')?'checked':''?>><label for="twice"> Twice</label><br>
        <input type="radio" id="none" name="boost" value="none" <?php echo ($vaxbooster=='none')?'checked':''?>><label for="none"> None</label><br>
        <br>
        <label><b>First Dose: </b></label>
        <input type="date" id="firstdosage" name="firstdosage" min="2021-03-01" max="2022-12-31" value="<?php echo $userid['BOOSTER_FIRST']?>">
        <label><b>Vaccine Brand: </b></label>
        <select name="brand" id="brand">
        <option value="<?php echo $userid['BOOSTER_BRAND_FIRST']?>"><?php echo $userid['BOOSTER_BRAND_FIRST']?></option>
            <option value="Pfizer">Pfizer</option>
            <option value="Sinovac">Sinovac</option>
            <option value="Astrazeneca">Astrazeneca</option>
            <option value="Sinopharm">Sinopharm</option>
            <option value="Moderna">Moderna</option>
            <option value="Janssen">Janssen</option>
            <option value="Bharat">Bharat</option>
            <option value="Sputnik V">Sputnik V</option>
            <option value="None">None</option>
        </select><br>
        <label><b>Second Dose: </b></label>
        <input type="date" id="seconddosage" name="seconddosage" min="2021-04-01" max="2022-12-31" value="<?php echo $userid['BOOSTER_SECOND']?>">
        <label><b>Vaccine Brand: </b></label>
        <select name="brandd" id="brandd">
        <option value="<?php echo $userid['BOOSTER_BRAND_SECOND']?>"><?php echo $userid['BOOSTER_BRAND_SECOND']?></option>
            <option value="Pfizer">Pfizer</option>
            <option value="Sinovac">Sinovac</option>
            <option value="Astrazeneca">Astrazeneca</option>
            <option value="Sinopharm">Sinopharm</option>
            <option value="Moderna">Moderna</option>
            <option value="Janssen">Janssen</option>
            <option value="Bharat">Bharat</option>
            <option value="Sputnik V">Sputnik V</option>
            <option value="None">None</option>
        </select><br>
        <br>
            <input type="submit" value="Update" name="submit" class="submit"><br>

        </form>
        <br>
        <form action="login.php">
        <input type="submit"value="Sign Out" class="submit">
        </form>
        </div>
    </div>
  </div>
</body>
</html>

<?php

if(isset($_POST['submit'])){
    if($firstnameErr=="" &&
        $midnameErr=="" && 
         $lastnameErr=="" && 
         $housenumberErr=="" && 
         $streetErr=="" && 
         $brgyErr=="" && 
         $cityErr=="" && 
         $bdayErr=="" && 
         $phoneErr=="" && 
         $cellErr=="" && 
         $emailErr=="" && 
         $firstnameenErr=="" && 
         $middlenameenErr=="" &&
         $lastnameenErr=="" && 
         $cellenErr=="" && 
         $phoneenErr=="" && 
         $celllenErr=="" && 
         $phonelenErr=="" &&
         $seconddoseErr==""&&
        $secondboosterErr==""&&
        $boosterErr==""){


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
$firstname=$userid['FIRST_NAME'];
$middlename=$userid['MIDDLE_NAME'];
$lastname=$userid['LAST_NAME'];
$bday=$userid['BIRTHDAY'];
//CONTACT
$phone=$userid['CITIZEN_LANDLINE'];
$cell=$userid['CITIZEN_CELLPHONE'];
$email=$userid['CITIZEN_EMAIL'];
//LOCATION
$housenumber=$userid['HOUSE_NUM'];
$street=$userid['HOUSE_STREET'];
$brgy=$userid['HOUSE_BRGY'];
$city=$userid['HOUSE_CITY'];
//VACCINATION STATUS
$question=$userid['VACCINATED'];
$firstdose=$userid['FIRST_DOSE'];
$seconddose=$userid['SECOND_DOSE'];
$vaccine=$userid['VACCINE_BRAND'];
//BOOSTER_STATUS
$booster=$_POST['booster'];    
$boost=$_POST['boost'];  
$firstdosage=$_POST['firstdosage'];
$brand=$_POST['brand'];
$seconddosage=$_POST['seconddosage'];
$brandd=$_POST['brandd'];


//to insert the values on the table
           

$sql1 = "UPDATE VACCINE SET 
FIRST_NAME = '$firstname',
MIDDLE_NAME = '$middlename',
LAST_NAME = '$lastname',
HOUSE_NUM = '$housenumber',
HOUSE_STREET = '$street',
HOUSE_BRGY = '$brgy',
HOUSE_CITY = '$city',
BIRTHDAY = '$bday',
CITIZEN_LANDLINE = '$phone',
CITIZEN_CELLPHONE = '$cell',
CITIZEN_EMAIL = '$email',
VACCINATED = '$question',
FIRST_DOSE = '$firstdose',
SECOND_DOSE = '$seconddose',
VACCINE_BRAND = '$vaccine',
BOOSTER = '$booster',
HOW_MANY = '$boost',
BOOSTER_FIRST = '$firstdosage',
BOOSTER_BRAND_FIRST = '$brand',
BOOSTER_SECOND = '$seconddosage',
BOOSTER_BRAND_SECOND = '$brandd'
WHERE CITIZEN_ID='$user'";

$result=sqlsrv_query($conn,$sql1);

if($result){
header("Location: registereduser.php");
    echo "Edit Successful";
}else 
    echo "Error!";
}
}
?>
