<?php
/**
 * Template Name: Summer Camps
 */
$placeholder = THEMEURI . 'images/rectangle.png';
$square = THEMEURI . 'images/square.png';
$banner = get_field("flexslider_banner");
$has_banner = ($banner) ? 'hasbanner':'nobanner';
get_header(); ?>

<div id="primary" class="content-area-full summer-camps <?php echo $has_banner ?>">
	<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php
			$mainText = '';
			ob_start();
			the_content();
			$mainText = ob_get_contents();
			ob_end_clean();
			$has_h1 = (strpos($mainText, '<h1>') !== false) ? true : false;

			$short_description = get_the_content();
			if($banner) {
				
				if($short_description) { ?>
				<section class="text-centered-section">
					<div class="wrapper text-center">
						<?php if ($has_h1==false) { ?>
							<div class="page-header">
								<h1 class="page-title"><?php the_title(); ?></h1>
							</div>
						<?php } ?>
						<?php echo anti_email_spam($short_description); ?>
					</div>
				</section>
				<?php } ?>

			<?php } else { ?>

				<section class="text-centered-section noBanner">
					<div class="wrapper text-center">
						<div class="page-header">
							<h1 class="page-title"><?php the_title(); ?></h1>
						</div>
						<?php echo anti_email_spam($short_description); ?>
					</div>
				</section>

			<?php } ?>


			<?php get_template_part("parts/subpage-tabs"); ?>


			<?php  
			$price = get_field("price");
			$ages = get_field("ages");
			$dates = get_field("dates");
			$info['price'] = array('Price',$price);
			$info['ages'] = array('Ages',$ages);
			$info['dates'] = array('Dates',$dates);
			?>

			<section class="section-price-ages full">
				<div class="flexwrap">
					<?php foreach ($info as $n) { ?>
						<div class="info">
							<div class="wrap">
								<div class="label"><?php echo $n[0] ?></div>
								<div class="val"><?php echo $n[1] ?></div>
							</div>
						</div>	
					<?php } ?>
				</div>

				<?php 
				if( $galleries = get_field("gallery") ) { ?>
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
				<?php } ?>
			</section>

			<?php 
			$sched_title = get_field("schedule_title");
			$schedules = get_field("schedule_items");
			if($schedules) { ?>
			<section id="section-schedule" data-section="<?php echo $sched_title ?>" class="section-content">
				<div class="wrapper">

					<?php if ($sched_title) { ?>
					<div class="shead-icon text-center">
						<div class="icon"><span class="ci-menu"></span></div>
						<h2 class="stitle"><?php echo $sched_title ?></h2>
					</div>
					<?php } ?>
					
					<div class="schedules-list">
						<ul class="items">
						<?php foreach ($schedules as $s) { ?>
							<li class="item">
								<div class="time"><?php echo $s['time'] ?></div>
								<div class="event"><?php echo $s['event'] ?></div>
							</li>
						<?php } ?>
						</ul>
					</div>

				</div>
			</section>
			<?php } ?>
			
		<?php endwhile; ?>


		<?php get_template_part("parts/post-type-camp"); ?>


		<?php  
		$registration_title = get_field("registration_title");
		$steps = get_field("steps");
		if($registration_title || $steps) { ?>
		<section id="section-registration" data-section="<?php echo $registration_title ?>" class="section-content">

			<?php if ($steps) { ?>
			<div class="steps-wrapper">
				<div class="wrapper">
					<div class="flexwrap stepsdata">
						<?php $n=1; foreach ($steps as $s){ 
							$s_icon = $s['icon'];
							$s_title = $s['title'];
							if($s_title) { ?>
							<div class="step">
								<div class="stepnum">Step <?php echo $n ?></div>
								<div class="wrap">
									<div class="text">
										<?php if ($s_icon) { ?>
											<div class="icon"><span style="background-image:url('<?php echo $s_icon['url']?>')"></span></div>
										<?php } ?>
										<?php if ($s_title) { ?>
											<div class="title"><?php echo $s_title ?></div>
										<?php } ?>
									</div>
									<img src="<?php echo $placeholder ?>" alt="" aria-hidden="true" class="placeholder">
								</div>
							</div>	
							<?php $n++; } ?>
						<?php  } ?>
					</div>
					<div class="dashed"><div></div></div>
				</div>
			</div>	
			<?php } ?>

			<?php if ($registration_title) { ?>
			<div class="titlediv registerdiv">
				<div class="wrapper">
					<div class="shead-icon text-center">
						<div class="icon"><span class="ci-editor"></span></div>
						<h2 class="stitle"><?php echo $registration_title ?></h2>
					</div>
				</div>
			</div>
			<?php } ?>
		</section>
		<?php } ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php include( locate_template('inc/pagetabs-script.php') );  ?>

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
get_footer();
