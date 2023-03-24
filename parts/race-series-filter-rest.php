<?php
$blank_image = THEMEURI . "images/square.png";
$square = THEMEURI . "images/square.png";
$rectangle = THEMEURI . "images/rectangle-lg.png";
$canceledImage = THEMEURI . "images/canceled.svg";
$portrait_spacer = THEMEURI . "images/portrait.png";

// $postype = 'race';
// $perpage = 40;
// $has_filter = array();
// $paged = ( get_query_var( 'pg' ) ) ? absint( get_query_var( 'pg' ) ) : 1;
// $metaQueries = array(); 
// $args = array(
// 	'posts_per_page'   	=> -1,
// 	'post_type'        	=> $postype,
// 	'post_status'      	=> 'publish',
// 	'facetwp' 				 	=> true,
// 	'meta_key' 					=> 'start_date',
// 	'orderby'  					=> array(
// 		'meta_value_num' 	=> 'ASC',
// 		'post_date'      	=> 'ASC',
// 	),
// 	// 'meta_key'			=> 'start_date',
// 	// 'orderby'			=> 'meta_value',
// 	// 'order'				=> 'ASC'
// );

// if( isset($_GET['_race_event_status']) && $_GET['_race_event_status'] ) {
// 	$status = $_GET['_race_event_status'];
// 	$has_filter['_race_event_status'] = $status;
// 	$statusArrs = explode(",",$status);
// 	// $args['meta_query'] = array(
// 	// 		array(
// 	// 			'key'	 	=> 'eventstatus',
// 	// 			'value'	  	=> $statusArrs,
// 	// 			'compare' 	=> 'IN'
// 	// 		)
// 	// 	);
// }

// if( isset($_GET['_race_series_discipline']) && $_GET['_race_series_discipline'] ) {
// 	$discipline = $_GET['_race_series_discipline'];
// 	$has_filter['_race_series_discipline'] = $discipline;
// 	$disciplineArrs = explode(",",$discipline);
// 	// foreach($disciplineArrs as $slug) {
// 	// 	$term = get_term_by($slug,'activity_type');
// 	// 	print_r($term);
// 	// }
// 	// $args['tax_query'] = array(
// 	// 	array (
// 	// 		'taxonomy' => 'activity_type',
// 	// 		'field' => 'slug',
// 	// 		'terms' => $disciplineArrs,
// 	// 		'operator' => 'IN'
// 	// 	)
// 	// );

// 	// print_r($args);
// }
// $finalList = array();
// $groupItems = array();
function get_wordpress_races() {
  $url = 'https://center.whitewater.org/wp-json/wp/v2/race?per_page=10'; // Replace "example.com" with your own website URL
  $args = array(
    'headers' => array(
      'Accept' => 'application/json'
    )
  );
  
  $response = wp_remote_get( $url, $args ); // Make the API request using the WP HTTP API
  
  if ( is_wp_error( $response ) ) { // Check for errors
    return false;
  } else {
    $races = json_decode( wp_remote_retrieve_body( $response ), true ); // Decode the JSON response into an array
    
    // Loop through the races and get the terms for each one
    foreach ( $races as &$race ) {
      $terms_url = 'https://center.whitewater.org/wp-json/wp/v2/race/' . $race['id'] . '/activity_type'; // Replace "example.com" with your own website URL
      
      $terms_response = wp_remote_get( $terms_url, $args ); // Make the API request for the terms
      
      if ( ! is_wp_error( $terms_response ) ) { // Check for errors
        $terms = json_decode( wp_remote_retrieve_body( $terms_response ), true ); // Decode the JSON response into an array
        $race['activity_type_terms'] = $terms; // Add the terms to the race array
      }
    }
    
    return $races;
  }
}


$races = get_wordpress_races();

if ( $races ) {
  foreach ( $races as $race ) {
    echo '<h2>' . $race['title']['rendered'] . '</h2>'; // Display the race title
    echo '<p>' . $race['excerpt']['rendered'] . '</p>'; // Display the race excerpt
    
    if ( isset( $race['activity_type_terms'] ) ) { // Check if terms are available
      echo '<ul>';
      foreach ( $race['activity_type_terms'] as $term ) {
        echo '<li>' . $term['name'] . '</li>'; // Display the term name
      }
      echo '</ul>';
    }
  }
} else {
  echo 'Error retrieving races.';
}





