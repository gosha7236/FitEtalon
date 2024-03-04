<?php if (!defined('ABSPATH')) {exit;}
/**
* Plugin Name: Maps for WP Lite
* Plugin URI: https://icopydoc.ru/category/documentation/
* Description: A handy plugin for inserting Yandex and Google maps using shortcode.
* Version: 1.2.1
* Requires at least: 4.5
* Requires PHP: 5.6.0
* Author: Maxim Glazunov
* Author URI: https://icopydoc.ru
* License: GPL v2 or later
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain: maps-for-wp
* Domain Path: /languages
* Tags: yandex, google, maps, map, yandex maps
*
* This program is free software; you can redistribute it and/or modify it under the terms of the GNU
* General Public License version 2, as published by the Free Software Foundation. You may NOT assume
* that you can use any other version of the GPL.
*
* This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
* even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
* 
* Copyright 2018-2023 (Author emails: djdiplomat@yandex.ru, support@icopydoc.ru)
*/ 

$nr = false;
// Check php version
if (version_compare(phpversion(), '5.6.0', '<')) { // не совпали версии
	add_action('admin_notices', function() {
		warning_notice('notice notice-error', 
			sprintf(
				'<strong style="font-weight: 700;">%1$s</strong> %2$s 5.6.0 %3$s %4$s',
				'Maps for WP Lite',
				__('plugin requires a php version of at least', 'maps-for-wp'),
				__('You have the version installed', 'maps-for-wp'),
				phpversion()
			)
		);
	});
	$nr = true;
}

/**
 * @since	0.1.0
 * 
 * @param	string			$class (not require)
 * @param	string 			$message (not require)
 * 
 * @return	string/nothing
 * 
 * Display a notice in the admin Plugins page. Usually used in a @hook 'admin_notices'
 */
if (!function_exists('warning_notice')) {
	function warning_notice($class = 'notice', $message = '') {
		printf('<div class="%1$s"><p>%2$s</p></div>', $class, $message);
	}
}

// Define constants
$upload_dir = wp_get_upload_dir();
define('MFWP_SITE_UPLOADS_URL', $upload_dir['baseurl']); // http://site.ru/wp-content/uploads
define('MFWP_SITE_UPLOADS_DIR_PATH', $upload_dir['basedir']); // /home/site.ru/public_html/wp-content/uploads

define('MFWP_PLUGIN_VERSION', '1.2.1'); // 0.1.0
define('MFWP_PLUGIN_UPLOADS_DIR_URL', $upload_dir['baseurl'].'/maps-for-wp'); // http://site.ru/wp-content/uploads/maps-for-wp
define('MFWP_PLUGIN_UPLOADS_DIR_PATH', $upload_dir['basedir'].'/maps-for-wp'); // /home/site.ru/public_html/wp-content/uploads/maps-for-wp
define('MFWP_PLUGIN_DIR_URL', plugin_dir_url(__FILE__)); // http://site.ru/wp-content/plugins/maps-for-wp/
define('MFWP_PLUGIN_DIR_PATH', plugin_dir_path(__FILE__)); // /home/p135/www/site.ru/wp-content/plugins/maps-for-wp/
define('MFWP_PLUGIN_MAIN_FILE_PATH', __FILE__); // /home/p135/www/site.ru/wp-content/plugins/maps-for-wp/maps-for-wp.php
define('MFWP_PLUGIN_SLUG', wp_basename(dirname(__FILE__))); // maps-for-wp - псевдоним плагина
define('MFWP_PLUGIN_BASENAME', plugin_basename(__FILE__)); // maps-for-wp/maps-for-wp.php - полный псевдоним плагина (папка плагина + имя главного файла)
// $nr = apply_filters('mfwp_f_nr', $nr);
unset($upload_dir);

// load translation
add_action('plugins_loaded', function() {
	load_plugin_textdomain('mfwp', false, dirname(MFWP_PLUGIN_BASENAME).'/languages/');
});
/*
if (false === $nr) {
	unset($nr);
	require_once MFWP_PLUGIN_DIR_PATH.'/packages.php';
	register_activation_hook(__FILE__, ['MapsForWP', 'on_activation']);
	register_deactivation_hook(__FILE__, ['MapsForWP', 'on_deactivation']);
	add_action('plugins_loaded', ['MapsForWP', 'init'], 10); // активируем плагин
	define('MFWP_ACTIVE', true);
} */

