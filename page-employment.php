<?php
/**
 * Template Name: Employment
 */

get_header(); 
$blank_image = THEMEURI . "images/rectangle.png";
$square = THEMEURI . "images/square.png";
$banner = get_field("flexslider_banner");
$has_banner = ($banner) ? 'hasbanner':'nobanner';
$currentPageLink = get_permalink();
?>

<div id="primary" data-post="<?php echo get_the_ID()?>" class="content-area-full employment-page <?php echo $has_banner ?>">
	
		<?php while ( have_posts() ) : the_post(); ?>
			<?php if( get_the_content() ) { ?>
				<div class="intro-text-wrap">
					<div class="wrapper">
						<h1 class="page-title"><span><?php the_title(); ?></span></h1>
						<div class="intro-text"><?php the_content(); ?></div>
					</div>
				</div>
			<?php } ?>
		<?php endwhile;  ?>

		<?php get_template_part("parts/subpage-tabs"); ?>


		<?php
			$icon1 = get_field("icon1");
			$title1 = get_field("title1");
			$text1 = get_field("text1");
			$gallery1 = get_field("gallery1");
			$class1 = ( ($title1 || $text1) && $gallery1 ) ? 'half':'full';
			if( ($title1 || $text1) || $gallery1 ) { ?>
			<section id="section1" data-section="<?php echo $title1 ?>" class="text-and-gallery <?php echo $class1 ?>">
				<div class="mscol <?php echo $class1 ?>">
					
					<?php if ($title1 || $text1) { ?>
					<div class="textcol">
						<div class="inside">
							<div class="info">
								<?php if ($icon1) { ?>
								<div class="icondiv"><span style="background-image:url('<?php echo $icon1['url'];?>')"></span></div>	
								<?php } ?>
								<?php if ($title1) { ?>
								<h3 class="mstitle"><?php echo $title1 ?></h3>	
								<?php } ?>
								<?php if ($text1) { ?>
								<div class="textwrap"><?php echo $text1 ?></div>	
								<?php } ?>
							</div>
						</div>
					</div>
					<?php } ?>

					<?php if ($gallery1) { ?>
					<div class="gallerycol">
						<div class="flexslider">
							<ul class="slides">
								<?php $helper = THEMEURI . 'images/rectangle-narrow.png'; ?>
								<?php foreach ($gallery1 as $s) { ?>
									<li class="slide-item" style="background-image:url('<?php echo $s['url']?>')">
										<img src="<?php echo $helper ?>" alt="" aria-hidden="true" class="placeholder">
										<img src="<?php echo $s['url'] ?>" alt="<?php echo $s['title'] ?>" class="actual-image" />
									</li>
								<?php } ?>
							</ul>
						</div>
					</div>	
					<?php } ?>

				</div>
			</section>
			<?php } ?>

		<?php
			$title2 = get_field("title2");
			$title2 = ($title2) ? $title2 : '';
			$video_code = get_field("video_code");
			$gallery1 = get_field("gallery1");
			if( $video_code ) { ?>
			<section id="section2" data-section="<?php echo $title2 ?>" class="section-content section-video">
				<div class="wrapper narrow">
					<div class="video-frame">
						<?php echo $video_code ?>
						<img src="<?php echo $blank_image ?>" alt="" aria-hidden="true" class="video-helper" />		
					</div>
				</div>
			</section>
			<?php } ?>


			<?php
			$left_image = get_field("left_image");
			$left_text = get_field("left_text");
			$jobfair = get_field("jobfair");
			$title3 = ( isset($jobfair['title']) && $jobfair['title'] ) ? $jobfair['title']:'';
			$schedule = ( isset($jobfair['schedule']) && $jobfair['schedule'] ) ? $jobfair['schedule']:'';
			$s3 = ( ($left_image || $left_text) &&  $jobfair ) ? 'half':'full';
			if( $title3 ) { ?>
			<section id="section3" data-section="<?php echo $title3 ?>" class="section-content section-jobfair <?php echo $s3 ?>">
				<div class="flexwrap">
					<?php if ($left_image || $left_text) { ?>
					<div class="imagecol">
						<?php if ($left_image) { ?>
							<div class="r1"><img src="<?php echo $left_image['url'] ?>" alt="<?php echo $left_image['title'] ?>" class="left-image"></div>
						<?php } ?>
						<?php if ($left_text) { ?>
							<div class="r2">
								<div class="text"><?php echo $left_text ?></div>
							</div>
						<?php } ?>
					</div>
					<?php } ?>

					<?php if ($jobfair) { ?>
					<div class="jobfair">
						<div class="inside">
							
							<div class="wrap">
								<?php if ($title3) { ?>
								<div class="shead-icon text-center">
									<div class="icon"><span class="ci-menu"></span></div>
									<h2 class="stitle"><?php echo $title3 ?></h2>
								</div>
								<?php } ?>

								<?php if ($schedule) { ?>
								<div class="schedule">
									<?php foreach ($schedule as $s) { 
									$day = $s['day'];
									$date = $s['date'];
									$time = $s['time'];
									$button = $s['button'];
									$target = ( isset($button['target']) && $button['target'] ) ? $button['target'] : '_self';
									?>
									<div class="info">
										<div class="time">
											<?php if ($day) { ?>
											<span class="day"><?php echo $day ?></span>	
											<?php } ?>

											<?php if ($date) { ?>
											<span class="date"><?php echo $date ?></span>	
											<?php } ?>

											<?php if ($time) { ?>
											<span class="time"><?php echo $time ?></span>	
											<?php } ?>
										</div>

										<?php if ($button) { ?>
											<div class="buttondiv">
												<a href="<?php echo $button['url'] ?>" target="<?php echo $target ?>" class="btn-sm"><span><?php echo $button['title'] ?></span></a>
											</div>	
										<?php } ?>
									</div>
									<?php } ?>
								</div>	
								<?php } ?>
							</div>

						</div>
					</div>
					<?php } ?>
				</div>
			</section>
			<?php } ?>


		
		<?php get_template_part("parts/content-available-jobs") ?>
		<?php //get_template_part("parts/content-employee-stories") ?>


		<?php
		$customFAQTitle = 'FAQ';
		$customFAQClass = 'custom-class-faq graybg';
		include( locate_template('parts/content-faqs.php') );
		include( locate_template('inc/faqs.php') );
		?>

