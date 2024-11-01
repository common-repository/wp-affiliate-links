<?php

class WPAL_Stat_Record extends WPAL_Model_Record {
	/**
	 * Initialize model instance
	 * @param array[optional] $data Array of record data to initialize object with
	 */
	public function __construct($data = array()) {
		parent::__construct($data);
		$this->setTable(WPAL_Plugin::getInstance()->getTablePrefix() . 'stats');
	}
	
	
	/**
	 * @see WPAL_Model_Record::insert()
	 */
	public function insert() {
		parent::insert();
		$list = new WPAL_Stat_List();
		$list->sweepHistory();
		return $this;
	}
	
}