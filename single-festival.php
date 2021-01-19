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
	
<div id="primary" class="content-area-full content-default single-post <?php echo $has_hero;?> post-type-<?php echo $post_type;?>">

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

			<?php get_template_part("parts/subpage-tabs"); ?>
				
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


			<?php /* SCHEDULE */ ?>
			<?php
			$activities = get_field("festival_activities");
			$schedule_dates = get_field("schedule_dates");
			if($activities) { ?>
			<section id="section-schedule" data-section="SCHEDULE" class="section-content">
				<div class="wrapper">
					<div class="shead-icon text-center">
						<div class="icon"><span class="ci-menu"></span></div>
						<h2 class="stitle">SCHEDULE</h2>
						<?php if ($schedule_dates) { ?>
						<p class="eventDates"><?php echo $schedule_dates ?></p>	
						<?php } ?>
					</div>

					<?php /* Filter Options */ ?>
					<div class="filter-wrapper filterstyle optionsnum3" style="display:none;">
						<div class="wrapper">
							
							<div class="filter-inner">
								<div class="flexwrap">

									<div class="filter-label">
										<div class="inside"><span>Filter By</span></div>
									</div>

									<?php if ( do_shortcode('[facetwp facet="job_locations"]') ) { ?>
									<div class="select-wrap">
										<?php echo do_shortcode('[facetwp facet="job_locations"]'); ?>
									</div>
									<?php } ?>

								</div>
							</div>

						</div>
					</div>

					<div id="tabSchedules" class="schedules-list-wrap">
						<div id="tabOptions"></div>
						<div class="scheduleContent">
						<?php $ctr=1; foreach ($activities as $a) { 
							$day = $a['day'];
							$daySlug = ($day) ? sanitize_title($day) : '';
							$schedules = $a['schedule'];
							$isActive = ($ctr==1) ? ' active':'';
							if($schedules) { ?>
							<div id="daygroup<?php echo $ctr?>" class="schedules-list<?php echo $isActive?>">
								<?php if ($day) { ?>
								<h3 class="day"><?php echo ucwords($day) ?></h3>
								<?php } ?>
								<ul class="items">
									<?php foreach ($schedules as $s) { 
										// echo "<pre>";
										// print_r($s);
										// "</pre>";
										$act = ( isset($s['activity']) && $s['activity'] ) ? $s['activity']:'';
										$activityName = ($act) ? $act->post_title :'';
										$activityID = ($act) ? $act->ID :'';
										$is_pop_up = ( isset($s['popup_info'][0]) && $s['popup_info'][0] ) ? true : false;
										$altText = ( isset($s['alt_text']) && $s['alt_text'] ) ? $s['alt_text']:'';
										if($activityName && $altText) {
											$altText = ' ('.$altText.')';
										}
										$pageLink = ($activityID) ? get_permalink($activityID) : '#';
									?>
									<li class="item">
										<div class="time"><?php echo $s['time'] ?></div>
										<div class="event">
											<?php if ($activityName) { ?>
												<?php if ($is_pop_up && $activityID) { ?>
												<a href="#" data-url="<?php echo $pageLink ?>" data-action="ajaxGetPageData" data-id="<?php echo $activityID ?>" class="actname popdata"><?php echo $activityName ?></a>	
												<?php } else { ?>
												<span class="actname"><?php echo $activityName ?></span>	
												<?php } ?>
											<?php } ?>

											<?php if ($altText) { ?>
											<span class="alttext"><?php echo $altText ?></span>
											<?php } ?>
										</div>
									</li>
									<?php } ?>
								</ul>
							</div>
							<?php $ctr++; } ?>
						<?php } ?>
						</div>
					</div>

				</div>
			</section>
			<?php } ?>


			


			<?php  /* FAQ */ 
				$customFAQTitle = 'FAQ';
				include( locate_template('parts/content-faqs.php') ); 
			?>


		</main>

	</div>


<div id="activityModal" class="modal customModal fade">
	<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="modalBodyText" class="modal-body">
      </div>
    </div>
  </div>
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

	/* Tabs */
	var tabs = '<ul>';
	var i = 1;
	$("#tabSchedules .day").each(function(){
		if( $(this).text().replace(/\s+/g,'').trim() ) {
			var active = (i==1) ? ' active':'';
			tabs += '<li class="tablink'+active+'"><a href="#" data-tab="#daygroup'+i+'">'+$(this).text()+'</a></li>';
			i++;
		}
	});
	tabs += '<ul>';
	$("#tabOptions").html(tabs);

	$(document).on("click","#tabOptions a",function(e){
		e.preventDefault();
		$("#tabOptions li").removeClass('active');
		$(this).parent().addClass('active');
		$(".schedules-list").removeClass('active');
		var tabContent = $(this).attr("data-tab");
		$(tabContent).addClass('active');
	});

	$(".popdata").on("click",function(e){
		e.preventDefault();
		var pageURL = $(this).attr('data-url');
		var actionName = $(this).attr('data-action');
		var pageID = $(this).attr('data-id');

		$.ajax({
			url : frontajax.ajaxurl,
			type : 'post',
			dataType : "json",
			data : {
				'action' : actionName,
				'ID' : pageID
			},
			beforeSend:function(){
				$("#loaderDiv").show();
			},
			success:function( obj ) {
			
				var content = '';
				if(obj) {
					content += '<div class="modaltitleDiv text-center"><h5 class="modal-title">'+obj.post_title+'</h5></div>';
					if(obj.featured_image) {
						var img = obj.featured_image;
						content += '<div class="modalImage"><img src="'+img.url+'" alt="'+img.title+'p" class="feat-image"></div>';
					}
					content += '<div class="modalText"><div class="text">'+obj.post_content+'</div></div>';
				}

				if(content) {
					$("#modalBodyText").html(content);
					$("#activityModal").modal("show");
				}

				$("#loaderDiv").hide();
				
			},
			error:function() {
				$("#loaderDiv").hide();
			}
		});


	});

});
</script>
<?php
include( locate_template('inc/pagetabs-script.php') );  
include( locate_template('inc/faqs.php') );  
get_footer();
