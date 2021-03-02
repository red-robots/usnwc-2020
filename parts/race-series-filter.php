<?php
$metaQueries = array(); 
if( isset($_GET['_event_status']) ) {
	$status = $_GET['_event_status'];
	$metaQueries[] = array(
		'key'	 	=> 'eventstatus',
		'value'	  	=> $status,
		'compare' 	=> '='
	);
}
if( isset($_GET['_race_series_discipline']) ) {
	$discipline = $_GET['_race_series_discipline'];
	$disciplineArrs = explode(",",$discipline);
	$metaQueries[] = array(
		'key'	 	=> 'discipline_options',
		'value'	  	=> $disciplineArrs,
		'compare' 	=> 'IN'
	);
}

if($metaQueries) {
	if( count($metaQueries) > 1 ) {
		$metaQueries['relation'] = 'OR';
	}
}
?>
<div class="filter-wrapper">
	<div class="wrapper">
		
		<div class="filter-inner">
			<div class="flexwrap">

				<?php if ( do_shortcode('[facetwp facet="event_status"]') ) { ?>
				<!-- <div class="select-wrap align-middle"> -->
				<div class="select-wrap">
					<label>Status</label>
					<?php echo do_shortcode('[facetwp facet="event_status" pager="true"]'); ?>
				</div>
				<?php } ?>

				<?php if ( do_shortcode('[facetwp facet="race_series_discipline"]') ) { ?>
				<div class="select-wrap">
					<label>Discipline</label>
					<?php echo do_shortcode('[facetwp facet="race_series_discipline" pager="true"]'); ?>
				</div>
				<?php } ?>

			</div>
		</div>

	</div>
</div>


<?php  
$args = array(
	'posts_per_page'   =>-1,
	'post_type'        => 'race',
	'post_status'      => 'publish',
	'facetwp' 				 => true
);
if($metaQueries) {
	$args['meta_query'] = $metaQueries;
}
$entries = new WP_Query($args);
if ( $entries->have_posts() ) {  ?>
	<?php while ( $entries->have_posts() ) : $entries->the_post(); ?>
	<div class="init-entry" style="display:none;"><?php the_title(); ?></div>
	<?php  endwhile; wp_reset_postdata(); ?>
<?php } ?>