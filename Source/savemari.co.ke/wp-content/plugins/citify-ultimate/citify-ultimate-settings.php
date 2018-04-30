<?php
if($_POST['cu_set_settings'])
{
	update_option('cu_menu_label',$_POST['cu_menu_label']);
	update_option('cu_city_list',$_POST['cu_city_list']);
	update_option('cu_auto_popup',$_POST['cu_auto_popup']);
	update_option('cu_selector_popup_title',$_POST['cu_selector_popup_title']);
	update_option('cu_selector_popup_message',$_POST['cu_selector_popup_message']);
	?>
	<form name="frm" action="" method="get">
	<input type="hidden" name="page" value="citify-ultimate" />
	<input type="hidden" name="msg" value="success" />
	</form>
	<script>document.frm.submit();</script>
	<?php
		exit;
}
?>

<div class="wrap">
	<div class="icon32 icon32-posts-blinds" id="icon-edit"><br></div>
	<h2><?php _e('Citify Ultimate Settings',APP_TD);?></h2>
	<?php if($_REQUEST['msg']=='success'){?>
		<p class="info"><?php _e('Settings Saved Successfully',APP_TD);?></p>
	<?php }?>
	<form method="post" action="" name="frm_settings">
		<input type="hidden" name="cu_set_settings" value="1" />
		<?php
		$cu_auto_popup = get_option('cu_auto_popup');
		
		?>
		<table cellpadding="5" cellspacing="5">
			
			<tr>
				<td><strong><?php _e('Main Navigation Menu Label',APP_TD);?></strong></td>
				<td><input type="text" size="100" name="cu_menu_label" value="<?php echo stripslashes(get_option('cu_menu_label')); ?>" />
					<br /><code><?php _e("eg: Cities/Towns",APP_TD)?></code>
				</td>
			</tr>
			
			<tr>
				<td><strong><?php _e('Cities',APP_TD);?></strong></td>
				<td><textarea name="cu_city_list" style="width:75%;"><?php echo stripslashes(get_option('cu_city_list')); ?></textarea>
					<br /><code><?php _e("eg: New York,Los Angeles,Chicago,Houston,Philadelphia,Phoenix,Dallas",APP_TD)?></code>
				</td>
			</tr>
			
			<tr>
				<td colspan="2"><hr />
				</td>
			</tr>
			
			<tr>
				<td colspan="2"><h3><?php _e('City Selector Popup',APP_TD);?></h3></td>
			</tr>
			
			<tr>
				<td colspan="2">
					<input type="checkbox" name="cu_auto_popup" value="1" <?php if($cu_auto_popup){echo 'checked="checked"';}?>  />  <b><?php _e('Auto open the City Selector popup first time a user vists the homepage?',APP_TD);?></b>
					<br /><code><?php _e('This will open the popup automatically only once during a session because you don\'t want to keep annoying your visitors. '); ?></code>
				</td>
			</tr>
			
			<tr>
				<td><strong><?php _e('City Selector Popup Title',APP_TD);?></strong></td>
				<td><input type="text" size="100" name="cu_selector_popup_title" value="<?php echo stripslashes(get_option('cu_selector_popup_title')); ?>" />
					<br /><code><?php _e("eg: Select a City",APP_TD)?></code>
				</td>
			</tr>
			
			<tr>
				<td><strong><?php _e('City Selector Popup Message',APP_TD);?></strong></td>
				<td><input type="text" size="100" name="cu_selector_popup_message" value="<?php echo stripslashes(get_option('cu_selector_popup_message')); ?>" />
					<br /><code><?php _e("eg: Closing the popup will show you ads from everywhere",APP_TD)?></code>
				</td>
			</tr>
			
			<tr>
				<td colspan="2"><hr />
				</td>
			</tr>
			
			<tr>
				<td colspan="2"><h3><?php _e('Help',APP_TD);?></h3></td>
			</tr>
			
			<tr>
				<td colspan="2"><h4 style="margin:0;"><?php _e('What is the Citify Ultimate Plugin?',APP_TD);?></h4></td>
			</tr>
			
			<tr>
				<td colspan="2"><p><?php _e('The Citify Ultimate plugin gives you the ability to add sub-sites based on cities. Once a visitor selects a city, they will only see the results from that city, until they switch cities or cancel their selection. The plugin will add a new menu item called Cities in the main navigation and an optional homepage city selector popup for the first time visitors.',APP_TD);?></p></td>
			</tr>
			
			<tr>
				<td colspan="2"><h4 style="margin:0;"><?php _e('How to integrate the plugin?',APP_TD);?></h4></td>
			</tr>
			
			<tr>
				<td colspan="2">
					<p><?php _e('Open <em>header.php</em> in your child theme folder and add:',APP_TD);?></p>
					<code>&lt;?php do_action('cu_show_city_menu'); ?&gt;</code>
					<p><?php _e('right below:'); ?></p>
					<code>&lt;?php wp_nav_menu( array('theme_location' => 'primary', 'fallback_cb' => false, 'container' => false) ); ?&gt;</code>
					<p><?php _e('To enable the first time visitor popup scroll up the page and fill in the settings in the <strong>City Selector Popup</strong> section.'); ?></p>
				</td>
			</tr>
			<tr>
				<td colspan="2">
		
					<p><?php _e('Enjoy the plugin and report any issue you encounter to <a href="mailto:info@themebound.com">info@themebound.com</a>. Follow us on <a href="https://twitter.com/#!/themebound" target="_blank">Twitter</a>, and like us on <a href="https://www.facebook.com/themebound" target="_blank">Facebook</a> to get updates on new products and useful tips.'); ?></p>
				</td>
			</tr>


		</table>
		<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="<?php _e('Save Settings',APP_TD);?>"></p>
	</form>
	
</div>