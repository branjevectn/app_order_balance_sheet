<?php
include 'db.php';
$page = 1;


  if($_POST['start_date'] != "" && $_POST['end_date'] != ""){
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
     $both = "&& `date` BETWEEN '$start_date' AND '$end_date'";
  }
else{  
  if($_POST['start_date'] != ""){
    $start_date = $_POST['start_date'];
       $greaterthen = " 
       && `date` >= '$start_date'"; 
  } 
  if($_POST['end_date'] != ""){
    $end_date = $_POST['end_date'];;
    $lessthen = "&& `date` <= '$end_date'";  
}
}

if(isset($_POST['search_term'])){
$search_term = $_POST['search_term'];
}

$sql3 = "SELECT * FROM main WHERE `give` = 0 ".$both.$lessthen.$greaterthen." && (`date` LIKE '%$search_term%' OR `value` LIKE '%$search_term%') ORDER BY `id` DESC";
$result3 = $conn->query($sql3);

 $total_pages2 = mysqli_num_rows($result3);
 $total_pages = ceil($total_pages2 / $limit);
setcookie('total_pagez', $total_pages, time() + (86400 * 30), "/");


if(isset($_POST['page'])){
	$page = $_POST['page'];
}


 

$offset = ($page - 1) * $limit;
?>

       <div class="table_box">
        <div>            <?php 
                $result = $conn->query("SELECT SUM(value) AS total FROM main WHERE `give` = 0 ".$both.$lessthen.$greaterthen." && (`date` LIKE '%$search_term%' OR `value` LIKE '%$search_term%') ");

while($row = $result->fetch_assoc()) {
    $total = $row['total'];
        if ($total == '') {
        $total = 0;
    }
    if ($total < 0) {
        echo '<h3 class="text_color_primary">'.$total.'</h3>';
    }
    else {
        echo '<h3 class="text_color_success">'.$total.'</h3>';
    }
}?>

            <p>Total Score</p>
        </div>
        <div>
            <?php 
                $result = $conn->query("SELECT SUM(value) AS total FROM main WHERE lost=1 ".$both.$lessthen.$greaterthen." && (`date` LIKE '%$search_term%' OR `value` LIKE '%$search_term%') ");

while($row = $result->fetch_assoc()) {
    $total = $row['total'];
        if ($total == '') {
        $total = 0;
    }
    if ($total < 0) {
        echo '<h3 class="text_color_primary">'.$total.'</h3>';
    }
    else {
        echo '<h3 class="text_color_success">'.$total.'</h3>';
    }
}?>
            <p>Total Lost</p>
        </div>
        <div>
            <?php 
                $result = $conn->query("SELECT SUM(my_m) AS total FROM main WHERE `give` = 0 ".$both.$lessthen.$greaterthen." && (`date` LIKE '%$search_term%' OR `value` LIKE '%$search_term%') ");

while($row = $result->fetch_assoc()) {
    $total = $row['total'];
        if ($total == '') {
        $total = 0;
    }
    if ($total < 0) {
        echo '<h3 class="text_color_primary">'.$total.'</h3>';
    }
    else {
        echo '<h3 class="text_color_success">'.$total.'</h3>';
    }
}?>
            <p>Total M</p>
        </div>
         <div>
            <?php 
                $result = $conn->query("SELECT SUM(ABS(my_p)) AS total FROM main WHERE  `give` = 0 ".$both.$lessthen.$greaterthen." && (`date` LIKE '%$search_term%' OR `value` LIKE '%$search_term%') ");

while($row = $result->fetch_assoc()) {
    $total = $row['total'];
        if ($total == '') {
        $total = 0;
    }
    if ($total < 0) {
        echo '<h3 class="text_color_primary">'.$total.'</h3>';
    }
    else {
        echo '<h3 class="text_color_success">'.$total.'</h3>';
    }
}?>
            <p>Total P</p>
        </div>       

        </div>

 

<?php
$sql = "SELECT * FROM main WHERE `give` = 0 ".$both.$lessthen.$greaterthen." && (`date` LIKE '%$search_term%' OR `value` LIKE '%$search_term%') ORDER BY `id` DESC";
$result = $conn->query($sql);

$rowcount=mysqli_num_rows($result);
echo '<div class="allrows">Total '.$rowcount.'</div>';


$sql = "SELECT * FROM main WHERE `give` = '0'  ".$both.$lessthen.$greaterthen." && (`date` LIKE '%$search_term%' OR `value` LIKE '%$search_term%') ORDER BY `id` DESC LIMIT $offset, $limit";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
  ?>
       <div class="table_box">
        <div>
            <h3><a href="#" data-link="<?php echo $row['date'];?>" class="data-link"><?php echo $row['date'];?></a></h3>
            <p>Date</p>
        </div>
        <div>
            <h3><a href="#" data-link="<?php echo $row['value'];?>" class="data-link <?php     if ( $row['value'] < 0) {
        if ($row['give'] == 2) {
            echo 'text_color_success';
        }
        else {
        echo 'text_color_primary';            
        }

    }
    else {
        echo 'text_color_success';
    }?>"><?php echo $row['value'];?></a></h3>
            <p>Value
            <?php
            if ($row['lost'] == 1) {
                echo '<small class="text_color_primary">Lost</small>';
            }
            
            ?>
            </p>
        </div>
            </div>
   <?php

  }
} else {
  echo '<div class="allrows">0 results</div>';
}





?>
