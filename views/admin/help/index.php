<div class="wrap">

	<?php

		// $helpurl = "http://www.wpwizardcloak.com/adminpanel/help.php?lite=true&v=".urlencode(WPAL_Plugin::getInstance()->getVersion());
		$helpurl = "http://www.dojo.social";

		$contents = @file_get_contents($helpurl);

		if (!$contents) {

			?>

			<iframe src='<?php echo $helpurl; ?>' width='600'></iframe><br />

			<?php

		} else {

			echo $contents;

		}

	?>



</div>