<?php
$blank_image = THEMEURI . "images/square.png";
$square = THEMEURI . "images/square.png";
$rectangle = THEMEURI . "images/rectangle-lg.png";
$canceledImage = THEMEURI . "images/canceled.svg";

$postype = 'wildwoods_activities';
$perpage = 16;
$has_filter = ( isset($_GET['_festival_status']) && $_GET['_festival_status'] ) ? true : false;
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

$finalList = array();
$groupItems = array();
$entries = new WP_Query($args); ?>
<?php if ( $entries->have_posts() ) {  ?>

	<div class="filter-wrapper">
			<div class="wrapper">
				
				<div class="filter-inner">
					<div class="flexwrap">

						<?php if ( do_shortcode('[facetwp facet="festival_status"]') ) { ?>
						<div class="select-wrap align-middle event-status">
							<label>Filter By</label>
							<?php echo do_shortcode('[facetwp facet="festival_status"]'); ?>
							<button onclick="FWP.reset()" class="resetBtn festival"><span>Reset</span></button>
						</div>
						<?php } ?>



						<!-- <div id="resetBtn" class="select-reset-wrap <?php //echo ($has_filter) ? '':'hide'; ?>">
							<a href="<?php //echo get_permalink(); ?>" class="resetpage">Reset</a>
						</div> -->
					</div>
				</div>

			</div>
	</div>

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
						$eventStatus = ( get_field("eventstatus") ) ? get_field("eventstatus"):'upcoming';
						$thumbImage = get_field("thumbnail_image");
						$groupItems[$eventStatus][] = $pid;
						?>
					<?php  $i++; endwhile; wp_reset_postdata(); ?>

					<?php 
						krsort($groupItems);
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
							$eventStatus = (isset($p->eventstatus) && $p->eventstatus) ? $p->eventstatus:'upcoming';
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
										
										<?php get_template_part('parts/wave-SVG'); ?>

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
	$total = $entries->found_posts;
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
		    echo paginate_links($pagination); ?>
		</div>
	<?php } ?>

<?php } ?>




