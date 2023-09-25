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
    $sql = " SELECT * FROM VACCINE ";
    $results=sqlsrv_query($conn,$sql);

    $sql2="SELECT COUNT(CITIZEN_ID)as totalcount FROM VACCINE";
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
        <title>Complete List</title>
        
    </head>
    
    <body>

        <h1>Complete Registered Users List</h1>
        
        <table border="1px" style="width:800px; line-height:50px;" align="center" class="tb">
            <thead>
                <tr>
                    <th>CitizenID</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>Landline Number</th>
                    <th>Cellphone Number</th>
                    <th>Email Address</th>
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
                        echo '<tr>
                         <td>'.$fieldname1.'</td>
                         <td>'.$fieldname2.'</td>
                         <td>'.$fieldname3.'</td>
                         <td>'.$fieldname4.'</td>
                         <td>'.$fieldname5.'</td>
                         <td>'.$fieldname6.'</td>
                         <td>'.$fieldname7.'</td>
                       </tr>';
                    }
                    ?>
                
                 
            
        </table>

        <h3 align="center">Total Records:   <?php echo $totalcount['totalcount'];?></h3>
                          



            
</body>
</html>