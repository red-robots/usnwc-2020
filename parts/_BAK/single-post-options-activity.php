<?php
$placeholder = THEMEURI . 'images/rectangle-lg.png';
$articles = get_field("global_single_post_featured_articles","option");
if($articles) { 
$count = count($articles); 
$colClass = ($count>1) ? 'half':'full';
?>
<section id="section-featured-posts" class="section-content <?php echo $colClass ?>">
	<div class="flexwrap">
		<?php foreach ($articles as $a) { 
			$icon = $a['icon'];
			$title = $a['title'];
			$description = $a['text'];
			$button = $a['button_link'];
			$image = $a['image'];
			?>

			<?php if ($title || $description || $image) { ?>
				<div class="block">
					<div class="inside">

						<div class="textwrap js-blocks">
							<div class="inner-wrap">
								<?php if ($icon) { ?>
									<div class="icon"><span style="background-image:url('<?php echo $icon['url'] ?>')"></span></div>
								<?php } ?>

								<?php if ($title) { ?>
									<h3 class="sectionTitle"><span><?php echo $title ?></span></h3>
								<?php } ?>

								<?php if ($description) { ?>
									<div class="text"><?php echo $description ?></div>
								<?php } ?>

								<?php if ($button) { 
									$target = ($button['target']) ? ' target="'.$button['target'].'"':'';?>
									<div class="button">
										<a href="<?php echo $button['url'] ?>" class="btn-sm"<?php echo $target ?>><span><?php echo $button['title'] ?></span></a>
									</div>
								<?php } ?>
							</div>
						</div>

						<?php if ($image) { ?>
							<div class="feat-image">
								<div class="bg" style="background-image:url('<?php echo $image['url'] ?>')">
									<img src="<?php echo $placeholder ?>" alt="">
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			<?php } ?>

		<?php } ?>

	</div>
</section>
<?php } ?>


<?php /* EXPLORE OTHER ACTIVITIES */ ?>
<?php
$args = array(
	'posts_per_page'=> -1,
	'post_type'		=> 'activity',
	'post_status'	=> 'publish',
);
$posts = new WP_Query($args);
$explore_title = get_field("explore_section_title","option");
if($posts) { ?>
<section class="explore-other-stuff">
	<div class="wrapper">
		<?php if ($explore_title) { ?>
			<h3 class="sectionTitle"><?php echo $explore_title ?></h3>
		<?php } ?>
		
		<div class="post-type-entries">
			<div class="columns">
				<?php $i=1; while ( $posts->have_posts() ) : $posts->the_post(); ?>
					<div class="entry">
						<a href="<?php echo get_permalink() ?>"><?php echo get_the_title(); ?></a>
					</div>
				<?php $i++; endwhile; wp_reset_postdata(); ?>
			</div>
		</div>
	</div>
</section>
<?php } ?>

