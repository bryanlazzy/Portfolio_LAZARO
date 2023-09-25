<!DOCTYPE HTML>
<html>
  <head>
    <title>ESP32 WITH MYSQL DATABASE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
      html {font-family: Arial; display: inline-block; text-align: center;}
      p {font-size: 1.2rem;}
      h4 {font-size: 0.8rem;}
      body {margin: 0;}
      /* ----------------------------------- TOPNAV STYLE */
      .topnav {overflow: hidden; background-color: #5F7161; color: white; font-size: 1.2rem;}
      /* ----------------------------------- */
      
      /* ----------------------------------- TABLE STYLE */
      .styled-table {
        border-collapse: collapse;
        margin-left: auto; 
        margin-right: auto;
        font-size: 0.9em;
        font-family: sans-serif;
        min-width: 400px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        border-radius: 0.5em;
        overflow: hidden;
        width: 90%;
      }

      .styled-table thead tr {
        background-color: #5F7161;
        color: #ffffff;
        text-align: left;
      }

      .styled-table th {
        padding: 12px 15px;
        text-align: left;
      }

      .styled-table td {
        padding: 12px 15px;
        text-align: left;
      }

      .styled-table tbody tr:nth-of-type(even) {
        background-color: #f3f3f3;
      }

      .styled-table tbody tr.active-row {
        font-weight: bold;
        color: #009879;
      }

      .bdr {
        border-right: 1px solid #e3e3e3;
        border-left: 1px solid #e3e3e3;
      }
      
      td:hover {background-color: rgba(12, 105, 128, 0.21);}
      tr:hover {background-color: rgba(12, 105, 128, 0.15);}
      .styled-table tbody tr:nth-of-type(even):hover {background-color: rgba(12, 105, 128, 0.15);}
      /* ----------------------------------- */
      
      /* ----------------------------------- BUTTON STYLE */
      .btn-group .button {
        background-color: #5F7161; /* Green */
        border: 1px solid #e3e3e3;
        color: white;
        padding: 5px 8px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        cursor: pointer;
        float: center;
      }

      .btn-group .button:not(:last-child) {
        border-right: none; /* Prevent double borders */
      }

      .btn-group .button:hover {
        background-color: #094c5d;
      }

      .btn-group .button:active {
        background-color: #0c6980;
        transform: translateY(1px);
      }

      .btn-group .button:disabled,
      .button.disabled{
        color:#fff;
        background-color: #a0a0a0; 
        cursor: not-allowed;
        pointer-events:none;
      }
      /* ----------------------------------- */
    </style>
  </head>
  
  <body>
    <div class="topnav">
      <h3>ESP32 WITH MYSQL DATABASE</h3>
    </div>
    
    <br>
    
    <h3 style="color: #5F7161;">ESP32_01 TEMP AND HUMID SET TABLE</h3>
    
    <table class="styled-table" id= "table_id">
      <thead>
        <tr>
          <th>NO</th>
          <th>ID</th>
          <th>MIN_TEMP(°C)</th>
          <th>MAX_TEMP(°C)</th>
          <th>SET_HUMIDITY(%)</th>
        </tr>
      </thead>
      <tbody id="tbody_table_record">
        <?php
        ob_start();
          include 'database.php';

          if (!empty($_POST)) {

            //........................................ keep track POST values
          $id = $_POST['id'];

          $id_key;
          $found_empty = false;
          
          $pdo = Database::connect();
          
          //:::::::: Process to check if "id" is already in use.
          while ($found_empty == false) {
            $id_key = generate_string_id(10);
            // replace_with_your_table_name, on this project I use the table name 'esp32_table_dht11_leds_record'.
            // This table is used to store and record DHT11 sensor data updated by ESP32. 
            // This table is also used to store and record the state of the LEDs, the state of the LEDs is controlled from the "home.php" page. 
            // This table is operated with the "INSERT" command, so this table will contain many rows.
            // Before saving and recording data in this table, the "id" will be checked first, to ensure that the "id" that has been created has not been used in the table.
            $sql = 'SELECT * FROM esp32_table_temp_humd_set WHERE id="' . $id_key . '"';
            $q = $pdo->prepare($sql);
            $q->execute();
            
            if (!$data = $q->fetch()) {
              $found_empty = true;
            }
          }

          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          // replace_with_your_table_name, on this project I use the table name 'esp32_table_dht11_leds_record'.
          // This table is used to store and record DHT11 sensor data updated by ESP32. 
          // This table is also used to store and record the state of the LEDs, the state of the LEDs is controlled from the "home.php" page. 
          // This table is operated with the "INSERT" command, so this table will contain many rows.
		  $sql = "INSERT INTO esp32_table_temp_humd_set (id,time,date) values(?, ?, ?)";
		  $q = $pdo->prepare($sql);
		  $q->execute(array($id_key,$board,$tm,$dt));

          $pdo = Database::disconnect();
        }

          session_start();

          $mintemp = $_SESSION['mintemp'];
          $maxtemp = $_SESSION['maxtemp'];
          $sethum = $_SESSION['sethum'];

          $hostname = "localhost";
          $username = "root";
          $password = "";
          $database = "esp32_mc_db";

          $conn = mysqli_connect($hostname, $username, $password, $database);

          if (!$conn){
            die("Connection failed: " . mysqli_connect_error());
          }

          $sql = "INSERT INTO esp32_table_temp_humd_set (MIN_TEMP,MAX_TEMP,SET_HUMIDIFIER) values($mintemp, $maxtemp, $sethum)";

          if (mysqli_query($conn, $sql)){
            echo '';
        }
        
    //:::::::   
          $num = 0;
          //------------------------------------------------------------ The process for displaying a record table containing the DHT11 sensor data and the state of the LEDs.
          $pdo = Database::connect();
          // replace_with_your_table_name, on this project I use the table name 'esp32_table_dht11_leds_record'.
          // This table is used to store and record DHT11 sensor data updated by ESP32. 
          // This table is also used to store and record the state of the LEDs, the state of the LEDs is controlled from the "home.php" page. 
          // To store data, this table is operated with the "INSERT" command, so this table will contain many rows.
          $sql = 'SELECT * FROM esp32_table_temp_humd_set';
          foreach ($pdo->query($sql) as $row) {
            $num++;
            echo '<tr>';
            echo '<td>'. $num . '</td>';
            echo '<td class="bdr">'. $row['id'] . '</td>';
            echo '<td class="bdr">'. $row['MIN_TEMP'] . '</td>';
            echo '<td class="bdr">'. $row['MAX_TEMP'] . '</td>';
            echo '<td class="bdr">'. $row['SET_HUMIDIFIER'] . '</td>';
            echo '</tr>';
          }
          Database::disconnect();

          function generate_string_id($strength = 16) {
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $input_length = strlen($permitted_chars);
            $random_string = '';
            for($i = 0; $i < $strength; $i++) {
              $random_character = $permitted_chars[mt_rand(0, $input_length - 1)];
              $random_string .= $random_character;
            }
            return $random_string;
          }
          //------------------------------------------------------------
        ?>
      </tbody>
    </table>
    
    <br>
    
    <div class="btn-group">
      <button class="button" id="btn_prev" onclick="prevPage()">Prev</button>
      <button class="button" id="btn_next" onclick="nextPage()">Next</button>
      <div style="display: inline-block; position:relative; border: 0px solid #e3e3e3; float: center; margin-left: 2px;;">
        <p style="position:relative; font-size: 14px;"> Table : <span id="page"></span></p>
      </div>
      <select name="number_of_rows" id="number_of_rows">
        <option value="10">10</option>
        <option value="25">25</option>
        <option value="50">50</option>
        <option value="100">100</option>
      </select>
      <button class="button" id="btn_apply" onclick="apply_Number_of_Rows()">Apply</button>
    </div>

    <br>
    
    <script>
      //------------------------------------------------------------
      var current_page = 1;
      var records_per_page = 10;
      var l = document.getElementById("table_id").rows.length
      //------------------------------------------------------------
      
      //------------------------------------------------------------
      function apply_Number_of_Rows() {
        var x = document.getElementById("number_of_rows").value;
        records_per_page = x;
        changePage(current_page);
      }
      //------------------------------------------------------------
      
      //------------------------------------------------------------
      function prevPage() {
        if (current_page > 1) {
            current_page--;
            changePage(current_page);
        }
      }
      //------------------------------------------------------------
      
      //------------------------------------------------------------
      function nextPage() {
        if (current_page < numPages()) {
            current_page++;
            changePage(current_page);
        }
      }
      //------------------------------------------------------------
      
      //------------------------------------------------------------
      function changePage(page) {
        var btn_next = document.getElementById("btn_next");
        var btn_prev = document.getElementById("btn_prev");
        var listing_table = document.getElementById("table_id");
        var page_span = document.getElementById("page");
       
        // Validate page
        if (page < 1) page = 1;
        if (page > numPages()) page = numPages();

        [...listing_table.getElementsByTagName('tr')].forEach((tr)=>{
            tr.style.display='none'; // reset all to not display
        });
        listing_table.rows[0].style.display = ""; // display the title row

        for (var i = (page-1) * records_per_page + 1; i < (page * records_per_page) + 1; i++) {
          if (listing_table.rows[i]) {
            listing_table.rows[i].style.display = ""
          } else {
            continue;
          }
        }
          
        page_span.innerHTML = page + "/" + numPages() + " (Total Number of Rows = " + (l-1) + ") | Number of Rows : ";
        
        if (page == 0 && numPages() == 0) {
          btn_prev.disabled = true;
          btn_next.disabled = true;
          return;
        }

        if (page == 1) {
          btn_prev.disabled = true;
        } else {
          btn_prev.disabled = false;
        }

        if (page == numPages()) {
          btn_next.disabled = true;
        } else {
          btn_next.disabled = false;
        }
      }
      //------------------------------------------------------------
      
      //------------------------------------------------------------
      function numPages() {
        return Math.ceil((l - 1) / records_per_page);
      }
      //------------------------------------------------------------
      
      //------------------------------------------------------------
      window.onload = function() {
        var x = document.getElementById("number_of_rows").value;
        records_per_page = x;
        changePage(current_page);
      };
      //------------------------------------------------------------
    </script>
  </body>
</html>