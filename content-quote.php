<?php
/**
 * The template for displaying posts in the Quote post format
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
		<blockquote>
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'current' ) ); ?>
		</blockquote>
		<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'current' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">

		<?php if ( comments_open() && ! is_single() ) : ?>
		<span class="comments-link">
			<?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a comment', 'current' ) . '</span>', __( 'One comment so far', 'current' ), __( 'View all % comments', 'current' ) ); ?>
		</span><!-- .comments-link -->
		<?php endif; // comments_open() ?>
	</footer><!-- .entry-meta -->
</article><!-- #post -->
