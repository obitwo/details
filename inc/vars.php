<?php

	global $opts; // load theme options

	// Theme options variables used in header.php
	$hide_logo_area = $opts['hide_logo_area'];
	$enable_logo_image = $opts['enable_logo_image'];
	$logo_upload = $opts['logo_upload'];
	$enable_nav_logo = $opts['enable_nav_logo'];
	$nav_logo_upload = $opts['nav_logo_upload'];
	$fav_icon_upload = $opts['fav_icon_upload'];
	$disable_preloader = $opts['disable_preloader'];
	$disable_fixed = $opts['disable_fixed'];
	$disable_search = $opts['disable_search'];
	$placeholder_text = $opts['placeholder_text'];
	$enable_retina = $opts['retina_display'];
	$sidebar_position = $opts['sidebar_position'];
	$container_type = $opts['container_type'];
	$enable_retina = $opts['enable_retina'];
	$copyright = $opts['copyright'];
	$enable_preview = $opts['enable_preview'];

	$facebook_url = $opts['facebook_url'];
	$twitter_url = $opts['twitter_url'];
	$instagram_url = $opts['instagram_url'];
	$google_url = $opts['google_url'];
	$pinterest_url = $opts['pinterest_url'];
	$youtube_url = $opts['youtube_url'];
	$linkedin_url = $opts['linkedin_url'];
	$tumblr_url = $opts['tumblr_url'];

	$template_style = $opts['template_style'];
	$disable_type = $opts['disable_type'];


	$body_weight = $opts['body_weight'];
	$heading_weight = $opts['heading_weight'];
	$menu_weight = $opts['menu_weight'];
	$body_font = $opts['body_font']['font_family'];
	$heading_font = $opts['heading_font']['font_family'];
	$menu_font = $opts['menu_font']['font_family'];

	$hide_ad_728 = $opts['hide_ad_728'];
	$type_ad_728 = $opts['type_ad_728'];
	$link_ad_728 = $opts['link_ad_728'];
	$image_ad_728 = $opts['image_ad_728'];
	$code_ad_728 = $opts['code_ad_728'];

	$archive_format = $opts['archive_format'];

  $placeholder_text =  $opts['placeholder_text'];

  $panel_max_count = $opts['panel_max_count'];

  $disable_ticker = $opts['disable_ticker'];
  $ticker_title = $opts['ticker_title'];
  $ticker_count = $opts['ticker_count'];
  $ticker_type = $opts['ticker_type'];
  $ticker_cat = $opts['ticker_cat'];
  $ticker_tag = $opts['ticker_tag'];

  $show_sidebar = get_post_meta(get_the_ID(), 'show_sidebar', true);

	if($enable_logo_image == 1 && $enable_retina == 1 && $logo_upload['url']):
		$logo_size_array = getimagesize($logo_upload['url']);
		$logo_size = floor($logo_size_array[0] / 2);
	endif;

?>
