<?php
/*===== ROW 4: STORIES =====*/
$row4_title = get_field('row4_title');  
$row4_button_name = get_field('row4_button_name');  
$row4_button_link = get_field('row4_button_link');  
$sample = THEMEURI . "images/sample.jpg";  
$blank_image = THEMEURI . "images/rectangle.png";
?>
<?php if ($row4_title) { ?>
<section id="section-stories" class="homerow row4">
	<div class="wrapper inner-content text-center">
		<div class="icondiv"><span class="video"></span></div>
		<h2 class="stitle"><?php echo $row4_title ?></h2>
		<?php if ($row4_button_name && $row4_button_link) { ?>
		<div class="buttondiv">
			<a href="<?php echo $row4_button_link['url'] ?>" target="<?php echo $row4_button_link['target'] ?>" class="btn-sm"><span><?php echo $row4_button_name ?></span></a>
		</div>	
		<?php } ?>
	</div>

	<?php /* VIDEOS */ ?>
	<?php  
	$args = array(
		'posts_per_page'	=> 5,
		'post_type'		=> 'story',
		'post_status'	=> 'publish',
		'meta_key'		=> 'show_on_homepage',
		'meta_value'	=> 'yes'
	);
	$posts = new WP_Query($args);
	if ( $posts->have_posts() ) { 
	$totalpost = $posts->found_posts;  ?>
	<div class="home-video-gallery full count<?php echo $totalpost?>">
		<div class="inner-wrap">
			<div class="flexwrap">
				<?php $i=1; while ( $posts->have_posts() ) : $posts->the_post(); 
				$post_title = get_the_title(); 
				$videoURL = get_field("video");
				$custom_thumb = get_field("image");
				$thumbType = get_field("thumbnail_type");
				$thumbnail_type = ($thumbType=='custom_image') ? $thumbType : 'default_image';
				$video_thumbnail = '';
				$default_thumb = '';
				$youtubeID = '';
				$vimeoID = '';

				//Youtube
				if ( (strpos( strtolower($videoURL), 'youtube.com') !== false) || (strpos( strtolower($videoURL), 'youtu.be') !== false) ) {
					if(strpos( strtolower($videoURL), 'youtu.be') !== false) {
						$parts = explode("/",$videoURL);
						$youtubeID = end($parts);
					}
					if(strpos( strtolower($videoURL), 'youtube.com') !== false) {
						$parts = parse_url($videoURL);
						parse_str($parts['query'], $query);
						$youtubeID = (isset($query['v']) && $query['v']) ? $query['v']:''; 
					}
					$video_thumbnail = 'https://i.ytimg.com/vi/'.$youtubeID.'/maxresdefault.jpg';
					$default_thumb = $video_thumbnail;
				}

				//Vimeo
				if (strpos( strtolower($videoURL), 'vimeo.com') !== false) {
					$vimeo_parts = explode("/",$videoURL);
					$parts = ($vimeo_parts && array_filter($vimeo_parts) ) ? array_filter($vimeo_parts) : '';
					$vimeoId = ($parts) ?  preg_replace('/\s+/', '', end($parts)) : '';
					$vimeoData = ($vimeoId) ? get_vimeo_data($vimeoId) : '';
					$videoURL .= '?autoplay=1';
					if($vimeoData) { 
						$video_thumbnail = $vimeoData->thumbnail_large;
						$default_thumb = $video_thumbnail;
					}
				}


				if($thumbnail_type=='default_image') {
					$video_thumbnail = $default_thumb;
				} else {
					if($custom_thumb) {
						$video_thumbnail = $custom_thumb['url'];
					}
				}

				$imageBg = ($video_thumbnail) ? ' style="background-image:url('.$video_thumbnail.')"':'';

				if ($i==1) { ?>
				<div class="colLeft video-big">
					<div class="imagediv wavehover"<?php echo $imageBg ?>>
						<img src="<?php echo $blank_image ?>" alt="" aria-hidden="true" class="blankImg">
						
						<?php if ($thumbnail_type=='default_image') { ?>
						<div class="videoBtn">
							<a href="#" class="play-btn large"></a>
						</div>
						<?php } ?>

						<div class="videoName"><span><?php echo $post_title ?></span></div>
						<div class="wave"></div>
						<?php if ($videoURL) { ?>
						<a data-fancybox href="<?php echo $videoURL ?>" class="videoLink"><span>Play Video</span></a>
						<?php } ?>
					</div>
				</div>
				<div class="colRight small-videos">
					<div class="wrap">
				<?php } else { ?>
						<div class="sm-video">
							<div class="thumb wavehover"<?php echo $imageBg ?>>
								<img src="<?php echo $blank_image ?>" alt="" aria-hidden="true" class="blankImg">
								<?php if ($thumbnail_type=='default_image') { ?>
								<div class="videoBtn">
									<a href="#" class="play-btn"></a>
								</div>
								<?php } ?>
								<div class="videoName"><span><?php echo $post_title ?></span></div>
								<div class="wave"></div>
								<?php if ($videoURL) { ?>
								<a data-fancybox href="<?php echo $videoURL ?>" class="videoLink"><span>Play Video</span></a>
								<?php } ?>
							</div>
						</div>
				<?php } ?>
				<?php $i++; endwhile; wp_reset_postdata(); ?>
					</div><!-- .wrap -->
				</div><!-- .colRight -->
			</div>
		</div>
	</div>
	<?php } ?>

</section>
<?php } ?>