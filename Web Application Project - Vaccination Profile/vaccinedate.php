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

    $dosagedate=$_POST['dosagedate'];

    $sql = " SELECT * FROM VACCINE WHERE (FIRST_DOSE = '$dosagedate') OR (SECOND_DOSE = '$dosagedate') OR (BOOSTER_FIRST = '$dosagedate') OR (BOOSTER_SECOND = '$dosagedate')";
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
                    <th>Date of Vaccination</th>
                    
                </tr>
            </thead>
            
                <?php
                    while($rows = sqlsrv_fetch_array($results)){
                    
                        $fieldname1=$rows['CITIZEN_ID'];
                        $fieldname2=$rows['FIRST_NAME'];
                        $fieldname3=$rows['MIDDLE_NAME'];
                        $fieldname4=$rows['LAST_NAME'];
                        $fieldname9=$rows['FIRST_DOSE'];
                        $fieldname10=$rows['SECOND_DOSE'];
                        $fieldname14=$rows['BOOSTER_FIRST'];
                        $fieldname16=$rows['BOOSTER_SECOND'];



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

                        if ($fieldname9==$dosagedate){
                            $dosage=$fieldname9;
                        }elseif ($fieldname10==$dosagedate) {
                            $dosage=$fieldname10;
                        }elseif ($firstbooster==$dosagedate){
                            $dosage=$firstbooster;
                        }elseif ($fieldname16==$dosagedate){
                            $dosage=$fieldname16;
                        }
                        

                    echo '<tr>
                     <td>'.$fieldname1.'</td>
                     <td>'.$fieldname2.'</td>
                     <td>'.$fieldname3.'</td>
                     <td>'.$fieldname4.'</td>
                     <td>'.$dosage.'</td>
                   </tr>';
                    }
                    ?>
                
                 
            
        </table>

                          



            
</body>
</html>

          
            

         