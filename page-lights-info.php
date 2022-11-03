<!DOCTYPE html>
<html>
<head>
	<title>Lights!</title>

<script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/Swiper/7.0.6/swiper-bundle.min.js' id='jquery-swiper'></script>

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
	<section class="lights-info">
		<div class="container">

			<section>
			    <div class="image" data-type="background" data-speed="<?php echo $dataSpeed; ?>" style="background-image: url(<?php echo $hImg['url']; ?>);"></div>
			    <div class="stuff" data-type="content">
			    	<h1><?php echo $hTitle; ?></h1>
			    	<?php if( $hDesc ){ echo '<p>'.$hDesc.'</p>'; } ?>
			    </div>
			  </section>

		<?php if( have_rows('section') ): while( have_rows('section') ): the_row(); 
				$bg = get_sub_field('background_image');
				$title = get_sub_field('title');
				$desc = get_sub_field('description');
				$gallery = get_sub_field('gallery');
				$dataSpeed = get_sub_field('data_speed');

				// echo '<pre>';
				// echo print_r($gallery);
				// echo '</pre>';
			?>
			<section>
			    <div class="image" data-type="background" data-speed="<?php echo $dataSpeed; ?>" style="background-image: url(<?php echo $bg['url']; ?>);"></div>
			    <div class="stuff" data-type="content">
			    	<?php if( $desc ){ echo $desc; } ?>
			    		<?php if( $gallery ){ ?>
			    			<div class="image-gallery">
							  <div class="swiper-container">
							    <div class="swiper-wrapper">
							    	

							    	<?php foreach( $gallery as $g ) { ?>
									      <div class="swiper-slide">
									        <div class="image-gallery__picture">
									        	<img class="image-gallery__img" src="<?php echo $g['sizes']['medium']; ?>"/>
									        	<?php if( $g['description'] ){ ?>
									        		<div class="img-desc">
									        			<?php echo $g['description']; ?>
									        		</div>
									        	<?php } ?>
									        </div>
									      </div>
									  <?php } ?>

							     </div>

							    <div class="image-gallery__arrows">
								    <div class="swiper-button-prev">
								       <div class="image-gallery__button"><<<</div>
								    </div>
								    <div class="swiper-button-next">
								       <div class="image-gallery__button">>>></div>
								    </div>
								</div>

							  </div>
							</div>
			    		<?php } // if gallery ?>
			    		<?php $gallery == ''; ?>
			    	</div>
			  </section>

			<!-- <section>
			    <div class="parallax" style="background-image: url(<?php echo $bg['url']; ?>);">
			      <h2><?php echo $title; ?></h2>
			    </div>
			</section>

			<section>
			  <div class="block">
			    <?php echo $desc; ?>
			  </div>
			</section> -->

		<?php endwhile; endif; ?>
	




		</div>
	</section>
 <?php wp_footer(); ?>
 <script type="text/javascript">

jQuery(document).ready(function ($) {

const slider = () => {
		  return new Swiper(".swiper-container", {
		    slidesPerView: 1,
		    spaceBetween: 24,
		    centeredSlides: false,
		    loop: true,
		    navigation: {
		      nextEl: ".swiper-button-next",
		      prevEl: ".swiper-button-prev"
		    },
		    breakpoints: {
		      768: {
		        slidesPerView: 1
		      },
		      1024: {
		        slidesPerView: 3
		      },
		      1440: {
		        slidesPerView: 4
		      },
		      1920: {
		        slidesPerView: 5
		      }
		    }
		  });
		};

		slider();







 	// makes the parallax elements
	function parallaxIt() {
	  // create variables
	  var $fwindow = $(window);
	  var scrollTop = window.pageYOffset || document.documentElement.scrollTop;

	  var $contents = [];
	  var $backgrounds = [];

	  // for each of content parallax element
	  $('[data-type="content"]').each(function(index, e) {
	    var $contentObj = $(this);

	    $contentObj.__speed = ($contentObj.data('speed') || 1);
	    $contentObj.__fgOffset = $contentObj.offset().top;
	    $contents.push($contentObj);
	  });

	  // for each of background parallax element
	  $('[data-type="background"]').each(function() {
	    var $backgroundObj = $(this);

	    $backgroundObj.__speed = ($backgroundObj.data('speed') || 1);
	    $backgroundObj.__fgOffset = $backgroundObj.offset().top;
	    $backgrounds.push($backgroundObj);
	  });

	  // update positions
	  $fwindow.on('scroll resize', function() {
	    scrollTop = window.pageYOffset || document.documentElement.scrollTop;

	    $contents.forEach(function($contentObj) {
	      var yPos = $contentObj.__fgOffset - scrollTop / $contentObj.__speed;

	      $contentObj.css('top', yPos);
	    })

	    $backgrounds.forEach(function($backgroundObj) {
	      var yPos = -((scrollTop - $backgroundObj.__fgOffset) / $backgroundObj.__speed);

	      $backgroundObj.css({
	        backgroundPosition: '50% ' + yPos + 'px'
	      });
	    });
	  });

	  // triggers winodw scroll for refresh
	  $fwindow.trigger('scroll');
	};

	parallaxIt();


	

});// END
 </script>
 </body>
</html>