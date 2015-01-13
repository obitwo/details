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
<section class="slider-feature">
  <ul data-orbit data-options="slide_number: false; bullets: false">
<?php endif; ?>

<?php if ($counter % 2 != 0): ?>
    <li>
      <ul class="slider-container">
<?php endif; ?>
    
    <li>
      <div class="thumb-box">
        <a href="<?php the_permalink(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/panel-slider.gif" data-interchange="[<?php echo $full_phone[0]; ?>, (only screen and (min-width: 1px))], [<?php echo $half[0]; ?>, (only screen and (min-width: 480px))]" class="attachment-half" height="<?php echo $half[2]; ?>" width="<?php echo $half[1]; ?>" alt="panel-slider" /></a>
        <div class="caption">
          <h4 class="caption-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
          <div class="caption-content">
            <?php current_subtitle(); ?>
            <?php current_short_byline(); ?>
          </div>
        </div>
        <?php current_post_info(); ?>
      </div>
    </li>


<?php if ($counter % 2 == 0 || $counter == $count): ?>
        </ul>
      </li>
<?php endif; ?>

<?php if ($counter == $count) :?>
  </ul>
</section>
<?php endif; $counter++;?>