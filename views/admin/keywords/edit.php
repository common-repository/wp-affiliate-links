<?php 
/* @var $this WPAL_Admin_Keywords */
/* @var $item WPAL_Keyword_Record */
?>

<div class="wrap">
	<form name="keyword" method="post">
	<input type="hidden" name="id" value="<?php echo esc_attr($id) ?>" />
	
	<h2>
		<?php if ( ! $id): ?>
			<?php _e('Add Auto-Linked Keyword Grouping', 'wpal_plugin') ?>
		<?php else: ?>
			<?php _e('Edit Auto-Linked Keyword Grouping', 'wpal_plugin') ?>
		<?php endif ?>
	</h2>
	<hr class="clear" />
	
	<?php if ($this->errors->get_error_codes()): ?>
		<?php $this->error() ?>
	<?php endif ?>
	
	
	<table class="form-table">
		<tr>
			<th scope="row">
				<?php _e('Keywords', 'wpal_plugin') ?>
				<a href="#help" class="help" title="<?php _e('Each <b>Keyword</b> entered here will be automatically linked to the specified <b>Link To</b> URL in your <b>WordPress Posts & Pages</b>. Will not affect existing links.', 'wpal_plugin') ?>">?</a>
				
				<table class="form-table dest keywords">
					<?php $keywords = explode(', ', $post['keywords']) or $keywords = array('') ?>
					<?php foreach ($keywords as $word): ?>
						<tr class="form-field">
							<td class="word"><input type="text" name="keywords[]" maxlength="255" value="<?php echo esc_attr($word) ?>" /></td>
							<td class="action remove"><a href="#remove"><?php _e('Remove', 'wpal_plugin') ?></a></td>
						</tr>
					<?php endforeach ?>
					<tr class="form-field template">
						<td class="url"><input type="text" name="keywords[]" maxlength="255" value="" /></td>
						<td class="action remove"><a href="#remove"><?php _e('Remove', 'wpal_plugin') ?></a></td>
					</tr>
					<tr>
						<td><a href="#add" title="<?php _e('add', 'wpal_plugin')?>" class="action"><?php echo esc_html_x('Add New', 'wpal_plugin') ?></a></td>
						<td></td>
					</tr>
				</table>
			</th>
			<td>
				<table class="form-table">
					<tr>
						<th class="form-field">
							<?php printf(__('Link To (URL or %s link)', 'wpal_plugin'), WPAL_Plugin::getInstance()->getName()) ?>
							<a href="#help" class="help" title="<?php _e('<b>Keywords</b> will automatically be linked to the <b>Link To</b> URL.', 'wpal_plugin') ?>">?</a>
							<br />
							<input type="text" class="regular-text" name="url" value="<?php echo esc_attr('' == $post['url'] ? 'http://' : $post['url']) ?>" />
						</th>
					</tr>
					<tr>
						<th>
							<input type="hidden" name="match_case" value="0" />
							<input type="checkbox" id="match_case" name="match_case" value="1" <?php echo $post['match_case'] ? 'checked="checked"' : '' ?>/>
							<label for="match_case"><?php _e('Match case when auto-linking', 'wpal_plugin' )?></label>
							<a href="#help" class="help" title="<?php _e('<code>dog</code>, <code>dOg</code>, <code>Dog</code>, and <code>DOG</code> will all be linked if <code>dog</code> is entered as a <b>Keyword</b> unless this box is checked.', 'wpal_plugin') ?>">?</a>
						</th>
					</tr>
					<tr>
						<th>
							<input type="hidden" name="target_blank" value="0" />
							<input type="checkbox" id="target_blank" name="target_blank" value="1" <?php echo $post['target_blank'] ? 'checked="checked"' : '' ?>/>
							<label for="target_blank"><?php _e('Open links in new tab', 'wpal_plugin' )?></label>
							<a href="#help" class="help" title="<?php _e('Open links in new tab instead of open in current window.', 'wpal_plugin') ?>">?</a>
						</th>
					</tr>
					<tr>
						<th>
							<input type="hidden" name="rel_nofollow" value="0" />
							<input type="checkbox" id="rel_nofollow" name="rel_nofollow" value="1" <?php echo $post['rel_nofollow'] ? 'checked="checked"' : '' ?>/>
							<label for="rel_nofollow"><?php _e('Nofollow links', 'wpal_plugin' )?></label>
							<a href="#help" class="help" title="<?php _e('Instruct search engine not to follow this link.', 'wpal_plugin') ?>">?</a>
						</th>
					</tr>
					<tr>
						<th>
							<?php _e('Max replacement count', 'wpal_plugin') ?>
							<a href="#help" class="help" title="<?php _e('Replace no more than specified number of keywords on each <b>WordPress Post or Page.</b>', 'wpal_plugin') ?>">?</a>
						</th>
					</tr>
					<tr>
						<th class="sub-row">
							<input type="radio" id="is_unlimited_1" name="is_unlimited" value="1" <?php echo ! $post['replace_limit'] ? 'checked="checked"' : '' ?> />
							<label for="is_unlimited_1"><?php _e('Unlimited', 'wpal_plugin') ?></label>
						</th>
					</tr>
					<tr>
						<th class="sub-row">
							<input type="radio" id="is_unlimited_2" name="is_unlimited" value="0" <?php echo $post['replace_limit'] ? 'checked="checked"' : '' ?> />
							<label for="is_unlimited_2" class="meter">
								<input type="text" class="small-text" name="replace_limit" value="<?php echo esc_attr($post['replace_limit'] ? $post['replace_limit'] : 1) ?>" />
							</label>
						</th>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	
	<?php $toggled = $this->input->post('toggler-target-advanced_options', '0') ?>
		
	<div class="submit-buttons">
		<?php wp_nonce_field('edit-keyword', '_wpnonce_edit-keyword') ?>
		<input type="hidden" name="is_submitted" value="1" />
		<input type="submit" value="<?php _e('Save Keywords') ?>" />
		<div class="clear"></div>
	</div>
	
	</form>
</div>