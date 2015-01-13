<?php
global $count, $counter, $panel_sidebar;

if ($panel_sidebar):
  $src = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'half' );
  $half = $src;
else:
  $src = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'half-fullscreen' );
  $half = $src;
endif;
$src = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full-phone' );
$full_phone = $src;

?> 

<?php if ($counter == 1): ?>
<ul class="panel-content half-excerpt-container">
<?php endif; ?>

    <li>
      <div class="thumb-box">
        <a href="<?php the_permalink(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/panel-slider.gif" data-interchange="[<?php echo $full_phone[0]; ?>, (only screen and (min-width: 1px))], [<?php echo $half[0]; ?>, (only screen and (min-width: 480px))]" class="attachment-half" height="<?php echo $half[2]; ?>" width="<?php echo $half[1]; ?>" alt="panel-excerpt" /></a>
        <?php current_post_info(); ?>
      </div>
    </li>

    <li>
      <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><?php current_subtitle(); ?></h2>
      
      <?php current_short_byline(); ?>
      <?php the_excerpt(); ?>
      
    </li>

<?php if ($counter == $count) :?>
</ul>
<?php endif; $counter++;?>