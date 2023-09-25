<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Registration Page</title>
    <html lang="en" dir="ltr">
    <meta charset="UTF-8">

    <link rel="stylesheet" href="css/stylesc.css">
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


if($_SERVER['REQUEST_METHOD'] == "POST"){
$firstname=$_POST['firstname'];
if(empty($_POST['firstname'])){
    $firstnameErr = "First name is required <br>";
    echo $firstnameErr;
}
elseif(!preg_match ("/^[a-zA-z]+$/", $firstname) ) {
    $firstnameenErr = "Only alphabets and whitespace are allowed. <br>";
    echo $firstnameenErr;  
}
else{
    $firstname=$_POST['firstname'];
}

$middlename=$_POST['middlename'];
if(empty($_POST['middlename'])){
    $midnameErr = "Middle name is required <br>";
    echo $midnameErr;
}
elseif (!preg_match ("/^[a-zA-z]+$/", $middlename) ) {
    $middlenameenErr = "Only alphabets and whitespace are allowed. <br>";
    echo $middlenameenErr;
}
else{
    $middlename=$_POST['middlename'];
}


$lastname=$_POST['lastname'];
if(empty($_POST['lastname'])){
    $lastnameErr = "Last name is required <br>";
    echo $lastnameErr;
}
elseif (!preg_match ("/^[a-zA-z]+$/", $lastname) ) {
    $lastnameenErr = "Only alphabets and whitespace are allowed. <br>";
    echo $lastnameenErr;
}
else{
    $lastname=$_POST['lastname'];
}

$phone=$_POST['phone'];
if(empty($_POST['phone'])){
    $phoneErr = "Landline number is required <br>";
    echo $phoneErr;
}
elseif (!preg_match("/^[a-zA-z]+$/", $phone)){
    if(!preg_match('/^[0-9]{9}+$/', $phone)){
        $phonelenErr = "Landline number should be 9 digits including area code <br>";
        echo $phonelenErr;
    }
    else{
        $phone=$_POST['phone'];
    }
}
else{
    $phoneenErr = "Only numeric value is allowed <br>";
    echo $phoneenErr; 
}



$cell=$_POST['cell'];
if(empty($_POST['cell'])){
    $cellErr = "Cellphone number is required <br>";
    echo $cellErr;
}
elseif (!preg_match("/^[a-zA-z]+$/", $cell)) {
    if(!preg_match('/^[0-9]{11}+$/', $cell)){
        $celllenErr = "Cellphone number should be 11 digits <br>";
        echo $celllenErr;
    }
    else{
        $cell=$_POST['cell'];
    }
}
else{
    $cellenErr = "Only numeric value is allowed <br>";
    echo $cellenErr;
}

$firstdose=$_POST['firstdose'];
$seconddose=$_POST['seconddose'];
$firstdosage=$_POST['firstdosage'];
$seconddosage=$_POST['seconddosage'];
if ($seconddose < $firstdose ) {
    $seconddoseErr="Date of 2nd dose should not be before the date of the 1st dose <br>";
    echo $seconddoseErr;
} 


if(empty($_POST['bday'])){
    $bdayErr = "Birthday is required <br>";
    echo $bdayErr;
}
else{
    $bday=$_POST['bday'];
}


if(empty($_POST['email'])){
    $emailErr = "Email is required <br>";
    echo $emailErr;
}
else{
    $email=$_POST['email'];
}

$email=$_POST['email'];
$sql="SELECT CITIZEN_EMAIL FROM VACCINE";
$stmt=sqlsrv_query($conn,$sql);
while ($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)){
    if( $row['CITIZEN_EMAIL'] == $email) {
        $emailduplicateErr= "Email Address already in use. <br> ";
        echo $emailduplicateErr;
    }
}

$cell=$_POST['cell'];
$sql="SELECT CITIZEN_CELLPHONE FROM VACCINE";
$stmt=sqlsrv_query($conn,$sql);
while ($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)){
    if( $row['CITIZEN_CELLPHONE'] == $cell) {
        $cellduplicateErr="This mobile number is already taken. <br>";
        echo $cellduplicateErr;
    }
}

}