$restArray = array();
//$response = wp_remote_get( 'https://center.whitewater.org/wp-json/wp/v2/race?per_page=99' );
if( is_array($response) ) :
    $code = wp_remote_retrieve_response_code( $response );
    if(!empty($code) && intval(substr($code,0,1))===2) {
        $body = json_decode(wp_remote_retrieve_body( $response),true);
    
//$entries = new WP_Query($args); ?>
<?php 
//if ( $entries->have_posts() ) {  $totalFound = $entries->found_posts; 

?>

	<div class="filter-wrapper">
			<div class="wrapper">
				
				<div class="filter-inner">
					<div class="flexwrap">

						<?php if ( do_shortcode('[facetwp facet="race_event_status"]') ) { ?>
						<!-- <div class="select-wrap align-middle"> -->
						<div class="select-wrap">
							<label>Status</label>
							<?php echo do_shortcode('[facetwp facet="race_event_status"]'); ?>
						</div>
						<?php } ?>

						<?php if ( do_shortcode('[facetwp facet="race_series_discipline"]') ) { ?>
						<div class="select-wrap">
							<label>Discipline</label>
							<?php echo do_shortcode('[facetwp facet="race_series_discipline"]'); ?>
						</div>
						<?php } ?>

						<!-- <div id="resetBtn" class="select-reset-wrap <?php //echo ($has_filter) ? '':'hide'; ?>">
							<a href="<?php //echo get_permalink(); ?>" class="resetpage">Reset</a>
						</div> -->
						<button onclick="FWP.reset()" class="resetBtn jobs"><span>Reset</span></button>
					</div>
				</div>

			</div>
		</div>

	<div class="post-type-entries <?php echo $postype ?>">
		<div id="data-container">
			<div class="posts-inner animate__animated animate__fadeIn">
				<div class="flex-inner result countItems<?php echo $totalFound?>">
					<?php $i=1; 
					//while ( $entries->have_posts() ) : $entries->the_post();
					foreach ($body as $post) {
						// echo '<pre>';
						// print_r($post);
						// echo '</pre>';
						$pid = $post['id']; //echo $pid;
						$title = $post['title']['rendered'];
						$pagelink = $post['link'];
						$start = $post['acf']['start_date'];
						$end = $post['acf']['end_date'];
						$activity_type = $post['activity_type'];
						$aT = get_activity_type($activity_type);
						$event_date = get_event_date_range($start,$end);
						$short_description = $post['acf']['short_description'];
						$eventStatus = ( $post['acf']['eventstatus'] ) ? $post['acf']['eventstatus']:'upcoming';
						$thumbImage = $post['acf']['thumbnail_image'];
						$hideOnPage = get_field("hidePostfromMainPage",$pid);
						$date_range = get_event_date_range($start,$end);
						if(!$hideOnPage) {
							$groupItems[$eventStatus][] = $pid;

							// create an array for rest
							$restArray[] = array(
								'pID' => $pid,
								'title' => $title,
								'pagelink' => $pagelink,
								'start' => $start,
								'end' => $end,
								'activity_type' => $activity_type,
								'date_range' => $date_range,
								'event_date' => $event_date,
								'short_description' => $short_description,
								'eventStatus' => $eventStatus,
								'thumbImage' => $thumbImage,
							);
						}

						// echo '<pre>';
						// print_r($restArray);
						// echo '</pre>';
						?>
					<?php  
						$i++; 
						//endwhile; 
						}
						//wp_reset_postdata(); ?>

					<?php 
					function sort_events($restArray) {
					    usort($restArray, function($a, $b) {
					        if ($a['eventStatus'] === $b['eventStatus']) {
					            if ($a['eventStatus'] === 'upcoming') {
					                return strtotime($a['start']) - strtotime($b['start']);
					            } elseif ($a['eventStatus'] === 'completed') {
					                return strtotime($b['start']) - strtotime($a['start']);
					            }
					        } else {
					            if ($a['eventStatus'] === 'upcoming') {
					                return -1;
					            } elseif ($b['eventStatus'] === 'upcoming') {
					                return 1;
					            }
					        }
					    });
					    return $restArray;
					}




					$sorted_events = sort_events($restArray);
					// krsort($sorted_events['completed']);

					// foreach ($sorted_events as $event) {
					// 	echo $event['title'];
					// 	echo '<br>';
					// 	echo $event['date_range'];
					// 	echo '<div style="width: 100%;"></div>';
					// }


						// echo '<pre>';
						// print_r($sorted_events);
						// echo '</pre>';
						// krsort($groupItems);
						// krsort($groupItems['completed']);
						// krsort($restArray);
						// krsort($restArray['completed']);
						// echo '<pre>';
						// print_r($restArray);
						// echo '</pre>';
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

		      <?php 
		      foreach ($sorted_events as $event) {
		      // for($i=$start; $i<=$stop; $i++) {
		      // 	if( isset($finalList[$i]) && $finalList[$i] ) {
		      // 		$id = $finalList[$i];
	    //   		echo '<pre>';
					// print_r($groupItems);
					// echo '</pre>';
		      				$p = $event['pID'];
							$title = $event['title'];
							$pagelink = $event['pagelink'];
							$start = $event['start'];
							$end = $event['end'];
							$event_date = $event['event_date'];
							$short_description = get_field("short_description",$id);
							$eventStatus = (isset($event['eventStatus']) && $event['eventStatus']) ? $event['eventStatus']:'upcoming';
							$thumbImage = $event['thumbImage'];
							$main_event_date = get_field("main_event_date",$id);
							// if($main_event_date) {
							// 	$event_date = date('M j, Y',strtotime($main_event_date));
							// }
							
							?>
							<div id="post-<?php echo $id?>" class="postbox <?php echo ($thumbImage) ? 'has-image':'no-image' ?> <?php echo $eventStatus ?>">
								<div class="inside">
									<?php if ($eventStatus=='completed') { ?>
										<div class="event-completed"><span>Event Complete</span></div>
									<?php } ?>
									<div class="linkwrap js-blocks">
										<a href="<?php echo $pagelink ?>" class="photo wave-effect js-blocks">
											<?php if ($thumbImage) { ?>
												<!-- <div class="imagediv" style="background-image:url('<?php //echo $thumbImage['sizes']['medium_large'] ?>')"></div> -->
												<img src="<?php echo $thumbImage['url']; ?>" alt="<?php echo $thumbImage['title'] ?>" class="feat-img" style="visibility:visible;">
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
										<img src="<?php echo $portrait_spacer; ?>" alt="" aria-hidden="true" class="rectangle-spacer">
									</div>
									<div class="details">
										<div class="info">
											<h3 class="event-name js-title"><?php echo $title ?></h3>
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

									<?php if( is_user_logged_in() && current_user_can('administrator') ) {
												$editLink = get_edit_post_link($id); ?>
									<div class="editpostlink"><a href="<?php echo $editLink ?>">Edit</a></div>
									<?php } ?>
								</div>
							</div>
						<?php } ?>
		      <?php //} ?>

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

<?php 
} 
// endif;
endif;
?>




