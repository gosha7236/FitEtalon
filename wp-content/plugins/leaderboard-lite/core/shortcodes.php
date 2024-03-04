<?php if ( ! defined( 'ABSPATH' ) ) exit; 
//Shortcode to list individual events 
add_shortcode( 'Events', 'getLBDEvent' );
function getLBDEvent($atts ){}