?>
<div class="container">
    <div class="content">
      <div class="right-side">
        <div class="topic-text"><h1>Registration Form</h1></div>
         <form id="vaccine" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <h3>Full Name</h3>
        <label for="firstname">First Name: </label>  <input type="text" id="firstname" name="firstname">
        <label for="middlename">Middle Name: </label>  <input type="text" id="middlename" name="middlename">
        <label for="lastname">Last Name: </label>  <input type="text" id="lastname" name="lastname"><br>
        <br>
        <h3>Address</h3>
        <label for="housenumber">House Number: </label><input type="text" id="housenumber" name="housenumber">
        <label for="street">Street/Subdivision: </label><input type="text" id="street" name="street">
        <label for="brgy">Brgy: </label><input type="text" id="brgy" name="brgy">
        <p>City/Municipality:
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
        </select></p>
        <br>
        <h3>Birthday</h3>
        <input type="date" id="bday" name="bday" min="1900-01-01" max="2022-12-31"><br>
        <br>
        <h3>Contacts</h3>
        <label for="phone">Landline: </label><input type="tel" id="phone" name="phone"><br>
        <label for="cell">Cellphone Number: </label><input type="tel" id="cell" name="cell"><br>
        <label for="email">Email: </label>  <input type="email" id="email" name="email"><br>
        <br>
        <h3>Vaccination Information</h3>
        <label><b>Are you fully vaccinated?</b></label><br>
        <input type="radio" id="yes" name="question" value="yes" checked><label for="yes"> yes</label><br>
        <input type="radio" id="no" name="question" value="no"><label for="no"> no</label><br>
        <br>
        <label><b>First Dose: </b></label>
        <input type="date" id="firstdose" name="firstdose" min="2021-03-01" max="2022-12-31"><br>
        <label><b>Second Dose: </b></label>
        <input type="date" id="seconddose" name="seconddose" min="2021-04-01" max="2022-12-31"><br>
        <br>
        <label><b>Brand of Vaccine</b></label><br>
        <input type="radio" id="Pfizer" name="vaccine" value="Pfizer"><label for="Pfizer"> Pfizer</label><br>
        <input type="radio" id="Sinovac" name="vaccine" value="Sinovac"><label for="Sinovac"> Sinovac</label><br>
        <input type="radio" id="Astrazeneca" name="vaccine" value="Astrazeneca"><label for="Astrazeneca"> Astrazeneca</label><br>
        <input type="radio" id="Sinopharm" name="vaccine" value="Sinopharm"><label for="Sinopharm"> Sinopharm</label><br>
        <input type="radio" id="Moderna" name="vaccine" value="Moderna"><label for="Moderna"> Moderna</label><br>
        <input type="radio" id="Janssen" name="vaccine" value="Janssen"><label for="Janssen"> Janssen</label><br>
        <input type="radio" id="Bharat" name="vaccine" value="Bharat"><label for="Bharat"> Bharat</label><br>
        <input type="radio" id="Sputnik" name="vaccine" value="Sputnik"><label for="Sputnik"> Sputnik V</label><br>
        <br>
        <label><b>Have you taken a booster vaccine?</b></label><br>
        <input type="radio" id="yes" name="booster" value="yes"><label for="yes"> yes</label><br>
        <input type="radio" id="no" name="booster" value="no"><label for="no"> no</label><br>
        <input type="radio" id="none" name="booster" value="none"><label for="none"> none</label><br><br>
        <label><b>If yes: Once or Twice?</b></label><br>
        <input type="radio" id="once" name="boost" value="once"><label for="once"> Once</label><br>
        <input type="radio" id="twice" name="boost" value="twice"><label for="twice"> Twice</label><br>
        <input type="radio" id="none" name="boost" value="none"><label for="none"> None</label><br>
        <br>
        <label><b>First Dose: </b></label>
        <input type="date" id="firstdosage" name="firstdosage" min="2021-03-01" max="2022-12-31">
        <label><b>Vaccine Brand: </b></label>
        <select name="brand" id="brand">
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
        <input type="date" id="seconddosage" name="seconddosage" min="2021-04-01" max="2022-12-31">
        <label><b>Vaccine Brand: </b></label>
        <select name="brandd" id="brandd">
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
        <input type="submit" value="Submit" name="submit" class="submit"><br>
        <br>
    </form>
    </div>
    </div>
  </div>

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
         $seconddoseErr=="" &&
         $emailduplicateErr=="" &&
         $cellduplicateErr==""){


$firstname=$_POST['firstname'];
$middlename=$_POST['middlename'];
$lastname=$_POST['lastname'];
$housenumber=$_POST['housenumber'];
$street=$_POST['street'];
$brgy=$_POST['brgy'];
$city=$_POST['city'];
$bday=$_POST['bday'];
$phone=$_POST['phone'];
$cell=$_POST['cell'];
$email=$_POST['email'];
$question=$_POST['question'];
$firstdose=$_POST['firstdose'];
$seconddose=$_POST['seconddose'];
$vaccine=$_POST['vaccine'];
$booster=$_POST['booster'];
$boost=$_POST['boost'];
$firstdosage=$_POST['firstdosage'];
$brand=$_POST['brand'];
$seconddosage=$_POST['seconddosage'];
$brandd=$_POST['brandd'];

$sql="INSERT INTO VACCINE (FIRST_NAME,
MIDDLE_NAME,
LAST_NAME,
HOUSE_NUM,
HOUSE_STREET,
HOUSE_BRGY,
HOUSE_CITY,
BIRTHDAY,
CITIZEN_LANDLINE,
CITIZEN_CELLPHONE,
CITIZEN_EMAIL,
VACCINATED,
FIRST_DOSE,
SECOND_DOSE,
VACCINE_BRAND,
BOOSTER,
HOW_MANY,
BOOSTER_FIRST,
BOOSTER_BRAND_FIRST,
BOOSTER_SECOND,
BOOSTER_BRAND_SECOND) VALUES ('$firstname',
'$middlename',
'$lastname',
'$housenumber',
'$street',
'$brgy',
'$city',
'$bday',
'$phone',
'$cell',
'$email',
'$question',
'$firstdose',
'$seconddose',
'$vaccine',
'$booster',
'$boost',
'$firstdosage',
'$brand',
'$seconddosage',
'$brandd')";
$result=sqlsrv_query($conn,$sql);
if($result){
    header("Location: account.php");
    exit();
    echo'Registration Successful';
}else{
    echo'Error';
} 
    }


}

?>
</body>
</html>