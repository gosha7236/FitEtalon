<?php if (!defined('ABSPATH')) {exit;}
function mfwp_set_page() {
 if (isset($_REQUEST['mfwp_submit_action'])) {
  if (!empty($_POST) && check_admin_referer('mfwp_nonce_action','mfwp_nonce_field')) {
	if (is_multisite()) {
		update_blog_option(get_current_blog_id(), 'mfwp_map_from', sanitize_text_field($_POST['mfwp_map_from']));
		update_blog_option(get_current_blog_id(), 'mfwp_gapikey', sanitize_text_field($_POST['mfwp_gapikey']));		
		update_blog_option(get_current_blog_id(), 'mfwp_type_map', sanitize_text_field($_POST['mfwp_type_map']));
		update_blog_option(get_current_blog_id(), 'mfwp_style_map', sanitize_text_field($_POST['mfwp_style_map']));
		update_blog_option(get_current_blog_id(), 'mfwp_h', sanitize_text_field($_POST['mfwp_h']));	
		update_blog_option(get_current_blog_id(), 'mfwp_zoom_OnePoint', sanitize_text_field($_POST['zoom_OnePoint']));
		update_blog_option(get_current_blog_id(), 'mfwp_zoom_ManyPoints', sanitize_text_field($_POST['mfwp_zoom_ManyPoints']));		
		update_blog_option(get_current_blog_id(), 'mfwp_point_img', sanitize_text_field($_POST['mfwp_point_img']));			
		update_blog_option(get_current_blog_id(), 'mfwp_center_lat_ManyPoints', sanitize_text_field($_POST['mfwp_center_lat_ManyPoints']));	 
		update_blog_option(get_current_blog_id(), 'mfwp_center_lon_ManyPoints', sanitize_text_field($_POST['mfwp_center_lon_ManyPoints']));	
		
		if (isset($_POST['mfwp_default_point_img'])) {
			update_blog_option(get_current_blog_id(), 'mfwp_default_point_img', sanitize_text_field($_POST['mfwp_default_point_img']));
		} else {
			update_blog_option(get_current_blog_id(), 'mfwp_default_point_img', '');
		}
	} else {
		update_option('mfwp_map_from', sanitize_text_field($_POST['mfwp_map_from']));
		update_option('mfwp_gapikey', sanitize_text_field($_POST['mfwp_gapikey']));
		update_option('mfwp_type_map', sanitize_text_field($_POST['mfwp_type_map']));
		update_option('mfwp_style_map', sanitize_text_field($_POST['mfwp_style_map']));		
		update_option('mfwp_h', sanitize_text_field($_POST['mfwp_h']));
		update_option('mfwp_zoom_OnePoint', sanitize_text_field($_POST['mfwp_zoom_OnePoint']));
		update_option('mfwp_zoom_ManyPoints', sanitize_text_field($_POST['mfwp_zoom_ManyPoints']));	
		update_option('mfwp_point_img', sanitize_text_field($_POST['mfwp_point_img']));
		update_option('mfwp_center_lat_ManyPoints', sanitize_text_field($_POST['mfwp_center_lat_ManyPoints']));	 
		update_option('mfwp_center_lon_ManyPoints', sanitize_text_field($_POST['mfwp_center_lon_ManyPoints']));
		
		if (isset($_POST['mfwp_default_point_img'])) {
			update_option('mfwp_default_point_img', sanitize_text_field($_POST['mfwp_default_point_img']));
		} else {
			update_option('mfwp_default_point_img', '');
		}
	}
				
  }
 } 
 if (is_multisite()) {		
	$gapikey = get_blog_option(get_current_blog_id(), 'mfwp_gapikey');
	$map_from = get_blog_option(get_current_blog_id(), 'mfwp_map_from');
	$type_map = get_blog_option(get_current_blog_id(), 'mfwp_type_map');
	$style_map = get_blog_option(get_current_blog_id(), 'mfwp_style_map');
	$h = get_blog_option(get_current_blog_id(), 'mfwp_h');
	$zoom = get_blog_option(get_current_blog_id(), 'mfwp_zoom_OnePoint');
	$zoomMany = get_blog_option(get_current_blog_id(), 'mfwp_zoom_ManyPoints');
	$center_lat_ManyPoints = get_blog_option(get_current_blog_id(), 'mfwp_center_lat_ManyPoints');
	$center_lon_ManyPoints = get_blog_option(get_current_blog_id(), 'mfwp_center_lon_ManyPoints');
	$default_point_img = get_blog_option(get_current_blog_id(), 'mfwp_default_point_img');
	
	if (get_blog_option(get_current_blog_id(), 'mfwp_point_img') !== '') { // если фото загружено
		$image_attributes = wp_get_attachment_image_src(get_blog_option(get_current_blog_id(), 'mfwp_point_img'), array(44, 44));
		$src = $image_attributes[0]; // урл картинки
		$idimg = get_blog_option(get_current_blog_id(), 'mfwp_point_img');
	} else {
		$idimg = ''; $src = plugin_dir_url(__FILE__).'img/no-img.png'; /* если картинки нет */
	}
 } else {
	$gapikey = get_option('mfwp_gapikey');
	$map_from = get_option('mfwp_map_from');
	$type_map = get_option('mfwp_type_map');
	$style_map = get_option('mfwp_style_map');	
	$h = get_option('mfwp_h');
	$zoom = get_option('mfwp_zoom_OnePoint');
	$zoomMany = get_option('mfwp_zoom_ManyPoints');
	$center_lat_ManyPoints = get_option('mfwp_center_lat_ManyPoints');
	$center_lon_ManyPoints = get_option('mfwp_center_lon_ManyPoints');
	$default_point_img = get_option('mfwp_default_point_img');
	
	if (get_option('mfwp_point_img') !== '') { // если фото загружено
		$image_attributes = wp_get_attachment_image_src(get_option('mfwp_point_img'), array(44, 44));
		$src = $image_attributes[0]; // урл картинки
		$idimg = get_option('mfwp_point_img');
	} else {
		$idimg = ''; $src = plugin_dir_url(__FILE__).'img/no-img.png'; /* если картинки нет */
	}
 }
?>
 <div class="wrap">
  <h1><?php _e('Maps for WP Settings', 'mfwp'); ?></h1> 
  <div style="margin: 0 auto; max-width: 1332px" class="clear">
  <div class="icp_wrap">
	<input type="radio" name="icp_slides" id="icp_point1">
	<input type="radio" name="icp_slides" id="icp_point2">
	<input type="radio" name="icp_slides" id="icp_point3" checked>	
	<div class="icp_slider">
		<div class="icp_slides icp_img1"><a href="//wordpress.org/plugins/yml-for-yandex-market/" target="_blank"></a></div>
		<div class="icp_slides icp_img2"><a href="//wordpress.org/plugins/import-products-to-ok-ru/" target="_blank"></a></div>
		<div class="icp_slides icp_img3"><a href="//wordpress.org/plugins/xml-for-google-merchant-center/" target="_blank"></a></div>
	</div>	
	<div class="icp_control">
		<label for="icp_point1"></label>
		<label for="icp_point2"></label>
		<label for="icp_point3"></label>
	</div>
  </div>  	
  </div>  
  <div id="dashboard-widgets-wrap"><div id="dashboard-widgets" class="metabox-holder">	
	<div id="postbox-container-1" class="postbox-container"><div class="meta-box-sortables" >
     <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data">	
	 <div class="postbox">
	   <div class="inside">
	    <h1><?php _e('Main parameters', 'mfwp'); ?></h1>
		<table class="form-table"><tbody>
		 <tr>
			<th scope="row"><label for="mfwp_map_from"><?php _e('Use maps from', 'mfwp'); ?></label></th>
			<td class="overalldesc">
				<select name="mfwp_map_from">					
					<option value="yandex" <?php selected($map_from, 'yandex'); ?>><?php _e('Yandex', 'mfwp'); ?></option>
					<option value="google" <?php selected($map_from, 'google'); ?>><?php _e('Google', 'mfwp'); ?></option>
				</select><br />
				<span class="description"><?php _e('Please note that in order to work correctly with Google Maps, you need to provide an API key', 'mfwp'); ?></span>
			</td>
		 </tr>
		 <tr>
			<th scope="row"><label for="mfwp_gapikey"><?php _e('Google Maps API Key', 'mfwp'); ?></label></th>
			<td class="overalldesc">
				<input type="text" name="mfwp_gapikey" value="<?php echo $gapikey; ?>" /><br />
				<span class="description"><?php _e('Required for Google Maps', 'mfwp'); ?>.<br /><?php _e('Google Maps require an API key to function', 'mfwp'); ?>. <a href="//maps-apis.googleblog.com/2016/06/building-for-scale-updates-to-google.html"><?php _e('Read more', 'mfwp'); ?></a>.<br />
				<a href="//developers.google.com/maps/documentation/javascript/get-api-key"><?php _e('You can create an API key here now (free)', 'mfwp'); ?></a>.
				</span>				
			</td>	
		 </tr>
		 <tr>
			<th scope="row"><label for="mfwp_default_point_img"><?php _e('Use standard map markers', 'mfwp'); ?></label></th>
			<td class="overalldesc">
				<input type="checkbox" name="mfwp_default_point_img" <?php checked($default_point_img, 'on' ); ?>/><br />
				<span class="description"><?php _e('Use standard map markers', 'mfwp'); ?></span>
			</td>
		 </tr>
		 <tr>
			<th scope="row"><label><?php _e('The image point on the map (36×36)', 'mfwp'); ?></label></th>
			<td>
				<div class="cacf">
					<img data-src="<?php echo $default; ?>" src="<?php echo $src; ?>" width="44px" height="44px" />
					<div>
					<input type="hidden" name="mfwp_point_img" value="<?php echo $idimg; ?>" />
					<button style="padding-top: 3px;" type="button" class="upload_image_button button"><span class="dashicons dashicons-upload"></span></button>
					<button style="padding-top: 3px;" type="button" class="remove_image_button button"><span class="dashicons dashicons-no"></span></button>			
					</div>
				</div>
			</td>
		 </tr>		 
		 <tr>		
			<th scope="row"><label for="mfwp_type_map"><?php _e('Default Type of Maps', 'mfwp'); ?></label></th>
			<td class="overalldesc">
				<select name="mfwp_type_map">					
					<option value="roadmap" <?php selected($type_map, 'roadmap'); ?>><?php _e('Roadmap', 'mfwp'); ?></option>
					<option value="satellite" <?php selected($type_map, 'satellite'); ?>><?php _e('Satellite', 'mfwp'); ?></option>
					<option value="hybrid" <?php selected($type_map, 'hybrid'); ?>><?php _e('Hybrid', 'mfwp'); ?></option>
					<option value="terrain" <?php selected($type_map, 'terrain'); ?>><?php _e('Terrain (only Google Maps)', 'mfwp'); ?></option>					
				</select><br />
				<span class="description"><?php _e('Please note that in order to work correctly with Google Maps, you need to provide an API key', 'mfwp'); ?></span>
			</td>
		 </tr>		 
		 <tr>		
			<th scope="row"><label for="mfwp_style_map"><?php _e('Style of Maps', 'mfwp'); ?></label></th>
			<td class="overalldesc">
				<select name="mfwp_style_map">					
					<option value="default" <?php selected($style_map, 'default'); ?>><?php _e('Default', 'mfwp'); ?></option>
					<option value="blackwhite" <?php selected($style_map, 'blackwhite'); ?>><?php _e('Black-white', 'mfwp'); ?></option>
					<option value="blackout" <?php selected($style_map, 'blackout'); ?>><?php _e('Blackout', 'mfwp'); ?></option>
					<option value="сolorinversion" <?php selected($style_map, 'сolorinversion'); ?>><?php _e('Color inversion', 'mfwp'); ?></option>
				</select><br />
				<span class="description"><?php _e('Only for Yandex maps', 'mfwp'); ?></span>
			</td>
		 </tr>		 
		 <tr>
			<th scope="row"><label for="mfwp_h"><?php _e('Default maps height', 'mfwp'); ?></label></th>
			<td class="overalldesc">
				<input min="50" max="1300" type="number" name="mfwp_h" value="<?php echo $h; ?>" /><br />
				<span class="description"><?php _e('Default maps height in pixels', 'mfwp'); ?>.</span>				
			</td>
		 </tr>
		 <tr>
			<th scope="row"><label for="mfwp_zoom_OnePoint"><?php _e('Default Zoom map with one point', 'mfwp'); ?></label></th>
			<td class="overalldesc">
				<input min="0" max="18" type="number" name="mfwp_zoom_OnePoint" value="<?php echo $zoom; ?>" /><br />
				<span class="description"><?php _e('Zoom map with one point', 'mfwp'); ?>.</span>				
			</td>
		 </tr>
		 <tr>
			<th scope="row"><label for="mfwp_zoom_ManyPoints"><?php _e('Default Zoom map with many points', 'mfwp'); ?></label></th>
			<td class="overalldesc">
				<input min="0" max="18" type="number" name="mfwp_zoom_ManyPoints" value="<?php echo $zoomMany; ?>" /><br />
				<span class="description"><?php _e('Zoom map with many points', 'mfwp'); ?>.</span>				
			</td>
		 </tr>
		 <tr>
			<th scope="row"><label><?php _e('Latitude center map with many points', 'mfwp'); ?></label></th>
			<td><input required type="number" step="any" name="mfwp_center_lat_ManyPoints" value="<?php echo $center_lat_ManyPoints; ?>"></td>
		 </tr>
		 <tr>
			<th scope="row"><label><?php _e('Longitude center map with many points', 'mfwp'); ?></label></th>
			<td><input required type="number" step="any" name="mfwp_center_lon_ManyPoints" value="<?php echo $center_lon_ManyPoints; ?>"></td>
		 </tr>		 
		</tbody></table>
	  </div>
	 </div>
	 
	 <div class="postbox">
	 <div class="inside">
		<table class="form-table"><tbody>
		 <tr>
			<th scope="row"><label for="button-primary"></label></th>
			<td class="overalldesc"><?php wp_nonce_field('mfwp_nonce_action','mfwp_nonce_field'); ?><input class="button-primary" type="submit" name="mfwp_submit_action" value="<?php _e('Save', 'mfwp'); ?>" /><br />
			<span class="description"><?php _e('Click to save the settings', 'mfwp'); ?></span></td>
		 </tr>
		</tbody></table>
	  </div>
	 </div>
	 </form>
	</div></div>
	
	<div id="postbox-container-2" class="postbox-container"><div class="meta-box-sortables" >    
	 <div class="postbox">
	  <div class="inside">
	  <h1><?php _e('Please support the project!', 'mfwp'); ?></h1>
	  <p><?php _e('Thank you for using the plugin', 'mfwp'); ?> <strong>Maps for WP</strong></p>
	  <p><?php _e('Please help make the plugin better', 'mfwp'); ?> <a href="//docs.google.com/forms/d/1Tf9GQZfe8VHHcZZ4Lo4djiTBZLdHmD3hrSOrj1LNsPw" target="_blank" ><?php _e('answering 5 questions', 'mfwp'); ?>!</a></p>
	  <p><?php _e('If this plugin useful to you, please support the project one way', 'mfwp'); ?>:</p>
	  <ul>
		<li>- <a href="//wordpress.org/plugins/maps-for-wp/" target="_blank"><?php _e('Leave a comment on the plugin page', 'mfwp'); ?></a>.</li>
		<li>- <?php _e('Support the project financially. Even $1 is a help!', 'mfwp'); ?><a href="https://icopydoc.ru/donate/" target="_blank"> <?php _e('Donate now', 'mfwp'); ?></a>.</li>
		<li>- <?php _e('Noticed a bug or have an idea how to improve the quality of the plugin?', 'mfwp'); ?> <a href="mailto:pt070@yandex.ru"><?php _e('Let me know', 'mfwp'); ?></a>.</li>
	  </ul>
	  <p><?php _e('The author of the plugin Maxim Glazunov', 'mfwp'); ?>.</p>
	  <p><span style="color: red;"><?php _e('Accept orders for individual revision of the plugin', 'mfwp'); ?></span>:<br /><a href="mailto:pt070@yandex.ru"><?php _e('Leave a request', 'mfwp'); ?></a>.</p>  
	  </p>
	  </div>
	 </div>
	 
	 <div class="postbox">
	  <div class="inside">
		<h1><?php _e('Examples shotcodes', 'mfwp'); ?>:</h1>
		<p>[MapOnePoint id="" type="" lon="" lat="" zoom="" h="" img="" thover="" tclick=""]</p>
		<p><strong><?php _e('Where', 'mfwp'); ?>:</strong></p>
		<p><strong>id (required)</strong> - <?php _e('unique id', 'mfwp'); ?><br />
		<strong>type (required)</strong> - <?php _e('map layer', 'mfwp'); ?> (roadmap, satellite, hybrid, terrain)<br />
		<strong>lon (required)</strong> - <?php _e('longitude of the center of the map', 'mfwp'); ?><br />
		<strong>lat (required)</strong> - <?php _e('latitude of the center of the map', 'mfwp'); ?><br />
		<strong>mstyle (not required)</strong> - <?php _e('style of Maps', 'mfwp'); ?> (default, blackwhite, blackout, сolorinversion)<br />
		<strong>h (not required)</strong> - <?php _e('Map height in pixels', 'mfwp'); ?><br />
		<strong>img (not required)</strong> - <?php _e('URL image markers', 'mfwp'); ?><br />
		<strong>thover (not required)</strong> - <?php _e('Text when pointing to a point', 'mfwp'); ?><br />
		<strong>tclick (not required)</strong> - <?php _e('Text when clicking on a point', 'mfwp'); ?>
		</p>
		<p>[MapManyPoints id="" type="" lat="" lon="" zoom="" h="" img="" points=""]</p>
		<p><strong><?php _e('Where', 'mfwp'); ?>:</strong></p>
		<p><strong>id (required)</strong> - <?php _e('unique id', 'mfwp'); ?><br />
		<strong>type (required)</strong> - <?php _e('map layer', 'mfwp'); ?> (roadmap, satellite, hybrid, terrain)<br />		
		<strong>lon (required)</strong> - <?php _e('longitude of the center of the map', 'mfwp'); ?><br />
		<strong>lat (required)</strong> - <?php _e('latitude of the center of the map', 'mfwp'); ?><br />
		<strong>mstyle (not required)</strong> - <?php _e('style of Maps', 'mfwp'); ?> (default, blackwhite, blackout, сolorinversion)<br />
		<strong>h (not required)</strong> - <?php _e('Map height in pixels', 'mfwp'); ?><br />
		<strong>img (not required)</strong> - <?php _e('URL image markers', 'mfwp'); ?><br />
		<strong>points (required)</strong> - [lat point 1],[lon point 1],[text on hover 1],[text on click 1];[lat point 2],[lon point 2],[text on hover 2],[text on click 2]
		</p>
	  </div>
	 </div>
	</div></div>
	
  </div></div>
 </div>
<?php
} /* end функция настроек */ 