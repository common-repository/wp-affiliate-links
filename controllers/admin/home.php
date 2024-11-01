<?php 
/**
 * Admin Home page
 * 
 * @author Pavel Kulbakin <p.kulbakin@gmail.com>
 */
class WPAL_Admin_Home extends WPAL_Controller_Admin {
	
	public function index() {
		$this->data['license'] = $license = $this->input->post('license', WPAL_Plugin::getInstance()->getLicense());
		
		if ($this->input->post('is_submitted')) {
			check_admin_referer('set-license', '_wpnonce_set-license');
			
			// recheck & update license key if changed
			if ($license != WPAL_Plugin::getInstance()->getLicense() or ! WPAL_Plugin::getInstance()->isLicensed()) {
				$checking_result = WPAL_Plugin::getInstance()->setLicense($license);
				if ( ! $checking_result) {
					if (is_null($checking_result)) {
						$this->errors->add('form-validation', sprintf(__('License checking server is unreachable. Please contact <a href="%s">support</a> for assistance.', 'wpal_plugin'), WPAL_Plugin::getInstance()->getPluginURI()));
					} elseif(FALSE === $checking_result) {
						$this->errors->add('form-validation', sprintf(__('License key verification has failed. Please make sure you entered a valid key and if so, contact <a href="%s">support</a> for assistance.', 'wpal_plugin'), WPAL_Plugin::getInstance()->getPluginURI()));
					}
					WPAL_Plugin::getInstance()->setLicense(''); // reset license
				}
			}
		}
		
		$this->render();
	}
}