/* АКТИВАЦИЯ ПЛАГИНА */
require_once plugin_dir_path(__FILE__).'/functions.php'; // Подключаем файл функций
register_activation_hook(__FILE__, array('MapsForWP', 'on_activation'));
register_deactivation_hook(__FILE__, array('MapsForWP', 'on_deactivation'));
register_uninstall_hook(__FILE__, array('MapsForWP', 'on_uninstall'));
add_action('plugins_loaded', array('MapsForWP', 'init'));

final class MapsForWP {
	protected static $instance;
	public static function init() {
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;  
	}
	
	public function __construct() {
		define('mfwp_DIR', plugin_dir_path(__FILE__)); // mfwp_DIR contains /home/p135/www/site.ru/wp-content/plugins/myplagin/
		define('mfwp_URL', plugin_dir_url(__FILE__)); // mfwp_URL contains http://site.ru/wp-content/plugins/myplagin/
		define('mfwp_VER', '1.2.1');	
		
		add_action('admin_menu', array($this, 'add_admin_menu'));	
		add_action('wp_enqueue_scripts', array($this, 'mfwp_enqueue_fp'));
		add_action('admin_notices', array($this, 'mfwp_admin_notices_function'));	
		add_shortcode('MapOnePoint', array($this, 'mfwp_visibility_map_onepoint'));
		add_shortcode('MapManyPoints', array($this, 'mfwp_visibility_map_manypoints'));

		/* Регаем стили только для страницы настроек плагина	*/
		add_action('admin_init', function() {
			wp_register_style('mfwp-admin-css', plugins_url('css/mfwp.css', __FILE__));
		}, 9999);
		
		require_once (WP_PLUGIN_DIR .'/maps-for-wp/includes/class-add-custom-fields.php'); // Подключаем класс
	}

 public static function mfwp_admin_css_func() {
	/* Ставим css-файл в очередь на вывод */
	wp_enqueue_style('mfwp-admin-css');
 } 
 
 public static function mfwp_admin_head_css_func() {
	/* печатаем css в шапке админки */
	print '<style>/* Maps for WP Lite */
		.icp_img1 {background-image: url('. mfwp_URL .'/img/sl1.jpg);}
		.icp_img2 {background-image: url('. mfwp_URL .'/img/sl2.jpg);}
		.icp_img3 {background-image: url('. mfwp_URL .'/img/sl3.jpg);}
	</style>';
 } 
 
 public static function on_activation() {  	
	if (is_multisite()) {
	 add_blog_option(get_current_blog_id(), 'mfwp_version', '1.2.1');
	 add_blog_option(get_current_blog_id(), 'mfwp_map_from', 'google');
	 add_blog_option(get_current_blog_id(), 'mfwp_gapikey', '');
	 add_blog_option(get_current_blog_id(), 'mfwp_type_map', 'roadmap');
	 add_blog_option(get_current_blog_id(), 'mfwp_style_map', 'default');
	 add_blog_option(get_current_blog_id(), 'mfwp_h', '250');	 
	 add_blog_option(get_current_blog_id(), 'mfwp_zoom_OnePoint', '5');
	 add_blog_option(get_current_blog_id(), 'mfwp_zoom_ManyPoints', '5');
	 add_blog_option(get_current_blog_id(), 'mfwp_default_point_img', '');
	 add_blog_option(get_current_blog_id(), 'mfwp_point_img', ''); 
	 add_blog_option(get_current_blog_id(), 'mfwp_center_lat_ManyPoints', '47.236');
	 add_blog_option(get_current_blog_id(), 'mfwp_center_lon_ManyPoints', '38.896');
	} else {
	 add_option('mfwp_version', '1.2.1');
	 add_option('mfwp_map_from', 'google');
	 add_option('mfwp_gapikey', '');
	 add_option('mfwp_type_map', 'roadmap');
	 add_option('mfwp_style_map', 'default');	 
	 add_option('mfwp_h', '250');
	 add_option('mfwp_zoom_OnePoint', '5');
	 add_option('mfwp_zoom_ManyPoints', '5');
	 add_option('mfwp_default_point_img', '');
	 add_option('mfwp_point_img', '');
 	 add_option('mfwp_center_lat_ManyPoints', '47.236');
	 add_option('mfwp_center_lon_ManyPoints', '38.896');
	}
 }
 
 public static function on_deactivation() {  	

 } 
 
