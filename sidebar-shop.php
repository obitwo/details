<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package current
 */
 include('inc/vars.php');
 if ( current_show_sidebar() ):
?>

  <div class="sidebar-container">
	<div id="secondary" class="sidebar widget-area" role="complementary">
		<?php if ( ! dynamic_sidebar( 'shop' ) ) : ?>

			<aside id="search" class="widget widget_search">
				<?php get_search_form(); ?>
			</aside>

			<aside id="archives" class="widget">
				<h4 class="widget-title"><?php _e( 'Archives', 'current' ); ?></h4>
				<ul>
					<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
				</ul>
			</aside>

			<aside id="meta" class="widget">
				<h4 class="widget-title"><?php _e( 'Meta', 'current' ); ?></h4>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<?php wp_meta(); ?>
				</ul>
			</aside>

		<?php endif; // end sidebar widget area ?>
	</div><!-- #secondary -->
  </div>
  
<?php endif; ?>
