<?php
/**
 * List of plugin optins, contains only default values, actual values are stored in database
 * and can be changed by corresponding wordpress function calls
 */
$config = array(
	"meta_redirect_delay" => 0,
	"history_link_count" => 1000,
	"history_link_age" => 365,
	"url_prefix" => "",
	"forward_url_params" => 1,
	"header_tracking_code" => "",
	"footer_tracking_code" => "",
	"destination_mode" => "simple",
	"dashboard" => array('content' => '', 'updated_at' => 0),

	"keywords_color" => "",
	"keywords_font_size" => "",
	"keywords_font_weight" => "",
	"keywords_font_style" => "",
	"keywords_text_decoration" => "",
	"info_api_url" => 'http://www.dojo.cc',
);
