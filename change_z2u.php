<?php 
include 'db.php';

$checkbox_status = $_POST['checkbox'];
// false true


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

 
?>
<canvas id="myChart" style="width:100%;max-width:100%;" class="mb_15"></canvas>
<script>

<?php 
if ($checkbox_status == "false") {

?>
var xValues = [
<?php
$sql = "SELECT * FROM main WHERE `type` = 'z2u' ".$both.$lessthen.$greaterthen." GROUP BY `date` ORDER BY `id` ASC";
$result = $conn->query($sql);
$num = mysqli_num_rows($result);
if ($num > 0) {
$i = 1;
	while($row = $result->fetch_assoc()) { 
$date = $row['date'];
$result2 = $conn->query("SELECT SUM(ABS(value)) AS total FROM main WHERE `type` = 'z2u' && `date`='$date' ORDER BY `id` ASC");

$row2 = $result2->fetch_assoc();
$total = $row2['total'];
if ($total == "") {
    $total = 0;
}
$result2 = $conn->query("SELECT SUM(ABS(value)) AS give FROM main WHERE `type` = 'z2u' && `date`='$date' ORDER BY `id` ASC");

$row2 = $result2->fetch_assoc();
$give = $row2['give']; 
if ($give == "") {
    $give = 0;
}
	    if ($i == $num) {
	        echo '"'.$row['d'].'/'.$row['m'].'/'.$row['y'].'"';
	    }
	    else {
	        echo '"'.$row['d'].'/'.$row['m'].'/'.$row['y'].'",';
	    }
	    $i++;
	}
}
?>
];
var total = [
<?php
$sql = "SELECT * FROM main WHERE `type` = 'z2u' ".$both.$lessthen.$greaterthen." GROUP BY `date` ORDER BY `id` ASC";
$result = $conn->query($sql);
$num = mysqli_num_rows($result);
if ($num > 0) {
$i = 1;
	while($row = $result->fetch_assoc()) { 
$date = $row['date'];
$result2 = $conn->query("SELECT SUM(ABS(order_net)) AS total FROM main WHERE `type` = 'z2u' && `date`='$date' ORDER BY `id` ASC");

$row2 = $result2->fetch_assoc();
$total = $row2['total'];
if ($total == "") {
    $total = 0;
}

	    if ($i == $num) {
	        echo '"'.$total.'"';
	    }
	    else {
	        echo '"'.$total.'",';
	    }
	    $i++;
	}
}
?>
];
var give = [
<?php
$sql = "SELECT * FROM main WHERE `type` = 'z2u' ".$both.$lessthen.$greaterthen." GROUP BY `date` ORDER BY `id` ASC";
$result = $conn->query($sql);
$num = mysqli_num_rows($result);
if ($num > 0) {
$i = 1;
	while($row = $result->fetch_assoc()) { 
$date = $row['date'];

$result2 = $conn->query("SELECT * FROM main WHERE `type` = 'z2u' && `date`='$date' ORDER BY `id` ASC");


$give = mysqli_num_rows($result2);
	    if ($i == $num) {
	        echo '"'.$give.'"';
	    }
	    else {
	        echo '"'.$give.'",';
	    }
	    $i++;
	}
}
?>
];

var total2 = [
<?php
$sql = "SELECT * FROM main WHERE `type` = 'z2u' ".$both.$lessthen.$greaterthen." GROUP BY `date` ORDER BY `id` ASC";
$result = $conn->query($sql);
$num = mysqli_num_rows($result);
if ($num > 0) {
$i = 1;
	while($row = $result->fetch_assoc()) { 
$date = $row['date'];
$result2 = $conn->query("SELECT SUM(order_useable + order_not_useable) AS total FROM main WHERE `type` = 'z2u' ".$both.$lessthen.$greaterthen." ORDER BY `id` ASC");

$row2 = $result2->fetch_assoc();
$total = $row2['total'];
if ($total == "") {
    $total = 0;
}

	    if ($i == $num) {
	        echo '"'.$total.'"';
	    }
	    else {
	        echo '"'.$total.'",';
	    }
	    $i++;
	}
}
?>
];

var totalavg = [
<?php
$sql = "SELECT * FROM main WHERE `type` = 'z2u' ".$both.$lessthen.$greaterthen." GROUP BY `date` ORDER BY `id` ASC";
$result = $conn->query($sql);
$num = mysqli_num_rows($result);
if ($num > 0) {
$i = 1;
	while($row = $result->fetch_assoc()) { 
$date = $row['date'];
$result2 = $conn->query("SELECT SUM(ABS(order_net)) AS total FROM main WHERE `type` = 'z2u' && `date`='$date' ORDER BY `id` ASC");

$row2 = $result2->fetch_assoc();
$total = $row2['total'];
if ($total == "") {
    $total = 0;
}
$result2 = $conn->query("SELECT * FROM main WHERE `type` = 'z2u' && `date`='$date'  ORDER BY `id` ASC");


$give = mysqli_num_rows($result2);

	    if ($i == $num) {
	        echo '"'.$total/$give.'"';
	    }
	    else {
	        echo '"'.$total/$give.'",';
	    }
	    $i++;
	}
}
?>
];
new Chart("myChart", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      label: 'Net',
      backgroundColor: "#1BDBFF",
      data: total
    },
      {
      label: 'Orders',
      backgroundColor: "#FA2545",
      data: give
    },
    {
      label: 'Total Useable + Not',
      backgroundColor: "#00FF7F",
      data: total2
    },
    {
      label: 'Avg',
      backgroundColor: "#FF6347",
      data: totalavg
    }    
    ]
  },
});

