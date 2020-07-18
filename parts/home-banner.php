<?php
/**
 * Sidebar-banner.php
 *
 */ 
//$placeholder = THEMEURI . 'images/rectangle-lg.png';
?>
<div id="banner">
	<?php 
	$flexslider = get_field( "flexslider_banner" );
	$firstImg = array();
	if($flexslider) {
		foreach($flexslider as $r) {
			if( isset($r['image']['url']) ) {
				$firstImg[] = $r['image']['url'];
			}
		}
	}

	if ( $flexslider ):?>
		<div class="flexslider">
			<ul class="slides">
				<?php for ($i = 0; $i< count($flexslider) ; $i++ ):
				$row = $flexslider[$i]; ?>
					<?php if ( strcmp( $row['video_or_image'], "video" ) === 0 && ($row['video']||$row['native_video']) ): ?>
						<li class="slideItem">
							<div class="iframe-wrapper <?php echo ($row['mobile_video']||$row['mobile_image'])?'yes-mobile':'no-mobile';?>">
                                <?php if($row['link']):?>
								    <a href="<?php echo $row['link']; ?>" class="slideLink" <?php if ( $row['target'] ):echo 'target="_blank"'; endif; ?>></a>
								<?php endif;?>
									<?php if($row['native_video']):?>
										<video class="desktop" autoPlay loop muted playsinline>
											<source src="<?php echo $row['native_video'];?>" type="video/mp4">
										</video>
									<?php elseif($row['video']):?>
											
										<?php 
											$videoURL = $row['video'];
											$parts = parse_url($videoURL);
											parse_str($parts['query'], $query);
											$youtubeId = (isset($query['v']) && $query['v']) ? $query['v']:''; 
											if($youtubeId) {
												$embed_url = 'https://www.youtube.com/embed/'.$youtubeId.'?version=3&rel=0&loop=0';	
												$mainImage = 'https://i.ytimg.com/vi/'.$youtubeId.'/maxresdefault.jpg'
											?>

											<?php if ( isset($firstImg[0]) && $firstImg[0] ) { ?>
												<img src="<?php echo $firstImg[0] ?>" alt="" class="image-size-ref">	
											<?php } ?>

											<div class="videoIframeDiv" style="background-image:url('<?php echo $mainImage?>');">
												<div class="playButtonDiv">
													<a href="#" class="playVidBtn" data-embed="<?php echo $embed_url; ?>"><span>Play</span></a>
												</div>
												<iframe class="videoIframe" src="<?php echo $embed_url; ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
											</div>

										<?php } ?>
									
									<?php endif;
									if($row['mobile_video']):?>
										<video class="mobile" autoPlay loop muted playsinline>
											<source src="<?php echo $row['mobile_video'];?>" type="video/mp4">
										</video>
									<?php elseif($row['mobile_image']):?>
										<img class="mobile <?php if($i!==0) echo 'lazy';?>" <?php if($i!==0) echo 'data-';?>src="<?php echo $row['mobile_image']['url']; ?>"
												alt="<?php echo $row['mobile_image']['alt']; ?>">
									<?php endif;?> 
							</div><!--.iframe-wrapper-->
							<?php if (isset($row['slide_text']) && $row['slide_text']) { ?>
							<div class="slideCaption"><div class="text"><?php echo $row['slide_text'] ?></div></div>
							<?php } ?>
						</li>
					<?php elseif ( strcmp( $row['video_or_image'], "image" ) === 0 && $row['image'] ): ?>
						<li class="slideItem">
							<div class="image-wrapper <?php echo $row['mobile_image']?'yes-mobile':'no-mobile';?>"
							     style="background-image: url(<?php if($row['mobile_image']):
								     echo $row['mobile_image']['url'];
							     else:
                                     echo $row['image']['url'];
							     endif;?>);">
                                <?php if($row['link']):?>
								    <a href="<?php echo $row['link']; ?>" class="slideLink" <?php if ( $row['target'] ):echo 'target="_blank"'; endif; ?>>
								<?php endif;?>
                                        <img class="desktop <?php if($i!==0) echo 'lazy';?>" <?php if($i!==0) echo 'data-';?>src="<?php echo $row['image']['url']; ?>"
									     alt="<?php echo $row['image']['alt']; ?>">
                                        <?php if($row['mobile_image']):?>
                                            <img class="mobile <?php if($i!==0) echo 'lazy';?>" <?php if($i!==0) echo 'data-';?>src="<?php echo $row['mobile_image']['url']; ?>"
                                                 alt="<?php echo $row['mobile_image']['alt']; ?>">
                                        <?php endif;?>
                                <?php if($row['link']):?>
								    </a>
                                <?php endif;?>
							</div><!--.image-wrapper-->
							<?php if (isset($row['slide_text']) && $row['slide_text']) { ?>
							<div class="slideCaption"><div class="text"><?php echo $row['slide_text'] ?></div></div>
							<?php } ?>
						</li>
					<?php endif; ?>
				<?php endfor; ?>
			</ul>
		</div><!--.flexslider-->
	<?php endif; ?>
</div><!--#banner-->
