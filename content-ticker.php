<?php
include('inc/vars.php'); 
global $count, $counter;
?> 

<?php if ($counter == 1): ?>
    <!-- Ticker -->
    <section class="ticker-container">
      <div class="container">
        <div class="ticker">
          <div class="ticker-title"><div class="ticker-title-padding"><?php echo $ticker_title; ?></div></div>
          <div class="ticker-switch">
            <ul data-orbit data-options="pause_on_hover: true; resume_on_mouseout: true; timer_speed: 4000; navigation_arrows: false; slide_number: false; bullets: false; timer: true; variable_height: false">
    <?php endif; ?>
    
        <li><div class="ticker-item"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div></li>
        
    <?php if ($counter == $count) :?>
            </ul>
          </div>
        </div>
      </div>
    </section>
<?php endif; $counter++;?>