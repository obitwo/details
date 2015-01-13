<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package current
 */

  include('inc/vars.php');
  // Check if panels are enabled
  $use_panels = get_post_meta($post->ID, 'use_panels', true);
  $show_panel = get_post_meta($post->ID, 'show_panel', true);

  if ($panel_max_count):
    $max_panels = $panel_max_count;
  else:
    $max_panels = 10;
  endif;


get_header(); ?>
  

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">


		<?php 

		if ( $use_panels ):

			for($x = 1; $x <= $max_panels; $x++):
		
				if ($show_panel[$x]): 
				
					current_display_panel($x); 
					
				endif;
		
			endfor;
		
		else:
		
		?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() ) :
						comments_template();
					endif;
				?>

			<?php endwhile; // end of the loop. ?>
    
    <?php endif; ?>
    
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
