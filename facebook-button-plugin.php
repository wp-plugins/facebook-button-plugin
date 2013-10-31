<?php
/*
Plugin Name: Facebook Button
Plugin URI: http://bestwebsoft.com/plugin/
Description: Put Facebook Button in to your post.
Author: BestWebSoft
Version: 2.24
Author URI: http://bestwebsoft.com/
License: GPLv2 or later
*/

/*  Copyright 2013  BestWebSoft  ( http://support.bestwebsoft.com )

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

require_once( dirname( __FILE__ ) . '/bws_menu/bws_menu.php' );

if ( ! function_exists( 'fcbk_bttn_plgn_add_pages' ) ) {
	function fcbk_bttn_plgn_add_pages() {
		add_menu_page( 'BWS Plugins', 'BWS Plugins', 'manage_options', 'bws_plugins', 'bws_add_menu_render', plugins_url( "img/px.png", __FILE__ ), 1001 );
		add_submenu_page( 'bws_plugins', __( 'Facebook Button Settings', 'facebook' ), __( 'Facebook Button', 'facebook' ), 'manage_options', "facebook-button-plugin.php", 'fcbk_bttn_plgn_settings_page' );

		/* Call register settings function */
		add_action( 'admin_init', 'fcbk_bttn_plgn_settings' );
	}
}

if ( ! function_exists( 'fcbk_bttn_plgn_settings' ) ) {
	function fcbk_bttn_plgn_settings() {
		global $wpmu, $fcbk_bttn_plgn_options_array;
		$fcbk_bttn_plgn_options_array_default = array(
			'fcbk_bttn_plgn_link'				=> '',
			'fcbk_bttn_plgn_my_page'			=> 1,
			'fcbk_bttn_plgn_like'				=> 1,
			'fcbk_bttn_plgn_where'				=> '',
			'fcbk_bttn_plgn_display_option' 	=> '',
			'fcbk_bttn_plgn_count_icon'			=> 1,
			'fb_img_link'						=>  plugins_url( "img/standart-facebook-ico.jpg", __FILE__ ),
			'fcbk_bttn_plgn_locale' 			=> 'en_US'
		);
		/* Install the option defaults */
		if ( 1 == $wpmu ) {
			if ( ! get_site_option( 'fcbk_bttn_plgn_options_array' ) ) {
				add_site_option( 'fcbk_bttn_plgn_options_array', $fcbk_bttn_plgn_options_array_default, '', 'yes' );
			}
		} else {
			if( ! get_option( 'fcbk_bttn_plgn_options_array' ) )
				add_option( 'fcbk_bttn_plgn_options_array', $fcbk_bttn_plgn_options_array_default, '', 'yes' );
		}
		/* Get options from the database */
		if ( 1 == $wpmu )
			$fcbk_bttn_plgn_options_array = get_site_option( 'fcbk_bttn_plgn_options_array' );
		else
			$fcbk_bttn_plgn_options_array = get_option( 'fcbk_bttn_plgn_options_array' );
		$fcbk_bttn_plgn_options_array = array_merge( $fcbk_bttn_plgn_options_array_default, $fcbk_bttn_plgn_options_array );
		update_option( 'fcbk_bttn_plgn_options_array', $fcbk_bttn_plgn_options_array );
	}
}