 public static function on_uninstall() {  	
	if (is_multisite()) {
	 delete_blog_option(get_current_blog_id(), 'mfwp_version');
	 delete_blog_option(get_current_blog_id(), 'mfwp_map_from');
	 delete_blog_option(get_current_blog_id(), 'mfwp_gapikey');
	 delete_blog_option(get_current_blog_id(), 'mfwp_type_map');
	 delete_blog_option(get_current_blog_id(), 'mfwp_style_map');	 
	 delete_blog_option(get_current_blog_id(), 'mfwp_h');
	 delete_blog_option(get_current_blog_id(), 'mfwp_zoom_OnePoint');
	 delete_blog_option(get_current_blog_id(), 'mfwp_zoom_ManyPoints');
	 delete_blog_option(get_current_blog_id(), 'mfwp_default_point_img');
	 delete_blog_option(get_current_blog_id(), 'mfwp_point_img');
	 delete_blog_option(get_current_blog_id(), 'mfwp_center_lat_ManyPoints');
	 delete_blog_option(get_current_blog_id(), 'mfwp_center_lon_ManyPoints');	 
	} else {
	 delete_option('mfwp_version');
	 delete_option('mfwp_map_from');
	 delete_option('mfwp_gapikey');
	 delete_option('mfwp_type_map');
	 delete_option('mfwp_style_map');		 
	 delete_option('mfwp_h');
	 delete_option('mfwp_zoom_OnePoint');
	 delete_option('mfwp_zoom_ManyPoints');
	 delete_option('mfwp_default_point_img');
	 delete_option('mfwp_point_img');
	 delete_option('mfwp_center_lat_ManyPoints');
	 delete_option('mfwp_center_lon_ManyPoints');
	}
 }

 //регистрируем скрипты для внешней части сайта
 public function mfwp_enqueue_fp() { 
	if (is_multisite()) {		
		$gapikey = get_blog_option(get_current_blog_id(), 'mfwp_gapikey');
		$map_from = get_blog_option(get_current_blog_id(), 'mfwp_map_from');
	} else {
		$gapikey = get_option('mfwp_gapikey');
		$map_from = get_option('mfwp_map_from');
	}
	if ($map_from == 'google') {
		wp_register_script('mfwp_gmaps', 'https://maps.googleapis.com/maps/api/js?key='.$gapikey.'');
		wp_enqueue_script('mfwp_gmaps','', '','', true); // подключаем в футре
		wp_register_script('mfwp_gmaps_js', plugins_url('/js/create-gmaps.js', __FILE__));
		wp_enqueue_script('mfwp_gmaps_js', '', '', '', true);
	} else {
		wp_register_script('mfwp_yamaps', 'https://api-maps.yandex.ru/2.1/?lang=ru_RU');
		wp_enqueue_script('mfwp_yamaps', '', '', '', true); // подключаем в футре
		wp_register_script('mfwp_yamaps_js', plugins_url('/js/create-yamaps.js', __FILE__));
		wp_enqueue_script('mfwp_yamaps_js', '', '', '', true);
	}
 } 
 
 // Register the management page
 public function add_admin_menu() {
	$page_suffix = add_menu_page(null , __('Maps for WP', 'mfwp'), 'manage_options', 'mfwpset', 'mfwp_set_page', 'dashicons-location-alt', 29);
	require_once mfwp_DIR.'/settings.php'; // Подключаем файл настроек

	add_action('admin_print_styles-' . $page_suffix, array($this, 'mfwp_admin_css_func'));
  	add_action('admin_print_styles-' . $page_suffix, array($this, 'mfwp_admin_head_css_func'));

	//add_submenu_page( 'mfwpexport', __('Add Extensions', 'mfwp'), __('Extensions', 'mfwp'), 'manage_options', 'mfwpextensions', 'mfwp_extensions_page' );
	//require_once mfwp_DIR.'/extensions.php'; // Подключаем файл настроек
 } 
 
