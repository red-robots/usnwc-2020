<?php
/**
 * Template Name: Adventure Dining
 */

get_header(); 
$blank_image = THEMEURI . "images/square.png";
?>

<div id="primary" data-post="<?php echo get_the_ID()?>" class="content-area-full festival-page">
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

	<?php  /* Adventure Dining posts */ ?>
	<?php  
		$postype = 'dining';
		$perpage = -1;
		$paged = ( get_query_var( 'pg' ) ) ? absint( get_query_var( 'pg' ) ) : 1;
		$args = array(
			'post_type'				=> $postype,
			'posts_per_page'	=> $perpage,
			'post_status'			=> 'publish',
		);
		$entries = new WP_Query($args);
		if( $entries->have_posts() ) { ?>	
		<div class="post-type-entries <?php echo $postype ?>">
			<div id="data-container">
				<div class="posts-inner animate__animated animate__fadeIn">
					<div class="flex-inner">
					<?php while ( $entries->have_posts()) : $entries->the_post(); ?>
						<?php
						$title = get_the_title();
						$thumbImage = get_field("post_image_thumb");
						$short_description = get_field("short_description");
						$imageLinkTarget = '_self';
						$imageLink = get_permalink();
						//$button_type = (get_field("button_type")) ? get_field("button_type") : 'pagelink';
						//$button = get_field("button_".$button_type);
						//$imageLink = '#';
						// if ($button && $button_type=='pdf') { 
						// 	$imageLink = $button['button_link'];
						// 	$imageLinkTarget = '_blank';
						// }
						// else if ($button && $button_type=='pagelink') { 
						// 	$imageLink = $button['url'];
						// 	$imageLinkTarget = ( isset($button['target']) && $button['target'] ) ? $button['target']:'_self';
						// }
						?>
						<div class="postbox <?php echo ($thumbImage) ? 'has-image':'no-image' ?>">
							<div class="inside">
								<a href="<?php echo $imageLink ?>" target="<?php echo $imageLinkTarget ?>" class="photo wave-effect js-blocks">
										<?php if ($thumbImage) { ?>
											<span class="imagediv" style="background-image:url('<?php echo $thumbImage['url'] ?>')"></span>
											<img src="<?php echo $thumbImage['url']; ?>" alt="<?php echo $thumbImage['title'] ?>" class="feat-img">
										<?php } else { ?>
											<span class="imagediv"></span>
											<img src="<?php echo $blank_image ?>" alt="" class="feat-img placeholder">
										<?php } ?>

										<span class="boxTitle">
											<span class="twrap">
												<span class="t1"><?php echo $title ?></span>
											</span>
										</span>
										
										<?php include( locate_template('images/wave-svg.php') ); ?>
									</a>

									<div class="details">
										<div class="info">
											<h3 class="event-name"><?php echo $title ?></h3>
											<?php if ($short_description) { ?>
											<div class="short-description"><?php echo $short_description; ?></div>	
											<?php } ?>

											<div class="button">
												<a href="<?php echo $imageLink ?>" target="<?php echo $imageLinkTarget ?>" class="btn-sm"><span>See Details</span></a>
											</div>
											
										</div>
									</div>

							</div>
						</div>

					<?php endwhile; wp_reset_postdata(); ?>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>

</div><!-- #primary -->

<?php
get_footer();
