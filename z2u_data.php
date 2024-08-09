<?php
$active = "z2u_data";
include 'header.php';


$page = 1;
?>

<div class="side_index">
<div class="container">
  <h3 class="mb_15">Z2U Orders</h3>
  <input type="text" id="search" placeholder="Search...">
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
        
  <?php
  $sql = "SELECT * FROM main WHERE `type` = 'z2u' GROUP BY `order_net` ORDER BY `order_net` ASC";
$result = $conn->query($sql);
$num = mysqli_num_rows($result);
if ($num > 0) {
$i = 1;
	while($row = $result->fetch_assoc()) {
	    $net = $row['order_net'];
	      $sql2 = "SELECT * FROM main WHERE `type` = 'z2u' && `order_net`='$net'";
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
        
if(isset($_POST['page'])){
	$page = $_POST['page'];
}

 $offset = ($page - 1) * $limit;
 
 
$sql = "SELECT * FROM main WHERE `type` = 'z2u' ORDER BY `id` DESC";
$result = $conn->query($sql);
$rowcount = mysqli_num_rows($result);
echo '<div class="allrows">Total '.$rowcount.'</div>';


$sql = "SELECT * FROM main WHERE `type` = 'z2u' ORDER BY `id` DESC LIMIT $offset, $limit";
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
 $total_pages = ceil(($conn->query("SELECT COUNT(*) FROM main WHERE `type` = 'z2u'")->fetch_assoc()['COUNT(*)']) / $limit);
?>
</div>

	<div id="pagination">		
	<?php 

	for($i = 1; $i <= $total_pages; $i++){ ?>
			<a href="#" class="<?php if($i == 1) { echo 'active'; }?>" data-page="<?php echo $i; ?>"><?php echo $i; ?></a>
		<?php } ?>

	</div>


</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$(document).ready(function() {

   $("#start").on("change", function() {
    var startDate = $(this).val();
     var endDate = $("#end").val();
    $.ajax({
      type: "POST",
      url: "z2u_search.php",
      data: {
        start_date: startDate,
        end_date: endDate
      },
      success: function(data) {
        $("#search-results").html(data);
      }
    });
  });
  
$("#end").on("change", function() {
    var endDate = $(this).val();
    var startDate = $("#start").val();   
    $.ajax({
      type: "POST",
      url: "z2u_search.php",
      data: {
        end_date: endDate,
         start_date: startDate
      },
      success: function(data) {
        $("#search-results").html(data);
      }
    });
  });

    $("#pagination").on("click", "a", function(event) {
  event.preventDefault();
  var page = $(this).data("page");
  var search_term = $("#search").val();
    var startDate = $("#start").val(); 
     var endDate = $("#end").val();
  $.ajax({
    type: "POST",
    url: "z2u_search.php",
    data: {page: page, search_term: search_term, end_date: endDate,
         start_date: startDate},
    success: function(data) {
      $("#search-results").html(data);
    }
  });
  $.ajax({
  type: "POST",
  url: "update_cookie.php",  
  data: {page: page},
  success: function(response) {
    $("#pagination").html(response);
  }
});
});



$("#search").on("keyup", function() {
  var search_term = $(this).val();
  var page = 1; 
    var startDate = $("#start").val(); 
     var endDate = $("#end").val();
  $.ajax({
    type: "POST",
    url: "z2u_search.php",
    data: {page: page, search_term: search_term, end_date: endDate,
         start_date: startDate},
    success: function(data) {
      $("#search-results").html(data);
    }
  });
$.ajax({
  type: "POST",
  url: "update_cookie.php",
data: {page: page},
  success: function(response) {
    $("#pagination").html(response);
  }
});
});

});



 
 $(document).on("click", ".data-link", function(e) {

e.preventDefault();

  var dataLink = $(this).data("link");
$("#search").val(dataLink);
    var startDate = $("#start").val(); 
     var endDate = $("#end").val();
  var page = 1;  
  $.ajax({
    type: "POST",
    url: "z2u_search.php",
    data: {search_term: dataLink,end_date: endDate,
         start_date: startDate},
    success: function(data) {
      $("#search-results").html(data);
    }
  });
$.ajax({
  type: "POST",
  url: "update_cookie.php",  
  data: {page: page},
  success: function(response) {
    $("#pagination").html(response);
  }

     
 });
 
 
 });
</script>



</body>
</html>