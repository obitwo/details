(function($){
  


  

	$(document).ready(function() {
	  
    $(document).foundation();
    $(document).foundation('reflow');
    
    $(document).on('replace', 'img', function (e, new_path, original_path) {
      $(window).trigger('resize');
    });
    
    $("a[rel^='prettyPhoto']").prettyPhoto({
      show_title: false,
      social_tools: '',
      theme: 'light_square'
    });

  

    // Adjust order of main feature (content-feature.php)
    
    if ($('.sub-feature').length > 0) { 
      $(".sub-feature").changeElementType("div");
      $('.sub-feature').appendTo('.home-featured');
    }  
    
    $(window).load(function(){
       
      $('.home-feature-preloader').hide();
      $('.home-featured').fadeIn('slow');
      $(window).trigger('resize'); 
    });

	  // After page loads 
		$(window).load(function() { // makes sure the whole site is loaded
			$('.ticker-switch ul').mouseenter().mouseleave();
		});
		
		// Scroll back to top on off canvas toggle
		$(".right-off-canvas-toggle").click( function(){
  		
  		$('html, body').animate({ scrollTop: 0 }, 0);
  		
		});


    // Execute on load
    checkWidth();
    // Bind event listener
    $(window).resize(checkWidth);	  
		
		
    // Disable sticky nav on flyout menu
    
    function checkWidth() {
      var windowSize = $(window).width();

      if (windowSize < 1220) {
        $('#fixed').removeClass('fixed');
      }
      else if (windowSize >= 1220) {
        $('#fixed').addClass('fixed');
      }


    }



    // Slide caption for thumbnail box

    if ($(window).width() > 480) {
  	  $('.thumb-box').hover(
  	    function(){
  	      var el = $(this).find('.caption-content'),
            curHeight = el.height(),
            autoHeight = el.css('height', 'auto').height();
          el.height(curHeight).animate({height: autoHeight}, 250);
    	  },
  	    function(){
    	    $(this).find('.caption-content').animate({height: "0"}, 250);
    	  }
  	  );
    }



		// Category Widget Count customization
		
		$('.widget_categories .cat-item').each(function(){
  		$(this).html($(this).html().replace('(', '<span class="cat-count">'));
  		$(this).html($(this).html().replace(')', '</span><div class="clearfix"></div>'));
  		$(this).find('.cat-count').prependTo(this);
		});
		$('.children .cat-item').each(function(){
  		$(this).html($(this).html().replace('(', '<span class="cat-count">'));
  		$(this).html($(this).html().replace(')', '</span><div class="clearfix"></div>'));
  		$(this).find('.cat-count').prependTo(this);
      $(this).find('.cat-item').each(function(){
    		$(this).html($(this).html().replace('(', '<span class="cat-count">'));
    		$(this).html($(this).html().replace(')', '</span><div class="clearfix"></div>'));
    		$(this).find('.cat-count').prependTo(this);
      });
		});


		// Tag cloud Widget Clearfix
		
		$('.widget_tag_cloud').append('<div class="clearfix"></div>');
    
    
    // Toggle navigation search form
    
	  $(".toggle-search").click(function(){
  	  $(".nav-search").slideToggle('fast');
	  });


	  // Add foundation navigation to Wordpress menus
	  
	  $('.nav-desktop > li > ul').addClass('dropdown').parent('li').addClass('has-dropdown not-click');
	  

    // Copy navigation to flyout menu
	  $(".nav-desktop").clone().appendTo(".right-off-canvas-menu");
	  $(".right-off-canvas-menu .nav-desktop").removeClass("left right");
	  $(".right-off-canvas-menu .nav-desktop").addClass("off-canvas-list");
	  
    // Slide navigation
    
	  $(".nav-desktop li.has-dropdown").hover(
	    function(){
        $(this).children('.dropdown').show('fast');
      },
      function(){
        $(this).children('.dropdown').hide(0);
      }
	  );
    

	  // Bind click for panel slider (content-feature-slider.php)
    $(".slider-feature-title .orbit-next").click(function() {
      $(this).parent().next(".slider-feature").find(".orbit-next").click();
    });

    $(".slider-feature-title .orbit-prev").click(function() {
      $(this).parent().next(".slider-feature").find(".orbit-prev").click();
    });
	  
	
  	// scale image on hover for thumbnail box
  	
  	$('.thumb-box').hover(
  	  function(){
    	  $(this).find('img').addClass('scale-img');
  	  },
  	  function(){
    	  $(this).find('img').removeClass('scale-img');
  	  }
  	);
  	
  	$(window).trigger('resize');
  	
  	
  	// Responsive iframes and embeds
  	
     $('iframe, object, video, embed' ).not('.flex-video iframe, .flex-video object, .flex-video video, .flex-video embed').wrap( "<div class='flex-video widescreen'></div>" );

	});
	
    (function($) {
        $.fn.changeElementType = function(newType) {
            var attrs = {};
    
            $.each(this[0].attributes, function(idx, attr) {
                attrs[attr.nodeName] = attr.nodeValue;
            });
    
            this.replaceWith(function() {
                return $("<" + newType + "/>", attrs).append($(this).contents());
            });
        }
    })(jQuery);

	

})(jQuery);