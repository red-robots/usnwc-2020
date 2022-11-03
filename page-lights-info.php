<!DOCTYPE html>
<html>
<head>
	<title>Lights!</title>

<!-- <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/Swiper/7.0.6/swiper-bundle.min.js' id='jquery-swiper'></script> -->
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"
/>
<style type="text/css">
	html,
      body {
        position: relative;
        height: 100%;
      }

      body {
        margin: 0;
        padding: 0;
      }
</style>




<?php 
/*
*
* Template Name: Lights Info
*
*
*/
wp_head();

$hImg = get_field('header_image');
$hTitle = get_field('header_title');
$hDesc = get_field('header_description');
?>
</head>
<body>
<!-- <section class="lights-info"> -->
	<div class="swiper mySwiper swiper-nocfl">
      <div class="swiper-wrapper">


        <div class="swiper-slide swiper-slide-nocfl ">
	        <div class="slide-guts">
	        	<img src="<?php echo $hImg['url']; ?>">
	        	<div class="cont">
		        	<h1><?php echo $hTitle; ?></h1>
				    <?php if( $hDesc ){ echo '<p>'.$hDesc.'</p>'; } ?>
			    </div>
	        </div>   
	    </div>
        
	    <?php if( have_rows('section') ):?>
	    	<?php while( have_rows('section') ): the_row(); 
				$bg = get_sub_field('background_image');
				$title = get_sub_field('title');
				$desc = get_sub_field('description');
				$gallery = get_sub_field('gallery');
			?>
		        <div class="swiper-slide swiper-slide-nocfl">
		        	<?php if( $gallery ){ ?>
		        		<div class="swiper mySwiperTwo swiper-nocfl">
		      				<div class="swiper-wrapper">
				        	<?php foreach( $gallery as $g ) { ?>
				        		<div class="swiper-slide swiper-slide-nocfl">
				        			<div class="slide-guts">
					        			<img src="<?php echo $g['url']; ?>">
					        			<div class="cont">
									        <div class="text"><?php echo $g['description']; ?></div>   
									    </div>
								    </div>
							    </div>
				        	<?php } ?>
					        </div>
					    </div>
			        <?php } ?>
		        </div>
		    <?php endwhile ?>
      </div>
  	<?php endif; ?>
      <!-- <div class="swiper-pagination"></div> -->
    </div>

	<?php //get_template_part('parts/swiper-one'); ?>

	
 <?php wp_footer(); ?>
 <!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

 <script type="text/javascript">

// jQuery(document).ready(function ($) {


	var swiper = new Swiper(".mySwiper", {
        direction: "vertical",
        pagination: {
          el: ".swiper-pagination",
          clickable: true,
        },
    });

    var swiper = new Swiper(".mySwiperTwo", {
        direction: "horizontal",
        // pagination: {
        //   el: ".swiper-pagination",
        //   clickable: true,
        // },
    });








// const slider = () => {
// 		  return new Swiper(".swiper-container", {
// 		    slidesPerView: 1,
// 		    spaceBetween: 24,
// 		    centeredSlides: false,
// 		    loop: true,
// 		    navigation: {
// 		      nextEl: ".swiper-button-next",
// 		      prevEl: ".swiper-button-prev"
// 		    },
// 		    breakpoints: {
// 		      768: {
// 		        slidesPerView: 1
// 		      },
// 		      1024: {
// 		        slidesPerView: 3
// 		      },
// 		      1440: {
// 		        slidesPerView: 4
// 		      },
// 		      1920: {
// 		        slidesPerView: 5
// 		      }
// 		    }
// 		  });
// 		};

// 		slider();







//  	// makes the parallax elements
// 	function parallaxIt() {
// 	  // create variables
// 	  var $fwindow = $(window);
// 	  var scrollTop = window.pageYOffset || document.documentElement.scrollTop;

// 	  var $contents = [];
// 	  var $backgrounds = [];

// 	  // for each of content parallax element
// 	  $('[data-type="content"]').each(function(index, e) {
// 	    var $contentObj = $(this);

// 	    $contentObj.__speed = ($contentObj.data('speed') || 1);
// 	    $contentObj.__fgOffset = $contentObj.offset().top;
// 	    $contents.push($contentObj);
// 	  });

// 	  // for each of background parallax element
// 	  $('[data-type="background"]').each(function() {
// 	    var $backgroundObj = $(this);

// 	    $backgroundObj.__speed = ($backgroundObj.data('speed') || 1);
// 	    $backgroundObj.__fgOffset = $backgroundObj.offset().top;
// 	    $backgrounds.push($backgroundObj);
// 	  });

// 	  // update positions
// 	  $fwindow.on('scroll resize', function() {
// 	    scrollTop = window.pageYOffset || document.documentElement.scrollTop;

// 	    $contents.forEach(function($contentObj) {
// 	      var yPos = $contentObj.__fgOffset - scrollTop / $contentObj.__speed;

// 	      $contentObj.css('top', yPos);
// 	    })

// 	    $backgrounds.forEach(function($backgroundObj) {
// 	      var yPos = -((scrollTop - $backgroundObj.__fgOffset) / $backgroundObj.__speed);

// 	      $backgroundObj.css({
// 	        backgroundPosition: '50% ' + yPos + 'px'
// 	      });
// 	    });
// 	  });

// 	  // triggers winodw scroll for refresh
// 	  $fwindow.trigger('scroll');
// 	};

// 	parallaxIt();


	

//});// END
 </script>
 </body>
</html>