 function mfwp_visibility_map_manypoints($atts){
 /*
 * Получить гугл ключик АПИ https://developers.google.com/maps/documentation/javascript/get-api-key?hl=ru#key
 * Вид шорткода:
 * lat - широта
 * lon - долгота
 * [MapManyPoints id="test" type="" lat="50" lon="30" zoom="6" h="150" points="25,-1,описание;-5,13,"]
 */	
	if (isset($atts['id'])) {$id = $atts['id'];} else {$id="0";}
	if (isset($atts['lat'])) {$lat = $atts['lat'];} else {		
	 if (is_multisite()) {		
		$lat = get_blog_option(get_current_blog_id(), 'mfwp_center_lat_ManyPoints');
	 } else {
		$lat = get_option('mfwp_center_lat_ManyPoints');
	 }
	}
	if (isset($atts['lon'])) {$lon = $atts['lon'];} else {
	 if (is_multisite()) {		
		$lon = get_blog_option(get_current_blog_id(), 'mfwp_center_lon_ManyPoints');
	 } else {
		$lon = get_option('mfwp_center_lon_ManyPoints');
	 }
	}
	if (isset($atts['zoom'])) {$zoom = (int)$atts['zoom'];} else {
		if (is_multisite()) {
			$zoom = (int)get_blog_option(get_current_blog_id(), 'mfwp_zoom_OnePoint');
		} else {
			$zoom = (int)get_option('mfwp_zoom_OnePoint');
		}
	}
	if (isset($atts['h'])) {$h = (int)$atts['h'];} else {
	 if (is_multisite()) {		
		$h = (int)get_blog_option(get_current_blog_id(), 'mfwp_h');
	 } else {
		$h = (int)get_option('mfwp_h');
	 }		
	}
	
	if (isset($atts['type'])) {$type = $atts['type'];} else {
	 if (is_multisite()) {
		$type = get_blog_option(get_current_blog_id(), 'mfwp_type_map');
	 } else {
		$type = get_option('mfwp_type_map'); 
	 }
	}
	
	if (isset($atts['mstyle'])) {$style = $atts['mstyle'];} else {
	 if (is_multisite()) {
		$mstyle = get_blog_option(get_current_blog_id(), 'mfwp_style_map');
	 } else {
		$mstyle = get_option('mfwp_style_map'); 
	 }
	}	
	
	if (isset($atts['img'])) {$src = $atts['img'];} else {
	 if (is_multisite()) {
		if (get_blog_option(get_current_blog_id(), 'mfwp_point_img') == '') {
			$src = WP_PLUGIN_URL ."/maps-for-wp/img/marker.png";
		} else {
			$image_attributes_res = wp_get_attachment_image_src(get_blog_option(get_current_blog_id(), 'mfwp_point_img'), array(130, 130));
			$src = $image_attributes_res[0]; // урл картинки		
		}
	 } else {
		if (get_option('mfwp_point_img') == '') {			
			$src = WP_PLUGIN_URL ."/maps-for-wp/img/marker.png";
		} else {
			$image_attributes_res = wp_get_attachment_image_src(get_option('mfwp_point_img'), array(130, 130));
			$src = $image_attributes_res[0]; // урл картинки		
		}		 
	 }
	}
	if (is_multisite()) {
	 if (get_blog_option(get_current_blog_id(), 'mfwp_default_point_img') == 'on') {$src = '';}	
	} else {
	 if (get_option('mfwp_default_point_img') == 'on') {$src = '';}		
	}
	
	$pointsdate = Array();
	if (isset($atts['points'])) {$points = $atts['points'];
		$res = explode(";", $points);
		//$pointsdate = Array();
		$i = 0;
		foreach ($res as $value) {
			$pointdate = explode(",", $value);
			$pointsdate[$i]['lat'] = (float)$pointdate[0];
			$pointsdate[$i]['lon'] = (float)$pointdate[1];
			$pointsdate[$i]['thover'] = $pointdate[2];
			$pointsdate[$i]['tclick'] = $pointdate[3];
			$i++;
			//$pointsdate[] = $pointdate;
		}	
	}
 /* end проверка данных */
	if (is_multisite()) {
		if (get_blog_option(get_current_blog_id(), 'mfwp_map_from') == 'yandex') {
			if ($type == 'roadmap' || $type == 'terrain') {$type = 'map';}
		}
	} else {
		if (get_option('mfwp_map_from') == 'yandex') {
			if ($type == 'roadmap' || $type == 'terrain') {$type = 'map';}
		}
	}
	$arr[] = array(
		'mfwp_id' => $id,
		'mfwp_type' => $type,
		'mfwp_lat' => $lat,
		'mfwp_lon' => $lon,
		'mfwp_zoom' => $zoom,
		'iconImageHref' => $src,
		//'points' => $points,
		//'res1' => $pointdate[1],
		//'mfwp_thover' => $thover,
		//'mfwp_tclick' => $tclick//,
		'mfwp_pointsdate' => $pointsdate
	);
	$js_obj2 = json_encode($arr); 
	
	print "<script language='javascript'>
	if (typeof mfwp_setings_ManyPoints =='undefined'){
		var mfwp_setings_ManyPoints = []; 
		mfwp_setings_ManyPoints.push($js_obj2); 
	} else {
		mfwp_setings_ManyPoints.push($js_obj2);
	}
	</script>";
	
	switch ($mstyle) {
		case 'blackwhite': // Черно-белая карта
			$css_for_yandex = 'filter: grayscale(1); -ms-filter: grayscale(1); -webkit-filter: grayscale(1); -moz-filter: grayscale(1); -o-filter: grayscale(1);';
			break;
		case 'blackout': // Затемнение
			$css_for_yandex = 'filter: brightness(50%); -ms-filter: brightness(50%); -webkit-filter: brightness(50%); -moz-filter: brightness(50%); -o-filter: brightness(50%);';
			break;
		case 'сolorinversion': // Инверсия цветов
			$css_for_yandex = 'filter: invert(100%); -ms-filter: invert(100%); -webkit-filter: invert(100%); -moz-filter: invert(100%); -o-filter: invert(100%);';
			break;			
		default:
			$css_for_yandex = '';
	}
	if ($css_for_yandex !== '') {
		print '<style>#mfwpm'.$id.' [class*="ymaps-2"][class*="-ground-pane"]{'.$css_for_yandex.'}</style>';
	}	
	
	return '<div style="width: 100%; height: '.$h.'px;" class="mfwpMany" id="mfwpm'.$id.'"></div>';	
 }
 
