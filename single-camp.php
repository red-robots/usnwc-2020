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
			$dates = get_field("date_range");
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
		get_template_part('parts/single-camp-registrations');
		?>


		<section id="section-requirements" class="section-content">
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

		<?php  /* FAQ */ 
			$customFAQTitle = 'FAQ';
			include( locate_template('parts/content-faqs.php') ); 
		?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
$currentPostType = get_post_type();
$similarPosts = get_field("similar_posts_section","option");
$bottomSectionTitle = '';
if($similarPosts) {
	foreach($similarPosts as $s) {
		$posttype = $s['posttype'];
		$sectionTitle = $s['section_title'];
		if($posttype==$currentPostType) {
			$bottomSectionTitle = $sectionTitle;
		}
	}
}
$args = array(
	'posts_per_page'=> 20,
	'post_type'			=> 'camp',
	'orderby' 			=> 'rand',
  'order'    			=> 'ASC',
	'post_status'		=> 'publish',
);
$posts = new WP_Query($args);
?>
<section class="explore-other-stuff">
	<div class="wrapper">
		<?php if ($bottomSectionTitle) { ?>
		<h3 class="sectionTitle"><?php echo $bottomSectionTitle ?></h3>
		<?php } ?>
		<div class="post-type-entries">
			<div class="columns">
				<?php $i=1; while ( $posts->have_posts() ) : $posts->the_post(); ?>
				<div class="entry">
					<a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a>
				</div>
				<?php $i++; endwhile; wp_reset_postdata(); ?>
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