/* Function formed content of the plugin's admin page. */
if ( ! function_exists( 'fcbk_bttn_plgn_settings_page' ) ) {
	function fcbk_bttn_plgn_settings_page() {
		global $fcbk_bttn_plgn_options_array;
		$copy = false;
		
		if ( false !== @copy( plugin_dir_path( __FILE__ ) . "img/facebook-ico.jpg", plugin_dir_path( __FILE__ ) . "img/facebook-ico3.jpg" ) )
			$copy = true;

		$message	=	"";
		$error		=	"";
		if ( isset( $_REQUEST['fcbk_bttn_plgn_form_submit'] ) && check_admin_referer( plugin_basename( __FILE__ ), 'fcbk_bttn_plgn_nonce_name' ) ) {
			/* Takes all the changed settings on the plugin's admin page and saves them in array 'fcbk_bttn_plgn_options_array'. */
			if ( isset( $_REQUEST['fcbk_bttn_plgn_where'] ) && isset( $_REQUEST['fcbk_bttn_plgn_link'] ) && isset( $_REQUEST['fcbk_bttn_plgn_display_option'] ) ) {
				$fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_link']				=	$_REQUEST['fcbk_bttn_plgn_link'];
				$fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_where']				=	$_REQUEST['fcbk_bttn_plgn_where'];
				$fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_display_option']		=	$_REQUEST['fcbk_bttn_plgn_display_option'];
				$fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_my_page']				=	isset( $_REQUEST['fcbk_bttn_plgn_my_page'] ) ? 1 : 0 ;
				$fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_like']				=	isset( $_REQUEST['fcbk_bttn_plgn_like'] ) ? 1 : 0 ;
				$fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale']				=	$_REQUEST['fcbk_bttn_plgn_locale'];
				if ( isset( $_FILES['uploadfile']['tmp_name'] ) &&  $_FILES['uploadfile']['tmp_name'] != "" ) {
					$fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_count_icon']		=	$fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_count_icon'] + 1;
				}

				if ( 2 < $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_count_icon'] )
					$fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_count_icon'] = 1;
				update_option( 'fcbk_bttn_plgn_options_array', $fcbk_bttn_plgn_options_array );
				$message = __( "Settings saved", 'facebook' );
			}
			/* Form options */
			if ( isset( $_FILES['uploadfile']['tmp_name'] ) &&  "" != $_FILES['uploadfile']['tmp_name'] ) {
				$max_image_width	=	100;
				$max_image_height	=	40;
				$max_image_size		=	32 * 1024;
				$valid_types 		=	array( 'jpg', 'jpeg' );
				/* Construction to rename downloading file */
				$new_name			=	'facebook-ico' . $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_count_icon'];
				$new_ext			=	'.jpg';
				$namefile			=	$new_name . $new_ext;
				$uploaddir			=	$_REQUEST['home'] . 'wp-content/plugins/facebook-button-plugin/img/'; /* The directory in which we will take the file: */
				$uploadfile			=	$uploaddir . $namefile;

				/* Checks is file download initiated by user */
				if ( isset( $_FILES['uploadfile'] ) && 'custom' == $_REQUEST['fcbk_bttn_plgn_display_option'] ) {
					/* Checking is allowed download file given parameters */
					if ( is_uploaded_file( $_FILES['uploadfile']['tmp_name'] ) ) {
						$filename	=	$_FILES['uploadfile']['tmp_name'];
						$ext		=	substr( $_FILES['uploadfile']['name'], 1 + strrpos( $_FILES['uploadfile']['name'], '.' ) );
						if ( filesize( $filename ) > $max_image_size ) {
							$error	=	__( "Error: File size > 32K", 'facebook' );
						}
						elseif ( ! in_array( $ext, $valid_types ) ) {
							$error	=	__( "Error: Invalid file type", 'facebook' );
						} else {
							$size	=	GetImageSize( $filename );
							if ( ( $size ) && ( $size[0] <= $max_image_width ) && ( $size[1] <= $max_image_height ) ) {
								/* If file satisfies requirements, we will move them from temp to your plugin folder and rename to 'facebook_ico.jpg' */
								if ( move_uploaded_file( $_FILES['uploadfile']['tmp_name'], $uploadfile ) ) {
									$message .= " Upload successful.";
								} else {
									$error = __( "Error: moving file failed", 'facebook' );
								}
							} else {
								$error = __( "Error: check image width or height", 'facebook' );
							}
						}
					} else {
						$error = __( "Uploading Error: check image properties", 'facebook' );
					}
				}
			}
			fcbk_bttn_plgn_update_option();
		} ?>
		<div class="wrap">
			<div class="icon32 icon32-bws" id="icon-options-general"></div>
			<h2><?php echo __( "Facebook Button Settings", 'facebook' ); ?></h2>
			<div class="updated fade" <?php if ( ! isset( $_REQUEST['fcbk_bttn_plgn_form_submit'] ) || "" != $error ) echo "style=\"display:none\""; ?>><p><strong><?php echo $message; ?></strong></p></div>
			<div class="error" <?php if ( "" == $error ) echo "style=\"display:none\""; ?>><p><strong><?php echo $error; ?></strong></p></div>
			<div>
				<form name="form1" method="post" action="admin.php?page=facebook-button-plugin.php" enctype="multipart/form-data" >
					<table class="form-table">
						<tr valign="top">
							<th scope="row"><?php _e( "Your Facebook ID:", 'facebook' ); ?></th>
							<td>
								<input name='fcbk_bttn_plgn_link' type='text' value='<?php echo $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_link']; ?>' style="width:200px;" />
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e( "Display button:", 'facebook' ); ?></th>
							<td>
								<label><input name='fcbk_bttn_plgn_my_page' type='checkbox' value='1' <?php if ( 1 == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_my_page'] ) echo 'checked="checked "'; ?>/> <?php echo __( "My Page", 'captcha' ); ?></label><br />
								<label><input name='fcbk_bttn_plgn_like' type='checkbox' value='1' <?php if ( 1 == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_like'] ) echo 'checked="checked "'; ?>/> <?php echo __( "Like", 'captcha' ); ?></label><br />
							</td>
						</tr>
						<tr>
							<th>
								<?php echo __( "Choose display settings:", 'facebook' ); ?>
							</th>
							<td>
								<select name="fcbk_bttn_plgn_display_option" onchange="if ( this . value == 'custom' ) { getElementById ( 'fcbk_bttn_plgn_display_option_custom' ) . style.display = 'block'; } else { getElementById ( 'fcbk_bttn_plgn_display_option_custom' ) . style.display = 'none'; }" style="width:200px;" >
									<option <?php if ( 'standart' == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_display_option'] ) echo 'selected="selected"'; ?> value="standart"><?php echo __( "Standard Facebook image", 'facebook' ); ?></option>
									<?php if ( $copy || 'custom' == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_display_option'] ) { ?>
										<option <?php if ( 'custom' == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_display_option'] ) echo 'selected="selected"'; ?> value="custom"><?php echo __( "Custom Facebook image", 'facebook' ); ?></option>
									<?php } ?>
								</select>
							</td>
						</tr>
						<tr>
							<th>
								<?php echo __( "Current image:", 'facebook' ); ?>
							</th>
							<td>
								<img src="<?php echo $fcbk_bttn_plgn_options_array['fb_img_link']; ?>" style="margin-left:2px;" />
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<div id="fcbk_bttn_plgn_display_option_custom" <?php if ( 'custom' == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_display_option'] ) { echo ( 'style="display:block"' ); } else { echo ( 'style="display:none"' ); } ?>>
									<table>
										<th style="padding-left:0px; font-size:13px;">
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
									<option <?php if ( 'before' == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_where']  ) echo 'selected="selected"'; ?> value="before"><?php echo __( "Before", 'facebook' ); ?></option>
									<option <?php if ( 'after' == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_where']  ) echo 'selected="selected"'; ?> value="after"><?php echo __( "After", 'facebook' ); ?></option>
									<option <?php if ( 'beforeandafter' == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_where']  ) echo 'selected="selected"'; ?> value="beforeandafter"><?php echo __( "Before and After", 'facebook' ); ?></option>
									<option <?php if ( 'shortcode' == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_where'] ) echo 'selected="selected"'; ?> value="shortcode"><?php echo __( "Shortcode", 'facebook' ); ?></option>
								</select>
								<span id="shortcode" style="color: rgb(136, 136, 136); font-size: 10px; <?php if ( $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_where'] == 'shortcode' ) { echo ( 'display:inline' ); } else { echo ( 'display:none' ); }?>"><?php echo __( "If you would like to add a Facebook button to your website, just copy and paste this shortcode into your post or page:", 'facebook' ); ?> [fb_button].</span>
							</td>
						</tr>
						<tr>
							<th>
								<?php echo __( "Facebook Button language:", 'facebook' ); ?>
							</th>
							<td>
								<select name="fcbk_bttn_plgn_locale">
									<option value="af_ZA" <?php if ( "af_ZA" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Afrikaans</option>
									<option value="ar_AR" <?php if ( "ar_AR" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>العربية</option>
									<option value="ay_BO" <?php if ( "ay_BO" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Aymar aru</option>
									<option value="az_AZ" <?php if ( "az_AZ" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Azərbaycan dili</option>
									<option value="be_BY" <?php if ( "be_BY" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Беларуская</option>
									<option value="bg_BG" <?php if ( "bg_BG" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Български</option>
									<option value="bn_IN" <?php if ( "bn_IN" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>বাংলা</option>
									<option value="bs_BA" <?php if ( "bs_BA" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Bosanski</option>
									<option value="ca_ES" <?php if ( "ca_ES" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Català</option>
									<option value="ck_US" <?php if ( "ck_US" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Cherokee</option>
									<option value="cs_CZ" <?php if ( "cs_CZ" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Čeština</option>
									<option value="cy_GB" <?php if ( "cy_GB" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Cymraeg</option>
									<option value="da_DK" <?php if ( "da_DK" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Dansk</option>
									<option value="de_DE" <?php if ( "de_DE" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Deutsch</option>
									<option value="el_GR" <?php if ( "el_GR" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Ελληνικά</option>
									<option value="en_US" <?php if ( "en_US" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>English</option>
									<option value="en_PI" <?php if ( "en_PI" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>English (Pirate)</option>
									<option value="eo_EO" <?php if ( "eo_EO" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Esperanto</option>
									<option value="es_CL" <?php if ( "es_CL" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Español (Chile)</option>
									<option value="es_CO" <?php if ( "es_CO" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Español (Colombia)</option>
									<option value="es_ES" <?php if ( "es_ES" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Español (España)</option>
									<option value="es_LA" <?php if ( "es_LA" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Español</option>
									<option value="es_MX" <?php if ( "es_MX" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Español (México)</option>
									<option value="es_VE" <?php if ( "es_VE" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Español (Venezuela)</option>
									<option value="et_EE" <?php if ( "et_EE" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Eesti</option>
									<option value="eu_ES" <?php if ( "eu_ES" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Euskara</option>
									<option value="fa_IR" <?php if ( "fa_IR" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>فارسی</option>
									<option value="fb_LT" <?php if ( "fb_LT" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Leet Speak</option>
									<option value="fi_FI" <?php if ( "fi_FI" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Suomi</option>
									<option value="fo_FO" <?php if ( "fo_FO" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Føroyskt</option>
									<option value="fr_CA" <?php if ( "fr_CA" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Français (Canada)</option>
									<option value="fr_FR" <?php if ( "fr_FR" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Français (France)</option>
									<option value="fy_NL" <?php if ( "fy_NL" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Frysk</option>
									<option value="ga_IE" <?php if ( "ga_IE" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Gaeilge</option>
									<option value="gl_ES" <?php if ( "gl_ES" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Galego</option>
									<option value="gn_PY" <?php if ( "gn_PY" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Avañe'ẽ</option>
									<option value="gu_IN" <?php if ( "gu_IN" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>ગુજરાતી</option>
									<option value="gx_GR" <?php if ( "gx_GR" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Ἑλληνική ἀρχαία</option>
									<option value="he_IL" <?php if ( "he_IL" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>עברית</option>
									<option value="hi_IN" <?php if ( "hi_IN" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>हिन्दी</option>
									<option value="hr_HR" <?php if ( "hr_HR" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Hrvatski</option>
									<option value="hu_HU" <?php if ( "hu_HU" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Magyar</option>
									<option value="hy_AM" <?php if ( "hy_AM" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Հայերեն</option>
									<option value="id_ID" <?php if ( "id_ID" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Bahasa Indonesia</option>
									<option value="is_IS" <?php if ( "is_IS" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Íslenska</option>
									<option value="it_IT" <?php if ( "it_IT" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Italiano</option>
									<option value="ja_JP" <?php if ( "ja_JP" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>日本語</option>
									<option value="jv_ID" <?php if ( "jv_ID" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Basa Jawa</option>
									<option value="ka_GE" <?php if ( "ka_GE" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>ქართული</option>
									<option value="kk_KZ" <?php if ( "kk_KZ" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Қазақша</option>
									<option value="km_KH" <?php if ( "km_KH" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>ភាសាខ្មែរ</option>
									<option value="kn_IN" <?php if ( "kn_IN" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>ಕನ್ನಡ</option>
									<option value="ko_KR" <?php if ( "ko_KR" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>한국어</option>
									<option value="ku_TR" <?php if ( "ku_TR" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Kurdî</option>
									<option value="la_VA" <?php if ( "la_VA" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>lingua latina</option>
									<option value="li_NL" <?php if ( "li_NL" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Limburgs</option>
									<option value="lt_LT" <?php if ( "lt_LT" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Lietuvių</option>
									<option value="lv_LV" <?php if ( "lv_LV" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Latviešu</option>
									<option value="mg_MG" <?php if ( "mg_MG" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Malagasy</option>
									<option value="mk_MK" <?php if ( "mk_MK" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Македонски</option>
									<option value="ml_IN" <?php if ( "ml_IN" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>മലയാളം</option>
									<option value="mn_MN" <?php if ( "mn_MN" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Монгол</option>
									<option value="mr_IN" <?php if ( "mr_IN" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>मराठी</option>
									<option value="ms_MY" <?php if ( "ms_MY" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Bahasa Melayu</option>
									<option value="mt_MT" <?php if ( "mt_MT" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Malti</option>
									<option value="nb_NO" <?php if ( "nb_NO" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Norsk (bokmål)</option>
									<option value="ne_NP" <?php if ( "ne_NP" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>नेपाली</option>
									<option value="nl_BE" <?php if ( "nl_BE" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Nederlands (België)</option>
									<option value="nl_NL" <?php if ( "nl_NL" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Nederlands</option>
									<option value="nn_NO" <?php if ( "nn_NO" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Norsk (nynorsk)</option>
									<option value="pa_IN" <?php if ( "pa_IN" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>ਪੰਜਾਬੀ</option>
									<option value="pl_PL" <?php if ( "pl_PL" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Polski</option>
									<option value="ps_AF" <?php if ( "ps_AF" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>پښتو</option>
									<option value="pt_BR" <?php if ( "pt_BR" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Português (Brasil)</option>
									<option value="pt_PT" <?php if ( "pt_PT" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Português (Portugal)</option>
									<option value="qu_PE" <?php if ( "qu_PE" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Qhichwa</option>
									<option value="rm_CH" <?php if ( "rm_CH" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Rumantsch</option>
									<option value="ro_RO" <?php if ( "ro_RO" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Română</option>
									<option value="ru_RU" <?php if ( "ru_RU" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Русский</option>
									<option value="sa_IN" <?php if ( "sa_IN" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>संस्कृतम्</option>
									<option value="se_NO" <?php if ( "se_NO" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Davvisámegiella</option>
									<option value="sk_SK" <?php if ( "sk_SK" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Slovenčina</option>
									<option value="sl_SI" <?php if ( "sl_SI" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Slovenščina</option>
									<option value="so_SO" <?php if ( "so_SO" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Soomaaliga</option>
									<option value="sq_AL" <?php if ( "sq_AL" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Shqip</option>
									<option value="sr_RS" <?php if ( "sr_RS" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Српски</option>
									<option value="sv_SE" <?php if ( "sv_SE" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Svenska</option>
									<option value="sw_KE" <?php if ( "sw_KE" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Kiswahili</option>
									<option value="sy_SY" <?php if ( "sy_SY" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>ܐܪܡܝܐ</option>
									<option value="ta_IN" <?php if ( "ta_IN" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>தமிழ்</option>
									<option value="te_IN" <?php if ( "te_IN" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>తెలుగు</option>
									<option value="tg_TJ" <?php if ( "tg_TJ" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>тоҷикӣ</option>
									<option value="th_TH" <?php if ( "th_TH" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>ภาษาไทย</option>
									<option value="tl_PH" <?php if ( "tl_PH" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Filipino</option>
									<option value="tl_ST" <?php if ( "tl_ST" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>tlhIngan-Hol</option>
									<option value="tr_TR" <?php if ( "tr_TR" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Türkçe</option>
									<option value="tt_RU" <?php if ( "tt_RU" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Татарча</option>
									<option value="uk_UA" <?php if ( "uk_UA" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Українська</option>
									<option value="ur_PK" <?php if ( "ur_PK" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>اردو</option>
									<option value="uz_UZ" <?php if ( "uz_UZ" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>O'zbek</option>
									<option value="vi_VN" <?php if ( "vi_VN" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>Tiếng Việt</option>
									<option value="yi_DE" <?php if ( "yi_DE" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>ייִדיש</option>
									<option value="zh_CN" <?php if ( "zh_CN" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>中文(简体)</option>
									<option value="zh_HK" <?php if ( "zh_HK" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>中文(香港)</option>
									<option value="zh_TW" <?php if ( "zh_TW" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>中文(台灣)</option>
									<option value="zu_ZA" <?php if ( "zu_ZA" == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] ) echo 'selected="selected"'; ?>>isiZulu</option>
									</select>
									<span id="shortcode" style="color: rgb(136, 136, 136); font-size: 10px; display:inline"><?php echo __( "Change the language of Facebook Like Button", 'facebook' ); ?></span>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<input type="hidden" name="fcbk_bttn_plgn_form_submit" value="submit" />
								<input type="submit" class="button-primary" value="<?php _e( 'Save Changes', 'facebook' ); ?>" />
							</td>
						</tr>
					</table>
					<?php wp_nonce_field( plugin_basename( __FILE__ ), 'fcbk_bttn_plgn_nonce_name' ); ?>
				</form>
			</div>
		</div>
	<?php }
}

/* Function 'facebook_fcbk_bttn_plgn_display_option' reacts to changes type of picture (Standard or Custom) and generates link to image, link transferred to array 'fcbk_bttn_plgn_options_array' */
if ( ! function_exists( 'fcbk_bttn_plgn_update_option' ) ) {
	function fcbk_bttn_plgn_update_option() {
		global $fcbk_bttn_plgn_options_array;
		if ( 'standart' == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_display_option'] ) {
			$fb_img_link = plugins_url( 'img/standart-facebook-ico.jpg', __FILE__ );
		} else if ( 'custom' == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_display_option'] ) {
			$fb_img_link = plugins_url( 'img/facebook-ico' . $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_count_icon'] . '.jpg', __FILE__ );
		}
		$fcbk_bttn_plgn_options_array['fb_img_link'] = $fb_img_link ;
		update_option( "fcbk_bttn_plgn_options_array", $fcbk_bttn_plgn_options_array );
	}
}

/* Function 'facebook_button' taking from array 'fcbk_bttn_plgn_options_array' necessary information to create Facebook Button and reacting to your choise in plugin menu - points where it appears. */
if ( ! function_exists( 'fcbk_bttn_plgn_display_button' ) ) {
	function fcbk_bttn_plgn_display_button( $content ) {
		global $post;
		/* Query the database to receive array 'fcbk_bttn_plgn_options_array' and receiving necessary information to create button */
		$fcbk_bttn_plgn_options_array	=	get_option( 'fcbk_bttn_plgn_options_array' );
		$fcbk_bttn_plgn_where			=	$fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_where'];
		$permalink_post					=	get_permalink( $post->ID );
		/* Button */
		$button							=	'<div id="fcbk_share">';
		$img							=	$fcbk_bttn_plgn_options_array['fb_img_link'];
		$url							=	$fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_link'];
		if ( 1 == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_my_page'] ) {
			$button .=	'<div class="fcbk_button">
							<a href="http://www.facebook.com/' . $url . '"	target="_blank">
								<img src="' . $img . '" alt="Fb-Button" />
							</a>
						</div>';
		}
		if ( 1 == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_like'] ) {
			$button .= '<div class="fcbk_like">
							<div id="fb-root"></div>
							<script src="http://connect.facebook.net/' . $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_locale'] . '/all.js#appId=224313110927811&amp;xfbml=1"></script>
							<fb:like href="' . $permalink_post . '" send="false" layout="button_count" width="450" show_faces="false" font=""></fb:like>
						</div>';
		}
		
		$button .= '</div>';
		/* Indication where show Facebook Button depending on selected item in admin page. */
		if ( 'before' == $fcbk_bttn_plgn_where ) {
			return $button . $content;
		} else if ( 'after' == $fcbk_bttn_plgn_where ) {
			return $content . $button;
		} else if ( 'beforeandafter' == $fcbk_bttn_plgn_where ) {
			return $button . $content . $button;
		} else if ( 'shortcode' == $fcbk_bttn_plgn_where ) {
			return $content;
		} else {
			return $content;
		}
	}
}

/* Function 'fcbk_bttn_plgn_shortcode' are using to create shortcode by Facebook Button. */
if ( ! function_exists( 'fcbk_bttn_plgn_shortcode' ) ) {
	function fcbk_bttn_plgn_shortcode( $content ) {
		global $post;
		$fcbk_bttn_plgn_options_array	=	get_option( 'fcbk_bttn_plgn_options_array' );
		$fcbk_bttn_plgn_where			=	$fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_where'];
		$permalink_post					=	get_permalink( $post->ID );
		$button							=	'<div id="fcbk_share">';
		$img							=	$fcbk_bttn_plgn_options_array['fb_img_link'];
		$url							=	$fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_link'];
		if ( 1 == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_my_page'] ) {
			$button .=	'<div class="fcbk_button">
							<a href="http://www.facebook.com/' . $url . '"	target="_blank">
								<img src="' . $img . '" alt="Fb-Button" />
							</a>
						</div>';
		}
		if ( 1 == $fcbk_bttn_plgn_options_array['fcbk_bttn_plgn_like'] ) {
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

/* Function 'fcbk_bttn_plgn_action_links' are using to create action links on admin page. */
if ( ! function_exists( 'fcbk_bttn_plgn_action_links' ) ) {
	function fcbk_bttn_plgn_action_links( $links, $file ) {
		/* Static so we don't call plugin_basename on every plugin row. */
		static $this_plugin;
		if ( ! $this_plugin )
			$this_plugin = plugin_basename( __FILE__ );
		if ( $file == $this_plugin ) {
			$settings_link = '<a href="admin.php?page=facebook-button-plugin.php">' . __( 'Settings', 'facebook' ) . '</a>';
			array_unshift( $links, $settings_link );
		}
		return $links;
	}
} /* End function fcbk_bttn_plgn_action_links */

/* Function 'fcbk_bttn_plgn_links' are using to create other links on admin page. */
if ( ! function_exists ( 'fcbk_bttn_plgn_links' ) ) {
	function fcbk_bttn_plgn_links( $links, $file ) {
		$base = plugin_basename( __FILE__ );
		if ( $file == $base ) {
			$links[] = '<a href="admin.php?page=facebook-button-plugin.php">' . __( 'Settings', 'facebook' ) . '</a>';
			$links[] = '<a href="http://wordpress.org/plugins/facebook-button-plugin/faq/" target="_blank">' . __( 'FAQ', 'facebook' ) . '</a>';
			$links[] = '<a href="http://support.bestwebsoft.com">' . __( 'Support', 'facebook' ) . '</a>';
		}
		return $links;
	}
} /* End function fcbk_bttn_plgn_links */

/* Function '_plugin_init' are using to add language files. */
if ( ! function_exists( 'fcbk_plugin_init' ) ) {
	function fcbk_plugin_init() {
		load_plugin_textdomain( 'facebook', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		load_plugin_textdomain( 'bestwebsoft', false, dirname( plugin_basename( __FILE__ ) ) . '/bws_menu/languages/' );
	}
} /* End function fcbk_plugin_init */

/* Function check if plugin is compatible with current WP version  */
if ( ! function_exists ( 'fcbk_bttn_plgn_version_check' ) ) {
	function fcbk_bttn_plgn_version_check() {
		global $wp_version;
		$plugin_data	=	get_plugin_data( __FILE__, false );
		$require_wp		=	"3.0"; /* Wordpress at least requires version */
		$plugin			=	plugin_basename( __FILE__ );
	 	if ( version_compare( $wp_version, $require_wp, "<" ) ) {
			if( is_plugin_active( $plugin ) ) {
				deactivate_plugins( $plugin );
				wp_die( "<strong>" . $plugin_data['Name'] . " </strong> " . __( 'requires', 'facebook' ) . " <strong>WordPress " . $require_wp . "</strong> " . __( 'or higher, that is why it has been deactivated! Please upgrade WordPress and try again.', 'facebook') . "<br /><br />" . __( 'Back to the WordPress', 'facebook') . " <a href='" . get_admin_url( null, 'plugins.php' ) . "'>" . __( 'Plugins page', 'facebook') . "</a>." );
			}
		}
	}
}

if ( ! function_exists( 'fcbk_admin_head' ) ) {
	function fcbk_admin_head() {
		wp_register_style( 'fcbkStylesheet', plugins_url( 'css/style.css', __FILE__ ) );
		wp_enqueue_style( 'fcbkStylesheet' );
		if ( isset( $_GET['page'] ) && $_GET['page'] == "bws_plugins" )
			wp_enqueue_script( 'bws_menu_script', plugins_url( 'js/bws_menu.js' , __FILE__ ) );
	}
}

/* Function for delete options */
if ( ! function_exists( 'fcbk_delete_options' ) ) {
	function fcbk_delete_options() {
		delete_option( 'fcbk_bttn_plgn_options_array' );
		delete_site_option( 'fcbk_bttn_plgn_options_array' );
	}
}

/* Calling a function add administrative menu. */
add_action( 'admin_menu', 'fcbk_bttn_plgn_add_pages' );
/* Add language files */
add_action( 'init', 'fcbk_plugin_init' );
add_action( 'admin_init', 'fcbk_bttn_plgn_version_check' );
add_action( 'wp_enqueue_scripts', 'fcbk_admin_head' );
add_action( 'admin_enqueue_scripts', 'fcbk_admin_head' );

/* Add shortcode. */
add_shortcode( 'fb_button', 'fcbk_bttn_plgn_shortcode' );

/* Add settings links. */
add_filter( 'the_content', 'fcbk_bttn_plgn_display_button' );
/* Adds "Settings" link to the plugin action page */
add_filter( 'plugin_action_links', 'fcbk_bttn_plgn_action_links', 10, 2 );
/* Additional links on the plugin page */
add_filter( 'plugin_row_meta', 'fcbk_bttn_plgn_links', 10, 2 );

register_uninstall_hook( __FILE__, 'fcbk_delete_options' );
?>