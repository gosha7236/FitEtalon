<?php if (!defined('ABSPATH')) {exit;}
/**
 * С версии 2.0.0
 * Возвращает то, что может быть результатом get_blog_option, get_option
 */
function mfwp_optionGET($optName) {
	if ($optName == '') {return false;}
	if (is_multisite()) { 
		return get_blog_option(get_current_blog_id(), $optName);
	} else {
		return get_option($optName);
	}
}
/**
 * С версии 2.0.0
 * Записывает файл логов /wp-content/uploads/mfwp/mfwp.log
 */
function mfwp_error_log($text, $i) {
	// $mfwp_keeplogs = mfwp_optionGET('mfwp_keeplogs');	
	if (mfwp_KEEPLOGS !== 'on') {return;}
	$upload_dir = (object)wp_get_upload_dir();
	$name_dir = $upload_dir->basedir."/mfwp";
	// подготовим массив для записи в файл логов
	if (is_array($text)) {$r = mfwp_array_to_log($text); unset($text); $text = $r;}
	if (is_dir($name_dir)) {
		$filename = $name_dir.'/mfwp.log';
		file_put_contents($filename, '['.date('Y-m-d H:i:s').'] '.$text.PHP_EOL, FILE_APPEND);		
	} else {
		if (!mkdir($name_dir)) {
			error_log('Нет папки mfwp! И создать не вышло! $name_dir ='.$name_dir.'; Файл: functions.php; Строка: '.__LINE__, 0);
		} else {
			error_log('Создали папку mfwp!; Файл: functions.php; Строка: '.__LINE__, 0);
			$filename = $name_dir.'/mfwp.log';
			file_put_contents($filename, '['.date('Y-m-d H:i:s').'] '.$text.PHP_EOL, FILE_APPEND);
		}
	} 
	return;
}
/**
 * С версии 2.1.0
 * Позволяте писать в логи массив /wp-content/uploads/mfwp/mfwp.log
 */
function mfwp_array_to_log($text, $i=0, $res = '') {
	$tab = ''; for ($x = 0; $x<$i; $x++) {$tab = '---'.$tab;}
	if (is_array($text)) { 
	$i++;
	foreach ($text as $key => $value) {
		if (is_array($value)) {	// массив
			$res .= PHP_EOL .$tab."[$key] => ";
			$res .= $tab.mfwp_array_to_log($value, $i);
		} else { // не массив
			$res .= PHP_EOL .$tab."[$key] => ". $value;
		}
	}
	} else {
		$res .= PHP_EOL .$tab.$text;
	}
	return $res;
}