<div class="filter-wrapper river-jam">
	<div class="wrapper">
		<div class="filter-inner">
			<div class="flexwrap">
				<?php if ( do_shortcode('[facetwp facet="river_jam_date_range"]') ) { ?>
				<div class="select-wrap align-middle">
					<label>View Upcoming Bands By Date</label>
					<?php echo do_shortcode('[facetwp facet="river_jam_date_range"]'); ?>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>

<?php 
$args = array(
	'posts_per_page'   	=> 1,
	'post_type'        	=> 'music',
	'post_status'      	=> 'publish',
	'facetwp' 				 	=> true,
	'meta_key' 					=> 'start_date',
	'orderby'  					=> array(
		'meta_value_num' 	=> 'ASC',
		'post_date'      	=> 'ASC',
	),
);
$entries = new WP_Query($args);
?>
<?php $i=1;  while ( $entries->have_posts() ) : $entries->the_post();?>
<div class="hidden-post" style="display:none"><?php the_title(); ?></div>
<?php  $i++; endwhile; wp_reset_postdata(); ?>