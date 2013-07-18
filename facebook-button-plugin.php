<?php
/*
Plugin Name: Facebook Button Plugin
Plugin URI:  http://bestwebsoft.com/plugin/
Description: Put Facebook Button in to your post.
Author: BestWebSoft
Version: 2.21
Author URI: http://bestwebsoft.com/
License: GPLv2 or later
*/

/*  Copyright 2011  BestWebSoft  ( http://support.bestwebsoft.com )

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( ! function_exists( 'bws_add_menu_render' ) ) {
	function bws_add_menu_render() {
		global $wpdb, $wp_version, $title;
		$active_plugins = get_option('active_plugins');
		$all_plugins = get_plugins();
		$error = '';
		$message = '';
		$bwsmn_form_email = '';

		$array_activate = array();
		$array_install	= array();
		$array_recomend = array();
		$count_activate = $count_install = $count_recomend = 0;
		$array_plugins	= array(
			array( 'captcha\/captcha.php', 'Captcha', 'http://bestwebsoft.com/plugin/captcha-plugin/', 'http://bestwebsoft.com/plugin/captcha-plugin/#download', '/wp-admin/plugin-install.php?tab=search&type=term&s=Captcha+bestwebsoft&plugin-search-input=Search+Plugins', 'admin.php?page=captcha.php' ), 
			array( 'contact-form-plugin\/contact_form.php', 'Contact Form', 'http://bestwebsoft.com/plugin/contact-form/', 'http://bestwebsoft.com/plugin/contact-form/#download', '/wp-admin/plugin-install.php?tab=search&type=term&s=Contact+Form+bestwebsoft&plugin-search-input=Search+Plugins', 'admin.php?page=contact_form.php' ), 
			array( 'facebook-button-plugin\/facebook-button-plugin.php', 'Facebook Like Button Plugin', 'http://bestwebsoft.com/plugin/facebook-like-button-plugin/', 'http://bestwebsoft.com/plugin/facebook-like-button-plugin/#download', '/wp-admin/plugin-install.php?tab=search&type=term&s=Facebook+Like+Button+Plugin+bestwebsoft&plugin-search-input=Search+Plugins', 'admin.php?page=facebook-button-plugin.php' ), 
			array( 'twitter-plugin\/twitter.php', 'Twitter Plugin', 'http://bestwebsoft.com/plugin/twitter-plugin/', 'http://bestwebsoft.com/plugin/twitter-plugin/#download', '/wp-admin/plugin-install.php?tab=search&type=term&s=Twitter+Plugin+bestwebsoft&plugin-search-input=Search+Plugins', 'admin.php?page=twitter.php' ), 
			array( 'portfolio\/portfolio.php', 'Portfolio', 'http://bestwebsoft.com/plugin/portfolio-plugin/', 'http://bestwebsoft.com/plugin/portfolio-plugin/#download', '/wp-admin/plugin-install.php?tab=search&type=term&s=Portfolio+bestwebsoft&plugin-search-input=Search+Plugins', 'admin.php?page=portfolio.php' ),
			array( 'gallery-plugin\/gallery-plugin.php', 'Gallery', 'http://bestwebsoft.com/plugin/gallery-plugin/', 'http://bestwebsoft.com/plugin/gallery-plugin/#download', '/wp-admin/plugin-install.php?tab=search&type=term&s=Gallery+Plugin+bestwebsoft&plugin-search-input=Search+Plugins', 'admin.php?page=gallery-plugin.php' ),
			array( 'adsense-plugin\/adsense-plugin.php', 'Google AdSense Plugin', 'http://bestwebsoft.com/plugin/google-adsense-plugin/', 'http://bestwebsoft.com/plugin/google-adsense-plugin/#download', '/wp-admin/plugin-install.php?tab=search&type=term&s=Adsense+Plugin+bestwebsoft&plugin-search-input=Search+Plugins', 'admin.php?page=adsense-plugin.php' ),
			array( 'custom-search-plugin\/custom-search-plugin.php', 'Custom Search Plugin', 'http://bestwebsoft.com/plugin/custom-search-plugin/', 'http://bestwebsoft.com/plugin/custom-search-plugin/#download', '/wp-admin/plugin-install.php?tab=search&type=term&s=Custom+Search+plugin+bestwebsoft&plugin-search-input=Search+Plugins', 'admin.php?page=custom_search.php' ),
			array( 'quotes-and-tips\/quotes-and-tips.php', 'Quotes and Tips', 'http://bestwebsoft.com/plugin/quotes-and-tips/', 'http://bestwebsoft.com/plugin/quotes-and-tips/#download', '/wp-admin/plugin-install.php?tab=search&type=term&s=Quotes+and+Tips+bestwebsoft&plugin-search-input=Search+Plugins', 'admin.php?page=quotes-and-tips.php' ),
			array( 'google-sitemap-plugin\/google-sitemap-plugin.php', 'Google sitemap plugin', 'http://bestwebsoft.com/plugin/google-sitemap-plugin/', 'http://bestwebsoft.com/plugin/google-sitemap-plugin/#download', '/wp-admin/plugin-install.php?tab=search&type=term&s=Google+sitemap+plugin+bestwebsoft&plugin-search-input=Search+Plugins', 'admin.php?page=google-sitemap-plugin.php' ),
			array( 'updater\/updater.php', 'Updater', 'http://bestwebsoft.com/plugin/updater-plugin/', 'http://bestwebsoft.com/plugin/updater-plugin/#download', '/wp-admin/plugin-install.php?tab=search&s=updater+bestwebsoft&plugin-search-input=Search+Plugins', 'admin.php?page=updater-options' )
		);
		foreach ( $array_plugins as $plugins ) {
			if( 0 < count( preg_grep( "/".$plugins[0]."/", $active_plugins ) ) ) {
				$array_activate[$count_activate]["title"] = $plugins[1];
				$array_activate[$count_activate]["link"] = $plugins[2];
				$array_activate[$count_activate]["href"] = $plugins[3];
				$array_activate[$count_activate]["url"]	= $plugins[5];
				$count_activate++;
			} else if ( array_key_exists(str_replace( "\\", "", $plugins[0]), $all_plugins ) ) {
				$array_install[$count_install]["title"] = $plugins[1];
				$array_install[$count_install]["link"]	= $plugins[2];
				$array_install[$count_install]["href"]	= $plugins[3];
				$count_install++;
			} else {
				$array_recomend[$count_recomend]["title"] = $plugins[1];
				$array_recomend[$count_recomend]["link"] = $plugins[2];
				$array_recomend[$count_recomend]["href"] = $plugins[3];
				$array_recomend[$count_recomend]["slug"] = $plugins[4];
				$count_recomend++;
			}
		}
		$array_activate_pro = array();
		$array_install_pro	= array();
		$array_recomend_pro = array();
		$count_activate_pro = $count_install_pro = $count_recomend_pro = 0;
		$array_plugins_pro	= array(
			array( 'gallery-plugin-pro\/gallery-plugin-pro.php', 'Gallery Pro', 'http://bestwebsoft.com/plugin/gallery-pro/?k=382e5ce7c96a6391f5ffa5e116b37fe0', 'http://bestwebsoft.com/plugin/gallery-pro/?k=382e5ce7c96a6391f5ffa5e116b37fe0#purchase', 'admin.php?page=gallery-plugin-pro.php' ),
			array( 'contact-form-pro\/contact_form_pro.php', 'Contact Form Pro', 'http://bestwebsoft.com/plugin/contact-form-pro/?k=773dc97bb3551975db0e32edca1a6d71', 'http://bestwebsoft.com/plugin/contact-form-pro/?k=773dc97bb3551975db0e32edca1a6d71#purchase', 'admin.php?page=contact_form_pro.php' )
		);
		foreach ( $array_plugins_pro as $plugins ) {
			if( 0 < count( preg_grep( "/".$plugins[0]."/", $active_plugins ) ) ) {
				$array_activate_pro[$count_activate_pro]["title"] = $plugins[1];
				$array_activate_pro[$count_activate_pro]["link"] = $plugins[2];
				$array_activate_pro[$count_activate_pro]["href"] = $plugins[3];
				$array_activate_pro[$count_activate_pro]["url"]	= $plugins[4];
				$count_activate_pro++;
			} else if( array_key_exists(str_replace( "\\", "", $plugins[0]), $all_plugins ) ) {
				$array_install_pro[$count_install_pro]["title"] = $plugins[1];
				$array_install_pro[$count_install_pro]["link"]	= $plugins[2];
				$array_install_pro[$count_install_pro]["href"]	= $plugins[3];
				$count_install_pro++;
			} else {
				$array_recomend_pro[$count_recomend_pro]["title"] = $plugins[1];
				$array_recomend_pro[$count_recomend_pro]["link"] = $plugins[2];
				$array_recomend_pro[$count_recomend_pro]["href"] = $plugins[3];
				$count_recomend_pro++;
			}
		}
		
		$sql_version = $wpdb->get_var( "SELECT VERSION() AS version" );
	    $mysql_info = $wpdb->get_results( "SHOW VARIABLES LIKE 'sql_mode'" );
	    if ( is_array( $mysql_info) )
	    	$sql_mode = $mysql_info[0]->Value;
	    if ( empty( $sql_mode ) )
	    	$sql_mode = __( 'Not set', 'facebook' );
	    if ( ini_get( 'safe_mode' ) )
	    	$safe_mode = __( 'On', 'facebook' );
	    else
	    	$safe_mode = __( 'Off', 'facebook' );
	    if ( ini_get( 'allow_url_fopen' ) )
	    	$allow_url_fopen = __( 'On', 'facebook' );
	    else
	    	$allow_url_fopen = __( 'Off', 'facebook' );
	    if ( ini_get( 'upload_max_filesize' ) )
	    	$upload_max_filesize = ini_get( 'upload_max_filesize' );
	    else
	    	$upload_max_filesize = __( 'N/A', 'facebook' );
	    if ( ini_get('post_max_size') )
	    	$post_max_size = ini_get('post_max_size');
	    else
	    	$post_max_size = __( 'N/A', 'facebook' );
	    if ( ini_get( 'max_execution_time' ) )
	    	$max_execution_time = ini_get( 'max_execution_time' );
	    else
	    	$max_execution_time = __( 'N/A', 'facebook' );
	    if ( ini_get( 'memory_limit' ) )
	    	$memory_limit = ini_get( 'memory_limit' );
	    else
	    	$memory_limit = __( 'N/A', 'facebook' );
	    if ( function_exists( 'memory_get_usage' ) )
	    	$memory_usage = round( memory_get_usage() / 1024 / 1024, 2 ) . __(' Mb', 'facebook' );
	    else
	    	$memory_usage = __( 'N/A', 'facebook' );
	    if ( is_callable( 'exif_read_data' ) )
	    	$exif_read_data = __( 'Yes', 'facebook' ) . " ( V" . substr( phpversion( 'exif' ), 0,4 ) . ")" ;
	    else
	    	$exif_read_data = __( 'No', 'facebook' );
	    if ( is_callable( 'iptcparse' ) )
	    	$iptcparse = __( 'Yes', 'facebook' );
	    else
	    	$iptcparse = __( 'No', 'facebook' );
	    if ( is_callable( 'xml_parser_create' ) )
	    	$xml_parser_create = __( 'Yes', 'facebook' );
	    else
	    	$xml_parser_create = __( 'No', 'facebook' );

		if ( function_exists( 'wp_get_theme' ) )
			$theme = wp_get_theme();
		else
			$theme = get_theme( get_current_theme() );

		if ( function_exists( 'is_multisite' ) ) {
			if ( is_multisite() ) {
				$multisite = __( 'Yes', 'facebook' );
			} else {
				$multisite = __( 'No', 'facebook' );
			}
		} else
			$multisite = __( 'N/A', 'facebook' );

		$site_url = get_option( 'siteurl' );
		$home_url = get_option( 'home' );
		$db_version = get_option( 'db_version' );
		$system_info = array(
			'system_info' => '',
			'active_plugins' => '',
			'inactive_plugins' => ''
		);
		$system_info['system_info'] = array(
	        __( 'Operating System', 'facebook' )				=> PHP_OS,
	        __( 'Server', 'facebook' )						=> $_SERVER["SERVER_SOFTWARE"],
	        __( 'Memory usage', 'facebook' )					=> $memory_usage,
	        __( 'MYSQL Version', 'facebook' )				=> $sql_version,
	        __( 'SQL Mode', 'facebook' )						=> $sql_mode,
	        __( 'PHP Version', 'facebook' )					=> PHP_VERSION,
	        __( 'PHP Safe Mode', 'facebook' )				=> $safe_mode,
	        __( 'PHP Allow URL fopen', 'facebook' )			=> $allow_url_fopen,
	        __( 'PHP Memory Limit', 'facebook' )				=> $memory_limit,
	        __( 'PHP Max Upload Size', 'facebook' )			=> $upload_max_filesize,
	        __( 'PHP Max Post Size', 'facebook' )			=> $post_max_size,
	        __( 'PHP Max Script Execute Time', 'facebook' )	=> $max_execution_time,
	        __( 'PHP Exif support', 'facebook' )				=> $exif_read_data,
	        __( 'PHP IPTC support', 'facebook' )				=> $iptcparse,
	        __( 'PHP XML support', 'facebook' )				=> $xml_parser_create,
			__( 'Site URL', 'facebook' )						=> $site_url,
			__( 'Home URL', 'facebook' )						=> $home_url,
			__( 'WordPress Version', 'facebook' )			=> $wp_version,
			__( 'WordPress DB Version', 'facebook' )			=> $db_version,
			__( 'Multisite', 'facebook' )					=> $multisite,
			__( 'Active Theme', 'facebook' )					=> $theme['Name'].' '.$theme['Version']
		);
		foreach ( $all_plugins as $path => $plugin ) {
			if ( is_plugin_active( $path ) ) {
				$system_info['active_plugins'][ $plugin['Name'] ] = $plugin['Version'];
			} else {
				$system_info['inactive_plugins'][ $plugin['Name'] ] = $plugin['Version'];
			}
		} 

		if ( ( isset( $_REQUEST['bwsmn_form_submit'] ) && check_admin_referer( plugin_basename(__FILE__), 'bwsmn_nonce_submit' ) ) ||
			 ( isset( $_REQUEST['bwsmn_form_submit_custom_email'] ) && check_admin_referer( plugin_basename(__FILE__), 'bwsmn_nonce_submit_custom_email' ) ) ) {
			if ( isset( $_REQUEST['bwsmn_form_email'] ) ) {
				$bwsmn_form_email = trim( $_REQUEST['bwsmn_form_email'] );
				if( $bwsmn_form_email == "" || !preg_match( "/^((?:[a-z0-9']+(?:[a-z0-9\-_\.']+)?@[a-z0-9]+(?:[a-z0-9\-\.]+)?\.[a-z]{2,5})[, ]*)+$/i", $bwsmn_form_email ) ) {
					$error = __( "Please enter a valid email address.", 'facebook' );
				} else {
					$email = $bwsmn_form_email;
					$bwsmn_form_email = '';
					$message = __( 'Email with system info is sent to ', 'facebook' ) . $email;			
				}
			} else {
				$email = 'plugin_system_status@bestwebsoft.com';
				$message = __( 'Thank you for contacting us.', 'facebook' );
			}

			if ( $error == '' ) {
				$headers  = 'MIME-Version: 1.0' . "\n";
				$headers .= 'Content-type: text/html; charset=utf-8' . "\n";
				$headers .= 'From: ' . get_option( 'admin_email' );
				$message_text = '<html><head><title>System Info From ' . $home_url . '</title></head><body>
				<h4>Environment</h4>
				<table>';
				foreach ( $system_info['system_info'] as $key => $value ) {
					$message_text .= '<tr><td>'. $key .'</td><td>'. $value .'</td></tr>';	
				}
				$message_text .= '</table>
				<h4>Active Plugins</h4>
				<table>';
				foreach ( $system_info['active_plugins'] as $key => $value ) {	
					$message_text .= '<tr><td scope="row">'. $key .'</td><td scope="row">'. $value .'</td></tr>';	
				}
				$message_text .= '</table>
				<h4>Inactive Plugins</h4>
				<table>';
				foreach ( $system_info['inactive_plugins'] as $key => $value ) {
					$message_text .= '<tr><td scope="row">'. $key .'</td><td scope="row">'. $value .'</td></tr>';
				}
				$message_text .= '</table></body></html>';
				$result = wp_mail( $email, 'System Info From ' . $home_url, $message_text, $headers );
				if ( $result != true )
					$error = __( "Sorry, email message could not be delivered.", 'facebook' );
			}
		}
		?><div class="wrap">
			<div class="icon32 icon32-bws" id="icon-options-general"></div>
			<h2><?php echo $title;?></h2>
			<div class="updated fade" <?php if( !( isset( $_REQUEST['bwsmn_form_submit'] ) || isset( $_REQUEST['bwsmn_form_submit_custom_email'] ) ) || $error != "" ) echo "style=\"display:none\""; ?>><p><strong><?php echo $message; ?></strong></p></div>
			<div class="error" <?php if ( "" == $error ) echo "style=\"display:none\""; ?>><p><strong><?php echo $error; ?></strong></p></div>
			<h3 style="color: blue;"><?php _e( 'Pro plugins', 'facebook' ); ?></h3>
			<?php if( 0 < $count_activate_pro ) { ?>
			<div style="padding-left:15px;">
				<h4><?php _e( 'Activated plugins', 'facebook' ); ?></h4>
				<?php foreach ( $array_activate_pro as $activate_plugin ) { ?>
				<div style="float:left; width:200px;"><?php echo $activate_plugin["title"]; ?></div> <p><a href="<?php echo $activate_plugin["link"]; ?>" target="_blank"><?php echo __( "Read more", 'facebook' ); ?></a> <a href="<?php echo $activate_plugin["url"]; ?>"><?php echo __( "Settings", 'facebook' ); ?></a></p>
				<?php } ?>
			</div>
			<?php } ?>
			<?php if( 0 < $count_install_pro ) { ?>
			<div style="padding-left:15px;">
				<h4><?php _e( 'Installed plugins', 'facebook' ); ?></h4>
				<?php foreach ( $array_install_pro as $install_plugin) { ?>
				<div style="float:left; width:200px;"><?php echo $install_plugin["title"]; ?></div> <p><a href="<?php echo $install_plugin["link"]; ?>" target="_blank"><?php echo __( "Read more", 'facebook' ); ?></a></p>
				<?php } ?>
			</div>
			<?php } ?>
			<?php if( 0 < $count_recomend_pro ) { ?>
			<div style="padding-left:15px;">
				<h4><?php _e( 'Recommended plugins', 'facebook' ); ?></h4>
				<?php foreach ( $array_recomend_pro as $recomend_plugin ) { ?>
				<div style="float:left; width:200px;"><?php echo $recomend_plugin["title"]; ?></div> <p><a href="<?php echo $recomend_plugin["link"]; ?>" target="_blank"><?php echo __( "Read more", 'facebook' ); ?></a> <a href="<?php echo $recomend_plugin["href"]; ?>" target="_blank"><?php echo __( "Purchase", 'facebook' ); ?></a></p>
				<?php } ?>
			</div>
			<?php } ?>
			<br />
			<h3 style="color: green"><?php _e( 'Free plugins', 'facebook' ); ?></h3>
			<?php if( 0 < $count_activate ) { ?>
			<div style="padding-left:15px;">
				<h4><?php _e( 'Activated plugins', 'facebook' ); ?></h4>
				<?php foreach( $array_activate as $activate_plugin ) { ?>
				<div style="float:left; width:200px;"><?php echo $activate_plugin["title"]; ?></div> <p><a href="<?php echo $activate_plugin["link"]; ?>" target="_blank"><?php echo __( "Read more", 'facebook' ); ?></a> <a href="<?php echo $activate_plugin["url"]; ?>"><?php echo __( "Settings", 'facebook' ); ?></a></p>
				<?php } ?>
			</div>
			<?php } ?>
			<?php if( 0 < $count_install ) { ?>
			<div style="padding-left:15px;">
				<h4><?php _e( 'Installed plugins', 'facebook' ); ?></h4>
				<?php foreach ( $array_install as $install_plugin ) { ?>
				<div style="float:left; width:200px;"><?php echo $install_plugin["title"]; ?></div> <p><a href="<?php echo $install_plugin["link"]; ?>" target="_blank"><?php echo __( "Read more", 'facebook' ); ?></a></p>
				<?php } ?>
			</div>
			<?php } ?>
			<?php if( 0 < $count_recomend ) { ?>
			<div style="padding-left:15px;">
				<h4><?php _e( 'Recommended plugins', 'facebook' ); ?></h4>
				<?php foreach ( $array_recomend as $recomend_plugin ) { ?>
				<div style="float:left; width:200px;"><?php echo $recomend_plugin["title"]; ?></div> <p><a href="<?php echo $recomend_plugin["link"]; ?>" target="_blank"><?php echo __( "Read more", 'facebook' ); ?></a> <a href="<?php echo $recomend_plugin["href"]; ?>" target="_blank"><?php echo __( "Download", 'facebook' ); ?></a> <a class="install-now" href="<?php echo get_bloginfo( "url" ) . $recomend_plugin["slug"]; ?>" title="<?php esc_attr( sprintf( __( 'Install %s' ), $recomend_plugin["title"] ) ) ?>" target="_blank"><?php echo __( 'Install now from wordpress.org', 'facebook' ) ?></a></p>
				<?php } ?>
			</div>
			<?php } ?>	
			<br />		
			<span style="color: rgb(136, 136, 136); font-size: 10px;"><?php _e( 'If you have any questions, please contact us via', 'facebook' ); ?> <a href="http://support.bestwebsoft.com">http://support.bestwebsoft.com</a></span>
			<div id="poststuff" class="bws_system_info_mata_box">
				<div class="postbox">
					<div class="handlediv" title="Click to toggle">
						<br>
					</div>
					<h3 class="hndle">
						<span><?php _e( 'System status', 'facebook' ); ?></span>
					</h3>
					<div class="inside">
						<table class="bws_system_info">
							<thead><tr><th><?php _e( 'Environment', 'facebook' ); ?></th><td></td></tr></thead>
							<tbody>
							<?php foreach ( $system_info['system_info'] as $key => $value ) { ?>	
								<tr>
									<td scope="row"><?php echo $key; ?></td>
									<td scope="row"><?php echo $value; ?></td>
								</tr>	
							<?php } ?>
							</tbody>
						</table>
						<table class="bws_system_info">
							<thead><tr><th><?php _e( 'Active Plugins', 'facebook' ); ?></th><th></th></tr></thead>
							<tbody>
							<?php foreach ( $system_info['active_plugins'] as $key => $value ) { ?>	
								<tr>
									<td scope="row"><?php echo $key; ?></td>
									<td scope="row"><?php echo $value; ?></td>
								</tr>	
							<?php } ?>
							</tbody>
						</table>
						<table class="bws_system_info">
							<thead><tr><th><?php _e( 'Inactive Plugins', 'facebook' ); ?></th><th></th></tr></thead>
							<tbody>
							<?php foreach ( $system_info['inactive_plugins'] as $key => $value ) { ?>	
								<tr>
									<td scope="row"><?php echo $key; ?></td>
									<td scope="row"><?php echo $value; ?></td>
								</tr>	
							<?php } ?>
							</tbody>
						</table>
						<div class="clear"></div>						
						<form method="post" action="admin.php?page=bws_plugins">
							<p>			
								<input type="hidden" name="bwsmn_form_submit" value="submit" />
								<input type="submit" class="button-primary" value="<?php _e( 'Send to support', 'facebook' ) ?>" />
								<?php wp_nonce_field( plugin_basename(__FILE__), 'bwsmn_nonce_submit' ); ?>		
							</p>		
						</form>				
						<form method="post" action="admin.php?page=bws_plugins">	
							<p>			
								<input type="hidden" name="bwsmn_form_submit_custom_email" value="submit" />						
								<input type="submit" class="button" value="<?php _e( 'Send to custom email &#187;', 'facebook' ) ?>" />
								<input type="text" value="<?php echo $bwsmn_form_email; ?>" name="bwsmn_form_email" />
								<?php wp_nonce_field( plugin_basename(__FILE__), 'bwsmn_nonce_submit_custom_email' ); ?>
							</p>				
						</form>						
					</div>
				</div>
			</div>
		</div>
	<?php }
}

if( ! function_exists( 'fcbk_bttn_plgn_add_pages' ) ) {
	function fcbk_bttn_plgn_add_pages() {
		add_menu_page( 'BWS Plugins', 'BWS Plugins', 'manage_options', 'bws_plugins', 'bws_add_menu_render', plugins_url( "img/px.png", __FILE__ ), 1001); 
		add_submenu_page( 'bws_plugins', __( 'Facebook Button Settings', 'facebook' ), __( 'Facebook Button', 'facebook' ), 'manage_options', "facebook-button-plugin.php", 'fcbk_bttn_plgn_settings_page');

		//call register settings function
		add_action( 'admin_init', 'fcbk_bttn_plgn_settings' );
	}
}

if( ! function_exists( 'fcbk_bttn_plgn_settings' ) ) {
	function fcbk_bttn_plgn_settings() {
		global $fcbk_bttn_plgn_options_array;

		$fcbk_bttn_plgn_options_array_default = array(
			'fcbk_bttn_plgn_link'						=> '',
			'fcbk_bttn_plgn_my_page'				=> 1,
			'fcbk_bttn_plgn_like'						=> 1,
			'fcbk_bttn_plgn_where'					=> '',
			'fcbk_bttn_plgn_display_option' => '',
			'fcbk_bttn_plgn_count_icon'			=> 1,
			'fb_img_link'										=>  plugins_url( "img/standart-facebook-ico.jpg", __FILE__ ),
			'fcbk_bttn_plgn_locale' => 'en_US'
		);

		if( ! get_option( 'fcbk_bttn_plgn_options_array' ) )
			add_option( 'fcbk_bttn_plgn_options_array', $fcbk_bttn_plgn_options_array_default, '', 'yes' );

		$fcbk_bttn_plgn_options_array = get_option( 'fcbk_bttn_plgn_options_array' );

		$fcbk_bttn_plgn_options_array = array_merge( $fcbk_bttn_plgn_options_array_default, $fcbk_bttn_plgn_options_array );
		update_option( 'fcbk_bttn_plgn_options_array', $fcbk_bttn_plgn_options_array );
	}
}

//Function formed content of the plugin's admin page.
if( ! function_exists( 'fcbk_bttn_plgn_settings_page' ) ) {
	function fcbk_bttn_plgn_settings_page() 
	{
		global $fcbk_bttn_plgn_options_array;
		$copy = false;
		
		if( @copy( plugin_dir_path( __FILE__ )."img/facebook-ico.jpg", plugin_dir_path( __FILE__ )."img/facebook-ico3.jpg" ) !== false )
			$copy = true;

		$message = "";
		$error = "";
		if( isset( $_REQUEST['fcbk_bttn_plgn_form_submit'] ) && check_admin_referer( plugin_basename(__FILE__), 'fcbk_bttn_plgn_nonce_name' ) ) {
			// Takes all the changed settings on the plugin's admin page and saves them in array 'fcbk_bttn_plgn_options_array'.
			if ( isset ( $_REQUEST['fcbk_bttn_plgn_where'] ) && isset ( $_REQUEST['fcbk_bttn_plgn_link'] ) && isset ( $_REQUEST['fcbk_bttn_plgn_display_option'] ) )	{				
				$fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_link' ]			=	$_REQUEST [ 'fcbk_bttn_plgn_link' ];
				$fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_where' ]		=	$_REQUEST [ 'fcbk_bttn_plgn_where' ];
				$fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_display_option' ]	=	$_REQUEST [ 'fcbk_bttn_plgn_display_option' ];
				$fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_my_page' ]	=	isset( $_REQUEST [ 'fcbk_bttn_plgn_my_page' ] ) ? 1 : 0 ;
				$fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_like' ]			=	isset( $_REQUEST [ 'fcbk_bttn_plgn_like' ] ) ? 1 : 0 ;
				if ( isset ( $_FILES [ 'uploadfile' ] [ 'tmp_name' ] ) &&  $_FILES [ 'uploadfile' ] [ 'tmp_name' ] != "" ) {		
					$fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_count_icon' ]	=	$fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_count_icon' ] + 1;
				}
				$fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ]		=	$_REQUEST [ 'fcbk_bttn_plgn_locale' ];

				if($fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_count_icon' ] > 2)
					$fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_count_icon' ] = 1;
				update_option	( 'fcbk_bttn_plgn_options_array', $fcbk_bttn_plgn_options_array );
				$message = __( "Settings saved", 'facebook' );
			}
			// Form options
			if ( isset ( $_FILES [ 'uploadfile' ] [ 'tmp_name' ] ) &&  $_FILES [ 'uploadfile' ] [ 'tmp_name' ] != "" ) {		
				$max_image_width	=	100;
				$max_image_height	=	40;
				$max_image_size		=	32 * 1024;
				$valid_types 		=	array( 'jpg', 'jpeg' );
				// Construction to rename downloading file
				$new_name			=	'facebook-ico'.$fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_count_icon' ]; 
				$new_ext			=	'.jpg';
				$namefile			=	$new_name.$new_ext;
				$uploaddir			=	$_REQUEST [ 'home' ] . 'wp-content/plugins/facebook-button-plugin/img/'; // The directory in which we will take the file:
				$uploadfile			=	$uploaddir.$namefile; 

				//checks is file download initiated by user
				if ( isset ( $_FILES [ 'uploadfile' ] ) && $_REQUEST [ 'fcbk_bttn_plgn_display_option' ] == 'custom' )	{		
					//Checking is allowed download file given parameters
					if ( is_uploaded_file( $_FILES [ 'uploadfile' ] [ 'tmp_name' ] ) ) {	
						$filename	=	$_FILES [ 'uploadfile' ] [ 'tmp_name' ];
						$ext		=	substr ( $_FILES [ 'uploadfile' ] [ 'name' ], 1 + strrpos( $_FILES [ 'uploadfile' ] [ 'name' ], '.' ) );		
						if ( filesize ( $filename ) > $max_image_size ) {
							$error = __( "Error: File size > 32K", 'facebook' );
						} 
						elseif ( ! in_array ( $ext, $valid_types ) ) { 
							$error = __( "Error: Invalid file type", 'facebook' );
						} 
						else {
							$size = GetImageSize ( $filename );
							if ( ( $size ) && ( $size[0] <= $max_image_width ) && ( $size[1] <= $max_image_height ) ) {
								//If file satisfies requirements, we will move them from temp to your plugin folder and rename to 'facebook_ico.jpg'
								if (move_uploaded_file ( $_FILES [ 'uploadfile' ] [ 'tmp_name' ], $uploadfile ) ) { 
									$message .= " Upload successful.";
								} 
								else { 
									$error = __( "Error: moving file failed", 'facebook' );
								}
							} 
							else { 
								$error = __( "Error: check image width or height", 'facebook' );
							}
						}
					} 
					else { 
						$error = __( "Uploading Error: check image properties", 'facebook' );
					}	
				}
			}
			fcbk_bttn_plgn_update_option();
	} 
		?>
	<div class="wrap">
		<div class="icon32 icon32-bws" id="icon-options-general"></div>
		<h2><?php echo __( "Facebook Button Settings", 'facebook' ); ?></h2>
		<div class="updated fade" <?php if( ! isset( $_REQUEST['fcbk_bttn_plgn_form_submit'] ) || $error != "" ) echo "style=\"display:none\""; ?>><p><strong><?php echo $message; ?></strong></p></div>
		<div class="error" <?php if( "" == $error ) echo "style=\"display:none\""; ?>><p><strong><?php echo $error; ?></strong></p></div>
		<div>
			<form name="form1" method="post" action="admin.php?page=facebook-button-plugin.php" enctype="multipart/form-data" >
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php _e( "Your Facebook ID:", 'facebook' ); ?></th>
						<td>
							<input name='fcbk_bttn_plgn_link' type='text' value='<?php echo $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_link' ] ?>' style="width:200px;" />		
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e( "Display button:", 'facebook' ); ?></th>
						<td>
							<input name='fcbk_bttn_plgn_my_page' type='checkbox' value='1' <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_my_page' ] == 1 ) echo 'checked="checked "'; ?>/> <label for="fcbk_bttn_plgn_my_page"><?php echo __( "My Page", 'captcha' ); ?></label><br />
							<input name='fcbk_bttn_plgn_like' type='checkbox' value='1' <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_like' ] == 1 ) echo 'checked="checked "'; ?>/> <label for="fcbk_bttn_plgn_like"><?php echo __( "Like", 'captcha' ); ?></label><br />
						</td>
					</tr>
					<tr>
						<th>
							<?php echo __( "Choose display settings:", 'facebook' ); ?>
						</th>
						<td>
							<select name="fcbk_bttn_plgn_display_option" onchange="if ( this . value == 'custom' ) { getElementById ( 'fcbk_bttn_plgn_display_option_custom' ) . style.display = 'block'; } else { getElementById ( 'fcbk_bttn_plgn_display_option_custom' ) . style.display = 'none'; }" style="width:200px;" >
								<option <?php if ( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_display_option' ] == 'standart' ) echo 'selected="selected"'; ?> value="standart"><?php echo __( "Standard Facebook image", 'facebook' ); ?></option>
								<?php if( $copy || $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_display_option' ] == 'custom' ) { ?>
								<option <?php if ( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_display_option' ] == 'custom' ) echo 'selected="selected"'; ?> value="custom"><?php echo __( "Custom Facebook image", 'facebook' ); ?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<th>
							<?php echo __( "Current image:", 'facebook' ); ?>
						</th>
						<td>
							<img src="<?php echo $fcbk_bttn_plgn_options_array [ 'fb_img_link' ]; ?>" style="margin-left:2px;" />
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<div id="fcbk_bttn_plgn_display_option_custom" <?php if ( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_display_option' ] == 'custom' ) { echo ( 'style="display:block"' ); } else {echo ( 'style="display:none"' ); }?>>
								<table>
									<th style="padding-left:0px;font-size:13px;">
										<input type="hidden" name="MAX_FILE_SIZE" value="64000"/>
										<input type="hidden" name="home" value="<?php echo ABSPATH ; ?>"/>
										<?php echo __( "Facebook image:", 'facebook' ); ?>
									</th>
									<td>
										<input name="uploadfile" type="file" style="width:196px;" /><br />
										<span style="color: rgb(136, 136, 136); font-size: 10px;"><?php echo __( 'Image properties: max image width:100px; max image height:40px; max image size:32Kb; image types:"jpg", "jpeg".', 'facebook' ); ?></span>	
									</td>
								</table>											
							</div>
						</td>
					</tr>
					<tr>
						<th>
							<?php echo __( "Facebook Button Position:", 'facebook' ); ?>
						</th>
						<td>
							<select name="fcbk_bttn_plgn_where" onchange="if ( this . value == 'shortcode' ) { getElementById ( 'shortcode' ) . style.display = 'inline'; } else { getElementById ( 'shortcode' ) . style.display = 'none'; }" style="width:200px;" >
								<option <?php if ( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_where' ] == 'before' ) echo 'selected="selected"'; ?> value="before"><?php echo __( "Before", 'facebook' ); ?></option>
								<option <?php if ( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_where' ] == 'after' ) echo 'selected="selected"'; ?> value="after"><?php echo __( "After", 'facebook' ); ?></option>
								<option <?php if ( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_where' ] == 'beforeandafter' ) echo 'selected="selected"'; ?> value="beforeandafter"><?php echo __( "Before and After", 'facebook' ); ?></option>
								<option <?php if ( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_where' ] == 'shortcode') echo 'selected="selected"'; ?> value="shortcode"><?php echo __( "Shortcode", 'facebook' ); ?></option>
							</select>
							<span id="shortcode" style="color: rgb(136, 136, 136); font-size: 10px; <?php if ( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_where' ] == 'shortcode' ) { echo ( 'display:inline' ); } else { echo ( 'display:none' ); }?>"><?php echo __( "If you would like to add a Facebook button to your website, just copy and paste this shortcode into your post or page:", 'facebook' ); ?> [fb_button].</span>
						</td>
					</tr>
					<tr>
						<th>
							<?php echo __( "Facebook Button language:", 'facebook' ); ?>
						</th>
						<td>
							<select name="fcbk_bttn_plgn_locale">
								<option value="af_ZA" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "af_ZA" ) echo 'selected="selected"'; ?>>Afrikaans</option>
								<option value="ar_AR" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "ar_AR" ) echo 'selected="selected"'; ?>>العربية</option>
								<option value="ay_BO" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "ay_BO" ) echo 'selected="selected"'; ?>>Aymar aru</option>
								<option value="az_AZ" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "az_AZ" ) echo 'selected="selected"'; ?>>Azərbaycan dili</option>
								<option value="be_BY" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "be_BY" ) echo 'selected="selected"'; ?>>Беларуская</option>
								<option value="bg_BG" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "bg_BG" ) echo 'selected="selected"'; ?>>Български</option>
								<option value="bn_IN" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "bn_IN" ) echo 'selected="selected"'; ?>>বাংলা</option>
								<option value="bs_BA" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "bs_BA" ) echo 'selected="selected"'; ?>>Bosanski</option>
								<option value="ca_ES" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "ca_ES" ) echo 'selected="selected"'; ?>>Català</option>
								<option value="ck_US" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "ck_US" ) echo 'selected="selected"'; ?>>Cherokee</option>
								<option value="cs_CZ" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "cs_CZ" ) echo 'selected="selected"'; ?>>Čeština</option>
								<option value="cy_GB" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "cy_GB" ) echo 'selected="selected"'; ?>>Cymraeg</option>
								<option value="da_DK" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "da_DK" ) echo 'selected="selected"'; ?>>Dansk</option>
								<option value="de_DE" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "de_DE" ) echo 'selected="selected"'; ?>>Deutsch</option>
								<option value="el_GR" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "el_GR" ) echo 'selected="selected"'; ?>>Ελληνικά</option>
								<option value="en_US" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "en_US" ) echo 'selected="selected"'; ?>>English</option>
								<option value="en_PI" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "en_PI" ) echo 'selected="selected"'; ?>>English (Pirate)</option>
								<option value="eo_EO" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "eo_EO" ) echo 'selected="selected"'; ?>>Esperanto</option>
								<option value="es_CL" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "es_CL" ) echo 'selected="selected"'; ?>>Español (Chile)</option>
								<option value="es_CO" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "es_CO" ) echo 'selected="selected"'; ?>>Español (Colombia)</option>
								<option value="es_ES" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "es_ES" ) echo 'selected="selected"'; ?>>Español (España)</option>
								<option value="es_LA" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "es_LA" ) echo 'selected="selected"'; ?>>Español</option>
								<option value="es_MX" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "es_MX" ) echo 'selected="selected"'; ?>>Español (México)</option>
								<option value="es_VE" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "es_VE" ) echo 'selected="selected"'; ?>>Español (Venezuela)</option>
								<option value="et_EE" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "et_EE" ) echo 'selected="selected"'; ?>>Eesti</option>
								<option value="eu_ES" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "eu_ES" ) echo 'selected="selected"'; ?>>Euskara</option>
								<option value="fa_IR" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "fa_IR" ) echo 'selected="selected"'; ?>>فارسی</option>
								<option value="fb_LT" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "fb_LT" ) echo 'selected="selected"'; ?>>Leet Speak</option>
								<option value="fi_FI" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "fi_FI" ) echo 'selected="selected"'; ?>>Suomi</option>
								<option value="fo_FO" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "fo_FO" ) echo 'selected="selected"'; ?>>Føroyskt</option>
								<option value="fr_CA" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "fr_CA" ) echo 'selected="selected"'; ?>>Français (Canada)</option>
								<option value="fr_FR" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "fr_FR" ) echo 'selected="selected"'; ?>>Français (France)</option>
								<option value="fy_NL" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "fy_NL" ) echo 'selected="selected"'; ?>>Frysk</option>
								<option value="ga_IE" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "ga_IE" ) echo 'selected="selected"'; ?>>Gaeilge</option>
								<option value="gl_ES" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "gl_ES" ) echo 'selected="selected"'; ?>>Galego</option>
								<option value="gn_PY" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "gn_PY" ) echo 'selected="selected"'; ?>>Avañe'ẽ</option>
								<option value="gu_IN" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "gu_IN" ) echo 'selected="selected"'; ?>>ગુજરાતી</option>
								<option value="gx_GR" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "gx_GR" ) echo 'selected="selected"'; ?>>Ἑλληνική ἀρχαία</option>
								<option value="he_IL" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "he_IL" ) echo 'selected="selected"'; ?>>עברית</option>
								<option value="hi_IN" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "hi_IN" ) echo 'selected="selected"'; ?>>हिन्दी</option>
								<option value="hr_HR" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "hr_HR" ) echo 'selected="selected"'; ?>>Hrvatski</option>
								<option value="hu_HU" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "hu_HU" ) echo 'selected="selected"'; ?>>Magyar</option>
								<option value="hy_AM" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "hy_AM" ) echo 'selected="selected"'; ?>>Հայերեն</option>
								<option value="id_ID" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "id_ID" ) echo 'selected="selected"'; ?>>Bahasa Indonesia</option>
								<option value="is_IS" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "is_IS" ) echo 'selected="selected"'; ?>>Íslenska</option>
								<option value="it_IT" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "it_IT" ) echo 'selected="selected"'; ?>>Italiano</option>
								<option value="ja_JP" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "ja_JP" ) echo 'selected="selected"'; ?>>日本語</option>
								<option value="jv_ID" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "jv_ID" ) echo 'selected="selected"'; ?>>Basa Jawa</option>
								<option value="ka_GE" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "ka_GE" ) echo 'selected="selected"'; ?>>ქართული</option>
								<option value="kk_KZ" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "kk_KZ" ) echo 'selected="selected"'; ?>>Қазақша</option>
								<option value="km_KH" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "km_KH" ) echo 'selected="selected"'; ?>>ភាសាខ្មែរ</option>
								<option value="kn_IN" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "kn_IN" ) echo 'selected="selected"'; ?>>ಕನ್ನಡ</option>
								<option value="ko_KR" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "ko_KR" ) echo 'selected="selected"'; ?>>한국어</option>
								<option value="ku_TR" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "ku_TR" ) echo 'selected="selected"'; ?>>Kurdî</option>
								<option value="la_VA" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "la_VA" ) echo 'selected="selected"'; ?>>lingua latina</option>
								<option value="li_NL" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "li_NL" ) echo 'selected="selected"'; ?>>Limburgs</option>
								<option value="lt_LT" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "lt_LT" ) echo 'selected="selected"'; ?>>Lietuvių</option>
								<option value="lv_LV" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "lv_LV" ) echo 'selected="selected"'; ?>>Latviešu</option>
								<option value="mg_MG" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "mg_MG" ) echo 'selected="selected"'; ?>>Malagasy</option>
								<option value="mk_MK" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "mk_MK" ) echo 'selected="selected"'; ?>>Македонски</option>
								<option value="ml_IN" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "ml_IN" ) echo 'selected="selected"'; ?>>മലയാളം</option>
								<option value="mn_MN" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "mn_MN" ) echo 'selected="selected"'; ?>>Монгол</option>
								<option value="mr_IN" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "mr_IN" ) echo 'selected="selected"'; ?>>मराठी</option>
								<option value="ms_MY" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "ms_MY" ) echo 'selected="selected"'; ?>>Bahasa Melayu</option>
								<option value="mt_MT" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "mt_MT" ) echo 'selected="selected"'; ?>>Malti</option>
								<option value="nb_NO" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "nb_NO" ) echo 'selected="selected"'; ?>>Norsk (bokmål)</option>
								<option value="ne_NP" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "ne_NP" ) echo 'selected="selected"'; ?>>नेपाली</option>
								<option value="nl_BE" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "nl_BE" ) echo 'selected="selected"'; ?>>Nederlands (België)</option>
								<option value="nl_NL" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "nl_NL" ) echo 'selected="selected"'; ?>>Nederlands</option>
								<option value="nn_NO" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "nn_NO" ) echo 'selected="selected"'; ?>>Norsk (nynorsk)</option>
								<option value="pa_IN" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "pa_IN" ) echo 'selected="selected"'; ?>>ਪੰਜਾਬੀ</option>
								<option value="pl_PL" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "pl_PL" ) echo 'selected="selected"'; ?>>Polski</option>
								<option value="ps_AF" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "ps_AF" ) echo 'selected="selected"'; ?>>پښتو</option>
								<option value="pt_BR" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "pt_BR" ) echo 'selected="selected"'; ?>>Português (Brasil)</option>
								<option value="pt_PT" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "pt_PT" ) echo 'selected="selected"'; ?>>Português (Portugal)</option>
								<option value="qu_PE" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "qu_PE" ) echo 'selected="selected"'; ?>>Qhichwa</option>
								<option value="rm_CH" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "rm_CH" ) echo 'selected="selected"'; ?>>Rumantsch</option>
								<option value="ro_RO" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "ro_RO" ) echo 'selected="selected"'; ?>>Română</option>
								<option value="ru_RU" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "ru_RU" ) echo 'selected="selected"'; ?>>Русский</option>
								<option value="sa_IN" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "sa_IN" ) echo 'selected="selected"'; ?>>संस्कृतम्</option>
								<option value="se_NO" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "se_NO" ) echo 'selected="selected"'; ?>>Davvisámegiella</option>
								<option value="sk_SK" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "sk_SK" ) echo 'selected="selected"'; ?>>Slovenčina</option>
								<option value="sl_SI" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "sl_SI" ) echo 'selected="selected"'; ?>>Slovenščina</option>
								<option value="so_SO" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "so_SO" ) echo 'selected="selected"'; ?>>Soomaaliga</option>
								<option value="sq_AL" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "sq_AL" ) echo 'selected="selected"'; ?>>Shqip</option>
								<option value="sr_RS" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "sr_RS" ) echo 'selected="selected"'; ?>>Српски</option>
								<option value="sv_SE" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "sv_SE" ) echo 'selected="selected"'; ?>>Svenska</option>
								<option value="sw_KE" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "sw_KE" ) echo 'selected="selected"'; ?>>Kiswahili</option>
								<option value="sy_SY" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "sy_SY" ) echo 'selected="selected"'; ?>>ܐܪܡܝܐ</option>
								<option value="ta_IN" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "ta_IN" ) echo 'selected="selected"'; ?>>தமிழ்</option>
								<option value="te_IN" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "te_IN" ) echo 'selected="selected"'; ?>>తెలుగు</option>
								<option value="tg_TJ" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "tg_TJ" ) echo 'selected="selected"'; ?>>тоҷикӣ</option>
								<option value="th_TH" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "th_TH" ) echo 'selected="selected"'; ?>>ภาษาไทย</option>
								<option value="tl_PH" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "tl_PH" ) echo 'selected="selected"'; ?>>Filipino</option>
								<option value="tl_ST" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "tl_ST" ) echo 'selected="selected"'; ?>>tlhIngan-Hol</option>
								<option value="tr_TR" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "tr_TR" ) echo 'selected="selected"'; ?>>Türkçe</option>
								<option value="tt_RU" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "tt_RU" ) echo 'selected="selected"'; ?>>Татарча</option>
								<option value="uk_UA" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "uk_UA" ) echo 'selected="selected"'; ?>>Українська</option>
								<option value="ur_PK" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "ur_PK" ) echo 'selected="selected"'; ?>>اردو</option>
								<option value="uz_UZ" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "uz_UZ" ) echo 'selected="selected"'; ?>>O'zbek</option>
								<option value="vi_VN" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "vi_VN" ) echo 'selected="selected"'; ?>>Tiếng Việt</option>
								<option value="yi_DE" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "yi_DE" ) echo 'selected="selected"'; ?>>ייִדיש</option>
								<option value="zh_CN" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "zh_CN" ) echo 'selected="selected"'; ?>>中文(简体)</option>
								<option value="zh_HK" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "zh_HK" ) echo 'selected="selected"'; ?>>中文(香港)</option>
								<option value="zh_TW" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "zh_TW" ) echo 'selected="selected"'; ?>>中文(台灣)</option>
								<option value="zu_ZA" <?php if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ] == "zu_ZA" ) echo 'selected="selected"'; ?>>isiZulu</option>
								</select>
								<span id="shortcode" style="color: rgb(136, 136, 136); font-size: 10px; display:inline"><?php echo __( "Change the language of Facebook Like Button", 'facebook' ); ?></span>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<input type="hidden" name="fcbk_bttn_plgn_form_submit" value="submit" />
							<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
						</td>
					</tr>
				</table>
				<?php wp_nonce_field( plugin_basename(__FILE__), 'fcbk_bttn_plgn_nonce_name' ); ?>
			</form>
		</div>
	</div>

	<?php
	}
}

//Function 'facebook_fcbk_bttn_plgn_display_option' reacts to changes type of picture (Standard or Custom) and generates link to image, link transferred to array 'fcbk_bttn_plgn_options_array'
if( ! function_exists( 'fcbk_bttn_plgn_update_option' ) ) {
	function fcbk_bttn_plgn_update_option () {
		global $fcbk_bttn_plgn_options_array;
		if ( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_display_option' ] == 'standart' ){
			$fb_img_link	=	plugins_url( 'img/standart-facebook-ico.jpg', __FILE__ );
		} else if ( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_display_option' ] == 'custom'){
			$fb_img_link	=	plugins_url( 'img/facebook-ico'.$fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_count_icon' ].'.jpg', __FILE__ );
		}
		$fcbk_bttn_plgn_options_array [ 'fb_img_link' ]	=	$fb_img_link ;
		update_option( "fcbk_bttn_plgn_options_array", $fcbk_bttn_plgn_options_array );
	}
}

//Function 'facebook_button' taking from array 'fcbk_bttn_plgn_options_array' necessary information to create Facebook Button and reacting to your choise in plugin menu - points where it appears.
if( ! function_exists( 'fcbk_bttn_plgn_display_button' ) ) {
	function fcbk_bttn_plgn_display_button ( $content ) {
		global $post;
		//Query the database to receive array 'fcbk_bttn_plgn_options_array' and receiving necessary information to create button
		$fcbk_bttn_plgn_options_array	=	get_option ( 'fcbk_bttn_plgn_options_array' );
		$fcbk_bttn_plgn_where			=	$fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_where' ];
		$img				=	$fcbk_bttn_plgn_options_array [ 'fb_img_link' ];
		$url				=	$fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_link' ];	
		$permalink_post		=	get_permalink ( $post->ID );
		//Button
		$button				=	'<div id="fcbk_share">';
		if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_my_page' ] == 1 ) {
			$button .=	'<div class="fcbk_button">
										<a name="fcbk_share"	href="http://www.facebook.com/' . $url . '"	target="blank">
											<img src="' . $img . '" alt="Fb-Button" />
										</a>	
									</div>';
		}
		if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_like' ] == 1 ) {
			$button .=	'<div class="fcbk_like">
										<div id="fb-root"></div>
										<script src="http://connect.facebook.net/'.$fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_locale' ].'/all.js#appId=224313110927811&amp;xfbml=1"></script>
										<fb:like href="' . $permalink_post . '" send="false" layout="button_count" width="450" show_faces="false" font=""></fb:like>
									</div>';
		}				
		
		$button .= '</div>';
		//Indication where show Facebook Button depending on selected item in admin page.
		if ( $fcbk_bttn_plgn_where == 'before' ) {
			return $button . $content; 
		} else if ( $fcbk_bttn_plgn_where == 'after' ) {		
			return $content . $button;
		} else if ( $fcbk_bttn_plgn_where == 'beforeandafter' ) {		
			return $button . $content . $button;
		} else if ( $fcbk_bttn_plgn_where == 'shortcode' ) {
			return $content;		
		} else {
			return $content;		
		}
	}
}

//Function 'fcbk_bttn_plgn_shortcode' are using to create shortcode by Facebook Button.
if( ! function_exists( 'fcbk_bttn_plgn_shortcode' ) ) {
	function fcbk_bttn_plgn_shortcode( $content ) {
		$fcbk_bttn_plgn_options_array	=	get_option ( 'fcbk_bttn_plgn_options_array' );
		$fcbk_bttn_plgn_where			=	$fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_where' ];	
		$img				=	$fcbk_bttn_plgn_options_array [ 'fb_img_link' ];
		$url				=	$fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_link' ];	
		$permalink_post		=	get_permalink ( $post_ID );
		$button				=	'<div id="fcbk_share">';
		if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_my_page' ] == 1 ) {
			$button .=	'<div class="fcbk_button">
										<a name="fcbk_share"	href="http://www.facebook.com/' . $url . '"	target="blank">
											<img src="' . $img . '" alt="Fb-Button" />
										</a>	
									</div>';
		}
		if( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_like' ] == 1 ) {
			$button .=	'<div class="fcbk_like">
										<div id="fb-root"></div>
										<script src="http://connect.facebook.net/en_US/all.js#appId=224313110927811&amp;xfbml=1"></script>
										<fb:like href="' . $permalink_post . '" send="false" layout="button_count" width="450" show_faces="false" font=""></fb:like>
									</div>';
		}				
		
		$button .= '</div>';		 
		return $button;	
	}
}

//Function 'fcbk_bttn_plgn_action_links' are using to create action links on admin page.
if( ! function_exists( 'fcbk_bttn_plgn_action_links' ) ) {
	function fcbk_bttn_plgn_action_links( $links, $file ) {
			//Static so we don't call plugin_basename on every plugin row.
		static $this_plugin;
		if ( ! $this_plugin ) $this_plugin = plugin_basename(__FILE__);

		if ( $file == $this_plugin ){
				 $settings_link = '<a href="admin.php?page=facebook-button-plugin.php">' . __( 'Settings', 'facebook' ) . '</a>';
				 array_unshift( $links, $settings_link );
			}
		return $links;
	}
} // end function fcbk_bttn_plgn_action_links

//Function 'fcbk_bttn_plgn_links' are using to create other links on admin page.
if ( ! function_exists ( 'fcbk_bttn_plgn_links' ) ) {
	function fcbk_bttn_plgn_links($links, $file) {
		$base = plugin_basename(__FILE__);
		if ($file == $base) {
			$links[] = '<a href="admin.php?page=facebook-button-plugin.php">' . __( 'Settings','facebook' ) . '</a>';
			$links[] = '<a href="http://wordpress.org/extend/plugins/facebook-button-plugin/faq/" target="_blank">' . __( 'FAQ','facebook' ) . '</a>';
			$links[] = '<a href="http://support.bestwebsoft.com">' . __( 'Support','facebook' ) . '</a>';
		}
		return $links;
	}
} // end function fcbk_bttn_plgn_links

//Function '_plugin_init' are using to add language files.
if ( ! function_exists ( 'fcbk_plugin_init' ) ) {
	function fcbk_plugin_init() {
		load_plugin_textdomain( 'facebook', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 
	}
} // end function fcbk_plugin_init


if ( ! function_exists ( 'fcbk_admin_head' ) ) {
	function fcbk_admin_head() {
		wp_register_style( 'fcbkStylesheet', plugins_url( 'css/style.css', __FILE__ ) );
		wp_enqueue_style( 'fcbkStylesheet' );

		if ( isset( $_GET['page'] ) && $_GET['page'] == "bws_plugins" )
			wp_enqueue_script( 'bws_menu_script', plugins_url( 'js/bws_menu.js' , __FILE__ ) );
	}
}

// Function for delete options 
if ( ! function_exists ( 'fcbk_delete_options' ) ) {
	function fcbk_delete_options() {
		global $wpdb;
		delete_option( 'fcbk_bttn_plgn_options_array' );
	}
}

//Add language files
add_action( 'init', 'fcbk_plugin_init' );

add_action( 'wp_enqueue_scripts', 'fcbk_admin_head' );
add_action( 'admin_enqueue_scripts', 'fcbk_admin_head' );

// adds "Settings" link to the plugin action page
add_filter( 'plugin_action_links', 'fcbk_bttn_plgn_action_links', 10, 2 );

//Additional links on the plugin page
add_filter( 'plugin_row_meta', 'fcbk_bttn_plgn_links', 10, 2 );

//Calling a function add administrative menu.
add_action( 'admin_menu', 'fcbk_bttn_plgn_add_pages' );

//Add shortcode.
add_shortcode( 'fb_button', 'fcbk_bttn_plgn_shortcode' );

//Add settings links.
add_filter( 'the_content', 'fcbk_bttn_plgn_display_button' );

register_uninstall_hook( __FILE__, 'fcbk_delete_options' );
?>