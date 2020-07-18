/**
 *	Custom jQuery Scripts
 *	
 *	Developed by: Lisa DeBona
 */

jQuery(document).ready(function ($) {
	var is_video_playing = false;

	var $slides = $('.flexslider .slides li');
    if ($slides.length > 0) {
        $slides.eq(1).add($slides.eq(-1)).find('img.lazy')
            .each(function () {
                var src = $(this).attr('data-src');
                $(this).removeClass('lazy');
                $(this).attr('src', src).removeAttr('data-src');
            });
    }

    var slideShow = $('.flexslider').flexslider({
		animation: "fade",
		smoothHeight: true,
		before: function (slider) { 
			var $slides = $(slider.slides),
                index = slider.animatingTo,
                current = index,
                nxt_slide = current + 1,
                prev_slide = current - 1;
            if ($slides.length > 0) {
                $slides.eq(current).add($slides.eq(nxt_slide)).add($slides.eq(prev_slide))
                    .find('img.lazy').each(function () {
                        var src = $(this).attr('data-src');
                        $(this).removeClass('lazy');
                        $(this).attr('src', src).removeAttr('data-src');
                    });
                if($slides.eq(current).find('.iframe-wrapper').length > 0){
                    slider.pause();
                    setTimeout(function(){
                      slider.play();
                    },10000);
                }
            }
		},
		start: function(slider){
			var $slides = $(slider.slides);
            if ($slides.length > 0) {
                if($slides.eq(0).find('.iframe-wrapper').length > 0){
                    slider.pause();
                    setTimeout(function(){
                    slider.play();
                    },10000);
                }
            }
            $(document).on("click",".playVidBtn",function(e){
				e.preventDefault();
				var iframeSRC = $(this).attr("data-embed");
				var parent = $(this).parents(".videoIframeDiv");
				parent.find("iframe.videoIframe")[0].src += "&autoplay=1";
				parent.find("iframe.videoIframe").fadeIn();
				is_video_playing = true;
				//slideShow.flexslider("pause");
				slider.pause();
			});
		}
	});

    

	
 	

	


 	/* Today (Top) */
 	// $(".topinfo .today a").on("click",function(e){
 	// 	e.preventDefault();
 	// 	$(".topinfo .today").toggleClass("open");
 	// });
 	$(".topinfo .today a").hover(
 		function(){
 			$(".topinfo .today").addClass("open");
 		}, function(){
 			//$(".topinfo .today").removeClass("open");
 		}
 	);

 	$(document).on('click', function (e) {
 		if ( e.target.id=='todayToggle' || e.target.id=='todayTxt' ) {
 			e.preventDefault();
 			$(".topinfo .today").toggleClass("open");
 		} else {
			if ($(e.target).closest("#businessHours").length === 0) {
 				$(".site-header .today").removeClass("open");
 			}
 		}
	});

    /* Smooth Scroll */
    $('a[href*="#"]')
	  .not('[href="#"]')
	  .not('[href="#0"]')
	  .click(function(event) {
	    // On-page links
	    if (
	      location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') 
	      && 
	      location.hostname == this.hostname
	    ) {
	      // Figure out element to scroll to
	      var target = $(this.hash);
	      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
	      // Does a scroll target exist?
	      if (target.length) {
	        // Only prevent default if animation is actually gonna happen
	        event.preventDefault();
	        $('html, body').animate({
	          scrollTop: target.offset().top
	        }, 1000, function() {
	          // Callback after animation
	          // Must change focus!
	          var $target = $(target);
	          $target.focus();
	          if ($target.is(":focus")) { // Checking if the target was focused
	            return false;
	          } else {
	            $target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
	            $target.focus(); // Set focus again
	          };
	        });
	      }
	    }
	});
	

	/*
	*
	*	Wow Animation
	*
	------------------------------------*/
	new WOW().init();


	$(document).on("click","#toggleMenu",function(){
		$(this).toggleClass('open');
		$('body').toggleClass('open-mobile-menu');
	});

});// END #####################################    END