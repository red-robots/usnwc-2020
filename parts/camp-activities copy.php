<?php
$placeholder = THEMEURI . 'images/rectangle.png';
$placeholder2 = THEMEURI . 'images/rectangle-narrow.png';
$camp_activities = get_field("camp_activities");
if($camp_activities) {
$perpage = -1;
$posttype = 'activity';

	$args = array(
		'posts_per_page'	=> $perpage,
		'post_type'				=> $posttype,
		'post__in'				=> $camp_activities,
		'post_status'			=> 'publish'
	);
	$entries = new WP_Query($args); 
	$section_title = get_field("activity_title");
	$activities_fullwidth = get_field("activity_fullwidth");

	if ( $entries->have_posts() ) { ?>
	<section id="section-activities" data-section="<?php echo $section_title ?>" class="section-content camp-activities">
		<?php if ($section_title) { ?>
		<div class="wrapper titlediv">
			<div class="shead-icon text-center">
				<div class="icon"><span class="ci-task"></span></div>
				<h2 class="stitle"><?php echo $section_title ?></h2>
			</div>
		</div>
		<?php } ?>
		<div class="flexwrap entries-flexwrap">
			<?php $i=1; while ( $entries->have_posts() ) : $entries->the_post(); ?>
				<?php 
				$pid = get_the_ID();
				$title = get_the_title(); 
				$text = get_the_content();
				$link = get_permalink();
				$thumbnail = get_field("thumbnail_image");
				$full_image = get_field("full_image");

				$flexBanner = get_field("flexslider_banner");
				if($flexBanner) {
					$data = $flexBanner[0];
					$img_type = $data['video_or_image'];
					if($img_type=='image') {
						$img = ( isset($data['image']) && $data['image'] ) ? $data['image']:'';
						if($img) {
							$thumbnail['url'] = $img['sizes']['medium_large'];
							$full_image['url'] = $img['url'];
						}
					}
				}


				$columnClass .= ($i % 2) ? ' odd':' even';
				$isFull = ( $activities_fullwidth && in_array($pid, $activities_fullwidth) ) ? ' fullwidthbox':'';
				if($isFull) {
					$thumbnail = $full_image;
				}
				?>
				<div class="fbox<?php echo $isFull ?>">
					<div class="inside">
						<a href="<?php echo $link ?>" class="imagediv <?php echo ($thumbnail) ? 'hasImage':'noImage'?>">
							<?php if ($isFull) { ?>

								<?php if ($full_image) { ?>
									<img src="<?php echo $full_image['url'] ?>" alt="<?php echo $full_image['title'] ?>" class="placeholder">
								<?php } else { ?>
									<img src="<?php echo $placeholder2 ?>" alt="" aria-hidden="true" class="placeholder">
								<?php } ?>

							<?php } else { ?>

								<?php if ($thumbnail) { ?>
									<span class="img" style="background-image:url('<?php echo $thumbnail['url']?>')"></span>
								<?php } ?>
								<img src="<?php echo $placeholder ?>" alt="" aria-hidden="true" class="placeholder">
							
							<?php } ?>
						</a>
						<div class="titlediv">
							<p class="name"><?php echo $title ?></p>
							<div class="buttondiv">
								<a href="<?php echo $link ?>" target="_blank" class="btn-sm"><span>See Details</span></a>
							</div>
						</div>
					</div>
				</div>
			<?php $i++; endwhile; wp_reset_postdata(); ?>
		</div>
	</section>
	<?php } ?>

<?php } ?>