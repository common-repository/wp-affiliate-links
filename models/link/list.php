<?php

class WPAL_Link_List extends WPAL_Model_List {
	
	public function __construct() {
		parent::__construct();
		$this->setTable(WPAL_Plugin::getInstance()->getTablePrefix() . 'links');
	}
}