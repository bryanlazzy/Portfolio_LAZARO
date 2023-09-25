<?php
  require 'database.php';
  
  //---------------------------------------- Condition to check that POST value is not empty.
  if (!empty($_POST)) {
    //........................................ keep track post values
    $id = $_POST['id'];
    $mintemp = $_POST['ESP32_01_Min_Temp_Update'];
    $maxtemp = $_POST['ESP32_01_Max_Temp_Update'];
    $sethum = $_POST['ESP32_01_Hum_Update'];
    //........................................ 
    
    //........................................ 
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // replace_with_your_table_name, on this project I use the table name 'esp32_table_dht11_leds_update'.
    // This table is used to store DHT11 sensor data updated by ESP32. 
    // This table is also used to store the state of the LEDs, the state of the LEDs is controlled from the "home.php" page. 
    // To store data, this table is operated with the "UPDATE" command, so this table contains only one row.
    $sql = "UPDATE esp32_table_temp_hum_update SET MIN_TEMP = ?, MAX_TEMP = ?, SET_HUMIDITY = ? WHERE id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($mintemp,$maxtemp,$sethum,$id));
    Database::disconnect();
    //........................................ 
  }
  //---------------------------------------- 
?>