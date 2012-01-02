<?php
/*
Plugin Name: Facebook Button Plugin
Plugin URI:  http://bestwebsoft.com/plugin/
Description: Put Facebook Button in to your post.
Author: BestWebSoft
Version: 2.07
Author URI: http://bestwebsoft.com/
License: GPLv2 or later
*/

/*  Copyright 2011  BestWebSoft  ( plugin@bestwebsoft.com )

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

if( ! function_exists( 'bws_add_menu_render' ) ) {
	function bws_add_menu_render() {
		global $title;
		$active_plugins = get_option('active_plugins');
		$all_plugins = get_plugins();

		$array_activate = array();
		$array_install = array();
		$array_recomend = array();
		$count_activate = $count_install = $count_recomend = 0;
		$array_plugins	= array(
			array( 'captcha\/captcha.php', 'Captcha', 'http://wordpress.org/extend/plugins/captcha/', 'http://bestwebsoft.com/plugin/captcha-plugin/', '/wp-admin/plugin-install.php?tab=search&type=term&s=Captcha+bestwebsoft&plugin-search-input=Search+Plugins', 'admin.php?page=captcha.php' ), 
			array( 'contact-form-plugin\/contact_form.php', 'Contact Form', 'http://wordpress.org/extend/plugins/contact-form-plugin/', 'http://bestwebsoft.com/plugin/contact-form/', '/wp-admin/plugin-install.php?tab=search&type=term&s=Contact+Form+bestwebsoft&plugin-search-input=Search+Plugins', 'admin.php?page=contact_form.php' ), 
			array( 'facebook-button-plugin\/facebook-button-plugin.php', 'Facebook Like Button Plugin', 'http://wordpress.org/extend/plugins/facebook-button-plugin/', 'http://bestwebsoft.com/plugin/facebook-like-button-plugin/', '/wp-admin/plugin-install.php?tab=search&type=term&s=Facebook+Like+Button+Plugin+bestwebsoft&plugin-search-input=Search+Plugins', 'admin.php?page=facebook-button-plugin.php' ), 
			array( 'twitter-plugin\/twitter.php', 'Twitter Plugin', 'http://wordpress.org/extend/plugins/twitter-plugin/', 'http://bestwebsoft.com/plugin/twitter-plugin/', '/wp-admin/plugin-install.php?tab=search&type=term&s=Twitter+Plugin+bestwebsoft&plugin-search-input=Search+Plugins', 'admin.php?page=twitter.php' ), 
			array( 'portfolio\/portfolio.php', 'Portfolio', 'http://wordpress.org/extend/plugins/portfolio/', 'http://bestwebsoft.com/plugin/portfolio-plugin/', '/wp-admin/plugin-install.php?tab=search&type=term&s=Portfolio+bestwebsoft&plugin-search-input=Search+Plugins', '' ),
			array( 'gallery-plugin\/gallery-plugin.php', 'Gallery', 'http://wordpress.org/extend/plugins/gallery-plugin/', 'http://bestwebsoft.com/plugin/gallery-plugin/', '/wp-admin/plugin-install.php?tab=search&type=term&s=Gallery+Plugin+bestwebsoft&plugin-search-input=Search+Plugins', '' ),
			array( 'adsense-plugin\/adsense-plugin.php', 'Google AdSense Plugin', 'http://wordpress.org/extend/plugins/adsense-plugin/', 'http://bestwebsoft.com/plugin/google-adsense-plugin/', '/wp-admin/plugin-install.php?tab=search&type=term&s=Adsense+Plugin+bestwebsoft&plugin-search-input=Search+Plugins', 'admin.php?page=adsense-plugin.php' )
		);
		foreach($array_plugins as $plugins)
		{
			if( 0 < count( preg_grep( "/".$plugins[0]."/", $active_plugins ) ) )
			{
				$array_activate[$count_activate]['title'] = $plugins[1];
				$array_activate[$count_activate]['link']	= $plugins[2];
				$array_activate[$count_activate]['href']	= $plugins[3];
				$array_activate[$count_activate]['url']	= $plugins[5];
				$count_activate++;
			}
			else if( array_key_exists(str_replace("\\", "", $plugins[0]), $all_plugins) )
			{
				$array_install[$count_install]['title'] = $plugins[1];
				$array_install[$count_install]['link']	= $plugins[2];
				$array_install[$count_install]['href']	= $plugins[3];
				$count_install++;
			}
			else
			{
				$array_recomend[$count_recomend]['title'] = $plugins[1];
				$array_recomend[$count_recomend]['link']	= $plugins[2];
				$array_recomend[$count_recomend]['href']	= $plugins[3];
				$array_recomend[$count_recomend]['slug']	= $plugins[4];
				$count_recomend++;
			}
		}
		?>
		<div class="wrap">
			<div class="icon32 icon32-bws" id="icon-options-general"></div>
			<h2><?php echo $title;?></h2>
			<?php if( 0 < $count_activate ) { ?>
			<div>
				<h3><?php _e( 'Activated plugins', 'facebook' ); ?></h3>
				<?php foreach( $array_activate as $activate_plugin ) { ?>
				<div style="float:left; width:200px;"><?php echo $activate_plugin['title']; ?></div> <p><a href="<?php echo $activate_plugin['link']; ?>" target="_blank"><?php echo __( "Read more", 'facebook'); ?></a> <a href="<?php echo $activate_plugin['url']; ?>"><?php echo __( "Settings", 'facebook'); ?></a></p>
				<?php } ?>
			</div>
			<?php } ?>
			<?php if( 0 < $count_install ) { ?>
			<div>
				<h3><?php _e( 'Installed plugins', 'facebook' ); ?></h3>
				<?php foreach($array_install as $install_plugin) { ?>
				<div style="float:left; width:200px;"><?php echo $install_plugin['title']; ?></div> <p><a href="<?php echo $install_plugin['link']; ?>" target="_blank"><?php echo __( "Read more", 'facebook'); ?></a></p>
				<?php } ?>
			</div>
			<?php } ?>
			<?php if( 0 < $count_recomend ) { ?>
			<div>
				<h3><?php _e( 'Recommended plugins', 'facebook' ); ?></h3>
				<?php foreach( $array_recomend as $recomend_plugin ) { ?>
				<div style="float:left; width:200px;"><?php echo $recomend_plugin['title']; ?></div> <p><a href="<?php echo $recomend_plugin['link']; ?>" target="_blank"><?php echo __( "Read more", 'facebook'); ?></a> <a href="<?php echo $recomend_plugin['href']; ?>" target="_blank"><?php echo __( "Download", 'facebook'); ?></a> <a class="install-now" href="<?php echo get_bloginfo( "url" ) . $recomend_plugin['slug']; ?>" title="<?php esc_attr( sprintf( __( 'Install %s' ), $recomend_plugin['title'] ) ) ?>"><?php echo __( 'Install now from wordpress.org', 'facebook' ) ?></a></p>
				<?php } ?>
				<span style="color: rgb(136, 136, 136); font-size: 10px;"><?php _e( 'If you have any questions, please contact us via plugin@bestwebsoft.com or fill in our contact form on our site', 'facebook' ); ?> <a href="http://bestwebsoft.com/contact/">http://bestwebsoft.com/contact/</a></span>
			</div>
			<?php } ?>
		</div>
		<?php
	}
}

if( ! function_exists( 'bws_plugin_header' ) ) {
	function bws_plugin_header() {
		global $post_type;
		?>
		<style>
		#adminmenu #toplevel_page_bws_plugins div.wp-menu-image
		{
			background: url("<?php echo get_bloginfo('url');?>/wp-content/plugins/facebook-button-plugin/img/icon_16.png") no-repeat scroll center center transparent;
		}
		#adminmenu #toplevel_page_bws_plugins:hover div.wp-menu-image,#adminmenu #toplevel_page_bws_plugins.wp-has-current-submenu div.wp-menu-image
		{
			background: url("<?php echo get_bloginfo('url');?>/wp-content/plugins/facebook-button-plugin/img/icon_16_c.png") no-repeat scroll center center transparent;
		}	
		.wrap #icon-options-general.icon32-bws
		{
			background: url("<?php echo get_bloginfo('url');?>/wp-content/plugins/facebook-button-plugin/img/icon_36.png") no-repeat scroll left top transparent;
		}
		#toplevel_page_bws_plugins .wp-submenu .wp-first-item
		{
			display:none;
		}
		</style>
		<?php
	}
}

if( ! function_exists( 'fcbk_bttn_plgn_add_pages' ) ) {
	function fcbk_bttn_plgn_add_pages() {
		add_menu_page( 'BWS Plugins', 'BWS Plugins', 'manage_options', 'bws_plugins', 'bws_add_menu_render', plugins_url( "img/px.png", __FILE__ ), 1001); 
		add_submenu_page( 'bws_plugins', __( 'FaceBook Button Options', 'facebook' ), __( 'FaceBook Button', 'facebook' ), 'manage_options', "facebook-button-plugin.php", 'fcbk_bttn_plgn_settings_page');

		//call register settings function
		add_action( 'admin_init', 'fcbk_bttn_plgn_settings' );
	}
}

if( ! function_exists( 'fcbk_bttn_plgn_settings' ) ) {
	function fcbk_bttn_plgn_settings() {
		global $fcbk_bttn_plgn_options_array;

		$fcbk_bttn_plgn_options_array_default = array(
			'fcbk_bttn_plgn_link'						=> '',
			'fcbk_bttn_plgn_where'					=> '',
			'fcbk_bttn_plgn_display_option' => '',
			'fcbk_bttn_plgn_count_icon'			=> 1,
			'fb_img_link'										=>  plugins_url( "img/standart-facebook-ico.jpg", __FILE__ )
		);

		if( ! get_option( 'fcbk_bttn_plgn_options_array' ) )
			add_option( 'fcbk_bttn_plgn_options_array', $fcbk_bttn_plgn_options_array_default, '', 'yes' );

		$fcbk_bttn_plgn_options_array = get_option( 'fcbk_bttn_plgn_options_array' );

		$fcbk_bttn_plgn_options_array = array_merge( $fcbk_bttn_plgn_options_array_default, $fcbk_bttn_plgn_options_array );
	}
}

//Function formed content of the plugin's admin page.
if( ! function_exists( 'fcbk_bttn_plgn_settings_page' ) ) {
	function fcbk_bttn_plgn_settings_page() 
	{
		global $fcbk_bttn_plgn_options_array;

		$message = "";
		$error = "";
		if( isset( $_REQUEST['fcbk_bttn_plgn_form_submit'] ) ) {
			// Takes all the changed settings on the plugin's admin page and saves them in array 'fcbk_bttn_plgn_options_array'.
			if ( isset ( $_REQUEST['fcbk_bttn_plgn_where'] ) && isset ( $_REQUEST['fcbk_bttn_plgn_link'] ) && isset ( $_REQUEST['fcbk_bttn_plgn_display_option'] ) )	{				
				$fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_link' ]			=	$_REQUEST [ 'fcbk_bttn_plgn_link' ];
				$fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_where' ]		=	$_REQUEST [ 'fcbk_bttn_plgn_where' ];
				$fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_display_option' ]	=	$_REQUEST [ 'fcbk_bttn_plgn_display_option' ];
				if ( isset ( $_FILES [ 'uploadfile' ] [ 'tmp_name' ] ) &&  $_FILES [ 'uploadfile' ] [ 'tmp_name' ] != "" ) {		
					$fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_count_icon' ]	=	$fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_count_icon' ] + 1;
				}
				if($fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_count_icon' ] > 2)
					$fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_count_icon' ] = 1;
				update_option	( 'fcbk_bttn_plgn_options_array', $fcbk_bttn_plgn_options_array );
				$message = __( "Options saved.", 'facebook' );
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
				fcbk_bttn_plgn_update_option();
			}
		} 
		?>
	<div class="wrap">
		<style>
		.wrap #icon-options-general.icon32-bws
		{
			 background: url("../wp-content/plugins/facebook-button-plugin/img/icon_36.png") no-repeat scroll left top transparent;
		}
		</style>
		<div class="icon32 icon32-bws" id="icon-options-general"></div>
		<h2><?php echo __( "FaceBook Button Options", 'facebook' ); ?></h2>
		<div class="updated fade" <?php if( ! isset( $_REQUEST['fcbk_bttn_plgn_form_submit'] ) || $error != "" ) echo "style=\"display:none\""; ?>><p><strong><?php echo $message; ?></strong></p></div>
		<div class="error" <?php if( "" == $error ) echo "style=\"display:none\""; ?>><p><strong><?php echo $error; ?></strong></p></div>
		<div>
			<form name="form1" method="post" action="admin.php?page=facebook-button-plugin.php" enctype="multipart/form-data" >
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php _e( "Your's FaceBook Id:", 'facebook' ); ?></th>
						<td>
							<input name='fcbk_bttn_plgn_link' type='text' value='<?php echo $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_link' ] ?>' style="width:200px;" />		
						</td>
					</tr>
					<tr>
						<th>
							<?php echo __( "Choose display option:", 'facebook' ); ?>
						</th>
						<td>
							<select name="fcbk_bttn_plgn_display_option" onchange="if ( this . value == 'custom' ) { getElementById ( 'fcbk_bttn_plgn_display_option_custom' ) . style.display = 'block'; } else { getElementById ( 'fcbk_bttn_plgn_display_option_custom' ) . style.display = 'none'; }" style="width:200px;" >
								<option <?php if ( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_display_option' ] == 'standart' ) echo 'selected="selected"'; ?> value="standart"><?php echo __( "Standart FaceBook image", 'facebook' ); ?></option>
								<option <?php if ( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_display_option' ] == 'custom' ) echo 'selected="selected"'; ?> value="custom"><?php echo __( "Custom FaceBook image", 'facebook' ); ?></option>
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
										<?php echo __( "FaceBook image:", 'facebook' ); ?>
									</th>
									<td>
										<input name="uploadfile" type="file" style="width:196px;" />
										<span style="color: rgb(136, 136, 136); font-size: 10px;"><?php echo __( 'Image properties: max image width:100px; max image height:40px; max image size:32Kb; image types:"jpg", "jpeg".', 'facebook' ); ?></span>	
									</td>
								</table>											
							</div>
						</td>
					</tr>
					<tr>
						<th>
							<?php echo __( "FaceBook Button Position:", 'facebook' ); ?>
						</th>
						<td>
							<select name="fcbk_bttn_plgn_where" onchange="if ( this . value == 'shortcode' ) { getElementById ( 'shortcode' ) . style.display = 'inline'; } else { getElementById ( 'shortcode' ) . style.display = 'none'; }" style="width:200px;" >
								<option <?php if ( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_where' ] == 'before' ) echo 'selected="selected"'; ?> value="before"><?php echo __( "Before", 'facebook' ); ?></option>
								<option <?php if ( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_where' ] == 'after' ) echo 'selected="selected"'; ?> value="after"><?php echo __( "After", 'facebook' ); ?></option>
								<option <?php if ( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_where' ] == 'beforeandafter' ) echo 'selected="selected"'; ?> value="beforeandafter"><?php echo __( "Before and After", 'facebook' ); ?></option>
								<option <?php if ( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_where' ] == 'shortcode ') echo 'selected="selected"'; ?> value="shortcode"><?php echo __( "Shortcode", 'facebook' ); ?></option>
							</select>
							<span id="shortcode" style="color: rgb(136, 136, 136); font-size: 10px; <?php if ( $fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_where' ] == 'shortcode' ) { echo ( 'display:inline' ); } else { echo ( 'display:none' ); }?>"><?php echo __( "If you would like to add a FaceBook button to your website, just copy and put this shortcode onto your post or page:", 'facebook' ); ?> [fb_button].</span>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<input type="hidden" name="fcbk_bttn_plgn_form_submit" value="submit" />
							<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
						</td>
					</tr>
				</table>		
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

//Function 'facebook_button' taking from array 'fcbk_bttn_plgn_options_array' necessary information to create FaceBook Button and reacting to your choise in plugin menu - points where it appears.
if( ! function_exists( 'fcbk_bttn_plgn_display_button' ) ) {
	function fcbk_bttn_plgn_display_button ( $content ) {
		//Query the database to receive array 'fcbk_bttn_plgn_options_array' and receiving necessary information to create button
		$fcbk_bttn_plgn_options_array	=	get_option ( 'fcbk_bttn_plgn_options_array' );
		$fcbk_bttn_plgn_where			=	$fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_where' ];
		$img				=	$fcbk_bttn_plgn_options_array [ 'fb_img_link' ];
		$url				=	$fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_link' ];	
		$permalink_post		=	get_permalink ( $post_ID );
		//Button
		$button				=	'<div id="fcbk_share">
									<div class="fcbk_button">
										<a name="fcbk_share"	href="http://www.facebook.com/' . $url . '"	target="blank">
											<img src="' . $img . '" alt="Fb-Button" />
										</a>	
									</div>
									<div class="fcbk_like">
										<div id="fb-root"></div>
										<script src="http://connect.facebook.net/en_US/all.js#appId=224313110927811&amp;xfbml=1"></script>
										<fb:like href="' . $permalink_post . '" send="false" layout="button_count" width="450" show_faces="false" font=""></fb:like>
									</div>					 
								</div>';
		//Indication where show FaceBook Button depending on selected item in admin page.
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

//Function 'fcbk_bttn_plgn_shortcode' are using to create shortcode by FaceBook Button.
if( ! function_exists( 'fcbk_bttn_plgn_shortcode' ) ) {
	function fcbk_bttn_plgn_shortcode( $content ) {
		$fcbk_bttn_plgn_options_array	=	get_option ( 'fcbk_bttn_plgn_options_array' );
		$fcbk_bttn_plgn_where			=	$fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_where' ];	
		$img				=	$fcbk_bttn_plgn_options_array [ 'fb_img_link' ];
		$url				=	$fcbk_bttn_plgn_options_array [ 'fcbk_bttn_plgn_link' ];	
		$permalink_post		=	get_permalink ( $post_ID );
		$button				= 	'<div id="fb_share" >
									<div style="float:left;margin-right:10px;" >
										<a name="fb_share"	href="http://www.facebook.com/'.$url.'"	target="blank">
											<img src="'.$img.'" alt="Fb-Button" />
										</a>
									</div>
									<div>
										<div id="fb-root"></div>
										<script src="http://connect.facebook.net/en_US/all.js#appId=224313110927811&amp;xfbml=1"></script>
										<fb:like href="'.$permalink_post.'" send="false" layout="button_count" width="400" show_faces="false" font=""></fb:like>
									</div>					 
								</div>';	
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
			$links[] = '<a href="Mailto:plugin@bestwebsoft.com">' . __( 'Support','facebook' ) . '</a>';
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
	}
}

//Add language files
add_action( 'init', 'fcbk_plugin_init' );

add_action( 'admin_head', 'bws_plugin_header');

add_action( 'init', 'fcbk_admin_head' );

// adds "Settings" link to the plugin action page
add_filter( 'plugin_action_links', 'fcbk_bttn_plgn_action_links',10,2);

//Additional links on the plugin page
add_filter( 'plugin_row_meta', 'fcbk_bttn_plgn_links',10,2);

//Calling a function add administrative menu.
add_action( 'admin_menu', 'fcbk_bttn_plgn_add_pages' );

//Add shortcode.
add_shortcode( 'fb_button', 'fcbk_bttn_plgn_shortcode' );

//Add settings links.
add_filter( 'the_content', 'fcbk_bttn_plgn_display_button' );

