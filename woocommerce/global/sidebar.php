<?php
/**
 * Sidebar
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $opts;

$sidebar_position = $opts['sidebar_position'];
$show_sidebar = get_post_meta($post->ID, 'show_sidebar', true);

if (is_shop() || is_product_category() || is_product_tag()):
	$show_sidebar = 'hide';
endif;


if ($show_sidebar != 'hide'): 
	if ($show_sidebar == 'show'): 
		get_sidebar('shop'); 
	else: 
		if($sidebar_position != 'none'): 
			get_sidebar('shop'); 
		endif; 
	endif; 
endif;

?>