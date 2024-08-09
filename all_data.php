<?php 
$active = "all_data";
include 'header.php';

$page = 1;
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
        echo '<h1 class="text_color_primary">'.$total.'</h1>';
    }
    else {
        echo '<h1 class="text_color_success">'.$total.'</h1>';
    }
}?>
            <p>Current Score</p>
</div>
</div>


</div>
<div class="container">
  <h3 class="mb_15">All Data</h3>
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
        <div>            <?php 
                $result = $conn->query("SELECT SUM(value) AS total FROM main WHERE `give` = 0");

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
                $result = $conn->query("SELECT SUM(value) AS total FROM main WHERE lost=1");

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
                $result = $conn->query("SELECT SUM(my_m) AS value FROM main");

while($row = $result->fetch_assoc()) {
    $total = $row['value'];
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
                $result = $conn->query("SELECT SUM(ABS(my_p)) AS value FROM main");

while($row = $result->fetch_assoc()) {
    $total = $row['value'];
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
        
if(isset($_POST['page'])){
	$page = $_POST['page'];
}

 $offset = ($page - 1) * $limit;
 
 
$sql = "SELECT * FROM main ORDER BY `id` DESC";
$result = $conn->query($sql);
$rowcount = mysqli_num_rows($result);
echo '<div class="allrows">Total '.$rowcount.'</div>';


$sql = "SELECT * FROM main ORDER BY `id` DESC LIMIT $offset, $limit";
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
 $total_pages = ceil(($conn->query("SELECT COUNT(*) FROM main WH")->fetch_assoc()['COUNT(*)']) / $limit);
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
      url: "search.php",
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
      url: "search.php",
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
    url: "search.php",
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
    url: "search.php",
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
    url: "search.php",
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