 function mfwp_visibility_map_onepoint($atts){
 /*
 * Получить гугл ключик АПИ https://developers.google.com/maps/documentation/javascript/get-api-key?hl=ru#key
 * Вид шорткода:
 * lat - широта
 * lon - долгота
 * [MapOnePoint id="" type="" lat="" lon="" zoom="" h="" img="" thover="" tclick=""]
 */	
 /* проверка данных */
	if (isset($atts['thover'])) {$thover = $atts['thover'];} else {$thover="";}
	if (isset($atts['tclick'])) {$tclick = $atts['tclick'];} else {$tclick="";}
	
	if (isset($atts['id'])) {$id = $atts['id'];} else {$id="0";}
	if (isset($atts['lat'])) {$lat = $atts['lat'];} else {$lat=30;}
	if (isset($atts['lon'])) {$lon = $atts['lon'];} else {$lon=30;}
	if (isset($atts['zoom'])) {$zoom = (int)$atts['zoom'];} else {
		if (is_multisite()) {
			$zoom = (int)get_blog_option(get_current_blog_id(), 'mfwp_zoom_OnePoint');
		} else {
			$zoom = (int)get_option('mfwp_zoom_OnePoint');
		}
	}
	if (isset($atts['h'])) {$h = (int)$atts['h'];} else {
	 if (is_multisite()) {		
		$h = (int)get_blog_option(get_current_blog_id(), 'mfwp_h');
	 } else {
		$h = (int)get_option('mfwp_h');
	 }		
	}
	
	if (isset($atts['type'])) {$type = $atts['type'];} else {
	 if (is_multisite()) {
		$type = get_blog_option(get_current_blog_id(), 'mfwp_type_map');
	 } else {
		$type = get_option('mfwp_type_map'); 
	 }
	}
	
	if (isset($atts['mstyle'])) {$mstyle = $atts['mstyle'];} else {
	 if (is_multisite()) {
		$mstyle = get_blog_option(get_current_blog_id(), 'mfwp_style_map');
	 } else {
		$mstyle = get_option('mfwp_style_map'); 
	 }
	}	
	
	if (isset($atts['img'])) {$src = $atts['img'];} else {
	 if (is_multisite()) {
		if (get_blog_option(get_current_blog_id(), 'mfwp_point_img') == '') {
			$src = WP_PLUGIN_URL ."/maps-for-wp/img/marker.png";
		} else {
			$image_attributes_res = wp_get_attachment_image_src(get_blog_option(get_current_blog_id(), 'mfwp_point_img'), array(130, 130));
			$src = $image_attributes_res[0]; // урл картинки		
		}
	 } else {
		if (get_option('mfwp_point_img') == '') {			
			$src = WP_PLUGIN_URL ."/maps-for-wp/img/marker.png";
		} else {
			$image_attributes_res = wp_get_attachment_image_src(get_option('mfwp_point_img'), array(130, 130));
			$src = $image_attributes_res[0]; // урл картинки		
		}		 
	 }
	}
	if (is_multisite()) {
	 if (get_blog_option(get_current_blog_id(), 'mfwp_default_point_img') == 'on') {$src = '';}	
	} else {
	 if (get_option('mfwp_default_point_img') == 'on') {$src = '';}		
	}
 /* end проверка данных */
	if (is_multisite()) {
		if (get_blog_option(get_current_blog_id(), 'mfwp_map_from') == 'yandex') {
			if ($type == 'roadmap' || $type == 'terrain') {$type = 'map';}
		}
	} else {
		if (get_option('mfwp_map_from') == 'yandex') {
			if ($type == 'roadmap' || $type == 'terrain') {$type = 'map';}
		}
	}
	$arr[] = array(
		'mfwp_id' => $id,
		'mfwp_type' => $type,
		'mfwp_lat' => $lat,
		'mfwp_lon' => $lon,
		'mfwp_zoom' => $zoom,
		'iconImageHref' => $src,
		'mfwp_thover' => $thover,
		'mfwp_tclick' => $tclick
	);
	$js_obj2 = json_encode($arr); 
	
	print "<script language='javascript'>
	if (typeof mfwp_setings_OnePoint =='undefined'){
		var mfwp_setings_OnePoint = []; 
		mfwp_setings_OnePoint.push($js_obj2); 
	} else {
		mfwp_setings_OnePoint.push($js_obj2);
	}
	</script>";
	
	switch ($mstyle) {
		case 'blackwhite': // Черно-белая карта
			$css_for_yandex = 'filter: grayscale(1); -ms-filter: grayscale(1); -webkit-filter: grayscale(1); -moz-filter: grayscale(1); -o-filter: grayscale(1);';
			break;
		case 'blackout': // Затемнение
			$css_for_yandex = 'filter: brightness(50%); -ms-filter: brightness(50%); -webkit-filter: brightness(50%); -moz-filter: brightness(50%); -o-filter: brightness(50%);';
			break;
		case 'сolorinversion': // Инверсия цветов
			$css_for_yandex = 'filter: invert(100%); -ms-filter: invert(100%); -webkit-filter: invert(100%); -moz-filter: invert(100%); -o-filter: invert(100%);';
			break;			
		default:
			$css_for_yandex = '';
	}
	if ($css_for_yandex !== '') {
		print '<style>#mfwp'.$id.' [class*="ymaps-2"][class*="-ground-pane"]{'.$css_for_yandex.'}</style>';
	}
	//return '<div id="mfwp_map_'.$id.'" class="mfwp_map"></div>';
	
	return '<div style="width: 100%; height: '.$h.'px;" class="mfwpOne" id="mfwp'.$id.'"></div>';
 }
 
