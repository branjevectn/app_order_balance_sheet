<?php
$active = "export";
include 'header.php';

?>
<div class="side_index">
<div class="container"> 
<?php


$dbname = $conn->query("SELECT DATABASE()")->fetch_row()[0];


// Get list of tables
$tables = array();
 $result = $conn->query("SHOW TABLES");

    while ($row = $result->fetch_array()) {
    
 $tables[] =  $row[0];
    }


// Fetch data from each table$jsonData = array();
foreach ($tables as $table) {
    $tableData = array();
    $result = $conn->query("SELECT * FROM $table");
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tableData[] = $row;
        }
    }
    $tableJson = array(
        "type" => "table",
        "name" => $table,
        "data" => $tableData
    );
    $jsonData[] = $tableJson;
}



// Convert data to JSON format
$jsonData = json_encode($jsonData, JSON_PRETTY_PRINT);
file_put_contents("db_data.json", $jsonData);
?>
    <h2 class="mb_15">Export Total Data: <?php echo  mysqli_num_rows($result); ?></h2>
    
<a href="db_data.json" class="download" download>
  Download  </a>

      </div>
            </div>
</body>
</html>