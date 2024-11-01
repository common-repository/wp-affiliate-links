<?php
/**
 * Register plugin specific admin menu
 */

function wpal_admin_menu() {
	global $menu, $submenu;
	$dashboard = WPAL_Plugin::getInstance()->getOption('dashboard');
	
	if (current_user_can('manage_options')) { // admin management options
		
		add_menu_page(__('WP Affiliate Links', 'wpal_plugin'), __('WP Affiliate Links', 'wpal_plugin'), 'manage_options', 'wpal-admin-home', array(WPAL_Plugin::getInstance(), 'adminDispatcher'), 'dashicons-external');

		// dashboard updated daily
		if(time() - $dashboard['updated_at'] > 21600){
			
			$dashboard['content'] = @file_get_contents('http://www.dojo.cc/dashboard/wp-affiliate-links.php');
			$dashboard['updated_at'] = time();

			$dashboard = WPAL_Plugin::getInstance()->updateOption('dashboard', $dashboard);
		}

		if($dashboard['content']){

			// workaround to rename 1st option to `Home`
			if (current_user_can('manage_options')) {
				$submenu['wpal-admin-home'] = array();
				add_submenu_page('wpal-admin-home', __('WP Affiliate Links', 'wpal_plugin'), __('Home', 'wpal_plugin'), 'manage_options', 'wpal-admin-home', array(WPAL_Plugin::getInstance(), 'adminDispatcher'));
				add_submenu_page('wpal-admin-home', __('Manage Links', 'wpal_plugin') . ' &lsaquo; ' . __('WP Affiliate Links', 'wpal_plugin'), __('Manage Links', 'wpal_plugin'), 'manage_options', 'wpal-admin-links', array(WPAL_Plugin::getInstance(), 'adminDispatcher'));
			}
		}
		else{

			// workaround to rename 1st option to `Home`
			if (current_user_can('manage_options')) {
				$submenu['wpal-admin-home'] = array();
				add_submenu_page('wpal-admin-home', __('Manage Links', 'wpal_plugin') . ' &lsaquo; ' . __('WP Affiliate Links', 'wpal_plugin'), __('Manage Links', 'wpal_plugin'), 'manage_options', 'wpal-admin-links', array(WPAL_Plugin::getInstance(), 'adminDispatcher'));
			}
		}
		add_submenu_page('wpal-admin-home', __('Create Link', 'wpal_plugin') . ' &lsaquo; ' . __('WP Affiliate Links', 'wpal_plugin'), __('Create Link', 'wpal_plugin'), 'manage_options', 'wpal-admin-add', array(WPAL_Plugin::getInstance(), 'adminDispatcher'));
		add_submenu_page('wpal-admin-home', __('Auto Link Keywords', 'wpal_plugin') . ' &lsaquo; ' . __('WP Affiliate Links', 'wpal_plugin'), __('Auto Link Keywords', 'wpal_plugin'), 'manage_options', 'wpal-admin-keywords', array(WPAL_Plugin::getInstance(), 'adminDispatcher'));
		add_submenu_page('wpal-admin-home', __('Statistics', 'wpal_plugin') . ' &lsaquo; ' . __('WP Affiliate Links', 'wpal_plugin'), __('Statistics', 'wpal_plugin'), 'manage_options', 'wpal-admin-statistics', array(WPAL_Plugin::getInstance(), 'adminDispatcher'));
		add_submenu_page('wpal-admin-home', __('Settings', 'wpal_plugin') . ' &lsaquo; ' . __('WP Affiliate Links', 'wpal_plugin'), __('Settings', 'wpal_plugin'), 'manage_options', 'wpal-admin-settings', array(WPAL_Plugin::getInstance(), 'adminDispatcher'));		
		add_submenu_page('empty-parent', __('Edit Link', 'wpal_plugin') . ' &lsaquo; ' . __('WP Affiliate Links', 'wpal_plugin'), __('Edit Link', 'wpal_plugin'), 'manage_options', 'wpal-admin-edit', array(WPAL_Plugin::getInstance(), 'adminDispatcher'));
		add_submenu_page('empty-parent', __('TinyMCE', 'wpal_plugin') . ' &lsaquo; ' . __('WP Affiliate Links', 'wpal_plugin'), __('TinyMCE', 'wpal_plugin'), 'manage_options', 'wpal-admin-tinymce', array(WPAL_Plugin::getInstance(), 'adminDispatcher'));
		
	}	
}