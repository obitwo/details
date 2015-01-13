<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package current
 */
 
 include('inc/vars.php');
 
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php if ($fav_icon_upload['url']): ?><link rel="icon" type="image/png" href="<?php echo $fav_icon_upload['url']; ?>"><?php endif; ?>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">


<?php wp_head(); ?>
<?php current_sidebar_position(); ?>
</head>

<body <?php body_class(); ?>>

  <?php current_show_preview(); ?>
  
  <!-- Boxed -->
  <?php if ($container_type == 'boxed'): ?>
  <div class="boxed">
  <?php endif; ?>



  <!-- Off Canvas Navigation -->
  <div class="off-canvas-wrap">


  <!-- Navigation -->
  <?php if($disable_fixed != 0 && !is_admin_bar_showing()): ?>
  <div class="fixed">
  <?php endif; ?>

  <nav class="top-bar" data-topbar data-options="sticky_class:sticky-nav">

    <section class="top-bar-section">
        <div class="container">
        <?php if ($enable_nav_logo != '0'): ?>
        <ul class="title-area">
          <li class="name logo">
            <h1><a href="<?php bloginfo('url') ?>"><?php if($nav_logo_upload['url']): ?><img src="<?php echo $nav_logo_upload['url']; ?>" alt="small logo" <?php if($nav_logo_size): echo ' width="'.$nav_logo_size.'"'; endif; ?> /><?php else: bloginfo('name'); endif; ?></a></h1>
          </li>
        </ul>
        <?php endif; ?>
        <!-- Left Nav Section -->
        <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'left nav-desktop' ) ); ?>

        <!-- Right Nav Section -->
        <ul class="right social-media nav-desktop">
          <?php current_social_links(); ?>
          <!-- Shopping Cart -->
          <?php if ( class_exists( 'WooCommerce' ) ): ?>
          <li class="has-form">
            <a href="<?php global $woocommerce; echo $woocommerce->cart->get_cart_url(); ?>" class="button cart-contents"><?php echo sprintf(_n('(%d)', '(%d)', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?> <i class="fa fa-shopping-cart"></i><?php if($woocommerce->cart->cart_contents_count > 0): echo ' - '.$woocommerce->cart->get_cart_total(); endif; ?> <span class="icon-label">Shopping Cart</span></a>
          </li>
          <?php endif; ?>
          <!-- Search -->
          <?php if ($disable_search != 0): ?>
          <li class="has-form search-li">
            <a class="button toggle-search"><i class="fa fa-search"></i></a>
            <div class="nav-search">
              <?php get_search_form(); ?>
            </div>
          </li>
          <?php endif; ?>
        </ul>

        <ul class="right nav-mobile">
          <li><a href="#" class="right-off-canvas-toggle"><i class="fa fa-list"></i></a></li>
        </ul>


        <div class="clearfix"></div>
      </div>
    </section>
  </nav>

  <?php if($disable_fixed != 0 && !is_admin_bar_showing()): ?>
  </div>
  <?php endif; ?>



  <div class="inner-wrap">
  <aside class="right-off-canvas-menu"></aside>
  <?php current_ticker(); ?>
  <?php if($hide_logo_area != 0): ?>
  <!-- Header -->
  <section class="header">
    <div class="container">
      <div class="logo<? if ($hide_ad_728 != "1"): echo ' logo-center'; endif; ?>"><a href="<?php bloginfo('url') ?>"><?php if($logo_upload['url']):?><img src="<?php echo $logo_upload['url']; ?>" alt="logo" <?php if($logo_size): echo ' width="'.$logo_size.'"'; endif; ?> /><?php else: bloginfo('name'); endif; ?></a><span><?php bloginfo('description'); ?></span></div>
      <? if ($hide_ad_728 == "1"): current_ad_728(); endif; ?>
      <div class="clearfix"></div>
    </div>
  </section>
  <?php endif; ?>

  <?php current_main_feature(); ?>
  <?php current_slider_feature(); ?>

  <div class="container">
    <div id="content" class="content<?php if ($show_sidebar == "hide"): echo " content-full"; endif; ?>">
