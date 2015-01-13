<?php
/**
 * The template for displaying posts in the Audio post format
 *
 * @package current
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if ( is_single() ) : ?>
		<h1 class="page-title"><?php the_title(); ?><?php current_subtitle(); ?></h1>
		<?php else : ?>
		<h1 class="page-title">
			<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
			<?php current_subtitle(); ?>
		</h1>
		<?php endif; // is_single() ?>


		<div class="entry-meta">
			<?php current_byline(); ?>
		</div><!-- .entry-meta -->

	</header><!-- .entry-header -->

	<div class="entry-content">
		<div class="audio-content">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'current' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'current' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
		</div><!-- .audio-content -->
	</div><!-- .entry-content -->

	<footer class="entry-meta">

		<?php if ( is_single() && get_the_author_meta( 'description' ) && is_multi_author() ) : ?>
			<?php get_template_part( 'author-bio' ); ?>
		<?php endif; ?>
	</footer><!-- .entry-meta -->
</article><!-- #post -->
