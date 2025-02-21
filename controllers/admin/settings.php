<?php 
/**
 * Admin Statistics page
 * 
 * @author Pavel Kulbakin <p.kulbakin@gmail.com>
 */
class WPAL_Admin_Settings extends WPAL_Controller_Admin {
	
	public function index() {
		$this->data['post'] = $post = $this->input->post(WPAL_Plugin::getInstance()->getOption()
			+ array('keywords_font_size_unit' => 'px', 'is_url_prefix' => 0));
		
		if ($this->input->post('is_submitted')) {
			check_admin_referer('edit-settings', '_wpnonce_edit-settings');
			
			// validate submitted values
			if ( ! preg_match('%^\d+$%', $post['meta_redirect_delay'])) {
				$this->errors->add('form-validation', __('Meta Redirect Delay must be a non-negative integer', 'wpal_plugin'));
			}
			if ( ! preg_match('%^\d+$%', $post['history_link_count'])) {
				$this->errors->add('form-validation', __('History Click Count must be a non-negative integer', 'wpal_plugin'));
			}
			if ( ! preg_match('%^\d+$%', $post['history_link_age'])) {
				$this->errors->add('form-validation', __('History Age must be a non-negative integer', 'wpal_plugin'));
			}
			if ('' != $post['keywords_font_size'] and ! preg_match('%^\d+(\.\d+)?$%', $post['keywords_font_size'])) {
				$this->errors->add('form-validation', __('Font size must be a non-negative number', 'wpal_plugin'));
			}
			if ($post['is_url_prefix'] and '' == $post['url_prefix']) {
				$this->errors->add('form-validation', __('URL Prefix is not specified', 'wpal_plugin'));
			}
			if ( ! $this->errors->get_error_codes()) { // no validation errors detected
				// alter some parameters from representation level to raw values
				$post['url_prefix'] = $post['is_url_prefix'] ? urlencode($post['url_prefix']) : '';
				'' !== $post['keywords_font_size'] and $post['keywords_font_size'] .= $post['keywords_font_size_unit'];
				unset($post['is_url_prefix'], $post['keywords_font_size_unit']);
			
				
				$options = WPAL_Plugin::getInstance()->updateOption($post);
				$stat = new WPAL_Stat_List(); $stat->sweepHistory(); // adjust history log to new settings specified
				
				wp_redirect(add_query_arg('wpal_nt', urlencode(__('Settings saved', 'wpal_plugin')), $this->baseUrl));
			}
		} else {
			$this->data['post']['url_prefix'] = urldecode($post['url_prefix']);
			$this->data['post']['is_url_prefix'] = ('' !== $post['url_prefix']);
			if (preg_match('%^(\d+(\.\d+)?)(\D+)$%', $post['keywords_font_size'], $mtch)) {
				$this->data['post']['keywords_font_size'] = $mtch[1];
				$this->data['post']['keywords_font_size_unit'] = $mtch[3];
			}
		}
		
		$this->render();
	}
	
	public function reset()
	{
		check_admin_referer('edit-settings');
		
		if ($this->input->post('is_confirmed')) {
			WPAL_Plugin::getInstance()->updateOption(WPAL_Config::createFromFile(WPAL_Plugin::ROOT_DIR . '/config/options.php')->toArray());
			wp_redirect(add_query_arg('wpal_nt', urlencode(__('Settings changed to default values', 'wpal_plugin')), $this->baseUrl));
		} 
		if ($this->input->post('is_cancelled')) {
			wp_redirect($this->baseUrl);
		}
		
		$this->render();
	}
}