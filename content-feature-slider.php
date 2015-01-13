<?php
global $count, $counter;

$src = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'slider-feature' );
$slider_feature = $src;
$src = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full-phone' );
$full_phone = $src;

?> 

<?php if ($counter == 1): ?>
<section class="slider-feature">
  <ul data-orbit data-options="slide_number: false; bullets: false">
<?php endif; ?>

<?php if ($counter == 1 || ($counter - 1) % 4 == 0): ?>
    <li>
      <ul class="slider-container">
<?php endif; ?>
    
    <li>
      <div class="thumb-box">
        <a href="<?php the_permalink(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/slider-feature.gif" data-interchange="[<?php echo $full_phone[0]; ?>, (only screen and (min-width: 1px))], [<?php echo $slider_feature[0]; ?>, (only screen and (min-width: 480px))]" class="attachment-slider-feature" height="<?php echo $slider_feature[2]; ?>" width="<?php echo $slider_feature[1]; ?>" alt="slider-feature" /></a>
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


<?php if ($counter % 4 == 0 || $counter == $count): ?>
        </ul>
      </li>
<?php endif; ?>

<?php if ($counter == $count) :?>
  </ul>
</section>
<?php endif; $counter++;?>