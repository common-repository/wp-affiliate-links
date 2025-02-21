<?php

class WPAL_Stat_List extends WPAL_Model_List {
	/**
	 * Initialize model instance
	 * @param array[optional] $data Array of record data to initialize object with
	 */
	public function __construct($data = array()) {
		parent::__construct($data);
		$this->setTable(WPAL_Plugin::getInstance()->getTablePrefix() . 'stats');
	}
	
	/**
	 * Sweep history log in accordance with plugin settings
	 * @return WPAL_Stat_List
	 * @chainable
	 */
	public function sweepHistory() {
		$age = WPAL_Plugin::getInstance()->getOption('history_link_age');
		if ($age > 0) {
			$date = new DateTime(); $date->modify('-' . $age . ' day');
			$this->wpdb->query($this->wpdb->prepare('DELETE FROM ' . $this->getTable() . ' WHERE registered_on < %s', $date->format('Y-m-d')));
		}
		$count = WPAL_Plugin::getInstance()->getOption('history_link_count');
		if ($count > 0) {
			$count_actual = $this->countBy();
			if ($count_actual > $count) {
				$this->wpdb->query($this->wpdb->prepare('DELETE FROM ' . $this->getTable() . ' ORDER BY registered_on LIMIT %d', $count_actual - $count));
			}
		}
		
		return $this;
	}
	
}