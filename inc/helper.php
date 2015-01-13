<?php

function setPostViews() {
	global $post;
	if (!current_user_can('level_7') ) :
		$count_key = 'view_count';
		$count = get_post_meta($post->ID, $count_key, true);
		if(empty($count)):
			update_post_meta($post->ID, $count_key, 0);
		endif;
		$count++;
		update_post_meta($post->ID, $count_key, $count);
	endif;
}




// Admin styles and scripts
function preview_js() { 

  include('vars.php');
  
  if ($enable_preview != 0):
  ?>
	
	<script type="text/javascript">
		(function($){
			$(document).ready(function() {
			  
    		// Styles
    		
    		$('.theme-style').change(function(){
      
          if ( $(this).val() == "style1" ){
            $('head').append('<link href="<?php echo get_template_directory_uri(); ?>/css/style1.css" rel="stylesheet" id="style1" />');
            jQuery('#style2').remove();
          }
          else if( $(this).val() == "style2" ){
            $('head').append('<link href="<?php echo get_template_directory_uri(); ?>/css/style2.css" rel="stylesheet" id="style2" />');
            jQuery('#style1').remove();
          }
          else{
            jQuery('#style1').remove();
            jQuery('#style2').remove();
            
          }
      
    		});
			  
    		// Change container type
    		$('.container-type').change(function(){
      
          if ( $(this).val() == "boxed" ){
            $('body').addClass('boxed-image');
          }	
          else{
            $('body').removeClass('boxed-image');
          }
      
    		});


			});
		
		})(jQuery);
	</script>
	
  <?php
  endif;
}

add_action('wp_head', 'preview_js');


