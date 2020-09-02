<?php /* EXPLORE OTHER ACTIVITIES */ ?>
<?php
$args = array(
	'posts_per_page'=> 15,
	'post_type'		=> array('music','festival','camp'),
	'post_status'	=> 'publish',
);
$posts = new WP_Query($args);
$bottom_title = get_field("race_bottom_section_title","option");
if($posts) { ?>
<section class="explore-other-stuff">
	<div class="wrapper">
		<?php if ($bottom_title) { ?>
			<h3 class="sectionTitle"><?php echo $bottom_title ?></h3>
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