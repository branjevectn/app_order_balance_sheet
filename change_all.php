<?php 
include 'db.php';
xxdswweeerrrttuytyy6
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
$sql = "SELECT * FROM main WHERE `type` = '0' && `give` = 0 ".$both.$lessthen.$greaterthen." GROUP BY `date` ORDER BY `id` ASC";
$result = $conn->query($sql);
$num = mysqli_num_rows($result);
if ($num > 0) {
$i = 1;
	while($row = $result->fetch_assoc()) { 
$date = $row['date'];
$result2 = $conn->query("SELECT SUM(ABS(value)) AS total FROM main WHERE `give` = 0 ".$both.$lessthen.$greaterthen." ORDER BY `id` ASC");

$row2 = $result2->fetch_assoc();
$total = $row2['total'];
if ($total == "") {
    $total = 0;
}
$result2 = $conn->query("SELECT SUM(ABS(value)) AS give FROM main WHERE `give` = 1 ".$both.$lessthen.$greaterthen." ORDER BY `id` ASC");

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
$sql = "SELECT * FROM main WHERE `type` = '0' && `give` = 0 ".$both.$lessthen.$greaterthen." GROUP BY `date` ORDER BY `id` ASC";
$result = $conn->query($sql);
$num = mysqli_num_rows($result);
if ($num > 0) {
$i = 1;
	while($row = $result->fetch_assoc()) { 
$date = $row['date'];
$result2 = $conn->query("SELECT SUM(ABS(value)) AS total FROM main WHERE `give` = 0 && `date`='$date' ".$both.$lessthen.$greaterthen." ORDER BY `id` ASC");

$row2 = $result2->fetch_assoc();
$total = $row2['total'];
if ($total == "") {
    $total = 0;
}
$result2 = $conn->query("SELECT SUM(ABS(value)) AS give FROM main WHERE `give` = 1 && `date`='$date' ".$both.$lessthen.$greaterthen." ORDER BY `id` ASC");

$row2 = $result2->fetch_assoc();
$give = $row2['give']; 
if ($give == "") {
    $give = 0;
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
$sql = "SELECT * FROM main WHERE `type` = '0' && `give` = 0 ".$both.$lessthen.$greaterthen." GROUP BY `date` ORDER BY `id` ASC";
$result = $conn->query($sql);
$num = mysqli_num_rows($result);
if ($num > 0) {
$i = 1;
	while($row = $result->fetch_assoc()) { 
$date = $row['date'];
$result2 = $conn->query("SELECT SUM(ABS(value)) AS total FROM main WHERE `give` = 0 && `date`='$date' ".$both.$lessthen.$greaterthen." ORDER BY `id` ASC");

$row2 = $result2->fetch_assoc();
$total = $row2['total'];
if ($total == "") {
    $total = 0;
}
$result2 = $conn->query("SELECT SUM(ABS(value)) AS give FROM main WHERE `give` = 1 && `date`='$date' ".$both.$lessthen.$greaterthen." ORDER BY `id` ASC");

$row2 = $result2->fetch_assoc();
$give = $row2['give']; 
if ($give == "") {
    $give = 0;
}
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

new Chart("myChart", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      label: 'Receive',
      backgroundColor: "#1BDBFF",
      data: total
    },
      {
      label: 'Give',
      backgroundColor: "#FA2545",
      data: give
    }]
  },
});
<?php
}
else {
?>
var xValues = [
<?php
$sql = "SELECT * FROM main WHERE `type` = '0' && `give` = 0 GROUP BY `m` ORDER BY `id` ASC";
$result = $conn->query($sql);
$num = mysqli_num_rows($result);
if ($num > 0) {
$i = 1;
	while($row = $result->fetch_assoc()) { 
$m = $row['m'];
$result2 = $conn->query("SELECT SUM(ABS(value)) AS total FROM main WHERE `give` = 0 && `m`='$m' ORDER BY `id` ASC");

$row2 = $result2->fetch_assoc();
$total = $row2['total'];
if ($total == "") {
    $total = 0;
}
$result2 = $conn->query("SELECT SUM(ABS(value)) AS give FROM main WHERE `give` = 1 && `m`='$m' ORDER BY `id` ASC");

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
$sql = "SELECT * FROM main WHERE `type` = '0' && `give` = 0 GROUP BY `m` ORDER BY `id` ASC";
$result = $conn->query($sql);
$num = mysqli_num_rows($result);
if ($num > 0) {
$i = 1;
	while($row = $result->fetch_assoc()) { 
$m = $row['m'];
$result2 = $conn->query("SELECT SUM(ABS(value)) AS total FROM main WHERE `give` = 0 && `m`='$m' ORDER BY `id` ASC");

$row2 = $result2->fetch_assoc();
$total = $row2['total'];
if ($total == "") {
    $total = 0;
}
$result2 = $conn->query("SELECT SUM(ABS(value)) AS give FROM main WHERE `give` = 1 && `m`='$m' ORDER BY `id` ASC");

$row2 = $result2->fetch_assoc();
$give = $row2['give']; 
if ($give == "") {
    $give = 0;
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
$sql = "SELECT * FROM main WHERE `type` = '0' && `give` = 0 GROUP BY `m` ORDER BY `id` ASC";
$result = $conn->query($sql);
$num = mysqli_num_rows($result);
if ($num > 0) {
$i = 1;
	while($row = $result->fetch_assoc()) { 
$m = $row['m'];
$result2 = $conn->query("SELECT SUM(ABS(value)) AS total FROM main WHERE `give` = 0 && `m`='$m' ORDER BY `id` ASC");

$row2 = $result2->fetch_assoc();
$total = $row2['total'];
if ($total == "") {
    $total = 0;
}
$result2 = $conn->query("SELECT SUM(ABS(value)) AS give FROM main WHERE `give` = 1 && `m`='$m' ORDER BY `id` ASC");

$row2 = $result2->fetch_assoc();
$give = $row2['give']; 
if ($give == "") {
    $give = 0;
}
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

new Chart("myChart", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      label: 'Receive',
      backgroundColor: "#1BDBFF",
      data: total
    },
      {
      label: 'Give',
      backgroundColor: "#FA2545",
      data: give
    }]
  },
});


<?php
}
?>
</script>    
