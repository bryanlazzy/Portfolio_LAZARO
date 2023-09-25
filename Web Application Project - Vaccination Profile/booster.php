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

    $booster=$_POST['booster'];

    $sql = " SELECT * FROM VACCINE WHERE HOW_MANY='$booster'";
    $results=sqlsrv_query($conn,$sql);

   
   
   
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <link rel="stylesheet" href="css/stylesb.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Vaccine Status</title>
        
        
    </head>
    
    <body>

        <h1>User Record Per Vaccine Status</h1>
     
        <table border="1px" style="width:1500px; line-height:20px;" align="center" class="tb">
            <thead>
                <tr>
                    <th>CitizenID</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>Landline Number</th>
                    <th>Cellphone Number</th>
                    <th>Email Address</th>
                    <th>Fully Vaccinated?</th>
                    <th>Date of First Dose</th>
                    <th>Date of Second Dose</th>
                    <th>Brand</th>
                    <th>Have taken a booster?</th>
                    <th>Once or Twice?</th>
                    <th>Date of 1st Booster</th>
                    <th>Brand</th>
                    <th>Date of 2nd Booster</th>
                    <th>Brand</th>
                </tr>
            </thead>
            
                <?php
                    while($rows = sqlsrv_fetch_array($results)){
                    
                        $fieldname1=$rows['CITIZEN_ID'];
                        $fieldname2=$rows['FIRST_NAME'];
                        $fieldname3=$rows['MIDDLE_NAME'];
                        $fieldname4=$rows['LAST_NAME'];
                        $fieldname5=$rows['CITIZEN_LANDLINE'];
                        $fieldname6=$rows['CITIZEN_CELLPHONE'];
                        $fieldname7=$rows['CITIZEN_EMAIL'];
                        $fieldname8=$rows['VACCINATED'];
                        $fieldname9=$rows['FIRST_DOSE'];
                        $fieldname10=$rows['SECOND_DOSE'];
                        $fieldname11=$rows['VACCINE_BRAND'];
                        $fieldname12=$rows['BOOSTER'];
                        $fieldname13=$rows['HOW_MANY'];
                        $fieldname14=$rows['BOOSTER_FIRST'];
                        $fieldname15=$rows['BOOSTER_BRAND_FIRST'];
                        $fieldname16=$rows['BOOSTER_SECOND'];
                        $fieldname17=$rows['BOOSTER_BRAND_SECOND'];


                        if (empty($fieldname14=$rows['BOOSTER_FIRST'])){
                            $firstbooster="";
                        }
                        else{
                            $firstbooster=$rows['BOOSTER_FIRST'];
                        }



                       if (empty($fieldname16=$rows['BOOSTER_SECOND'])){
                            $fieldname16="";
                        }
                        else{
                            $fieldname16=$rows['BOOSTER_SECOND'];
                        }
                        

                    echo '<tr>
                     <td>'.$fieldname1.'</td>
                     <td>'.$fieldname2.'</td>
                     <td>'.$fieldname3.'</td>
                     <td>'.$fieldname4.'</td>
                     <td>'.$fieldname5.'</td>
                     <td>'.$fieldname6.'</td>
                     <td>'.$fieldname7.'</td>
                     <td>'.$fieldname8.'</td>
                     <td>'.$fieldname9.'</td>
                     <td>'.$fieldname10.'</td>
                     <td>'.$fieldname11.'</td>
                     <td>'.$fieldname12.'</td>
                     <td>'.$fieldname13.'</td>
                     <td>'.$firstbooster.'</td>
                     <td>'.$fieldname15.'</td>
                     <td>'.$fieldname16.'</td>
                     <td>'.$fieldname17.'</td>
                   </tr>';
                    }
                    ?>
                
                 
            
        </table>

                          



            
</body>
</html>

          
            

         