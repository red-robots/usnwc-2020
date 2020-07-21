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
	<div class="home-video-gallery full">
		<div class="inner-wrap">
			<div class="flexwrap">
				<div class="colLeft video-big">
					<div class="imagediv wavehover" style="background-image:url('<?php echo $sample?>')">
						<img src="<?php echo $blank_image ?>" alt="" aria-hidden="true" class="blankImg">
						<div class="videoBtn">
							<a href="#" class="play-btn large"></a>
						</div>
						<div class="videoName"><span>Title Goes Here</span></div>
						<div class="wave"></div>
					</div>
				</div>

				<div class="colRight small-videos">
					<div class="wrap">
						<div class="sm-video">
							<div class="thumb wavehover" style="background-image:url('<?php echo $sample?>')">
								<img src="<?php echo $blank_image ?>" alt="" aria-hidden="true" class="blankImg">
								<div class="videoBtn">
									<a href="#" class="play-btn"></a>
								</div>
								<div class="videoName"><span>Title Goes Here</span></div>
								<div class="wave"></div>
							</div>
						</div>

						<div class="sm-video">
							<div class="thumb wavehover" style="background-image:url('<?php echo $sample?>')">
								<img src="<?php echo $blank_image ?>" alt="" aria-hidden="true" class="blankImg">
								<div class="videoBtn">
									<a href="#" class="play-btn"></a>
								</div>
								<div class="videoName"><span>Title Goes Here</span></div>
								<div class="wave"></div>
							</div>
						</div>

						<div class="sm-video">
							<div class="thumb wavehover" style="background-image:url('<?php echo $sample?>')">
								<img src="<?php echo $blank_image ?>" alt="" aria-hidden="true" class="blankImg">
								<div class="videoBtn">
									<a href="#" class="play-btn"></a>
								</div>
								<div class="videoName"><span>Title Goes Here</span></div>
								<div class="wave"></div>
							</div>
						</div>

						<div class="sm-video">
							<div class="thumb wavehover" style="background-image:url('<?php echo $sample?>')">
								<img src="<?php echo $blank_image ?>" alt="" aria-hidden="true" class="blankImg">
								<div class="videoBtn">
									<a href="#" class="play-btn"></a>
								</div>
								<div class="videoName"><span>Title Goes Here</span></div>
								<div class="wave"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php } ?>