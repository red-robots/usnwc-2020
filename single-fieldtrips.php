<?php
get_header(); 
$rectangle = THEMEURI . "images/rectangle.png";
$square = THEMEURI . "images/square.png";
$banner = get_field("fieldtrip_featured_image");
$has_banner = ($banner) ? 'hasbanner':'nobanner';
if($banner) { ?>
<div id="banner" class="subpageBanner">
	<div class="slides-wrapper static-banner">
		<ul class="slides">
			<li class="slideItem type-image">
				<div class="image-wrapper yes-mobile" style="background-image: url('<?php echo $banner['url']?>');">
					<img class="desktop " src="<?php echo $banner['url']?>" alt="<?php echo $banner['title']?>">
				</div>
			</li>
		</ul>
	</div>
</div>
<?php } ?>

<div id="primary" class="content-area-full content-default page-default-template single-fieldtrips <?php echo $has_banner ?>">
	<main id="main" class="site-main" role="main">

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
			$opt = get_field("fieldtrip_options");
			$educational_programs = ( isset($opt['educational_programs']) ) ? $opt['educational_programs'] : '';
			$pass_activities = ( isset($opt['pass_activities']) ) ? $opt['pass_activities'] : '';
			$grades = ( isset($opt['grades']) ) ? $opt['grades'] : '';
			$activity_options = ( isset($opt['activity_options']) ) ? $opt['activity_options'] : '';
			$price = ( isset($opt['price']) ) ? $opt['price'] : '';
			if($opt) { ?>
			<section class="section-price-ages full">
				<div class="flexwrap">

					<div class="info">
						<div class="wrap">
							<div class="inner">
								<div class="label">Grades</div>
								<div class="val"><?php echo $grades ?></div>
							</div>
						</div>
					</div>	

					<div class="info">
						<div class="wrap">
							<div class="inner">
								<div class="label">Price</div>
								<div class="val"><?php echo $price ?></div>
							</div>
						</div>
					</div>	


					<div class="info">
						<div class="wrap">
							<div class="inner">
								<div class="label">Activity Options</div>
								<div class="val"><?php echo $activity_options ?></div>
							</div>
						</div>
					</div>	
						
				</div>
			</section>
			<?php } ?>

		<?php endwhile; ?>

		<?php
		/* CLASSES */
		$classes_section_title = get_field("classes_section_title");
		$repeater_blocks = get_field("repeater_blocks");
		if($repeater_blocks) { ?>
		<section id="classes" data-section="<?php echo $classes_section_title ?>" class="section-content full">
			<?php if ($classes_section_title) { ?>
			<div class="shead-icon text-center">
				<div class="icon"><span class="ci-sun"></span></div>
				<h2 class="stitle"><?php echo $classes_section_title ?></h2>
			</div>
			<?php } ?>

			<div class="post-type-entries">
				<div id="data-container">
					<div class="posts-inner">
						<div class="flex-inner">
							<?php foreach ($repeater_blocks as $e) { 
								$title = $e['title'];
								$description = $e['text'];
								$thumbImage = $e['image'];
								$grades2 = $e['grades'];
								$hours = $e['hours'];
								//$display_option = ($e['display_option']) ? 'fullwidth' : 'normal';
								$blockWidth = ( isset($e['blockWidth']) && $e['blockWidth'] ) ? $e['blockWidth'] : '';
								$display_option = ($blockWidth) ? ' style="width:'.$blockWidth.'%"':'';
								$blockClass = ($blockWidth) ? ' has-custom-width block'.$blockWidth:'';
								?>
								<div class="postbox animated fadeIn <?php echo ($thumbImage) ? 'has-image':'no-image' ?><?php echo $blockClass ?>"<?php echo $display_option ?>>
									<div class="inside">
										
										<div class="photo">
											<?php if ($thumbImage) { ?>
												<span class="imagediv" style="background-image:url('<?php echo $thumbImage['sizes']['medium_large'] ?>')"></span>
												<img src="<?php echo $rectangle ?>" alt="" class="feat-img placeholder">
											<?php } else { ?>
												<span class="imagediv"></span>
												<img src="<?php echo $rectangle ?>" alt="" class="feat-img placeholder">
											<?php } ?>
										</div>

										<div class="details">
											<div class="info">
												<h3 class="event-name"><?php echo $title ?></h3>
												<?php if ($description) { ?>
												<div class="short-description">
													<?php echo $description ?>
												</div>
												<?php } ?>

												<?php if($grades2 || $hours) { ?>
												<div class="options">
													<?php if($grades2) { ?>
													<span>Grades <?php echo $grades2 ?></span>
													<?php } ?>

													<?php if($hours) { ?>
													<span><?php echo $hours ?></span>
													<?php } ?>
												</div>
												<?php } ?>

											</div>
										</div>

									</div>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
		</section>
		<?php } ?>


		<?php
		/* Pass Activities */
		$pass_section_title = get_field("pass_section_title");
		$repeater_blocks2 = get_field("repeater_blocks2");
		$pass_notes = get_field("pass_notes");
		if($repeater_blocks2) { ?>
		<section id="pass-activities" data-section="<?php echo $pass_section_title ?>" class="section-content full">
			<?php if ($pass_section_title) { ?>
			<div class="shead-icon text-center">
				<div class="icon"><span class="ci-task"></span></div>
				<h2 class="stitle"><?php echo $pass_section_title ?></h2>
			</div>
			<?php } ?>

			<div class="post-type-entries">
				<div id="data-container">
					<div class="posts-inner">
						<div class="flex-inner">
							<?php foreach ($repeater_blocks2 as $e) { 
								$title = $e['title'];
								$description = $e['text'];
								$thumbImage = $e['image'];
								$grades2 = $e['grades'];
								$hours = $e['hours'];
								//$display_option = ($e['display_option']) ? 'fullwidth' : 'normal';
								$blockWidth = ( isset($e['blockWidth']) && $e['blockWidth'] ) ? $e['blockWidth'] : '';
								$display_option = ($blockWidth) ? ' style="width:'.$blockWidth.'%"':'';
								$blockClass = ($blockWidth) ? ' has-custom-width block'.$blockWidth:'';
								?>
								<div class="postbox animated fadeIn <?php echo ($thumbImage) ? 'has-image':'no-image' ?><?php echo $blockClass ?>"<?php echo $display_option ?>>
									<div class="inside">
										
										<div class="photo">
											<?php if ($thumbImage) { ?>
												<span class="imagediv" style="background-image:url('<?php echo $thumbImage['sizes']['medium_large'] ?>')"></span>
												<img src="<?php echo $rectangle ?>" alt="" class="feat-img placeholder">
											<?php } else { ?>
												<span class="imagediv"></span>
												<img src="<?php echo $rectangle ?>" alt="" class="feat-img placeholder">
											<?php } ?>
										</div>

										<div class="details">
											<div class="info">
												<h3 class="event-name"><?php echo $title ?></h3>
												<?php if ($description) { ?>
												<div class="short-description">
													<?php echo $description ?>
												</div>
												<?php } ?>

												<?php if($grades2 || $hours) { ?>
												<div class="options">
													<?php if($grades2) { ?>
													<span>Grades <?php echo $grades2 ?></span>
													<?php } ?>

													<?php if($hours) { ?>
													<span><?php echo $hours ?></span>
													<?php } ?>
												</div>
												<?php } ?>

											</div>
										</div>

									</div>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>

			<?php if ($pass_notes) { ?>
			<div class="important-notes-red">
				<div class="wrapper text-center"><?php echo $pass_notes ?></div>
			</div>	
			<?php } ?>
		</section>
		<?php } ?>

		<?php
		/* FAQs */
		$customFAQTitle = 'FAQ';
		$customFAQClass = 'custom-class-faq graybg';
		include( locate_template('parts/content-faqs.php') );
		include( locate_template('inc/faqs.php') );
		?>


		<?php
		/* Form */
		$form_section_title = get_field("form_section_title");
		$form_content = get_field("content");
		$pass_notes = get_field("pass_notes");
		if($form_content) { ?>
		<section id="form-section" data-section="<?php echo $form_section_title ?>" class="section-content group-form-section full">
			<?php if ($form_section_title) { ?>
			<div class="shead-icon text-center">
				<h2 class="stitle"><?php echo $form_section_title ?></h2>
			</div>
			<?php } ?>

			<div class="form-content">
				<div class="wrapper narrow"><?php echo $form_content ?></div>
			</div>
		</section>
		<?php } ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php get_template_part("parts/bottom-content-fieldtrips"); ?>



<?php
include( locate_template('inc/pagetabs-script.php') );
get_footer();
