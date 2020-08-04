<?php while ( have_posts() ) : the_post(); 

	$postid = get_the_ID();
	$top_notification = get_field("top_notification");
	$main_description = get_field("activity_descr");
	$taxonomy = 'pass_type';
	$categories = get_the_terms($postid,$taxonomy);
	$catSlugs = array();
	if($categories) {
		foreach($categories as $c) {
			$catSlugs[] = $c->slug;
		}
	}

	/* Show description if category slug is 'all-access-pass' */
	$show_main_description = false;
	if( $categories &&  in_array('all-access-pass',$catSlugs) ) {
		$show_main_description = true;
	}

	$pageTabs = array('intro','options','what to wear','check-in','faq');
	?>
	
	<?php if ($show_main_description && $main_description) { ?>
	<section class="main-description">
		<div class="wrapper text-center">
			<?php echo $main_description ?>
		</div>
	</section>
	<?php } ?>

	<div id="pageTabs"></div>


	<?php 
	/* INTRO */
	$galleries = '';
	$galleryData = get_field("gallery_content");
	if( isset($galleryData['g_images']) && $galleryData['g_images'] ) {
		$galleries = $galleryData['g_images'];
	}
	$left_icon = ( isset($galleryData['g_icon']) && $galleryData['g_icon'] ) ? $galleryData['g_icon']:'';
	$left_text = ( isset($galleryData['g_description']) && $galleryData['g_description'] ) ? $galleryData['g_description']:'';
	$introClass = ($left_text && $galleries) ? 'half':'full';
	$placeholder = THEMEURI . 'images/rectangle.png';
	?>

	<?php if ($left_text || $galleries) { ?>
	<section id="section-intro" data-title="Intro" class="section-content intro-galleries <?php echo $introClass ?>">
		<div class="flexwrap">
			<?php if ($left_text) { ?>
			<div class="leftcol textcol">
				<div class="wrap">
					<div class="inner">
						<?php if ($left_icon) { ?>
						<div class="icon-col">
							<span style="background-image:url('<?php echo $left_icon['url'] ?>')"></span>
						</div>	
						<?php } ?>
						<?php echo $left_text ?>	
					</div>	
				</div>
			</div>	
			<?php } ?>

			<?php if ($galleries) { 
				$count = count($galleries); 
				$slider_class = ($count>1) ? 'subpage-sliders':'subpage-slider-static';
				?>
			<div id="subpageSlides" class="rightcol <?php echo $slider_class ?>">
				<ul class="slides">
					<?php foreach ($galleries as $g) { ?>
					<li class="sub-slide-item">
						<div class="slide-image" style="background-image:url('<?php echo $g['url']?>')">
							<img src="<?php echo $placeholder ?>" alt="">
						</div>
					</li>	
					<?php } ?>
				</ul>
			</div>	
			<?php } ?>
		</div>
	</section>	
	<?php } ?>


	<?php  
	/* OPTIONS */
	$activities = get_field("activities");
	$options_class = ($activities && $categories) ? 'half':'full';
	if($activities || $categories) { ?>
	<section id="section-options" data-title="Options" class="section-content <?php echo $options_class ?>">
		<div class="wrapper">
			<?php if ($activities) { ?>
			<div class="optcol activities">
				<div class="flex-items">
					<div id="items-head" class="item headings">
						<div class="cell hd1">Options</div>
						<div class="cell hd2">Difficulty</div>
						<div class="cell hd3">Age</div>
					</div>

					<?php $i=1; foreach ($activities as $a) {
						$a_name = $a['name'];
						$a_description = $a['description'];
						$a_difficulty = $a['difficulty'];
						$a_qualifiers = $a['qualifiers'];
						$a_show = $a['show']; 
						$show_this_option = ($a_show=='yes') ? true : false;
						if($show_this_option) { ?>
						<div id="item-<?php echo $i?>" class="item">

							<?php /* OPTIONS */ ?>
							<?php if ($a_name) { ?>
								<div class="item-title"><h2 class="type"><?php echo $a_name ?></h2></div>
							<?php } ?>
							<div class="cell desc-col">
								<?php if ($a_description) { ?>
								<div class="desc"><?php echo $a_description ?></div>	
								<?php } ?>
							</div>
							
							<?php /* DIFFICULTY */ ?>
							<div class="cell diff-col">
								<span class="cell-label">Difficulty:</span>
								<?php if ($a_difficulty) { ?>
									<?php foreach ($a_difficulty as $diff) { 
										$dSlug = sanitize_title($diff); ?>
										<span class="diff <?php echo $dSlug ?>"></span>
									<?php } ?>
								<?php } ?>
							</div>

							<?php /* AGE */ ?>
							<div class="cell age-col">
								<span class="cell-label">Age:</span>
								<?php if ($a_qualifiers) { ?>
								<span class="age"><?php echo $a_qualifiers ?></span>
								<?php } ?>
							</div>
						</div>	
						<?php $i++; } ?>
					<?php } ?>
				</div>

			</div>	
			<?php } ?>

			<?php 
			$purchase_link = get_field("purchase_link");
			$reservation = get_field("reservation_data");
			?>
			<?php if ($categories || $reservation) { ?>
			<div class="optcol categories">
				<?php if ($categories) { ?>
					<div class="inner graybox">
						<h2 class="box-title">Pass Options</h2>
						<div class="box-content">
							<ul class="cats">
							<?php foreach ($categories as $cat) {
								$cat_id = $cat->term_id;
								$pass_types = get_pass_type_category($cat_id); 
								$pass_types_list = '';
								if($pass_types) {
									foreach($pass_types as $k=>$v) {
										$comma = ($k>0) ? ', ':'';
										$pass_types_list .= $comma . ucwords( strtolower($v->post_title)); 
									}
								}
								?>
								<li class="cat-item">
									<span class="icon"></span>
									<span class="catName">
										<?php echo $cat->name; ?>
										<?php if ($pass_types_list) { ?>
										<small>(<?php echo $pass_types_list ?>)</small>	
										<?php } ?>
									</span>
								</li>
							<?php } ?>
							</ul>

							<?php if ($purchase_link) { 
								$btn_title = $purchase_link['title'];
								$btn_link = $purchase_link['url'];
								$btn_target = $purchase_link['target'];
								$target = ($btn_target) ? ' target="'.$btn_target.'"':'';
							?>
							<div class="button text-center">
								<a href="<?php echo $btn_link ?>" class="btn-border"<?php echo $target ?>>
									<span><?php echo $btn_title ?></span>
								</a>
							</div>	
							<?php } ?>
						</div>
					</div>
				<?php } ?>

				<?php if ($reservation) {
					$res_title =  $reservation['title'];
					$res_text =  $reservation['text'];
					$res_button =  $reservation['button'];
					$res_target = ($res_button['target']) ? ' target="'.$res_button['target'].'"':'';
					?>
					<div class="inner redbox">
						<div class="wrap">
							
							
							<?php if ($res_text || $res_button || $res_title) { ?>
								<div class="box-content">
									<div class="inner-wrap">
										<?php if ($res_title) { ?>
											<h2 class="box-title"><?php echo $res_title ?></h2>
										<?php } ?>
										<?php if ($res_text) { ?>
											<div class="text"><?php echo $res_text ?></div>
										<?php } ?>
										<?php if ($res_button) { ?>
											<div class="button">
												<a href="<?php echo $res_button['link'] ?>" class="btn-border-white"<?php echo $res_target ?>>
													<span><?php echo $res_button['title'] ?></span>
												</a>
											</div>
										<?php } ?>
									</div>
								</div>
							<?php } ?>

						</div>
					</div>	
				<?php } ?>
			</div>	
			<?php } ?>
		</div>
	</section>
	<?php } ?>
	

<?php endwhile; ?>