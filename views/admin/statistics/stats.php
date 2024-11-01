<?php 
/* @var $this WPAL_Admin_Statistics */
/* @var $link WPAL_Link_Record */
/* @var $list WPAL_Stat_List */
?>

<?php if ($this->errors->get_error_codes()): ?>
	<?php $this->error() ?>
<?php endif ?>

<div class="wrap">
	<h2>
		<?php echo sprintf(__('Detailed Statistics for %s Link', 'wpal_plugin'), '<strong>' . $link->name . '</strong>') ?>
		<?php if ('' != $s): ?>
			<span class="subtitle"><?php printf(__('Search results for &#8220;%s&#8221;'), $s) ?></span>
		<?php endif ?>
	</h2>
	<div><?php _e('Link URL', 'wpal_plugin')?>: <em><?php echo $link->getUrl() ?></em></div>
	
	<?php 
	// define the columns to display, the syntax is 'internal name' => 'display name'
	$columns = array(
		'id'				=> __('Click ID', 'wpal_plugin'),
		'registered_on'		=> __('Date/Time', 'wpal_plugin'),
		'sub_id'			=> __('Sub ID', 'wpal_plugin'),
		'country'			=> __('Country Code', 'wpal_plugin'),
		'country_name'		=> __('Country', 'wpal_plugin'),
		'ip'				=> __('IP Address', 'wpal_plugin'),
		'user_agent'		=> __('User Agent', 'wpal_plugin'),
		'destination_url'	=> __('Destination URL', 'wpal_plugin'),
		'referer'			=> __('Referrer', 'wpal_plugin')
	);
	?>
	<?php $baseTypeUrl = remove_query_arg(array('type', 'pagenum', 's', 'f'), $this->baseUrl) ?>
	<ul class="subsubsub">
		<?php $count_all = $list->countBy(array('link_id' => $link->id)) ?>
		<li>
			<a href="<?php echo $baseTypeUrl ?>" class="<?php echo '' == $type ? 'current' : '' ?>">
				<?php _e('All', 'wpal_plugin') ?>
				<span class="count">(<?php echo $count_all ?>)</span>
			</a>
		</li>
		<?php if (($count_today = $list->countBy(array('link_id' => $link->id, 'DATE(registered_on)' => date('Y-m-d')))) > 0): ?>
			<li>
				|
				<a href="<?php echo add_query_arg('type', 'today', $baseTypeUrl) ?>" class="<?php echo 'today' == $type ? 'current' : '' ?>">
					<?php _e('Today', 'wpal_plugin') ?>
					<span class="count">(<?php echo $count_today ?>)</span>
				</a>
			</li>
		<?php endif ?>
		<?php if (($count_yesterday = $list->countBy(array('link_id' => $link->id, 'DATE(registered_on)' => date('Y-m-d', strtotime('-1 day'))))) > 0): ?>
			<li>
				|
				<a href="<?php echo add_query_arg('type', 'yesterday', $baseTypeUrl) ?>" class="<?php echo 'yesterday' == $type ? 'current' : '' ?>">
					<?php _e('Yesterday', 'wpal_plugin') ?>
					<span class="count">(<?php echo $count_yesterday ?>)</span>
				</a>
			</li>
		<?php endif ?>
		<?php if (($count_week = $list->countBy(array('link_id' => $link->id, 'DATE(registered_on) >=' => date('Y-m-d', strtotime('-7 day'))))) > 0): ?>
			<li>
				|
				<a href="<?php echo add_query_arg('type', 'week', $baseTypeUrl) ?>" class="<?php echo 'week' == $type ? 'current' : '' ?>">
					<?php _e('Week To Date', 'wpal_plugin') ?>
					<span class="count">(<?php echo $count_week ?>)</span>
				</a>
			</li>
		<?php endif ?>
		<li>
			|
			<a href="<?php echo add_query_arg('type', 'range', $baseTypeUrl) ?>" class="<?php echo 'range' == $type ? 'current' : '' ?>">
				<?php _e('Custom Date Range', 'wpal_plugin') ?>
			</a>
		</li>
	</ul>
	
	<form method="get">
	<input type="hidden" name="page" value="<?php echo esc_attr($this->input->get('page')) ?>" />
	<input type="hidden" name="id" value="<?php echo esc_attr($link->id) ?>" />
	<?php if ('' != $type): ?>
		<input type="hidden" name="type" value="<?php echo esc_attr($type) ?>" />
	<?php endif ?>
	<p class="search-box">
		<label for="link-search-input" class="screen-reader-text"><?php _e('Search Clicks', 'wpal_plugin') ?>:</label>
		<input id="link-search-input" type="text" name="s" value="<?php echo esc_attr($s) ?>" />
		<input type="submit" class="button" value="<?php _e('Search Clicks', 'wpal_plugin') ?>">
	</p>
	<div class="tablenav">
		<?php if ('range' == $type): ?>
			<div class="alignleft actions">
				<?php _e('From', 'wpal_plugin')?> <input type="text" class="datepicker range-from" name="f[sd]" value="<?php echo esc_attr($f['sd']) ?>" />
				<?php _e('To', 'wpal_plugin')?> <input type="text" class="datepicker range-to" name="f[ed]" value="<?php echo esc_attr($f['ed']) ?>" />
				<input type="submit" value="<?php esc_attr_e('Filter', 'wpal_plugin') ?>" id="filter" class="button-secondary action" />
			</div>
		<?php endif ?>
		<?php if ($page_links): ?>
			<div class="tablenav-pages">
				<?php echo $page_links_html = sprintf(
					'<span class="displaying-num">' . __('Displaying %s&#8211;%s of %s', 'wpal_plugin') . '</span>%s',
					number_format_i18n(($pagenum - 1) * $perPage + 1),
					number_format_i18n(min($pagenum * $perPage, $list->total())),
					number_format_i18n($list->total()),
					$page_links
				) ?>
			</div>
		<?php endif ?>
	</div>
	</form>
	
	<div id="clicks" class="graph"></div>
	<script type="text/javascript">
	(function ($) {
		$('#clicks.graph').data('plotData', <?php echo json_encode($plotData) ?>);
		$('#clicks.graph').data('plotXTickFormat', <?php echo json_encode($plotXTickFormat) ?>);
		$('#clicks.graph').data('plotXTicks', <?php echo json_encode($plotXTicks) ?>);
		$('#clicks.graph').data('plotYMax', <?php echo $plotYMax ?>);
	})(jQuery);
	</script>
	
	<div class="clear"></div>
	<table class="widefat wpal-admin-stats">
		<thead>
		<tr>
			<?php
			$col_html = '';
			foreach ($columns as $column_id => $column_display_name) {
				if (in_array($column_id, array('country_name'))) { // some columns are not sortable
					$column_link = $column_display_name;
				} else {
					$column_link = "<a href='";
					$order2 = 'ASC';
					if ($order_by == $column_id)
						$order2 = ($order == 'DESC') ? 'ASC' : 'DESC';
		
					$column_link .= esc_url(add_query_arg(array('order' => $order2, 'order_by' => $column_id), $this->baseUrl));
					$column_link .= "'>{$column_display_name}</a>";
				}
				$col_html .= '<th scope="col" class="column-' . $column_id . ' ' . ($order_by == $column_id ? $order : '') . '">' . $column_link . '</th>';
			}
			echo $col_html;
			?>
		</tr>
		</thead>
		<tfoot>
		<tr>
			<?php echo $col_html; ?>
		</tr>
		</tfoot>
		<tbody id="the-wpal-admin-stats-list" class="list:wpal-admin-stats">
		<?php if ($list->isEmpty()): ?>
			<tr>
				<td colspan="<?php echo count($columns) ?>"><?php _e('No Statistics found.', 'wpal_plugin') ?></td>
			</tr>
		<?php else: ?>
			<?php $class = ''; $countries_config = WPAL_Config::createFromFile(WPAL_Plugin::ROOT_DIR . '/config/countries.php') ?>
			<?php foreach ($list as $item): ?>
				<?php $class = ('alternate' == $class) ? '' : 'alternate'; ?>
				<tr class="<?php echo $class; ?>" valign="middle">
					<?php foreach ($columns as $column_id => $column_display_name): ?>
						<?php
						switch ($column_id):
							case 'id':
								?>
								<th valign="top" scope="row"><?php echo $item['id'] ?></th>
								<?php
								break;
							case 'registered_on':
								?>
								<td><?php echo date(__('n/j/Y H:i:s', 'wpal_plugin'), strtotime($item['registered_on'])) ?></td>
								<?php 
								break;
							case 'country_name':
								$country = $item['country'];
								?>
								<td><?php echo isset($countries_config->$country) ? $countries_config->$country : $country ?></td>
								<?php
								break;
							default:
								?>
								<td><?php echo $item[$column_id] ?></td>
								<?php
								break;
						endswitch;
						?>
					<?php endforeach; ?>
				</tr>
			<?php endforeach; ?>
		<?php endif ?>
		</tbody>
	</table>
	<div class="tablenav">
		<div class="alignleft actions links">
			<?php _e('Download Click Data in CSV format', 'wpal_plugin') ?>:
			<a href="<?php echo esc_url(add_query_arg('action', 'export', $baseTypeUrl)) ?>"><?php _e('All Data For This link', 'wpal_plugin') ?></a>
			|
			<a href="<?php echo esc_url(add_query_arg('action', 'export', remove_query_arg('pagenum', $this->baseUrl))) ?>"><?php _e('Only Data Matching Specified Parameters', 'wpal_plugin') ?></a>
			|
			<a href="<?php echo esc_url(add_query_arg('action', 'export', add_query_arg('pagenum', $pagenum, $this->baseUrl))) ?>"><?php _e('Only Data On This Page', 'wpal_plugin') ?></a>
		</div>
		<?php if ($page_links): ?><div class="tablenav-pages"><?php echo $page_links_html ?></div><?php endif ?>
	</div>
	<div class="clear"></div>	
</div>