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

    $city=$_POST['city'];

    $sql = " SELECT * FROM VACCINE WHERE HOUSE_CITY='$city' ";
    $results=sqlsrv_query($conn,$sql);

    $sql2="SELECT COUNT(CITIZEN_ID)as totalcount FROM VACCINE WHERE HOUSE_CITY='$city' ";
    $result2=sqlsrv_query($conn,$sql2);
    $totalcount=sqlsrv_fetch_array($result2);

   
   
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <link rel="stylesheet" href="css/stylesb.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>User Record Per City</title>
        
    </head>
    
    <body>

        <h1>User Record Per City</h1>
     
        <table border="1px" style="width:1500x; line-height:20px;" align="center" class="tb">
            <thead>
                <tr>
                    <th>CitizenID</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>House Number</th>
                    <th>Street</th>
                    <th>Baranggay</th>
                    <th>City/Municipality</th>
                </tr>
            </thead>
            
                <?php
                    while($rows = sqlsrv_fetch_array($results)){

                        $fieldname1=$rows['CITIZEN_ID'];
                        $fieldname2=$rows['FIRST_NAME'];
                        $fieldname3=$rows['MIDDLE_NAME'];
                        $fieldname4=$rows['LAST_NAME'];
                        $fieldname5=$rows['HOUSE_NUM'];
                        $fieldname6=$rows['HOUSE_STREET'];
                        $fieldname7=$rows['HOUSE_BRGY'];
                        $fieldname8=$rows['HOUSE_CITY'];
                    echo '<tr>
                     <td>'.$fieldname1.'</td>
                     <td>'.$fieldname2.'</td>
                     <td>'.$fieldname3.'</td>
                     <td>'.$fieldname4.'</td>
                     <td>'.$fieldname5.'</td>
                     <td>'.$fieldname6.'</td>
                     <td>'.$fieldname7.'</td>
                     <td>'.$fieldname8.'</td>
                   </tr>';
                    }
                    ?>
                
                 
            
        </table>

        <h5 align="center">Total Records:   <?php echo $totalcount['totalcount'];?></h5>
                          



            
</body>
</html>

          
            

         