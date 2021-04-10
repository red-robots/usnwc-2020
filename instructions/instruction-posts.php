<?php
if( isset($current_term_id) && $current_term_id ) {
$blank_image = THEMEURI . "images/rectangle.png";
$square = THEMEURI . "images/square.png";
$perpage = -1;
$posttype = 'instructions';
$args = array(
	'posts_per_page'   => $perpage,
	'post_type'        => $posttype,
	'post_status'      => 'publish'
);

$args['tax_query'][] = array(
			'taxonomy' => $taxonomy,
			'field' => 'term_id',
			'terms' => $current_term_id
		);

$entries = new WP_Query($args); 
if ( $entries->have_posts() ) { 
$total = $entries->found_posts;
$flexClass = ($total<3) ? ' align-middle':'';
?>
<section class="section-content entries-with-filter" style="padding-top:0;">
	<div class="post-type-entries boxes-element threecols <?php echo $postype ?>">
		<div id="data-container">
			<div class="posts-inner result">
				<div id="resultContainer" class="flex-inner<?php echo $flexClass ?>">
					<?php $ctr=1; while ( $entries->have_posts() ) : $entries->the_post(); 
						$pid = get_the_ID();
						$title = get_the_title();
						$pagelink  = get_permalink();
						$short_description = get_field("short_description");
						$thumbImage = get_field("thumbnail_image");
						$price = get_field("price");
						$ages = get_field("ages");
						$duration = get_field("duration");
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
					<?php $ctr++; endwhile; wp_reset_postdata(); ?>
				</div>
			</div>
		</div>
	</div>
</section>
<?php }
}  ?>