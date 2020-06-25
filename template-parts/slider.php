<?php
/**
 * Slider for page
 * Custom Fields used:

   Repeater => flexslider_banner
   
   Sub Fields:
	video_or_image => Radio Button
	Need to go add the rest based on Jesse's answer of using a slider or not.
 *
 */ ?>
<div id="banner">
	<?php $flexslider = get_field( "flexslider_banner" );
	if ( $flexslider ):?>
		<div class="flexslider">
			<ul class="slides">
				<?php for ($i = 0; $i< count($flexslider) ; $i++ ):
				$row = $flexslider[$i]; ?>
					<?php if ( strcmp( $row['video_or_image'], "video" ) === 0 && ($row['video']||$row['native_video']) ): ?>
						<li>
							<div class="iframe-wrapper <?php echo ($row['mobile_video']||$row['mobile_image'])?'yes-mobile':'no-mobile';?>">
                                <?php if($row['link']):?>
								    <a href="<?php echo $row['link']; ?>" <?php if ( $row['target'] ):echo 'target="_blank"'; endif; ?>></a>
								<?php endif;?>
									<?php if($row['native_video']):?>
										<video class="desktop" autoPlay loop muted playsinline>
											<source src="<?php echo $row['native_video'];?>" type="video/mp4">
										</video>
									<?php elseif($row['video']):?>
										<iframe class="desktop" src="<?php echo $row['video']; ?>" webkitallowfullscreen mozallowfullscreen allowfullscreen="true"
											frameborder="0"></iframe>
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
						</li>
					<?php elseif ( strcmp( $row['video_or_image'], "image" ) === 0 && $row['image'] ): ?>
						<li>
							<div class="image-wrapper <?php echo $row['mobile_image']?'yes-mobile':'no-mobile';?>"
							     style="background-image: url(<?php if($row['mobile_image']):
								     echo $row['mobile_image']['url'];
							     else:
                                     echo $row['image']['url'];
							     endif;?>);">
                                <?php if($row['link']):?>
								    <a href="<?php echo $row['link']; ?>" <?php if ( $row['target'] ):echo 'target="_blank"'; endif; ?>>
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
						</li>
					<?php endif; ?>
				<?php endfor; ?>
			</ul>
		</div><!--.flexslider-->
	<?php endif; ?>
</div><!--#banner-->