 public function mfwp_admin_notices_function() {
	if (is_multisite()) {
	 if ((get_blog_option(get_current_blog_id(), 'mfwp_gapikey') == '') && (get_blog_option(get_current_blog_id(), 'mfwp_map_from') == 'google')) { 
		print '<div class="notice error is-dismissible"><p>'. __('Google Maps require an API key to function', 'mfwp'). '. <a href="//developers.google.com/maps/documentation/javascript/get-api-key">'. __('You can create an API key here now (free)', 'mfwp') .'</a>. '. __('Fill in the "Google Maps API Key" field in the plugin&#39;s settings or switch to Yandex maps', 'mfwp') .'.</p></div>';
	 } 
	} else {
	 if ((get_option('mfwp_gapikey') == '') && (get_option('mfwp_map_from') == 'google')) { 
		print '<div class="notice error is-dismissible"><p>'. __('Google Maps require an API key to function', 'mfwp'). '. <a href="//developers.google.com/maps/documentation/javascript/get-api-key">'. __('You can create an API key here now (free)', 'mfwp') .'</a>. '. __('Fill in the "Google Maps API Key" field in the plugin&#39;s settings or switch to Yandex maps', 'mfwp') .'.</p></div>';
	 } 		
	}
	if (isset($_REQUEST['mfwp_submit_action'])) {
		print '<div class="updated notice notice-success is-dismissible"><p>'. __('Updated', 'mfwp'). '.</p></div>';
	}
 }
} /* end class MapsForWP */