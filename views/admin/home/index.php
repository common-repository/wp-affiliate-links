<?php if ($this->errors->get_error_codes()): ?>
	<?php $this->error() ?>
<?php endif ?>

<div class="wrap">
	<?php
	$dashboard = @file_get_contents('http://www.dojo.cc/dashboard/wp-affiliate-links.php');
	echo $dashboard;
	?>
</div>
