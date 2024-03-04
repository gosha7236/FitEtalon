<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
function LBDdeleteParticipants( $user_id ){
	global $wpdb;
	$table1 = $wpdb->prefix . "lbd_event_participants"; 
	
	$user_obj = get_userdata( $user_id );
	$email = $user_obj->user_email;
	
	if($email != ''){
		$wpdb->delete( $table1, array( 'email' => $email ) );
	}
}
add_action( 'delete_user', 'LBDdeleteParticipants' );
/////////// Disable wp admin bar for all participants ///////////
add_action("init", "LBDdisableWPadminBar");
function LBDdisableWPadminBar() {
	if (!current_user_can('administrator') && !is_admin()) {
	  show_admin_bar(false);
	}
}
add_action('admin_init', 'LBDdisable_dashboard');
function LBDdisable_dashboard() {
	global $wpdb, $post;
	$my_account = get_option('LeaderBoard_eventMyAccount');
    if (is_admin()) {
		 if (current_user_can('event_participant')) {
			wp_redirect(get_permalink($my_account));
			exit;
		}
    }
}
/////////// upload media ///////////
function LBD_register_team_show_case_setting() {
//register our settings
    register_setting('my_team_show_case_setting', 'my_file_upload');
}
add_action('admin_init', 'LBD_register_team_show_case_setting');
function LBD_handle_attachment($file_handler,$post_id,$set_thu=false) {
  // check to make sure its a successful upload
  if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();

  require_once(ABSPATH . "wp-admin" . '/includes/image.php');
  require_once(ABSPATH . "wp-admin" . '/includes/file.php');
  require_once(ABSPATH . "wp-admin" . '/includes/media.php');

  $attach_id = media_handle_upload( $file_handler, $post_id );
  if ( is_numeric( $attach_id ) ) {
    update_post_meta( $post_id, '_front-EveScore', $attach_id );
  }
  return $attach_id;
}