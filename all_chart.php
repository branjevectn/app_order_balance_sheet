<?php
$active =  "all_chart";
include 'header.php';
fffg dsvvvcdccd
?>
<div class="side_index">
<div class="container nopadding">
<div class="balance_box">
                   <div>
            <?php 
                $result = $conn->query("SELECT SUM(value) AS total FROM main");

while($row = $result->fetch_assoc()) {
    $total = $row['total'];      
    if ($total == '') {
        $total = 0;
    }
    if ($total < 0) {
        echo '<h1 class="text_color_primary">'.$total.'$</h1>';
    }
    else {
        echo '<h1 class="text_color_success">'.$total.'$</h1>';
    }
}?>
            <p>Current Balance</p>
</div>
</div>


</div>
<div class="container">
  <h3 class="mb_15">All Data Excluded Z2U</h3>
  <div class="select_data">
      <div>
    <small for="start">Start Date</small>
    <input type="date" id="start">
      </div>
            <div>
  <small for="end">End Date</small>
    <input type="date" id="end">
          </div>
    </div>
    <label class="chart_months">
       Months
       <input type="checkbox" id="myCheckbox">
        <span class="checkmark"></span>
    </label>
  </div>
<div class="container nopadding"> 

<div id="search-results">

       <div class="table_box">
        <div>            <?php 
                $result = $conn->query("SELECT SUM(value) AS total FROM main WHERE `give` = 0");

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

            <p>Total Receive</p>
        </div>
        <div>
            <?php 
                $result = $conn->query("SELECT SUM(value) AS total FROM main WHERE `give` = 1");

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
            <p>Total Give + Lost</p>
        </div>
        <div>
            <?php 
                $result = $conn->query("SELECT SUM(value) AS total FROM main WHERE `lost` = 1");

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
            <p>Total Lost</p>
        </div>
         <div>
            <?php 
                $result = $conn->query("SELECT SUM(ABS(value)) AS total FROM main WHERE `give` = 2");

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
            <p>Total Withdrawal</p>
        </div>       

        </div>





</div>




</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<div id="change">
 <canvas id="myChart" style="width:100%;max-width:100%;" class="mb_15"></canvas>   
<script>


var xValues = [
<?php
$sql = "SELECT * FROM main WHERE `type` = '0' && `give` = 0 GROUP BY `date` ORDER BY `id` ASC";
$result = $conn->query($sql);
$num = mysqli_num_rows($result);
if ($num > 0) {
$i = 1;
	while($row = $result->fetch_assoc()) { 
$date = $row['date'];
$result2 = $conn->query("SELECT SUM(ABS(value)) AS total FROM main WHERE `give` = 0 && `date`='$date' ORDER BY `id` ASC");

$row2 = $result2->fetch_assoc();
$total = $row2['total'];
if ($total == "") {
    $total = 0;
}
$result2 = $conn->query("SELECT SUM(ABS(value)) AS give FROM main WHERE `give` = 1 && `date`='$date' ORDER BY `id` ASC");

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
$sql = "SELECT * FROM main WHERE `type` = '0' && `give` = 0 GROUP BY `date` ORDER BY `id` ASC";
$result = $conn->query($sql);
$num = mysqli_num_rows($result);
if ($num > 0) {
$i = 1;
	while($row = $result->fetch_assoc()) { 
$date = $row['date'];
$result2 = $conn->query("SELECT SUM(ABS(value)) AS total FROM main WHERE `give` = 0 && `date`='$date' ORDER BY `id` ASC");

$row2 = $result2->fetch_assoc();
$total = $row2['total'];
if ($total == "") {
    $total = 0;
}
$result2 = $conn->query("SELECT SUM(ABS(value)) AS give FROM main WHERE `give` = 1 && `date`='$date' ORDER BY `id` ASC");

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
$sql = "SELECT * FROM main WHERE `type` = '0' && `give` = 0 GROUP BY `date` ORDER BY `id` ASC";
$result = $conn->query($sql);
$num = mysqli_num_rows($result);
if ($num > 0) {
$i = 1;
	while($row = $result->fetch_assoc()) { 
$date = $row['date'];
$result2 = $conn->query("SELECT SUM(ABS(value)) AS total FROM main WHERE `give` = 0 && `date`='$date' ORDER BY `id` ASC");

$row2 = $result2->fetch_assoc();
$total = $row2['total'];
if ($total == "") {
    $total = 0;
}
$result2 = $conn->query("SELECT SUM(ABS(value)) AS give FROM main WHERE `give` = 1 && `date`='$date' ORDER BY `id` ASC");

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


</script>    
</div>
</div>
<script>




$(document).ready(function() {

   $("#start").on("change", function() {
         var isChecked = $("#myCheckbox").is(":checked");
    var startDate = $(this).val();
     var endDate = $("#end").val();
    $.ajax({
      type: "POST",
      url: "change_all.php",
      data: { checkbox: isChecked,
    end_date: endDate,
         start_date: startDate
      },
      success: function(data) {
        $("#change").html(data);
      }
    });
  });
  
$("#end").on("change", function() {
      var isChecked = $("#myCheckbox").is(":checked");
    var endDate = $(this).val();
    var startDate = $("#start").val();   
    $.ajax({
      type: "POST",
      url: "change_all.php",
      data: { checkbox: isChecked,
    end_date: endDate,
         start_date: startDate
      },
      success: function(data) {
        $("#change").html(data);
      }
    });
  });
  
$("#myCheckbox").on("change", function() {
  var isChecked = $("#myCheckbox").is(":checked");
  var startDate = $("#start").val();
  var endDate = $("#end").val();
  $.ajax({
    type: "POST",
    url: "change_all.php",
    data: { checkbox: isChecked,
    end_date: endDate,
         start_date: startDate },
    success: function(data) {
      $("#change").html(data);
    }
  });
});

});

  
</script>



</body>
</html>