// Admin styles and scripts
function admin_css() { 
?>

	<style type="text/css">
	
		.ce-half{
		}
		.ce-half .panel-sort-title{
			margin: -15px!important;
			cursor: pointer;
			padding: .5em!important;
			
			background: #f5f5f5;
		}
		.ce-half-padding{
			padding: 15px;
			border: 1px solid #ddd;
		}
		
		.panel-sort-title span{
			display: inline-block;
		}
		.panel-number{
			padding: .25em .5em;
			background: #FFF;
			border: 1px solid #CCC;
			margin-right: .1em;
		}
		.panel-style{
			color: #888;
			font-size: .9em;
		}
		.panel-status{
			background: #666;
			color: #FFF;
			padding: .25em .75em;
			margin-left: 1em;
			font-size: 10px;
			text-transform: uppercase;
		}
		.panel-sort-title .enabled{
			background: green;
		}
		.panel-toggle{
			float: right;
			font-size: 22px;
			font-weight: bold;
			cursor: pointer;
		}
		
		.panel-inputs{
			padding-top: 1em;
			display: none;
		}
		.clearfix{
			clear: both;
		}
		p label{
			font-weight: bold;
		}
		.cu-input{
			width: 100%;
		}
		.spinner{
			float: left!important;
		}
		
		
		
	
	</style>
	
	
	<script type="text/javascript">
		(function($){
			$(document).ready(function() {
			
				var url = $(location).attr('href');
				
<?php 
	global $opts;
	$panel_max_count = $opts['panel_max_count'];
	
	if ($panel_max_count):
		$max_panels = $panel_max_count;
	else:
		$max_panels = 10;
	endif;
?>

				<?php for($x = 0; $x <= $max_panels + 2; $x++): ?>
				
				$('.tax<?php echo $x; ?>').change(function() {
					
					$('.term-spinner<?php echo $x; ?>').show(0);
					var val = $('.tax<?php echo $x; ?> option:selected').val();
					var pathname = url + "&temp_tax<?php echo $x; ?>=" + val;
					$( ".term<?php echo $x; ?>" ).load( pathname + ' .term<?php echo $x; ?> select', function() { $('.term-spinner<?php echo $x; ?>').hide(0); });	
					
				});
				
				<?php endfor; ?>
				
				$('.ce-half .panel-sort-title').toggle(
					function(){
						$(this).next('.panel-inputs').show();
						$(this).find('.panel-toggle').html('&#8211;');
					},
					function(){
						$(this).next('.panel-inputs').hide();
						$(this).find('.panel-toggle').text('+');
					}
				);
				
				$( "#admin-sortable" ).sortable({
					
					stop: function(event, ui) {
            var counter = 2;
						$( ".ce-half" ).each(function( index ) {
							$(this).find('.sort-show').attr('name', 'show_panel['+counter+']');
							$(this).find('.sort-title').attr('name', 'panel_title['+counter+']');
							$(this).find('.sort-rating').attr('name', 'sub_rating_name['+counter+']');
							$(this).find('.sort-subtitle').attr('name', 'panel_subtitle['+counter+']');
							$(this).find('.sort-style').attr('name', 'panel_style['+counter+']');
							$(this).find('.sort-type').attr('name', 'panel_type['+counter+']');
							$(this).find('.sort-tax').attr('name', 'panel_tax['+counter+']');
							$(this).find('.sort-term').attr('name', 'panel_term['+counter+']');
							$(this).find('.sort-count').attr('name', 'panel_count['+counter+']');
							$(this).find('.sort-offset').attr('name', 'panel_offset['+counter+']');
							$(this).find('.sort-attr').attr('name', 'panel_attr['+counter+']');
							$(this).find('.sort-byline').attr('name', 'panel_byline['+counter+']');
							counter++;
						});
					}
				});
				$( "#admin-sortable" ).disableSelection();
				
				$('.sort-show').each(function(){
				    var c = this.checked ? 'enabled' : 'disabled';
				    $(this).parent().parent().parent('.ce-half-padding').find('span.panel-status').removeClass('enabled disabled');
				    $(this).parent().parent().parent('.ce-half-padding').find('span.panel-status').addClass(c).text(c);
				});

				$('.sort-show').change(function(){
				
				    var c = this.checked ? 'enabled' : 'disabled';
				    $(this).parent().parent().parent('.ce-half-padding').find('span.panel-status').removeClass('enabled disabled');
				    $(this).parent().parent().parent('.ce-half-padding').find('span.panel-status').addClass(c).text(c);
				});
			

				$('.sort-title').each(function(){
				    var c = $(this).val();
				    $(this).parent().parent('.ce-half-padding').find('span.panel-name').text(c);
				});

				$('.sort-title').change(function(){
				    var c = $(this).val();
				    $(this).parent().parent('.ce-half-padding').find('span.panel-name').text(c);
				});

				$('.sort-style').each(function(){
				    var c = $(this).find(':selected').text();
				    $(this).parent().parent('.ce-half-padding').find('span.panel-style').text(' ('+c+')');
				});

				$('.sort-style').change(function(){
				    var c = $(this).find(':selected').text();
				    $(this).parent().parent('.ce-half-padding').find('span.panel-style').text(' ('+c+')');
				});

			});
		
		})(jQuery);
	</script>
	
<?php
}

add_action('admin_head', 'admin_css');

// Option styling to add to wp_head

