<?php

include 'db.php';



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">


  <link href="asset/style.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
</head>
<body>
<input type="checkbox" name="MenuToggle" id="MenuToggle">
<aside class="sidebar">
   <nav>
      <div class="nav_items">
         <a href="all_data.php" <?php if ($active == "all_data") {echo 'class="active"';} ?>>All Data</a>
         <a href="all_chart.php" <?php if ($active == "all_chart") {echo 'class="active"';} ?>>All Chart</a>
         <a href="z2u_data.php" <?php if ($active == "z2u_data") {echo 'class="active"';} ?>>Z2U Orders</a>
         <a href="z2u_chart.php" <?php if ($active == "z2u_chart") {echo 'class="active"';} ?>>Z2U Chart</a>
        
        
         <a href="import.php" <?php if ($active == "import") {echo 'class="active"';} ?>>Import</a>
         <a href="export.php" <?php if ($active == "export") {echo 'class="active"';} ?>>Export</a>
         <a href="add.php" <?php if ($active == "add") {echo 'class="active"';} ?>>Add</a>
      </div>
   </nav>
</aside>
<main class="right">
   <label for="MenuToggle" class="toggle__icon">
   <span class="line line1"></span>
   <span class="line line3"></span>
   <span class="line line2"></span>
   </label>
</main>