(function($){
	$(document).ready(function() {
		$('.toggle-preview').toggle( 
			function(){
				$('.preview-container').animate({ 'right': '0px'});
			},
			function(){
				$('.preview-container').animate({ 'right': '-210px'});
			}
		);
		
		
		// Change container type
		$('.container-type').change(function(){
  
      if ( $(this).val() == "boxed" ){
        $('.off-canvas-wrap').wrap('<div class="boxed"></div>');
      }	
      else{
        $('.boxed').contents().unwrap();
      }
  
		});
		
		
		// Hide/show logo
		
		var logo;
		$('.hide-logo-area').change(function(){
  
      if ( $(this).val() == "hide" ){
        logo = $('.header').detach();
      }	
      else{
        if (logo){
          $(".ticker").before(logo);
        }
      }
  
		});


		// Hide/show navigation logo
		
		var navLogo;
		$('.enable-nav-logo').change(function(){
  
      if ( $(this).val() == "hide" ){
        navLogo = $('.title-area').detach();
      }	
      else{
        if (navLogo){
          navLogo.prependTo( ".top-bar-section .container" );
        }
      }
  
		});


		// Fixed navigation
		
		$('.disable-fixed').change(function(){
  
      if ( $(this).val() == "fluid" ){
        $('#fixed').removeClass('sticky-nav');
      }	
      else{
        $('#fixed').addClass('sticky-nav');
      }
  
		});





	});



})(jQuery);
