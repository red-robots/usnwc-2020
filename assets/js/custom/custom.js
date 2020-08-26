/**
 *	Custom jQuery Scripts
 *	
 *	Developed by: Lisa DeBona
 */

jQuery(document).ready(function ($) {

	/* NAVIGATION */
	$(".menu-toggle").on("click",function(e){
		e.preventDefault();
		$("body").addClass("nav-open");
		$("#site-navigation").addClass("open");
	});

	$("#closeNav,#overlay").on("click",function(e){
		e.preventDefault();
		$("body").removeClass("nav-open");
		$("#site-navigation").removeClass("open");
		$("#site-navigation *").removeClass("open");
		$("#site-navigation li.parent-link").removeClass("active");
		$("#site-navigation").removeClass("child-open");
	});

	$("#closeNavChild").on("click",function(e){
		e.preventDefault();
		$("#childrenNavs").removeClass("open");
		$(".children-group").removeClass("open");
		$("#site-navigation li.parent-link").removeClass("active");
		$("#site-navigation").removeClass("child-open");
	});

	$(document).on("click",".navigation a.parentlink", function(e){
		e.preventDefault();
		var link = $(this).attr("href");
		if(link=='#') {
			var child_menu = $(this).attr("data-parent");
			$("#site-navigation li.parent-link").removeClass("active");
			$(".children-group").removeClass("open");
			if( $(".children-group"+child_menu).length > 0 ) {
				$("#site-navigation").addClass("child-open");
				$("#childrenNavs").addClass("open");
				$(".children-group"+child_menu).addClass("open");
				$(this).addClass("active");
				$(this).parents("li").addClass('active');
			}
		}
		
	});


	$('[data-fancybox]').fancybox({
	    youtube : {
	        controls : 0,
	        showinfo : 0,
	        rel: 0
	    },
	    vimeo : {
	        color : 'ffffff'
	    }
	});


	var windowHeight = $(window).scrollTop();
	if(windowHeight  > 200) {
		$("body").addClass('scrolled');
	}

	$(window).scroll(function() {    
		var wHeight = $(window).scrollTop();
		if(wHeight  > 200) {
			$("body").addClass('scrolled');
		} else{
			$("body").removeClass('scrolled');
			//$('body').removeClass('subnav-clicked');
		}
	});

	if( $("#banner").length > 0 && $("#pageTabs").length>0 ) {
		
		$(window).scroll(function() { 
			var tabsHeight = $("#pageTabs").height();
			if( $(".main-description").length>0 ) {
				var main = $(".main-description").height();
				tabsHeight = main;
			}
			var bannerHeight = $("#banner").height();
			var screenOffset = bannerHeight + tabsHeight;
			var wHeight = $(window).scrollTop();
			if(wHeight  > screenOffset) {
				$("#pageTabs").addClass('fixed-top');
			} else {
				$("#pageTabs").removeClass('fixed-top');
			}
		});
	}

	if( $(".subpage-sliders").length > 0 ) {
		$('.subpage-sliders').flexslider({
			animation: "fade",
			smoothHeight: true
		});
	}

	if( $(".video__vimeo").length > 0 ) {
		$(".video__vimeo").each(function(){
			var target = $(this);
			var vimeoURL = $(this).attr("data-url");
			var apiURL = 'https://vimeo.com/api/oembed.json?url='+vimeoURL;
			$.get(apiURL,function(data){
				var thumbnail = data.thumbnail_url;
				target.css("background-image","url('"+thumbnail+"')");
			});
		});
	}


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
                if($slides.eq(current).find('.videoIframe').length > 0){

	    			$(".videoIframeDiv").removeClass("playing");
	    			$(".videoIframe").hide();

                    $("body").addClass("current-slide-is-video");
                } else {
                	$("body").removeClass("current-slide-is-video");
                }
            }
		},
		start: function(slider){
			var $slides = $(slider.slides);
            if ($slides.length > 0) {
                play_flexslider_video(slider);
            }
            
		}
	});

    $(document).on("click",".flex-next, .flex-prev",function(e){
    	e.preventDefault();
    	if( $("iframe.videoIframe").length > 0 ) {
    		$("iframe.videoIframe").each(function(){
    			var type = $(this).attr("data-vid");
    			if(type=='youtube') {
    				var parent = $(this).parents(".videoIframeDiv");
    				var embedURL = parent.find(".playVidBtn").attr("data-embed");
    				if(e.target.outerText=='Next') {
    					$(this).attr("src",embedURL);
    				}
    			} 
    			else if(type=='vimeo') {
 					var iframe = $(this)[0];
					var player = new Vimeo.Player(iframe);
					player.pause();
    			}
    		});
    	}
    });

    function play_flexslider_video(slider) {
		$(document).on("click",".playVidBtn",function(e){
			e.preventDefault();
			var type = $(this).attr("data-type");
			var parent = $(this).parents(".videoIframeDiv");
			if(type=='youtube') {
				var iframeSRC = $(this).attr("data-embed");
				parent.find("iframe.videoIframe")[0].src += "&autoplay=1";
				//parent.find("iframe.videoIframe").attr("src",iframeSRC+"&autoplay=1");
				parent.addClass("playing");
				parent.find("iframe.videoIframe").fadeIn();
				is_video_playing = true;
				slider.stop();
			}
			else if(type=='vimeo') {
				var iframe = parent.find("iframe.videoIframe")[0];
				var player = new Vimeo.Player(iframe);
				parent.addClass("playing");
				parent.find("iframe.videoIframe").fadeIn();
				player.play();
				slider.stop();
			}
		});


    }
	
 	

	
 	/* Today (Top) */
 	// $(".topinfo .today a").on("click",function(e){
 	// 	e.preventDefault();
 	// 	$(".topinfo .today").toggleClass("open");
 	// });

 	// $(".topinfo .today a").hover(
 	// 	function(){
 	// 		$(".topinfo .today").addClass("open");
 	// 	}, function(){
 	// 		//$(".topinfo .today").removeClass("open");
 	// 	}
 	// );

 	$(document).on('click', function (e) {
 		var tag = $(this);
 		var exceptions = ['todayToggle','todayLink','todayTxt','today-options'];
 		var elementId = e.target.id;
 		var is_open = false;
 		if( elementId=='today-options' ) {
 			$(".topinfo .today").addClass("open");
 		} else {
 			if($.inArray(elementId, exceptions) != -1) {
				if( $(".topinfo .today").hasClass("open") ) {
					$(".topinfo .today").removeClass("open");
				} else {
					$(".topinfo .today").addClass("open");
				}
	 		} else {
	 			$(".topinfo .today").removeClass("open");
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
	  	  var headHeight = $("#masthead").height();
	  	  var offset = headHeight + 100;
	      var target = $(this.hash);
	      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
	      // Does a scroll target exist?
	      if (target.length) {
	        // Only prevent default if animation is actually gonna happen
	        event.preventDefault();
	        $('html, body').animate({
	          scrollTop: target.offset().top - offset
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


	/* Load More */
	$("#loadMoreBtn").on("click",function(event){
		event.preventDefault();
		var loadButton = $(this);
		var pageURL = ( typeof $("a.page-numbers").eq(0)!=undefined ) ? $("a.page-numbers").attr("href") : '';
		var current_page = $(this).attr("data-current");
		var next_page = parseInt(current_page) + 1;
		var last_page = $(this).attr("data-end");
		if(pageURL) {
			var parts = pageURL.split("pg=");
			var num = parts[1];
			var url = pageURL.replace('pg='+num,'pg='+next_page);
			loadButton.attr("data-current",next_page);

			


			$(".next-posts").load(url + " #data-container",function(){
				var htmlContent = $(this).find("#data-container").html();
				$("#data-container").append(htmlContent);

				if(next_page==last_page) {
					//$(".loadmorediv .wrapper").html('<span class="end">No more post to load</span>');
					$(".loadmorediv").html('').hide();
					// var target = $("#stopHere");
					// if (target.length) {
		   //      // Only prevent default if animation is actually gonna happen
		   //      event.preventDefault();
		   //      $('html, body').animate({
		   //        scrollTop: target.offset().top
		   //      }, 1000, function() {
		   //        target.focus();
		   //        if (target.is(":focus")) { // Checking if the target was focused
		   //          return false;
		   //        } else {
		   //          target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
		   //          target.focus(); // Set focus again
		   //        };
		   //      });
		   //    }

				} 
			});
		}

		
		
		
	});

	/*
	*
	*	Wow Animation
	*
	------------------------------------*/
	new WOW().init();

	$('.js-blocks').matchHeight();


	$(document).on("click","#toggleMenu",function(){
		$(this).toggleClass('open');
		$('body').toggleClass('open-mobile-menu');
	});

	/* Search Form (Header) */
	$(document).on("click","#topsearchBtn",function(e){
		e.preventDefault();
		$("#topSearchBar form").submit();
	});

	$(document).on("click","#searchHereBtn",function(e){
		e.preventDefault();
		$(this).toggleClass('search-open');
		$('#topSearchBar').toggleClass('show');
		$('body').toggleClass('search-form-open');
		$("input.search-field").focus();
	});

	$(document).on("click","#closeTopSearch",function(e){
		e.preventDefault();
		$('#searchHereBtn').removeClass('search-open');
		$('#topSearchBar').removeClass('show');
		$('body').removeClass('search-form-open');
		//$("input.search-field").val("");
	});

	

	/* Footer Subscribe Form */
	$('#footSubscribeForm input[type="email"]').on("focus",function(){
		$("#footSubscribeForm").addClass('input-focus');
	});
	$('#footSubscribeForm input[type="email"]').on("focusout blur",function(){
		$("#footSubscribeForm").removeClass('input-focus');
	});

});// END #####################################    END