function current_add_to_head() {
	
	global $opts;
	
	$disable_style = $opts['disable_style'];
	$disable_type = $opts['disable_type'];
	
	if ($disable_style != 0):
	
	$site_link_color = $opts['site_link_color'];
	$site_hover_color = $opts['site_hover_color']; 
	$alt_bg_color = $opts['alt_bg_color'];
	$border_color = $opts['border_color'];
	$heading_bg_color = $opts['heading_bg_color'];
	$heading_alt_color = $opts['heading_alt_color'];
	$heading_link_color = $opts['heading_link_color'];
	$subheading_color = $opts['subheading_color'];
	$btn_text_color = $opts['btn_text_color'];
	$input_bg_color = $opts['input_bg_color'];
	$input_text_color = $opts['input_text_color'];
	$input_btn_bg_color = $opts['input_btn_bg_color'];
	$input_btn_text_color = $opts['input_btn_text_color'];
	$header_bg_color = $opts['header_bg_color'];
	$header_title_color = $opts['header_title_color'];
	$header_desc_color = $opts['header_desc_color'];
	$menu_bg_color = $opts['menu_bg_color'];
	
	$ticker_title_bg = $opts['ticker_title_bg'];
	$ticker_title_font = $opts['ticker_title_font'];
		
	$rating_bg = $opts['rating_bg'];	
	$rating_bg2 = $opts['rating_bg2'];	
	$rating_text_color = $opts['rating_text_color'];	
	
	$logo_header_color = $opts['logo_header_color'];
	?>
	
	<style>
	
		<?php if($site_link_color): ?>
		a{
			color: <?php echo $site_link_color; ?>;
		}
		<?php endif; if($site_hover_color): ?>
		a:hover{
			color: <?php echo $site_hover_color; ?>;
		}
		<?php endif; if($menu_bg_color): ?>
		.top-bar, .top-bar-section ul, .top-bar .top-bar-section ul.dropdown, .top-bar-section .has-form, .nav-search{
			background: <?php echo $menu_bg_color; ?>;
		}
		<?php endif; if($header_bg_color): ?>
		.header{
			background-color: <?php echo $header_bg_color; ?>;
		}
		<?php endif; if($logo_header_color): ?>
		.header .logo a{
			color: <?php echo $logo_header_color; ?>;
		}
		<?php endif; if($site_link_color || $btn_text_color): ?>
		a.post-format-icon{
			<?php if($site_link_color): ?>background: <?php echo $site_link_color; ?>;<?php endif; ?>
			<?php if($btn_text_color): ?>color: <?php echo $btn_text_color; ?>;<?php endif; ?>
		}
		<?php endif; if($btn_text_color): ?>
		.cart-contents .amount{
			<?php if($btn_text_color): ?>color: <?php echo $btn_text_color; ?>;<?php endif; ?>
		}
		<?php endif; if($site_hover_color || $btn_text_color): ?>
		page-links a:hover, .page-links > span, .nav-previous a:hover, .nav-next a:hover, .top-bar-section ul li>a.button:hover, .thumb-box .thumb-stats a.post-format-icon:hover, body.woocommerce a.button.alt:hover, body.woocommerce button.button.alt:hover, body.woocommerce input.button.alt:hover, body.woocommerce #respond input#submit.alt:hover, body.woocommerce #content input.button.alt:hover, body.woocommerce-page a.button.alt:hover, body.woocommerce-page button.button.alt:hover, body.woocommerce-page input.button.alt:hover, body.woocommerce-page #respond input#submit.alt:hover, body.woocommerce-page #content input.button.alt:hover, button:hover, button.btn:hover, html input[type="button"]:hover, input[type="reset"]:hover, input[type="submit"]:hover, #bbpress-forums div.bbp-the-content-wrapper div.quicktags-toolbar input:hover, body #buddypress button:hover, body #buddypress a.button:hover, body #buddypress input[type=submit]:hover, body #buddypress input[type=button]:hover, body #buddypress input[type=reset]:hover, body #buddypress ul.button-nav li a:hover, body #buddypress div.generic-button a:hover, body #buddypress .comment-reply-link:hover, body a.bp-title-button:hover, body #buddypress div.item-list-tabs ul li a span:hover, body #buddypress div.activity-meta a:hover, body #buddypress div.item-list-tabs ul li a:hover span:hover, body.woocommerce a.button:hover, body.woocommerce-page a.button:hover, body.woocommerce button.button:hover, body.woocommerce-page button.button:hover, body.woocommerce input.button:hover, body.woocommerce-page input.button:hover, body.woocommerce #respond input#submit:hover, body.woocommerce-page #respond input#submit:hover, body.woocommerce #content input.button:hover, body.woocommerce-page #content input.button:hover, body.woocommerce ul.products li.product .onsale, body.woocommerce-page ul.products li.product .onsale, body.woocommerce span.onsale, body.woocommerce-page span.onsale, body.woocommerce nav.woocommerce-pagination ul li span.current, body.woocommerce nav.woocommerce-pagination ul li a:hover, body.woocommerce nav.woocommerce-pagination ul li a:focus, body.woocommerce #content nav.woocommerce-pagination ul li span.current, body.woocommerce #content nav.woocommerce-pagination ul li a:hover, body.woocommerce #content nav.woocommerce-pagination ul li a:focus, body.woocommerce-page nav.woocommerce-pagination ul li span.current, body.woocommerce-page nav.woocommerce-pagination ul li a:hover, body.woocommerce-page nav.woocommerce-pagination ul li a:focus, body.woocommerce-page #content nav.woocommerce-pagination ul li span.current, body.woocommerce-page #content nav.woocommerce-pagination ul li a:hover, body.woocommerce-page #content nav.woocommerce-pagination ul li a:focus, .tagcloud a:hover, a.author-button:hover, .home-featured .main-feature .thumb-box .caption-container .caption a.feature-button:hover, .top-bar .top-bar-section ul li>a.button:hover{
			<?php if($site_hover_color): ?>background: <?php echo $site_hover_color; ?>;<?php endif; ?>
		}
		<?php endif; if($input_btn_bg_color || $input_btn_text_color): ?>
		button, input.button, button.button, html input[type="button"], input[type="reset"], input[type="submit"], #bbpress-forums div.bbp-the-content-wrapper div.quicktags-toolbar input, body #buddypress button, body #buddypress a.button, body #buddypress input[type=submit], body #buddypress input[type=button], body #buddypress input[type=reset], body #buddypress ul.button-nav li a, body #buddypress div.generic-button a, body #buddypress .comment-reply-link, body a.bp-title-button, body #buddypress div.item-list-tabs ul li a span, body #buddypress div.activity-meta a:hover, body #buddypress div.item-list-tabs ul li a:hover span, body.woocommerce a.button, body.woocommerce-page a.button, body.woocommerce button.button, body.woocommerce-page button.button, body.woocommerce input.button, body.woocommerce-page input.button, body.woocommerce #respond input#submit, body.woocommerce-page #respond input#submit, body.woocommerce #content input.button, body.woocommerce-page #content input.button, .top-bar-section .search-li a.toggle-search, #buddypress div.item-list-tabs ul li.selected a span, #buddypress div.item-list-tabs ul li.current a span{
			<?php if($input_btn_bg_color): ?>background: <?php echo $input_btn_bg_color; ?>;<?php endif; ?>
			<?php if($input_btn_text_color): ?>color: <?php echo $input_btn_text_color; ?>;<?php endif; ?>
		}
		<?php endif; if($ticker_title_bg || $ticker_title_font): ?>
		.ticker-title-padding{
			<?php if($ticker_title_bg): ?>background-color: <?php echo $ticker_title_bg; ?>!important;<?php endif; ?>
			<?php if($ticker_title_font): ?>color: <?php echo $ticker_title_font; ?>!important;<?php endif; ?>
		}		
		<?php endif; ?></style>	
	<?php
	endif;

	if ($disable_type != "0"):

	$body_font_size = $opts['body_font']['font-size'];
	$logo_font_size = $opts['logo_font']['font-size'];
	$nav_font_size = $opts['nav_font']['font-size'];
	$heading_font_size = $opts['heading_font']['font-size'];
	$subtitle_font_size = $opts['subtitle_font']['font-size'];

	$body_weight = $opts['body_font']['font-weight'];
	$logo_weight = $opts['logo_font']['font-weight'];
	$nav_weight = $opts['nav_font']['font-weight'];
	$heading_weight = $opts['heading_font']['font-weight'];
	$subtitle_weight = $opts['subtitle_font']['font-weight'];
	
	
	if($opts['body_font']['font-family']):
		$body_font = $opts['body_font']['font-family']; 
		if($opts['body_font']['font-backup']): 
			$body_font .= ', '.$opts['body_font']['font-backup']; 
		endif;
	endif;
	if($opts['logo_font']['font-family']):
		$logo_font = $opts['logo_font']['font-family']; 
		if($opts['logo_font']['font-backup']): 
			$logo_font .= ', '.$opts['logo_font']['font-backup']; 
		endif;
	endif;
	if($opts['heading_font']['font-family']): 
		$heading_font = $opts['heading_font']['font-family']; 
		if($opts['heading_font']['font-backup']): 
			$heading_font .= ', '.$opts['heading_font']['font-backup']; 
		endif;
	endif;
	if($opts['subtitle_font']['font-family']):
		$subtitle_font = $opts['subtitle_font']['font-family']; 
		if($opts['subtitle_font']['font-backup']): 
			$subtitle_font .= ', '.$opts['subtitle_font']['font-backup']; 
		endif;
	endif;
	if($opts['nav_font']['font-family']): 
		$nav_font = $opts['nav_font']['font-family']; 
		if($opts['nav_font']['font-backup']): 
			$nav_font .= ', '.$opts['nav_font']['font-backup']; 
		endif;
	endif;

	?>
	<style>
		<?php if ($body_font || $body_weight): ?>
		body{
			<?php if($body_font): ?>font-family: <?php echo $body_font; ?>;<?php endif; ?>
			<?php if($body_weight): ?>font-weight: <?php echo $body_weight; ?>;<?php endif; ?>
		}
		<?php if ($body_font): ?>
			.sub,
			h1.list-heading,
			h2.list-heading,
			h3.list-heading,
			h4.list-heading,
			h5.list-heading,
			h6.list-heading,
			body.woocommerce ul.products li.product h3, body.woocommerce-page ul.products li.product h3{
				font-family: <?php echo $body_font; ?>;
			}
		<?php endif; endif;  if($heading_font || $heading_weight): ?>
			h1, h2, h3, h4, h5, h6, .rating-number, legend, .btn, .page-links a, .nav-previous a, .nav-next a, ul.post-categories li a, body.woocommerce a.button.alt, body.woocommerce button.button.alt, body.woocommerce input.button.alt, body.woocommerce #respond input#submit.alt, body.woocommerce #content input.button.alt, body.woocommerce-page a.button.alt, body.woocommerce-page button.button.alt, body.woocommerce-page input.button.alt, body.woocommerce-page #respond input#submit.alt, body.woocommerce-page #content input.button.alt, button, button.btn, html input[type="button"], input[type="reset"], input[type="submit"], #bbpress-forums div.bbp-the-content-wrapper div.quicktags-toolbar input, body #buddypress button, body #buddypress a.button, body #buddypress input[type=submit], body #buddypress input[type=button], body #buddypress input[type=reset], body #buddypress ul.button-nav li a, body #buddypress div.generic-button a, body #buddypress .comment-reply-link, body a.bp-title-button, body #buddypress div.item-list-tabs ul li a span, body #buddypress div.activity-meta a:hover, body #buddypress div.item-list-tabs ul li a:hover span, body.woocommerce a.button, body.woocommerce-page a.button, body.woocommerce button.button, body.woocommerce-page button.button, body.woocommerce input.button, body.woocommerce-page input.button, body.woocommerce #respond input#submit, body.woocommerce-page #respond input#submit, body.woocommerce #content input.button, body.woocommerce-page #content input.button, body.woocommerce ul.products li.product .onsale, body.woocommerce-page ul.products li.product .onsale, body.woocommerce span.onsale, body.woocommerce-page span.onsale{
			<?php if($heading_font): ?>font-family: <?php echo $heading_font; ?>;<?php endif; ?>
			<?php if($heading_weight): ?>font-weight: <?php echo $heading_weight; ?>;<?php endif; ?>
		}
		<?php endif; if($logo_font || $logo_weight): ?>
		.top-bar .title-area h1, .header .logo a{
			<?php if($logo_font): ?>font-family: <?php echo $logo_font; ?>;<?php endif; ?>
			<?php if($logo_weight): ?>font-weight: <?php echo $logo_weight; ?>;<?php endif; ?>
		}
		<?php endif; if($nav_font || $nav_weight): ?>
		.top-bar-section ul li > a, .nav-desktop li a{
			<?php if($nav_font): ?>font-family: <?php echo $nav_font; ?>;<?php endif; ?>
			<?php if($nav_weight): ?>font-weight: <?php echo $nav_weight; ?>;<?php endif; ?>
		}
		<?php endif; if($subtitle_font || $subtitle_weight): ?>
		.sub-title{
			<?php if($subtitle_font): ?>font-family: <?php echo $subtitle_font; ?>;<?php endif; ?>
			<?php if($subtitle_weight): ?>font-weight: <?php echo $subtitle_weight; ?>;<?php endif; ?>
		}
		<?php endif; ?></style>
	<?php
	endif;
	
	
	
}
add_action('wp_head', 'current_add_to_head');



?>