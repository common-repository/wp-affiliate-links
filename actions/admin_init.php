<?php
function wpal_admin_init() {
	if ( ! WPAL_Plugin::getInstance()->isLicensed()) return;
	
	// add tinymce button and it's handler
	if (current_user_can('edit_posts') or current_user_can('edit_pages')) { // only bother if user can edit something
		if (get_user_option('rich_editing') == 'true') { // user enabled rich editing option
			add_filter("mce_external_plugins", create_function('$plugins', '$plugins["clink"] = WPAL_Plugin::ROOT_URL . "/static/js/tinymce/clink.js"; return $plugins;'));
			add_filter('mce_buttons', create_function('$buttons', 'array_push($buttons, "separator", "clink"); return $buttons;'));
		}
	}
}
