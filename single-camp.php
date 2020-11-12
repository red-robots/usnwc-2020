<?php
/**
 * Template Name: Summer Camps
 */
$placeholder = THEMEURI . 'images/rectangle.png';
$square = THEMEURI . 'images/square.png';
$banner = get_field("full_image");
$has_banner = ($banner) ? 'hasbanner':'nobanner';
get_header(); ?>
<?php get_template_part("parts/single-banner"); ?>
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
				<?php } else { ?>

				<section class="text-centered-section">
					<div class="wrapper text-center">
						<div class="page-header">
							<h1 class="page-title"><?php the_title(); ?></h1>
						</div>
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
			/* SCHEDULE */
			//$sched_title = get_field("schedule_title");
			$sched_title = "SCHEDULE";
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


		<?php get_template_part("parts/camp-activities"); ?>


		<?php  
		$formtypes = get_field("formtypes");
		$payment_options = get_field("payment_options");
		//$registration_title = get_field("registration_title");
		$registration_title = "Registration";
		$steps = get_field("steps");
		$sectionContent = array($steps,$payment_options);
		if( $sectionContent && array_filter($sectionContent) ) { ?>
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

			<?php /* PAYMENT OPTIONS */ ?>
			<?php if ($payment_options) { 
				$countOpts = count($payment_options); 
				$poClass = 'columns1';
				if($countOpts==1) {
					$poClass = 'columns1';
				}
				else if($countOpts==2) {
					$poClass = 'columns2';
				}
				else if($countOpts>2) {
					$poClass = 'columns3';
				}
				?>
			<div class="camps-payment-options full <?php echo $poClass ?>">
				<div class="flexwrap">
					<?php foreach ($payment_options as $p) {
						$type = $p['type'];
						$description = $p['description'];
						$button = $p['button'];
						$buttonName = ( isset($button['title']) && $button['title'] ) ? $button['title']:''; 
						$buttonLink = ( isset($button['url']) && $button['url'] ) ? $button['url']:''; 
						$buttonTarget = ( isset($button['target']) && $button['target'] ) ? $button['target']:'_self'; 
						if($type) { ?>
						<div class="fcol">
							<div class="inside">
								<div class="titlediv js-blocks"><h2 class="type"><?php echo $type ?></h2></div>
								<div class="textwrap">
									<div class="text"><?php echo $description ?></div>
									<?php if ($buttonName && $buttonLink) { ?>
									<div class="buttondiv">
										<a href="<?php echo $buttonLink ?>" target="<?php echo $buttonTarget ?>" class="btn-sm"><span><?php echo $buttonName ?></span></a>
									</div>	
									<?php } ?>
								</div>
							</div>
						</div>	
						<?php } ?>
					<?php } ?>
				</div>
			</div>
			<?php } ?>


			<?php /* FORMS */ ?>
			<?php
			//$form_title = get_field("form_title");
			$form_title = "FORMS";
			$form_text = get_field("form_text");
			$form_note = get_field("form_note");
			if($formtypes) { ?>
			<div class="camp-form-types full">
				<div class="wrapper">
					<?php if ($form_title) { ?>
						<div class="shead-icon text-center">
							<div class="icon"><span class="ci-board"></span></div>
							<h2 class="stitle"><span><?php echo $form_title ?></span></h2>
						</div>
					<?php } ?>
					<?php if ($form_text) { ?>
						<div class="form-text text-center">
							<?php echo $form_text ?>
						</div>
					<?php } ?>
				</div>

				<?php
				$countTypes = count($formtypes); 
				$typesClass = 'columns1';
				if($countTypes==1) {
					$typesClass = 'columns1';
				}
				else if($countTypes==2) {
					$typesClass = 'columns2';
				}
				else if($countTypes>2) {
					$typesClass = 'columns3';
				}
				?>
				<div class="form-types <?php echo $typesClass ?>">
					<div class="flexwrap">
					<?php foreach ($formtypes as $e) { 
						$f_title = $e['title'];
						$f_text = $e['description'];
						$f_button = $e['button'];
						$f_buttonName = ( isset($f_button['title']) && $f_button['title'] ) ? $f_button['title']:''; 
						$f_buttonLink = ( isset($f_button['url']) && $f_button['url'] ) ? $f_button['url']:''; 
						$f_buttonTarget = ( isset($f_button['target']) && $f_button['target'] ) ? $f_button['target']:'_self'; 
						$has_button = ($f_buttonName && $f_buttonLink) ? 'hasButton':'noButton';
						if($f_title || $f_text) { ?>
						<div class="block text-center <?php echo $has_button ?>">
							<div class="inner">
								<?php if ($f_title) { ?>
									<div class="ftitle">
										<h2><?php echo $f_title ?></h2>
									</div>
								<?php } ?>

								<div class="ftextwrap">
									<?php if ($f_text) { ?>
										<div class="ftext">
											<?php echo $f_text ?>
										</div>
									<?php } ?>

									<?php if ($f_buttonName && $f_buttonLink) { ?>
										<div class="buttondiv">
											<a href="<?php echo $f_buttonLink ?>" target="<?php echo $f_buttonTarget ?>" class="btn-sm"><span><?php echo $f_buttonName ?></span></a>
										</div>	
									<?php } ?>
								</div>

							</div>
						</div>
						<?php } ?>
					<?php } ?>
					</div>
				</div>

				<?php if ($form_note) { ?>
					<div class="form-note text-center">
						<?php echo $form_note ?>
					</div>
				<?php } ?>

			</div>
			<?php } ?>


			<?php /* REQUIREMENTS */ ?>
			<?php $requirements = get_field("activity_requirements"); ?>
			<?php if ($requirements) { ?>
			<?php  
				$countReqs = count($requirements); 
				$reqsClass = 'columns1';
				if($countReqs==1) {
					$reqsClass = 'columns1';
				}
				else if($countReqs==2) {
					$reqsClass = 'columns2';
				}
				else if($countReqs>2) {
					$reqsClass = 'columns3';
				}
			?>
			<div class="camp-requirements full <?php echo $reqsClass ?>">
				<div class="flexwrap">
					<?php foreach ($requirements as $r) { 
						$img = $r['image'];
						$title = $r['title'];
						$text = $r['description'];
						$rbutton = $r['button'];
						$rbuttonName = ( isset($rbutton['title']) && $rbutton['title'] ) ? $rbutton['title']:''; 
						$rbuttonLink = ( isset($rbutton['url']) && $rbutton['url'] ) ? $rbutton['url']:''; 
						$rbuttonTarget = ( isset($rbutton['target']) && $rbutton['target'] ) ? $rbutton['target']:'_self'; 
						$rhasButton = ($rbuttonName && $rbuttonLink) ? 'hasButton':'noButton';
						?>
						
						<?php if ($title || $text) { ?>
						<div class="req-block text-center <?php echo $rhasButton ?>">
							<div class="inside">
								<div class="reqImage <?php echo ($img) ? 'hasImage':'noImage' ?>">
									<?php if ($img) { ?>
									<div class="pic" style="background-image:url('<?php echo $img['url']?>')"></div>
									<?php } ?>
									<img src="<?php echo $placeholder ?>" alt="" aria-hidden="true" class="helper">
								</div>
								<div class="reqText">
									<?php if ($title) { ?>
										<h2 class="rtitle"><?php echo $title ?></h2>
									<?php } ?>
									<?php if ($text) { ?>
										<div class="rtext"><?php echo $text ?></div>
									<?php } ?>
									<?php if ($rbuttonName && $rbuttonLink) { ?>
										<div class="buttondiv">
											<a href="<?php echo $rbuttonLink ?>" target="<?php echo $rbuttonTarget ?>" class="btn-sm"><span><?php echo $rbuttonName ?></span></a>
										</div>	
									<?php } ?>
								</div>
							</div>
						</div>
						<?php } ?>

					<?php } ?>
				</div>
			</div>
			<?php } ?>

		</section>
		<?php } ?>


		<?php  /* FAQ */ 
			$customFAQTitle = 'FAQ';
			include( locate_template('parts/content-faqs.php') ); 
		?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
$similar_title = get_field("similar_title");
$maxItems = (get_field("maxItems")) ? get_field("maxItems") : 9;
$args = array(
	'posts_per_page'=> $maxItems,
	'post_type'		=> 'activity',
	'post_status'	=> 'publish',
);
$posts = new WP_Query($args);
?>
<section class="explore-other-stuff">
	<div class="wrapper">
		<?php if ($similar_title) { ?>
		<h3 class="sectionTitle"><?php echo $similar_title ?></h3>
		<?php } ?>
		
				
		<div class="post-type-entries">
			<div class="columns">
									<div class="entry">
						<a href="http://bellaworks/usnwc/activity/yoga/">Yoga</a>
					</div>
									<div class="entry">
						<a href="http://bellaworks/usnwc/activity/lights/">Lights</a>
					</div>
									<div class="entry">
						<a href="http://bellaworks/usnwc/activity/ice-skating/">Ice Skating</a>
					</div>
									<div class="entry">
						<a href="http://bellaworks/usnwc/activity/mountain-biking/">Mountain Biking, Trail Running + Hiking</a>
					</div>
									<div class="entry">
						<a href="http://bellaworks/usnwc/activity/whitewater-kayaking-sup/">Whitewater Kayaking + SUP</a>
					</div>
									<div class="entry">
						<a href="http://bellaworks/usnwc/activity/jumps/">Jumps</a>
					</div>
									<div class="entry">
						<a href="http://bellaworks/usnwc/activity/ropes-courses/">Ropes Courses</a>
					</div>
									<div class="entry">
						<a href="http://bellaworks/usnwc/activity/climbing/">Climbing</a>
					</div>
									<div class="entry">
						<a href="http://bellaworks/usnwc/activity/deep-water-solo/">Deep Water Solo</a>
					</div>
									<div class="entry">
						<a href="http://bellaworks/usnwc/activity/flatwater-kayaking-sup/">Flatwater Kayaking + SUP</a>
					</div>
									<div class="entry">
						<a href="http://bellaworks/usnwc/activity/ziplining/">Ziplining</a>
					</div>
									<div class="entry">
						<a href="http://bellaworks/usnwc/activity/whitewater-rafting/">Whitewater Rafting</a>
					</div>
			</div>
		</div>
	</div>
</section>


<?php 
include( locate_template('inc/pagetabs-script.php') );  
include( locate_template('inc/faqs.php') );  
?>

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
