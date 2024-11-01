<?php

function wpal_wp_head() {
	// output keyword style
	$options = WPAL_Plugin::getInstance()->getOption();
	echo "<style>a.wpal-linked-keyword{";
	foreach(array('color', 'font-size', 'font-weight', 'font-style', 'text-decoration') as $prop) {
		$opt = 'keywords_' . str_replace('-', '_', $prop);
		'' != $options[$opt] and print($prop . ':' . $options[$opt] . ';');
	}
	echo "}</style>\n";
}