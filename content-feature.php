<?php
global $count, $counter;

$src = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'feature' );
$feature = $src;
$src = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'sub-feature' );
$sub_feature = $src;
$src = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full-phone' );
$full_phone = $src;

?> 

<?php if ($counter == 1): ?>
    <section class="home-featured-container">
    <div class="home-feature-preloader"><div class="preloader"></div></div>
    <div class="home-featured container">
      <div class="main-feature">
        <ul data-orbit data-options="animation: fade; slide_number: false; timer: false; bullets: false; variable_height: true">
<?php endif; ?>

<?php if ($counter > 1 && $counter < 4): ?>
  <?php if ($counter == 2): ?>
      <li class="sub-feature">
  <?php endif; ?>

    <div class="sub-feature-container">
      <div class="thumb-box">
        <a href="<?php the_permalink(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/sub-feature.gif" data-interchange="[<?php echo $full_phone[0]; ?>, (only screen and (min-width: 1px))], [<?php echo $sub_feature[0]; ?>, (only screen and (min-width: 480px))]" class="attachment-sub-feature" height="<?php echo $sub_feature[2]; ?>" width="<?php echo $sub_feature[1]; ?>" alt="feature"  /></a>
        <div class="caption">
          <h4 class="caption-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
          <div class="caption-content">
            <?php current_subtitle(); ?>
            <?php current_short_byline(); ?>
          </div>
        </div>
        <?php current_post_info(); ?>
      </div>
    </div>


  <?php if ($counter == 3 || $counter == $count): ?>
      </li>
  <?php endif; ?>

<?php else: ?>
    <li data-orbit-slide="headline-<?php echo $counter; ?>">
      <div class="thumb-box">
        <a href="<?php the_permalink(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/feature.gif" data-interchange="[<?php echo $full_phone[0]; ?>, (only screen and (min-width: 1px))], [<?php echo $feature[0]; ?>, (only screen and (min-width: 480px))]" class="attachment-feature" height="<?php echo $feature[2]; ?>" width="<?php echo $feature[2]; ?>" alt="sub-feature" /></a>

        <div class="caption-container">
        <div class="caption">
            <h2 class="caption-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <?php current_subtitle(); ?>
            <div class="caption-excerpt">
            </div>
            <a href="<?php the_permalink(); ?>" class="button feature-button">Full Story</a>
            <div class="caption-content">
              <?php current_short_byline(); ?>
            </div>
        </div>
        </div>
        <?php current_post_info(); ?>
      </div>
    </li>
<?php endif; ?>


<?php if ($counter == $count) :?>
        </ul>
      </div>
    </div>
    </section>
<?php endif; $counter++;?>