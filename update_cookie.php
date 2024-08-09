<?php
if(isset($_COOKIE['total_pagez'])){
  $total_pages = $_COOKIE['total_pagez'];
}
$page = $_POST['page'];

	for($i = 1; $i <= $total_pages; $i++){ ?>
			<a href="#" class="<?php if($i == $page) { echo 'active'; }?>" data-page="<?php echo $i; ?>"><?php echo $i; ?></a>
		<?php } ?>