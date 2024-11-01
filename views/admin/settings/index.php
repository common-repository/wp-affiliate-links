<?php 
/* @var $this WPAL_Admin_Settings */
?>


<div class="wrap">
	<form name="settings" method="post" action="<?php echo $this->baseUrl ?>">
	<div class="load-preset">
		<a href="<?php echo esc_url(wp_nonce_url(add_query_arg('action', 'reset', $this->baseUrl), 'edit-settings')) ?>"><?php _e('Reset to defaults', 'wpal_plugin') ?></a>
	</div>
	<h2>
		<?php _e('WP Affiliate Links Advanced Settings', 'wpal_plugin') ?>
	</h2>
	<hr />
	
	<?php if ($this->errors->get_error_codes()): ?>
		<?php $this->error() ?>
	<?php endif ?>
	
	<h3><?php _e('Links', 'wpal_plugin') ?></h3>
	<table class="form-table link">

		<tr>
			<th>
				<input type="hidden" name="forward_url_params" value="0" />
				<input type="checkbox" id="forward_url_params" name="forward_url_params" value="1" <?php echo $post['forward_url_params'] ? 'checked="checked"' : '' ?>" />
				<label for="forward_url_params"><?php _e('Forward query string', 'wpal_plugin') ?></label>
				<a href="#help" class="help" title="<?php _e('<b>subid</b>, <b>cloaked</b> and <b>__a</b> parameters are never forwarded since they are reserved by plugin for its own needs', 'wpal_plugin') ?>">?</a>
			</th>
		</tr>
		<tr>
			<th style="height:32px">
				<input type="checkbox" class="switcher" id="is_url_prefix" name="is_url_prefix" <?php echo $post['is_url_prefix'] ? 'checked="checked"' : '' ?> />
				<input type="hidden" name="url_prefix" value="" />
				<label for="is_url_prefix"><?php _e('URL Prefix', 'wpal_plugin') ?></label>
				<a href="#help" class="help" title="<?php _e('Create Links like <b>http://www.yoursite.com/PREFIX/slug</b> instead of <b>http://www.yoursite.com/slug</b>', 'wpal_plugin') ?>">?</a>
				&nbsp;
				<input type="text" name="url_prefix" class="smaller-text switcher-target-is_url_prefix clear-on-switch" value="<?php echo esc_attr($post['url_prefix']) ?>" />
				<a href="#help" class="help switcher-target-is_url_prefix " title="<?php _e("Prefix to use for cloaked URLs. <b style='color:red'>When changed, old static links will no longer work.</b> Shortcodes will be updated automatically.", 'wpal_plugin') ?>">?</a>
			</th>
		</tr>
		<tr>
			<th scope="row"><?php _e('Meta Redirect Delay', 'wpal_plugin') ?></th>
			<td>
				<select name="meta_redirect_delay">
					<?php for($delay = 0; $delay <= 15; $delay++):
					$selected = '';
					if($delay == $post['meta_redirect_delay']){
						$selected = 'selected="selected"';
					}
					?>
					<option value="<?php echo $delay ?>" <?php echo $selected ?>><?php echo $delay ?> Seconds</option>
					<?php endfor;?>
				</select>
				<a href="#help" class="help" title="<?php _e('Most search engine treat 0 seconds redirect delay as 301 permanent redirect. Longer delay make referer masking more effective but sacrificing user experience.', 'wpal_plugin') ?>">?</a>
			</td>
		</tr>
	</table>

	<h3>Global Tracking Code</h3>
	<table class="form-table link">
		<tr class="tracking-code">
			<th colspan="2">
				<label for="is_header_tracking_code"><?php _e('Header Tracking Code', 'wpal_plugin') ?></label>
				<a href="#help" class="help" title="<?php _e('Track clicks with Google Analytics, Facebook open graph, facebook pixel or other 3rd party web analytics software. Paste header tracking code here and it will be appear between <code>head</code> tags.', 'wpal_plugin') ?>">?</a>
				<div class="textarea-container">
					<textarea name="header_tracking_code" class="regular-text code" rows="4" wrap="off"><?php echo esc_html($post['header_tracking_code']) ?></textarea>
				</div>
			</th>
		</tr>
		<tr class="tracking-code">
			<th colspan="2">
				<label for="is_footer_tracking_code"><?php _e('Footer Tracking Code', 'wpal_plugin') ?></label>
				<a href="#help" class="help" title="<?php _e('Track clicks with Google Analytics or other 3rd party web analytics software. Paste footer tracking code here and it will be appear before <code>/body</code> tag.', 'wpal_plugin') ?>">?</a>
				<div class="textarea-container">
					<textarea name="footer_tracking_code" class="regular-text code" rows="4" wrap="off"><?php echo esc_html($post['footer_tracking_code']) ?></textarea>
				</div>
			</th>
		</tr>
	
	</table>
	
	<h3>History &amp; Statistics Logging</h3>
	<table class="form-table link">
		<tr>
			<th><?php printf(__('Store maximum of %s of the most recent clicks. 0 = unlimited', 'wpal_plugin'), '<input class="small-text" type="text" name="history_link_count" value="' . esc_attr($post['history_link_count']) . '" />') ?></th>
		</tr>
		<tr>
			<th><?php printf(__('Store click data for a maximum of %s of days. 0 = unlimited', 'wpal_plugin'), '<input class="small-text" type="text" name="history_link_age" value="' . esc_attr($post['history_link_age']) . '" />') ?></th>
		</tr>
	</table>
	
	<h3><?php _e('Auto-Linked Keywords Style', 'wpal_plugin') ?> 
		<a href="#help" class="help" title="<?php _e('Control the styling of <b>Auto-Linked Keywords</b>. Styling of content and links on your site is controlled by your theme, but this feature will attempt to override it.', 'wpal_plugin') ?>">?</a>					
	</h3>
	<table class="form-table keywords-style">
		<tr>
			<th scope="row"><?php _e('Font Color', 'wpal_plugin') ?></th>
			<td>
				<input id="keywords_color" type="text" name="keywords_color" class="selectable" value="<?php echo esc_attr($post['keywords_color']) ?>" /><label for="keywords_color" class="color-picker"></label>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Font Size', 'wpal_plugin') ?></th>
			<td>
				<input type="text" name="keywords_font_size" class="small-text" value="<?php echo esc_attr($post['keywords_font_size']) ?>" /><select name="keywords_font_size_unit">
					<?php foreach (array('px', 'pt', '%', 'em', 'ex') as $unit): ?>
						<option value="<?php echo $unit ?>" <?php echo $post['keywords_font_size'] == $unit ? 'selected="selected"' : '' ?>><?php echo $unit ?></option>
					<?php endforeach ?>
				</select>
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row"><?php _e('Text Decoration', 'wpal_plugin') ?></th>
			<td>
				<select name="keywords_text_decoration">
					<option value=""></option>
					<option value="none" style="text-decoration:none" <?php echo 'none' == $post['keywords_text_decoration'] ? 'selected="selected"' : '' ?>>none</option>
					<option value="overline" style="text-decoration:overline" <?php echo 'overline' == $post['keywords_text_decoration'] ? 'selected="selected"' : '' ?>>overline</option>
					<option value="underline" style="text-decoration:underline" <?php echo 'underline' == $post['keywords_text_decoration'] ? 'selected="selected"' : '' ?>>underline</option>
					<option value="line-through" style="text-decoration:line-through" <?php echo 'line-through' == $post['keywords_text_decoration'] ? 'selected="selected"' : '' ?>>line-through</option>
					<option value="blink" style="text-decoration:blink" <?php echo 'blink' == $post['keywords_text_decoration'] ? 'selected="selected"' : '' ?>>blink</option>
				</select>
			</td>
		</tr>
		<tr>
			<th colspan="2">
				<input type="hidden" name="keywords_font_weight" value="" />
				<input type="checkbox" id="keywords_font_weight_bold" name="keywords_font_weight" value="bold" <?php echo 'bold' == $post['keywords_font_weight'] ? 'checked="checked"' : '' ?> />
				<label for="keywords_font_weight_bold"><?php _e('<span style="font-weight:bold">Bold</span> Text', 'wpal_plugin') ?></label>
			</th>
		</tr>
		<tr>
			<th colspan="2">
				<input type="hidden" name="keywords_font_style" value="" />
				<input type="checkbox" id="keywords_font_style_italic" name="keywords_font_style" value="italic" <?php echo 'italic' == $post['keywords_font_style'] ? 'checked="checked"' : '' ?> />
				<label for="keywords_font_style_italic"><?php _e('<span style="font-style:italic">Italic</span> Text', 'wpal_plugin') ?></label>
			</th>
		</tr>
	</table>
	<hr />
	<p class="submit-buttons">
		<?php wp_nonce_field('edit-settings', '_wpnonce_edit-settings') ?>
		<input type="hidden" name="is_submitted" value="1" />
		<input type="submit" value="Save Settings" />
		<br class="clear" />
	</p>
	</form>
</div>