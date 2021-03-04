<?php
$blank_image = THEMEURI . "images/square.png";
$square = THEMEURI . "images/square.png";
$rectangle = THEMEURI . "images/rectangle-lg.png";
$canceledImage = THEMEURI . "images/canceled.svg";

$postype = 'race';
$perpage = 16;
$paged = ( get_query_var( 'pg' ) ) ? absint( get_query_var( 'pg' ) ) : 1;
$metaQueries = array(); 
$args = array(
	'posts_per_page'   	=> -1,
	'post_type'        	=> $postype,
	'post_status'      	=> 'publish',
	'facetwp' 				 	=> true,
	'meta_key' 					=> 'start_date',
	'orderby'  					=> array(
		'meta_value_num' 	=> 'ASC',
		'post_date'      	=> 'ASC',
	),
);

if( isset($_GET['_event_status']) && $_GET['_event_status'] ) {
	$status = $_GET['_event_status'];
	$args['meta_query'] = array(
			array(
				'key'	 	=> 'eventstatus',
				'value'	  	=> $status,
				'compare' 	=> '='
			)
		);
}
if( isset($_GET['_race_series_discipline']) && $_GET['_race_series_discipline'] ) {
	$discipline = $_GET['_race_series_discipline'];
	$disciplineArrs = explode(",",$discipline);
	$args['tax_query'] = array(
		array (
			'taxonomy' => 'activity_type',
			'field' => 'slug',
			'terms' => $disciplineArrs,
		)
	);

	// $metaQueries[] = array(
	// 	'key'	 	=> 'discipline_options',
	// 	'value'	  	=> array(78),
	// 	'compare' 	=> 'IN'
	// );
}

// if($metaQueries) {
// 	if( count($metaQueries) > 1 ) {
// 		$metaQueries['relation'] = 'OR';
// 	}
// }
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
// $raw_entries = get_posts($args);
// $otherItems = array();
// if($raw_entries) {
// 	foreach($raw_entries as $row) {
// 		$id = $row->ID;
// 		$estatus = ( get_field("eventstatus",$id) ) ? get_field("eventstatus",$id):'active';
// 		if($estatus!='active') {
// 			$otherItems[$estatus][] = $row;
// 		}
// 	}
// }
$finalList = array();
$groupItems = array();
$entries = new WP_Query($args);
if ( $entries->have_posts() ) {  ?>
<div class="post-type-entries <?php echo $postype ?>">
	<div id="data-container">
		<div class="posts-inner animate__animated animate__fadeIn">
			<div class="flex-inner result">
				<?php $i=1;  while ( $entries->have_posts() ) : $entries->the_post();
					$pid = get_the_ID(); 
					$title = get_the_title();
					$pagelink = get_permalink();
					$start = get_field("start_date");
					$end = get_field("end_date");
					$event_date = get_event_date_range($start,$end);
					$short_description = get_field("short_description");
					$eventStatus = ( get_field("eventstatus") ) ? get_field("eventstatus"):'active';
					$thumbImage = get_field("thumbnail_image");
					$groupItems[$eventStatus][] = $pid;
					?>
				<?php  $i++; endwhile; wp_reset_postdata(); ?>

				<?php 
					ksort($groupItems);
					foreach($groupItems as $k=>$items) {
						foreach($items as $item) {
							$finalList[] = $item;
						}
					}

					$start = 0;
		      $stop = $perpage-1;
		      if($paged>1) {
		        $stop = (($paged+1) * $perpage) - $perpage;
		        $start = $stop - $perpage;
		        $stop = $stop - 1;
		      }
		    ?>

	      <?php for($i=$start; $i<=$stop; $i++) {
	      	if( isset($finalList[$i]) && $finalList[$i] ) {
	      		$id = $finalList[$i];
	      		$p = get_post($id);
						$title = $p->post_title;
						$pagelink = get_permalink($id);
						$start = get_field("start_date",$id);
						$end = get_field("end_date",$id);
						$event_date = get_event_date_range($start,$end);
						$short_description = get_field("short_description",$id);
						$eventStatus = (isset($p->eventstatus) && $p->eventstatus) ? $p->eventstatus:'active';
						$thumbImage = get_field("thumbnail_image",$id);
						?>
						<div class="postbox <?php echo ($thumbImage) ? 'has-image':'no-image' ?> <?php echo $eventStatus ?>">
							<div class="inside">
								<?php if ($eventStatus=='completed') { ?>
									<div class="event-completed"><span>Event Complete</span></div>
								<?php } ?>
								<a href="<?php echo $pagelink ?>" class="photo wave-effect js-blocks">
									<?php if ($thumbImage) { ?>
										<div class="imagediv" style="background-image:url('<?php echo $thumbImage['sizes']['medium_large'] ?>')"></div>
										<img src="<?php echo $thumbImage['url']; ?>" alt="<?php echo $thumbImage['title'] ?>" class="feat-img">
									<?php } else { ?>
										<div class="imagediv"></div>
										<img src="<?php echo $blank_image ?>" alt="" class="feat-img placeholder">
									<?php } ?>
									<span class="boxTitle">
										<span class="twrap">
											<span class="t1"><?php echo $title ?></span>
											<?php if ($event_date) { ?>
											<span class="t2"><?php echo $event_date ?></span>
											<?php } ?>
										</span>
									</span>
									<span class="wave">
											<svg class="waveSvg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
												<defs>
												<path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z"></path>
												</defs>
												<g class="waveAnimation">
												<use xlink:href="#gentle-wave" x="48" y="7" fill="#000"></use>
												</g>
											</svg>
									</span>
									<?php if ($eventStatus=='canceled') { ?>
									<span class="canceledStat">
										<img src="<?php echo $canceledImage ?>" alt="" aria-hidden="true">
									</span>	
									<?php } ?>
								</a>
								<div class="details">
									<div class="info">
										<h3 class="event-name"><?php echo $title ?></h3>
										<?php if ($event_date) { ?>
										<div class="event-date"><?php echo $event_date ?></div>
										<?php } ?>
										<?php if ($short_description) { ?>
										<div class="short-description"><?php echo $short_description; ?></div>	
										<?php } ?>
										<div class="button">
											<a href="<?php echo $pagelink ?>" class="btn-sm"><span>See Details</span></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
	      <?php } ?>

			</div>
		</div>
	</div>
</div>

	<div class="next-posts" style="display:none;"></div>

	<?php 
	$args['paged'] = $paged;
	$entries2 = get_posts($args);
	if ( $entries2 ) {
		$total = count($entries2);
		$total_pages = ceil($total / $perpage);
		if ($total > $perpage) { ?> 
		<div class="loadmorediv text-center">
			<div class="wrapper"><a href="#" id="loadMoreEntries" data-current="1" data-count="<?php echo $total?>" data-total-pages="<?php echo $total_pages?>" class="btn-sm wide"><span>Load More</span></a></div>
		</div>

		<div id="pagination" class="pagination-wrapper" style="display:none;">
		    <?php
		    $pagination = array(
					'base' => @add_query_arg('pg','%#%'),
					'format' => '?pg=%#%',
					'mid-size' => 1,
					'current' => $paged,
					'total' => ceil($total / $perpage),
					'prev_next' => True,
					'prev_text' => __( '<span class="fa fa-arrow-left"></span>' ),
					'next_text' => __( '<span class="fa fa-arrow-right"></span>' )
		    );
		    echo paginate_links($pagination);
		?>
		</div>

		<?php } ?>

	<?php } ?>

<?php } ?>