<?php
}
else {
?>
var xValues = [
<?php
$sql = "SELECT * FROM main WHERE `type` = 'z2u' GROUP BY `m` ORDER BY `id` ASC";
$result = $conn->query($sql);
$num = mysqli_num_rows($result);
if ($num > 0) {
$i = 1;
	while($row = $result->fetch_assoc()) { 
$m = $row['m'];
$result2 = $conn->query("SELECT SUM(ABS(value)) AS total FROM main WHERE `type` = 'z2u' && `m`='$m' ORDER BY `id` ASC");

$row2 = $result2->fetch_assoc();
$total = $row2['total'];
if ($total == "") {
    $total = 0;
}
$result2 = $conn->query("SELECT SUM(ABS(value)) AS give FROM main WHERE `type` = 'z2u' && `m`='$m' ORDER BY `id` ASC");

$row2 = $result2->fetch_assoc();
$give = $row2['give']; 
if ($give == "") {
    $give = 0;
}
	    if ($i == $num) {
	        echo '"'.$row['m'].'/'.$row['y'].'"';
	    }
	    else {
	        echo '"'.$row['m'].'/'.$row['y'].'",';
	    }
	    $i++;
	}
}
?>
];
var total = [
<?php
$sql = "SELECT * FROM main WHERE `type` = 'z2u' GROUP BY `m` ORDER BY `id` ASC";
$result = $conn->query($sql);
$num = mysqli_num_rows($result);
if ($num > 0) {
$i = 1;
	while($row = $result->fetch_assoc()) { 
$m = $row['m'];
$result2 = $conn->query("SELECT SUM(ABS(order_net)) AS total FROM main WHERE `type` = 'z2u' && `m`='$m' ORDER BY `id` ASC");

$row2 = $result2->fetch_assoc();
$total = $row2['total'];
if ($total == "") {
    $total = 0;
}

	    if ($i == $num) {
	        echo '"'.$total.'"';
	    }
	    else {
	        echo '"'.$total.'",';
	    }
	    $i++;
	}
}
?>
];
var give = [
<?php
$sql = "SELECT * FROM main WHERE `type` = 'z2u' GROUP BY `m` ORDER BY `id` ASC";
$result = $conn->query($sql);
$num = mysqli_num_rows($result);
if ($num > 0) {
$i = 1;
	while($row = $result->fetch_assoc()) { 
$m = $row['m'];

$result2 = $conn->query("SELECT * FROM main WHERE `type` = 'z2u' && `m`='$m' ORDER BY `id` ASC");


$give = mysqli_num_rows($result2);
	    if ($i == $num) {
	        echo '"'.$give.'"';
	    }
	    else {
	        echo '"'.$give.'",';
	    }
	    $i++;
	}
}
?>
];

var total2 = [
<?php
$sql = "SELECT * FROM main WHERE `type` = 'z2u' GROUP BY `m` ORDER BY `id` ASC";
$result = $conn->query($sql);
$num = mysqli_num_rows($result);
if ($num > 0) {
$i = 1;
	while($row = $result->fetch_assoc()) { 
$m = $row['m'];
$result2 = $conn->query("SELECT SUM(order_useable + order_not_useable) AS total FROM main WHERE `type` = 'z2u' && `m`='$m' ORDER BY `id` ASC");

$row2 = $result2->fetch_assoc();
$total = $row2['total'];
if ($total == "") {
    $total = 0;
}

	    if ($i == $num) {
	        echo '"'.$total.'"';
	    }
	    else {
	        echo '"'.$total.'",';
	    }
	    $i++;
	}
}
?>
];

var totalavg = [
<?php
$sql = "SELECT * FROM main WHERE `type` = 'z2u' GROUP BY `m` ORDER BY `id` ASC";
$result = $conn->query($sql);
$num = mysqli_num_rows($result);
if ($num > 0) {
$i = 1;
	while($row = $result->fetch_assoc()) { 
$m = $row['m'];
$result2 = $conn->query("SELECT SUM(ABS(order_net)) AS total FROM main WHERE `type` = 'z2u' && `m`='$m' ORDER BY `id` ASC");

$row2 = $result2->fetch_assoc();
$total = $row2['total'];
if ($total == "") {
    $total = 0;
}
$result2 = $conn->query("SELECT * FROM main WHERE `type` = 'z2u' && `m`='$m' ORDER BY `id` ASC");


$give = mysqli_num_rows($result2);

	    if ($i == $num) {
	        echo '"'.$total/$give.'"';
	    }
	    else {
	        echo '"'.$total/$give.'",';
	    }
	    $i++;
	}
}
?>
];
new Chart("myChart", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      label: 'Net',
      backgroundColor: "#1BDBFF",
      data: total
    },
      {
      label: 'Orders',
      backgroundColor: "#FA2545",
      data: give
    },
    {
      label: 'Total Useable + Not',
      backgroundColor: "#00FF7F",
      data: total2
    },
    {
      label: 'Avg',
      backgroundColor: "#FF6347",
      data: totalavg
    }    
    ]
  },
});

<?php
}
?>
</script>    
