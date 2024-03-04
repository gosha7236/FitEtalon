<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php global $wpdb, $post; ?>
<?php
	date_default_timezone_set("UTC");
	$table1 = $wpdb->prefix . "lbd_event_participants"; 
	$table2 = $wpdb->prefix . "lbd_event_scores"; 
	$table3 = $wpdb->prefix . "lbd_event_divisions"; 
	$table4 = $wpdb->prefix . "lbd_event_events"; 
	$table5 = $wpdb->prefix . "lbd_event_competitions"; 
	$table6 = $wpdb->prefix . "lbd_event_registeredEvents"; 
	
	$LeaderBoard_eventUserLogin 				= get_option('LeaderBoard_eventUserLogin');
	$LeaderBoard_eventspage 						= get_option('LeaderBoard_eventspage');
	$LeaderBoard_eventRegistrationpage 	= get_option('LeaderBoard_eventRegistrationpage');
	$LeaderBoard_eventMyAccount 				= get_option('LeaderBoard_eventMyAccount');
	$LeaderBoard_Payment 							= get_option('LeaderBoard_Payment');
	$LeaderBoard_eventUserRegistration 	= get_option('LeaderBoard_eventUserRegistration');
	
	if(is_user_logged_in() && current_user_can('event_participant')){
		wp_redirect(get_permalink($LeaderBoard_eventMyAccount));exit;
	}
?>
<?php get_header(); ?>
<?php
$login = (isset($_GET['login']))?sanitize_text_field($_GET['login']):'';
$id 		= (isset($_GET['id']))?sanitize_text_field($_GET['id']):'';
?>
<section class="commen-wraper log-in-block">
<?php if(isset($login)=='failed'){
		echo '<div class="note_error">Login Failed.</div>';
	} ?>
    <div class="log-in-main">
        <h3><?php echo esc_html('Event LeaderBoard Login'); ?> </h3>
        <div class="log-in-form">
		<?php
		$redirect_to = get_permalink($LeaderBoard_eventRegistrationpage)."?id=".$id;
		$args = array('redirect' => $redirect_to,
							'id_username' => 'user',
							'id_password' => 'pass',
							'label_username' => 'Username');
		?>
		<?php wp_login_form( $args ); ?>
		<p class="reg_sec"><label><?php echo esc_html('New User?'); ?> </label><a href="<?php echo get_permalink($LeaderBoard_eventUserRegistration); ?>" class="blue-btn"><?php echo esc_html('Register Now'); ?></a></p>
        </div>
    </div>
</section>
<?php get_footer(); ?>