<?php
$active = "import";
include 'header.php';

?>
<div class="side_index">
<?php

include 'db.php';

      
            // Check if table exists
            $tableExistsQuery = "SHOW TABLES LIKE 'main'";
            $result = $conn->query($tableExistsQuery);

            if ($result->num_rows == 0) {
                $createTableQuery = "CREATE TABLE main (id INT(255) UNSIGNED AUTO_INCREMENT PRIMARY KEY, name VARCHAR(255) NULL, username VARCHAR(255) NULL, username_value VARCHAR(255) DEFAULT(0), value DECIMAL(65,2) NULL, type VARCHAR(255) DEFAULT(0), order_id VARCHAR(255) NULL, order_net DECIMAL(65,2) NULL, order_useable DECIMAL(65,2) NULL, order_not_useable DECIMAL(65,2) NULL, order_service VARCHAR(255) NULL, give INT(11) DEFAULT(0), lost INT(11) DEFAULT(0), date VARCHAR(255) NULL, d VARCHAR(255) NULL, day_name VARCHAR(255) NULL, m VARCHAR(255) NULL, y VARCHAR(255) NULL)";

if (mysqli_query($conn, $createTableQuery)) {
                    echo "Table main created successfully.<br>";
                } else {
                    echo "Error creating table: " . $conn->error . "<br>";
                }             
           
            }
                
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get JSON data from form
    $jsonData = $_POST['json_data'];

$json = file_get_contents($jsonData); 

  
// Decode the JSON file 

$data = json_decode($json,true);




$mu = 0;

// Check if JSON decoding was successful
    if ($data === null) {
        die("Error decoding JSON data.");
    }
    
    // Loop through JSON data
    foreach ($data as $item) {
        if ($item['type'] == 'table') {
            $tableName = $item['name'];



            // Insert data into table
            foreach ($item['data'] as $rowData) {
                $insertKeys = implode(", ", array_keys($rowData));
                $insertParams = implode(", ", array_fill(0, count($rowData), "?"));
                $insertDataQuery = "INSERT INTO $tableName ($insertKeys) VALUES ($insertParams)";
                $stmt = $conn->prepare($insertDataQuery);

                // Bind parameters dynamically
                $types = "";
                $bindParams = array();
                foreach ($rowData as $value) {
                    if (is_numeric($value)) {
                        if (filter_var($value, FILTER_VALIDATE_FLOAT)) {
                        $types .= "d";
                        } else {
                        $types .= "i";
                        }
                    } else {
                        $types .= "s";
                    }
                    $bindParams[] = $value;
                }
                $stmt->bind_param($types, ...$bindParams);

                if ($stmt->execute() === TRUE) {
                 
                    $mu ++;
                } else {
                    echo "Error inserting data: " . $conn->error . "<br>";
                }
            }
        }
    }
echo "Data inserted $mu<br>";

    // Close connection
    $conn->close();
}

?>
   <div class="container">
    <h2 class="mb_15">Import</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <textarea id="json_data" name="json_data" rows="3" cols="50" class="mb_15"></textarea><br>
        <button type="submit" name="submit">Submit</button>
    </form>
    </div>
    </div>
</body>
</html>
