<?php

class WPAL_GeoIPCountry_Record extends WPAL_Model_Record {
	/**
	 * Initialize model instance
	 * @param array[optional] $data Array of record data to initialize object with
	 */
	public function __construct($data = array()) {
		parent::__construct($data);
		$this->setTable(WPAL_Plugin::getInstance()->getTablePrefix() . 'geoipcountry');
	}

	/**
	 * Find record by IP
	 * @param string|int $ip
	 */
	public function getByIp($ip) {
		is_string($ip) and $ip = ip2long($ip);
		$sip = sprintf('%u', $ip);
		return $this->getBy(array('begin_num <=' => $sip, 'end_num >=' => $sip));
	} 
}