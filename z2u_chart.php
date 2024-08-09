<?php
$active = "z2u_chart";
include 'header.php';

?>
<div class="side_index">
<div class="container nopadding">


</div>
<div class="container">
  <h3 class="mb_15">Z2U Chart</h3>
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
         <div>
            <?php 
                $result = $conn->query("SELECT * FROM main WHERE `type` = 'z2u'");

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
                $result = $conn->query("SELECT SUM(order_net) AS total FROM main WHERE `give` = 0 && `type` = 'z2u'");

while($row = $result->fetch_assoc()) {
    $total_net = $row['total'];
        if ($total_net == '') {
        $total_net = 0;
    }
    if ($total < 0) {
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
                $result = $conn->query("SELECT SUM(order_useable) AS total FROM main WHERE `give` = 0 && `type` = 'z2u'");

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
    $result = $conn->query("SELECT SUM(order_useable + order_not_useable) AS total FROM main WHERE `give` = 0 && `type` = 'z2u'");

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

        </div>





</div>




</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<div id="change">
 <canvas id="myChart" style="width:100%;max-width:100%;" class="mb_15"></canvas> 

<script>


var xValues = [
<?php
$sql = "SELECT * FROM main WHERE `type` = 'z2u' GROUP BY `date` ORDER BY `id` ASC";
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
$sql = "SELECT * FROM main WHERE `type` = 'z2u' GROUP BY `date` ORDER BY `id` ASC";
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
$sql = "SELECT * FROM main WHERE `type` = 'z2u' GROUP BY `date` ORDER BY `id` ASC";
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
$sql = "SELECT * FROM main WHERE `type` = 'z2u' GROUP BY `date` ORDER BY `id` ASC";
$result = $conn->query($sql);
$num = mysqli_num_rows($result);
if ($num > 0) {
$i = 1;
	while($row = $result->fetch_assoc()) { 
$date = $row['date'];
$result2 = $conn->query("SELECT SUM(order_useable + order_not_useable) AS total FROM main WHERE `type` = 'z2u' && `date`='$date' ORDER BY `id` ASC");

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
$sql = "SELECT * FROM main WHERE `type` = 'z2u' GROUP BY `date` ORDER BY `id` ASC";
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
$result2 = $conn->query("SELECT * FROM main WHERE `type` = 'z2u' && `date`='$date' ORDER BY `id` ASC");


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
      url: "change_z2u.php",
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
      url: "change_z2u.php",
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
    url: "change_z2u.php",
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
