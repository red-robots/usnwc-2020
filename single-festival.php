<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package bellaworks
 */

get_header(); 
$placeholder = THEMEURI . 'images/rectangle.png';
$square = THEMEURI . 'images/square.png';
$post_type = get_post_type();
$heroImage = get_field("full_image");
$flexbanner = get_field("flexslider_banner");
$has_hero = 'no-banner';
if($heroImage) {
	$has_hero = ($heroImage) ? 'has-banner':'no-banner';
} else {
	if($flexbanner) {
		$has_hero = ($flexbanner) ? 'has-banner':'no-banner';
	}
}

get_template_part("parts/subpage-banner");
$post_id = get_the_ID(); ?>
	
<div id="primary" class="content-area-full content-default single-post <?php echo $has_feat_image;?> post-type-<?php echo $post_type;?>">

		<main id="main" data-postid="post-<?php the_ID(); ?>" class="site-main" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
			<section class="text-centered-section">
				<div class="wrapper text-center">
					<div class="page-header">
						<h1 class="page-title"><?php the_title(); ?></h1>
					</div>
					<?php the_content(); ?>
				</div>
			</section>
				
			<?php 
			$start_date = get_field("start_date");
			$start_date = ($start_date) ? date('F j, Y',strtotime($start_date)):'';
			$price = get_field("price");

			$optionsVal = array($start_date,$price);
			$options[] = array('Date',$start_date);
			$options[] = array('Price',$price);
			?>

			<?php if ($optionsVal && array_filter($optionsVal)) { $countOpts = count(array_filter($optionsVal)); ?>
			<section class="section-price-ages full <?php echo ($countOpts==1) ? 'oneCol':'twoCols';?>">
				<div class="flexwrap">
					<?php foreach ($options as $e) { ?>
						<?php if ($e[1]) { ?>
						<div class="info">
							<div class="wrap">
								<div class="label"><?php echo $e[0]; ?></div>
								<div class="val"><?php echo $e[1]; ?></div>
							</div>
						</div>	
						<?php } ?>	
					<?php } ?>
				</div>
			</section>
			<?php } ?>


			<?php 
			if( $galleries = get_field("gallery") ) { ?>
			<section class="gallery-section full">
				<div id="carousel-images">
					<div class="loop owl-carousel owl-theme">
					<?php foreach ($galleries as $g) { ?>
						<div class="item">
							<div class="image" style="background-image:url('<?php echo $g['url']?>')">
								<img src="<?php echo $placeholder ?>" alt="" aria-hidden="true" />
							</div>
						</div>
					<?php } ?>
					</div>
				</div>
			</section>
			<?php } ?>

			<?php endwhile; ?>


			<?php  /* FAQ */ 
				$customFAQTitle = 'FAQ';
				include( locate_template('parts/content-faqs.php') ); 
			?>


		</main>

	</div>



<script type="text/javascript">
jQuery(document).ready(function($){
	$('.loop').owlCarousel({
    center: true,
    items:2,
    nav: true,
    loop:true,
    margin:15,
    autoplay:true,
    autoplayTimeout:3000,
    autoplayHoverPause:true,
    responsive:{
      600:{
       	items:2
      },
      400:{
       	items:1
      }
    }
	});
});
</script>
<?php

include( locate_template('inc/faqs.php') );  
get_footer();
