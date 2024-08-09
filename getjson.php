<?php 

  
// Read the JSON file  

$json = file_get_contents('http://192.168.100.243:8080/app/result_data.json'); 

  
// Decode the JSON file 

$json_data = json_decode($json,true); 

  
// Display data 

print_r($json_data); 

  
?>