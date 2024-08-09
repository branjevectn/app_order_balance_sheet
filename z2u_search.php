<?php
include 'db.php';
$page = 1;
/*

".$both.$lessthen.$greaterthen."

both
&& `date` BETWEEN '$start_date' AND '$end_date'



*Greater than:*

SELECT COUNT(*) FROM main WHERE `type` = '0' && `date` > '2024-02-05'


*Less than:*

SELECT COUNT(*) FROM main WHERE `type` = '0' && `date` < '2024-02-05'

*/

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

$sql3 = "SELECT * FROM main WHERE `type` = 'z2u'  ".$both.$lessthen.$greaterthen." && (`date` LIKE '%$search_term%' OR `order_service` LIKE '%$search_term%' OR `username` LIKE '%$search_term%' OR `order_net` LIKE '%$search_term%') ORDER BY `id` DESC";
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
       <div>
            <?php 
                $result = $conn->query("SELECT * FROM main WHERE `type` = 'z2u' ".$both.$lessthen.$greaterthen." && (`date` LIKE '%$search_term%' OR `order_service` LIKE '%$search_term%' OR `username` LIKE '%$search_term%' OR `order_net` LIKE '%$search_term%') ");

    $total_orders = mysqli_num_rows($result);
 
    if ($total_orders == 0) {
        echo '<h3 class="text_color_primary">0</h3>';
    }
    else {
        echo '<h3 class="text_color_success">'.$total_orders.'</h3>';
}

?>
            <p>Total Orders</p>
</div>        
<div>
            <?php 
                $result = $conn->query("SELECT SUM(order_net) AS total FROM main WHERE `give` = 0 && `type` = 'z2u' ".$both.$lessthen.$greaterthen." && (`date` LIKE '%$search_term%' OR `order_service` LIKE '%$search_term%' OR `username` LIKE '%$search_term%' OR `order_net` LIKE '%$search_term%') ");

while($row = $result->fetch_assoc()) {
    $total_net = $row['total'];
        if ($total_net == '') {
        $total_net = 0;
    }
    if ($total_net < 0) {
        echo '<h3 class="text_color_primary">'.$total_net.'$</h3>';
    }
    else {
        echo '<h3 class="text_color_success">'.$total_net.'$</h3>';
    }
}?>
            <p>Total Net</p>
        </div>

        <div>
            <?php 
                $result = $conn->query("SELECT SUM(order_useable) AS total FROM main WHERE `give` = 0 && `type` = 'z2u' ".$both.$lessthen.$greaterthen." && (`date` LIKE '%$search_term%' OR `order_service` LIKE '%$search_term%' OR `username` LIKE '%$search_term%' OR `order_net` LIKE '%$search_term%') ");

while($row = $result->fetch_assoc()) {
    $total = $row['total'];
        if ($total == '') {
        $total = 0;
    }
    if ($total < 0) {
        echo '<h3 class="text_color_primary">'.$total.'$</h3>';
    }
    else {
        echo '<h3 class="text_color_success">'.$total.'$</h3>';
    }
}?>
            <p>Total Useable</p>
        </div>
         <div>
            <?php 
    $result = $conn->query("SELECT SUM(order_useable + order_not_useable) AS total FROM main WHERE `give` = 0 && `type` = 'z2u' ".$both.$lessthen.$greaterthen." && (`date` LIKE '%$search_term%' OR `order_service` LIKE '%$search_term%' OR `username` LIKE '%$search_term%' OR `order_net` LIKE '%$search_term%') ");

while($row = $result->fetch_assoc()) {
    $total = $row['total'];
        if ($total == '') {
        $total = 0;
    }
    if ($total < 0) {
        echo '<h3 class="text_color_primary">'.$total.'$</h3>';
    }
    else {
        echo '<h3 class="text_color_success">'.$total.'$</h3>';
    }
}?>
            <p>Total Useable + Not</p>
        </div>
       
         <div>
<?php

  echo '<h3 class="text_color_success">'.round($total_net/$total_orders,2).'$</h3>';
?>
            <p>Total Avg</p>
        </div>
        
  <?php
  $sql = "SELECT * FROM main WHERE `type` = 'z2u' ".$both.$lessthen.$greaterthen." && (`date` LIKE '%$search_term%' OR `order_service` LIKE '%$search_term%' OR `username` LIKE '%$search_term%' OR `order_net` LIKE '%$search_term%') GROUP BY `order_net` ORDER BY `order_net` ASC";
$result = $conn->query($sql);
$num = mysqli_num_rows($result);
if ($num > 0) {
$i = 1;
	while($row = $result->fetch_assoc()) {
	    $net = $row['order_net'];
	      $sql2 = "SELECT * FROM main WHERE `type` = 'z2u' && `order_net`='$net' ".$both.$lessthen.$greaterthen." && (`date` LIKE '%$search_term%' OR `order_service` LIKE '%$search_term%' OR `username` LIKE '%$search_term%' OR `order_net` LIKE '%$search_term%') ";
$result2 = $conn->query($sql2);
$num = mysqli_num_rows($result2);
?>
         <div>

<h3 class="text_color_success"><?php echo $num;?></h3>

            <p><?php echo $net;?>$</p>
        </div>
<?php
	}
}
  ?>         
        </div>

 

<?php
$sql = "SELECT * FROM main WHERE `type` = 'z2u'  ".$both.$lessthen.$greaterthen." && (`date` LIKE '%$search_term%' OR `order_service` LIKE '%$search_term%' OR `username` LIKE '%$search_term%' OR `order_net` LIKE '%$search_term%') ORDER BY `id` DESC";
$result = $conn->query($sql);

$rowcount=mysqli_num_rows($result);
echo '<div class="allrows">Total '.$rowcount.'</div>';


$sql = "SELECT * FROM main WHERE `type` = 'z2u'  ".$both.$lessthen.$greaterthen." && (`date` LIKE '%$search_term%' OR `order_service` LIKE '%$search_term%' OR `username` LIKE '%$search_term%' OR `order_net` LIKE '%$search_term%') ORDER BY `id` DESC LIMIT $offset, $limit";

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
            <h3><a href="#" data-link="<?php echo $row['order_service'];?>" class="data-link <?php  if ($row['give'] == 2) {
            echo 'text_color_success';
        }?>"><?php echo $row['order_service'];?></a></h3>
            <p>Name</p>
        </div>
        <div>
            <h3><a href="#" data-link="<?php echo $row['username'];?>" class="data-link"><?php echo $row['username'];?></a></h3>
            <p>Username</p>
        </div>
        <div>
            <h3><a href="#" data-link="<?php echo $row['order_net'];?>" class="data-link text_color_success"><?php echo $row['order_net'];?>$</a></h3>
            <p>Net
            </p>
        </div>
        <div>
            <?php
            $order_useable = $row['order_useable'];
            $order_not_useable = $row['order_not_useable'];
            ?>
            <h3><a class="text_color_success"><?php echo $order_useable;?>$</a></h3>
            <p>Useable
            </p>
        </div>

        <div>
            <h3><a class="text_color_success"><?php echo $order_useable + $order_not_useable;?>$</a></h3>
            <p>Useable + Not
            </p>
        </div>        
            </div>

   <?php

  }
} else {
  echo '<div class="allrows">0 results</div>';
}





?>