</div><!-- #primary -->

<script type="text/javascript">
jQuery(document).ready(function($){
	var currentURL = window.location.href;

	$(document).on('facetwp-refresh', function() {
    var query_string = FWP.build_query_string();
    if ( '' === query_string ) { // no facets are selected
      $('.filter-message #fm').show();
      //location.reload();
    } else {
    	$('.filter-message #fm').hide();
    }
	});

		// $(document).on('change', '.facetwp-facet-job_locations', function(e) { // change product_tags to name of dropdown facet
  //       // FWP.is_reset = true;
  //       // FWP.facets['product_categories'] = []; // set other facet to no selections
  //       // delete FWP.facets['paged']; // remove "paged" from URL
  //       // FWP.refresh();
  //       //FWP.is_reset = true;
  //       //console.log(e)
  //   });

	$(document).on("click","#nextPostsBtn",function(e){
		e.preventDefault();
		var button = $(this);
		var baseURL = $(this).attr("data-baseurl");
		var currentPageNum = $(this).attr("data-current");
		var nextPageNum = parseInt(currentPageNum) + 1;
		var pageEnd = $(this).attr("data-end");
		var nextURL = baseURL + '?pg=' + nextPageNum;
		button.attr("data-current",nextPageNum);
		if(nextPageNum==pageEnd) {
			$(".loadmorediv").remove();
		}
		$(".hidden-entries").load(nextURL+" #data-container",function(){
			if( $(this).find(".posts-inner .flex-inner").length>0 ) {
				var entries = $(this).find(".posts-inner .flex-inner").html();
				$("#loaderDiv").addClass("show");
				if(entries) {
					$("#data-container .flex-inner").append(entries);
					setTimeout(function(){
						$("#loaderDiv").removeClass("show");
					},500);
				}
			}
		});
	});
});
</script>
<?php
include( locate_template('inc/pagetabs-script.php') );
get_footer();
