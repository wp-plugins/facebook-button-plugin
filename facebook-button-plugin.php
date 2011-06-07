<?php
/*
Plugin Name: Facebook Button Plugin
Plugin URI:  http://bestwebsoft.com/plugin/
Description: Put Facebook Button in to your post.
Author: BestWebSoft
Version: 0.1
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

//Function 'facebook_button_plugin_page' formed content of the plugin's admin page.
function facebook_button_plugin_page() {
	// Takes all the changed settings on the plugin's admin page and saves them in array 'fb_options_array'.
	if ( isset ( $_REQUEST['fb_where'] ) && isset ( $_REQUEST['fb_link'] ) && isset ( $_REQUEST['display_option'] ) ) {				
		$fb_options_array [ 'fb_link' ]			=	$_REQUEST [ 'fb_link' ];
		$fb_options_array [ 'fb_where' ]		=	$_REQUEST [ 'fb_where' ];
		$fb_options_array [ 'display_option' ]	=	$_REQUEST [ 'display_option' ];
			update_option	( 'fb_options_array', $fb_options_array );
	?>
<div class="updated fade below-h2"><p><strong>Options saved</strong></p></div>
<?php
	}
    // Form options
	if ( isset ( $_FILES [ 'uploadfile' ] [ 'tmp_name' ] ) ) {	?>	
		<div><? facebook_img_upload_and_rename_file($_FILES, $_REQUEST);?></div>
	<?php } ?>
<div class="wrap">
	<h2>Menu FaceBook Button Plugin Options</h2>
	<div>
		<form name="form1" method="post" action="admin.php?page=FaceBookButton" enctype="multipart/form-data" >
			<p><?php _e("Your's FaceBook Login:"); ?>
				<input name='fb_link' type='text' value='<?php $fb_options_array =	get_option ( 'fb_options_array' );  echo $fb_options_array [ 'fb_link' ] ?>'/>		
			</p>
				<p>Choose display option:
				<select name="display_option" onchange="if ( this . value == 'custom' ) { getElementById ( 'display_option_custom' ) . style.display = 'block'; } else { getElementById ( 'display_option_custom' ) . style.display = 'none'; }">
					<option <?php if ( $fb_options_array [ 'display_option' ] == 'standart' ) echo 'selected="selected"'; ?> value="standart">Standart FaceBook image</option>
					<option <?php if ( $fb_options_array [ 'display_option' ] == 'custom' ) echo 'selected="selected"'; ?> value="custom">Custom FaceBook image</option>
				</select>
			</p>
			<p>
				<div id="display_option_custom" <?php if ( $fb_options_array [ 'display_option' ] == 'custom' ) { echo ( 'style="display:block"' ); } else {echo ( 'style="display:none"' ); }?> class="setting-description">
					<input type="hidden" name="MAX_FILE_SIZE" value="64000"/>
					<input type="hidden" name="home" value="<?php echo	ABSPATH ; ?>"/>
						<p>Your's FaceBook image:<input name="uploadfile" type="file" /></p>
						<p><h6>Image properties - Max image width:100px; Max image height:40px; Max image size:32Kb; Image types:"jpg", "jpeg".</h6></p>
				</div>
			</p>
			<p>Your's FaceBook Button Position:
				<select name="fb_where" onchange="if ( this . value == 'shortcode' ) { getElementById ( 'shortcode' ) . style.display = 'block'; } else { getElementById ( 'shortcode' ) . style.display = 'none'; }">
					<option <?php if ( $fb_options_array [ 'fb_where' ] == 'before' ) echo 'selected="selected"'; ?> value="before">Before</option>
					<option <?php if ( $fb_options_array [ 'fb_where' ] == 'after' ) echo 'selected="selected"'; ?> value="after">After</option>
					<option <?php if ( $fb_options_array [ 'fb_where' ] == 'beforeandafter' ) echo 'selected="selected"'; ?> value="beforeandafter">Before and After</option>
					<option <?php if ( $fb_options_array [ 'fb_where' ] == 'shortcode ') echo 'selected="selected"'; ?> value="shortcode">Shortcode</option>
				</select>
					<span id="shortcode" <?php if ( $fb_options_array [ 'fb_where' ] == 'shortcode' ) { echo ( 'style="display:block"' ); } else { echo ( 'style="display:none"' ); }?> class="setting-description"><code>Past shortcode [fb_button] in to your post aniwhere</code></span>
			</p>
				<input type="submit" name="Submit" value="<?php _e( 'Update Options' ) ?>" />
		</form>
			<hr />
	</div>
</div>

<?php
}

//Upload and rename user picture to FaceBook Button
function facebook_img_upload_and_rename_file ( $FILES, $REQUEST ) {
   	// Requirements for the uploaded file.
	$max_image_width	=	100;
	$max_image_height	=	40;
	$max_image_size		=	32 * 1024;
	$valid_types 		=	array( 'jpg', 'jpeg' );
	
	// Construction to rename downloading file
	$new_name			=	'facebook-ico'; 
	$new_ext			=	'.jpg';
	$namefile			=	$new_name.$new_ext;
	$uploaddir			=	$_POST [ 'home' ] . 'wp-content/plugins/facebook-button-plugin/img/'; // The directory in which we will take the file:
	$uploadfile			=	$uploaddir.$namefile; 

	//checks is file download initiated by user
	if ( isset ( $FILES [ 'uploadfile' ] ) && $REQUEST [ 'display_option' ] == 'custom' ) {		
		//Checking is allowed download file given parameters
		if ( is_uploaded_file( $_FILES [ 'uploadfile' ] [ 'tmp_name' ] ) ) {	
			$filename	=	$FILES [ 'uploadfile' ] [ 'tmp_name' ];
			$ext		=	substr ( $FILES [ 'uploadfile' ] [ 'name' ], 1 + strrpos( $FILES [ 'uploadfile' ] [ 'name' ], '.' ) );		
			if ( filesize ( $filename ) > $max_image_size ) { ?>
				<div class="error fade below-h2"><p><strong>Error: File size > 32K</strong></p></div>
			<?php } 
			elseif ( ! in_array ( $ext, $valid_types ) ) { ?>
				<div class="error fade below-h2"><p><strong>Error: Invalid file type</strong></p></div>
			<?php } 
			else {
				$size = GetImageSize ( $filename );
				if ( ( $size ) && ( $size[0] <= $max_image_width ) && ( $size[1] <= $max_image_height ) ) {
					//If file satisfies requirements, we will move them from temp to your plugin folder and rename to 'facebook_ico.jpg'
					if (move_uploaded_file ( $_FILES [ 'uploadfile' ] [ 'tmp_name' ], $uploadfile ) ) { ?>
						<div class="updated fade below-h2"><p><strong>Upload successful</strong></p></div>
					<?php } 
					else { ?>
						<div class="error fade below-h2"><p><strong>Error: moving file failed</strong></p></div>
					<?php }
				} 
				else { ?>
					<div class="error fade below-h2"><p><strong>Error: check image width or height</strong></p></div>
				<?php }
			}
		} 
		else { ?>
			<div class="error fade below-h2"><p><strong>Uploading Error: check image properties</strong></p></div>
		<?php }	
		facebook_display_option ();
	}	
} 
	
//Function 'facebook_display_option' reacts to changes type of picture (Standard or Custom) and generates link to image, link transferred to array 'fb_options_array'
function facebook_display_option () {

	$fb_options_array	=	get_option ( 'fb_options_array' );
	if ( $fb_options_array [ 'display_option' ] == 'standart' ){
		$fb_img_link	=	$_GET [ 'home' ] . 'wp-content/plugins/facebook-button-plugin/img/standart-facebook-ico.jpg';
	} else if ( $fb_options_array [ 'display_option' ] == 'custom'){
		$fb_img_link	=	$_GET [ 'home' ] . 'wp-content/plugins/facebook-button-plugin/img/facebook-ico.jpg';
	}
	$fb_options_array [ 'fb_img_link' ]	=	$fb_img_link ;
	update_option( "fb_options_array", $fb_options_array );
}

//Function 'facebook_button' taking from array 'fb_options_array' necessary information to create FaceBook Button and reacting to your choise in plugin menu - points where it appears.
function facebook_button( $content ) {
	//Query the database to receive array 'fb_options_array' and receiving necessary information to create button
	$fb_options_array	=	get_option ( 'fb_options_array' );
	$fb_where			=	$fb_options_array [ 'fb_where' ];	
	$img				=	$fb_options_array [ 'fb_img_link' ];
	$url				=	$fb_options_array [ 'fb_link' ];	
	$permalink_post		=	get_permalink ( $post_ID );
	//Button
	$button				=	'<div id="fb_share">
								<div style="float:left;margin-right:10px;" >
									<a name="fb_share"	href="http://www.facebook.com/' . $url . '"	target="blank">
										<img src="' . $img . '" alt="Fb-Button" />
									</a>	
								</div>
								<div>
									<div id="fb-root"></div>
									<script src="http://connect.facebook.net/en_US/all.js#appId=224313110927811&amp;xfbml=1"></script>
									<fb:like href="' . $permalink_post . '" send="false" layout="button_count" width="450" show_faces="false" font=""></fb:like>
								</div>					 
							</div>';
	//Indication where show FaceBook Button depending on selected item in admin page.
	if ( $fb_where == 'before' ) {
		return $button . $content; 
	} else if ( $fb_where == 'after' ) {		
		return $content . $button;
	} else if ( $fb_where == 'beforeandafter' ) {		
		return $button . $content . $button;
	} else if ( $fb_where == 'shortcode' ) {
		return $content;		
	}
}

//Function 'facebook_button_short' are using to create shortcode by FaceBook Button.
function facebook_button_short( $content ) {
	$fb_options_array	=	get_option ( 'fb_options_array' );
	$fb_where			=	$fb_options_array [ 'fb_where' ];	
	$img				=	$fb_options_array [ 'fb_img_link' ];
	$url				=	$fb_options_array [ 'fb_link' ];	
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

//Calling a function add administrative menu.
add_action( 'admin_menu', 'facebook_button_plugin_add_pages' );

function facebook_button_plugin_add_pages() {
	add_options_page ( 'FaceBook Button', 'FaceBook Button', 0, 'FaceBookButton', 'facebook_button_plugin_page' );
}

//Add shortcode.
add_shortcode( 'fb_button', 'facebook_button_short' );

//Add settings links.
add_filter( 'the_content', 'facebook_button' );