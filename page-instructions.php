<?php
/**
 * Template Name: Instruction
 */

get_header(); 
$blank_image = THEMEURI . "images/rectangle.png";
$square = THEMEURI . "images/square.png";
$currentPageLink = get_permalink();
?>

<div id="primary" data-post="<?php echo get_the_ID()?>" class="content-area-full boxedImagesPage instruction-page">
	<?php while ( have_posts() ) : the_post(); ?>
		<div class="intro-text-wrap">
			<div class="wrapper">
				<h1 class="page-title"><span><?php the_title(); ?></span></h1>
				<?php if ( get_the_content() ) { ?>
				<div class="intro-text"><?php the_content(); ?></div>
				<?php } ?>
			</div>
		</div>
	<?php endwhile; ?>

	<?php /* Filter Options */ ?>
	<?php  
	$filtered = array();
	$filter_params = array('_instructions_discipline','_instructions_duration','_instructions_skill_level','_instructions_age');

	if( isset($_GET) && $_GET ) {
		foreach($_GET as $k=>$v) {
			if( in_array($k,$filter_params) ) {
				$filtered[$k] = $v;
			}
		}
	}
	?>
	<div class="filter-wrapper filterstyle optionsnum4" style="display:none;">
		<div class="wrapper">
			
			<div class="filter-inner">
				<div class="flexwrap">

					<div class="filter-label">
						<div class="inside"><span>Filter By</span></div>
					</div>

					<?php if ( do_shortcode('[facetwp facet="instructions_discipline"]') ) { ?>
					<div class="select-wrap">
						<?php echo do_shortcode('[facetwp facet="instructions_discipline"]'); ?>
					</div>
					<?php } ?>

					<?php if ( do_shortcode('[facetwp facet="instructions_duration"]') ) { ?>
					<div class="select-wrap">
						<?php echo do_shortcode('[facetwp facet="instructions_duration"]'); ?>
					</div>
					<?php } ?>

					<?php if ( do_shortcode('[facetwp facet="instructions_skill_level"]') ) { ?>
					<div class="select-wrap">
						<?php echo do_shortcode('[facetwp facet="instructions_skill_level"]'); ?>
					</div>
					<?php } ?>

					<?php if ( do_shortcode('[facetwp facet="instructions_age"]') ) { ?>
					<div class="select-wrap">
						<?php echo do_shortcode('[facetwp facet="instructions_age"]'); ?>
					</div>
					<?php } ?>

				</div>
			</div>

		</div>
	</div>

	<?php
		$postype = 'instructions';
		$args = array(
			'posts_per_page'	=> -1,
			'post_type'				=> $postype,
			'post_status'			=> 'publish',
			'facetwp'					=> true
		);

	$posts = new WP_Query($args);
	if( $posts->have_posts() ) { ?>
	<section class="section-content entries-with-filter" style="padding-top:0;">
		<div class="post-type-entries boxes-element threecols <?php echo $postype ?>">
			<div id="data-container">
				<div class="posts-inner">
					<div class="flex-inner">
						<?php while ( $posts->have_posts() ) : $posts->the_post();  ?>
							<?php
							$title = get_the_title();
							$pagelink = get_permalink();
							$short_description = get_field("short_description");
							$thumbImage = get_field("thumbnail_image");
							$price = get_field("price");
							$ages = get_field("ages");
							$duration = get_field("duration");
							//$schedules = get_field("schedule_items");
							$schedules = get_field("schedules_alt");
							$options1 = array($price,$ages,$duration);
							$options2 = array("ages"=>$ages,"duration"=>$duration,"price"=>$price);
							?>
							<div class="postbox animated fadeIn <?php echo ($thumbImage) ? 'has-image':'no-image';?>">
								<div class="inside">
									<div class="photo">
										<?php if ($thumbImage) { ?>
											<span class="imagediv" style="background-image:url('<?php echo $thumbImage['sizes']['medium_large'] ?>')"></span>
											<img src="<?php echo $thumbImage['url']; ?>" alt="<?php echo $thumbImage['title'] ?>" class="feat-img" style="display:none;">
											<img src="<?php echo $blank_image ?>" alt="" class="feat-img placeholder">
										<?php } else { ?>
											<span class="imagediv"></span>
											<img src="<?php echo $blank_image ?>" alt="" class="feat-img placeholder">
										<?php } ?>
									</div>
									<div class="details">
										<div class="info">
											<h3 class="event-name"><?php echo $title ?></h3>
											
											<?php if ( $options1 && array_filter($options1) ) { ?>
											<div class="pricewrap">
												<div class="price-info">
													<?php foreach ($options2 as $k=>$v) { ?>
														<?php if ($v) { ?>
														<span class="<?php echo $k?>">
															<?php if ($k=='ages') { echo 'Age '; } ?><?php echo $v?>		
														</span>
														<?php } ?>	
													<?php } ?>
												</div>
											</div>
											<?php } ?>

											<?php if ($schedules) { ?>
											<div class="dates compact">
												<?php echo $schedules ?>
											</div>
											<?php } ?>

											<?php if ($short_description) { ?>
											<div class="short-description">
												<?php echo $short_description ?>
											</div>
											<?php } ?>
										</div>
									</div>
								</div>
								<div class="button">
									<a href="<?php echo $pagelink ?>" class="btn-sm"><span>See Details</span></a>
								</div>
							</div>
						<?php endwhile; wp_reset_postdata(); ?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php } ?>

</div><!-- #primary -->

<?php
get_footer();
