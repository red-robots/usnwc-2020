<?php
	$title4 = get_field("title4");
	$canceledImage = THEMEURI . "images/canceled.svg";
	$filter_message = get_field("filter_message");
	$postype = 'job';
	$job_location = ( isset($_GET['_job_locations']) && $_GET['_job_locations'] ) ? explode(",",$_GET['_job_locations']):'';
	$job_type = ( isset($_GET['_job_types']) && $_GET['_job_types'] ) ? explode(",",$_GET['_job_types']):'';
	$job_department = ( isset($_GET['_job_department']) && $_GET['_job_department'] ) ? explode(",",$_GET['_job_department']):'';
	$tax_query = array();
	$postsByDepartment = array();

	if($job_location) {
		$tax_query[] = array(
			'taxonomy' => 'joblocation',
			'field' => 'slug',
			'terms' => $job_location,
			'operator' => 'IN'
    );
	}
	if($job_type) {
		$tax_query[] = array(
			'taxonomy' => 'jobtype',
			'field' => 'slug',
			'terms' => $job_type,
			'operator' => 'IN'
    );
	}
	if($job_department) {
		$tax_query[] = array(
			'taxonomy' => 'department',
			'field' => 'slug',
			'terms' => $job_department,
			'operator' => 'IN'
    );
	}

	$count_query = ($tax_query) ? count($tax_query):0;
	if($count_query>1) {
		$tax_query['relation'] = 'OR';
	}

	$per_page = ($tax_query) ? -1 : 1;
	$args = array(
		'posts_per_page'	=> $per_page,
		'post_type'				=> $postype,
		'post_status'			=> 'publish',
		'facetwp'					=> true
	);

	if($tax_query) {
		$args['tax_query'] = $tax_query;
		$entries = get_posts($args);
		
		if($entries) {
			foreach($entries as $e) {
				$id = $e->ID;
				$terms = get_the_terms($e,'department');
				if($terms) {
					foreach($terms as $term) {
						$term_id = $term->term_id;
						$term_name = $term->name;
						$postsByDepartment[$term_id]['department'] = $term_name;
						$postsByDepartment[$term_id]['entries'][] = $e;
					}
				}
			}
		}
	}


$posts = new WP_Query($args);
if( $posts->have_posts() ) { ?>
	<section id="section4" data-section="<?php echo $title4 ?>" class="section-content entries-with-filter">
		<div class="entries-inner wrapper text-center">

			<?php if ($title4) { ?>
			<div class="shead-icon text-center">
				<div class="icon"><span class="ci-menu"></span></div>
				<h2 class="stitle"><?php echo $title4 ?></h2>
			</div>
			<?php } ?>

			<div class="filter-message">
			<?php if ($filter_message) { ?>
				<div id="fm"><?php echo $filter_message ?></div>
			<?php } ?>
			</div>

			<?php /* Filter Options */ ?>
			<div class="filter-wrapper filterstyle optionsnum3">
				<div class="wrapper">
					
					<div class="filter-inner">
						<div class="flexwrap">

							<div class="filter-label">
								<div class="inside"><span>Filter By</span></div>
							</div>

							<?php if ( facetwp_display( 'facet', 'job_locations' ) ) { ?>
							<div class="select-wrap">
								<?php echo facetwp_display( 'facet', 'job_locations' ) ?>
							</div>
							<?php } ?>

							<?php if ( do_shortcode('[facetwp facet="job_types"]') ) { ?>
							<div class="select-wrap">
								<?php echo do_shortcode('[facetwp facet="job_types"]'); ?>
							</div>
							<?php } ?>

							<?php if ( do_shortcode('[facetwp facet="job_department"]') ) { ?>
							<div class="select-wrap">
								<?php echo do_shortcode('[facetwp facet="job_department"]'); ?>
							</div>
							<?php } ?>

						</div>
					</div>

				</div>
			</div>

			<?php /* Entries */ ?>
			<div class="post-type-entries columns3 <?php echo $postype ?>">
				<div class="wrapper">
					<div id="data-container">
						<div class="posts-inner">
							
							<div class="flex-inner">
								<?php if ($postsByDepartment) { ?>
									
									<?php foreach ($postsByDepartment as $p) {
										$department = $p['department'];
										$entries = $p['entries'];
										if($entries) { ?>
										<div class="job-group">
											<div class="job-department"><span><?php echo $department ?></span></div>
											<?php foreach($entries as $e) { 
											$pid = $e->ID; 
											$title = $e->post_title;
											$link = get_permalink($pid); ?>
											<div class="joblist show"><a href="<?php echo $link ?>"><?php echo $title; ?></a></div>	
											<?php } ?>
										</div>
										<?php } ?>
									<?php } ?>

									<?php $i=1; while ( $posts->have_posts()) : $posts->the_post(); ?>
										<div class="hide" style="display:none;"><?php echo get_the_title(); ?></div>
									<?php $i++; endwhile; wp_reset_postdata(); ?>

								<?php } ?>

								<?php $i=1; while ( $posts->have_posts()) : $posts->the_post(); ?>
									<div class="hide" style="display:none;"><?php echo get_the_title(); ?></div>
								<?php $i++; endwhile; wp_reset_postdata(); ?>
							</div>
						</div>
					</div>
				</div>
			</div> 
		</div>
	</section>
<?php } ?>