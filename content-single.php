<?php
/**
 * @package current
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?><?php current_subtitle(); ?></h1>

		<div class="entry-meta">
			<?php current_byline(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

  <?php $use_rating = get_post_meta($post->ID, 'use_rating', true); if ($use_rating): current_full_rating(); endif; ?>
  
	<div class="entry-content <?php if ($use_rating): ?> content-rating<?php endif; ?>">
	  
	  <?php current_show_feature(); ?>
	
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'current' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php if ( has_tag() ): ?><i class="fa fa-tag"></i> <?php the_tags(); endif; ?>		
	</footer><!-- .entry-footer -->
	
	<?php current_author_info(); ?>


</article><!-- #post-## -->
