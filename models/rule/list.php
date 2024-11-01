<?php

class WPAL_Rule_List extends WPAL_Model_List {
	/**
	 * Initialize model instance
	 * @param array[optional] $data Array of record data to initialize object with
	 */
	public function __construct($data = array()) {
		parent::__construct($data);
		$this->setTable(WPAL_Plugin::getInstance()->getTablePrefix() . 'rules');
	}
}