<?php
$placeholder = THEMEURI . 'images/rectangle.png';
$imageHelper = THEMEURI . 'images/rectangle-narrow.png';
$pageLink = get_permalink();
$baseURL = $pageLink;
$post_type = 'post';
$taxonomy = 'category'; 
$perPage = 6;
$paged = ( get_query_var( 'pg' ) ) ? absint( get_query_var( 'pg' ) ) : 1;
$args = array(
	'posts_per_page'   => $perPage,
	'orderby'          => 'date',
	'order'            => 'DESC',
	'post_type'        => 'post',
	'post_status'      => 'publish',
	'facetwp' 				 => true,
	'paged'			   		 => $paged
);

$get_is_all = array();
$count_get = 0;
if( isset($_GET) ) {
	$n=1; foreach($_GET as $k=>$v) {
		$delimited = ($n==1) ? '?':'&';
		$baseURL .= $delimited . $k."=".$v;

		if($v=='all') {
			$get_is_all[$k] = $v;
		}
		$n++;
	}
	$count_get = count($_GET);
}

if($get_is_all && ($count_get!=count($get_is_all)) ) {

	// if( isset($_GET['category']) || $_GET['activity_types'] ) {
	// 	$cat_id = ($_GET['category'] && $_GET['category']!='all') ? $_GET['category'] : 0;
	// 	$activity_type_id = ($_GET['activity_type'] && $_GET['activity_type']!='all') ? $_GET['activity_type'] : 0;

	// 	$args['tax_query'] = array(
	// 	 'relation' => 'OR',
	// 	  array(
	// 	      'taxonomy' => 'category',
	// 	      'field'    => 'term_id',
	// 	      'terms'    => $cat_id,
	// 	  ),
	// 	  array(
	// 	      'taxonomy' => 'activity_type',
	// 	      'field'    => 'term_id',
	// 	      'terms'    => $activity_type_id,
	// 	  )
	// 	);
	// }

	if( isset($_GET['_categories']) || $_GET['_activity_types'] ) {
		$cat_id = ($_GET['_categories'] && $_GET['_categories']!='all') ? $_GET['_categories'] : 0;
		$activity_type_id = ($_GET['_activity_types'] && $_GET['_activity_types']!='all') ? $_GET['_activity_types'] : 0;

		$args['tax_query'] = array(
		 'relation' => 'OR',
		  array(
		      'taxonomy' => 'category',
		      'field'    => 'term_id',
		      'terms'    => $cat_id,
		  ),
		  array(
		      'taxonomy' => 'activity_type',
		      'field'    => 'term_id',
		      'terms'    => $activity_type_id,
		  )
		);
	}

}


$blogs = new WP_Query($args);
$terms = get_terms( array(
	    'taxonomy' => $taxonomy,
	    'post_types'=> array($post_type),
	    'hide_empty' => true,
	) );

$types = get_terms( array(
	    'taxonomy' => 'activity_type',
	    'post_types'=> array($post_type),
	    'hide_empty' => true,
	) );

if ( $blogs->have_posts() ) {  ?>

<div id="load-post-div">
	<div id="load-data-div">
		<div class="filter-wrapper">
			<div class="wrapper">
				
				<div class="filter-inner">
					<div class="filterbytxt">Filter By:</div>
					<div class="flexwrap">

						<?php if ( do_shortcode('[facetwp facet="categories"]') ) { ?>
						<div class="select-wrap">
							<label for="category">Category</label>
								<?php echo do_shortcode('[facetwp facet="categories"]'); ?>
						</div>
						<?php } ?>

						<?php if ( do_shortcode('[facetwp facet="activity_types"]') ) { ?>
						<div class="select-wrap">
							<label for="activity_type">Type</label>
							<?php echo do_shortcode('[facetwp facet="activity_types"]'); ?>
						</div>
						<?php } ?>
					</div>
				</div>
				

				<?php
					/* Custom Filtering by Lisa */ 
					//include( get_stylesheet_directory() . '/parts/filter-stories.php' ); ?>
			</div>
		</div>

		<div class="archive-posts-wrap">
			<div id="postLists" class="posts-inner">

				<?php $sec=.1; $i=1; while ( $blogs->have_posts() ) : $blogs->the_post();
					$thumbId = get_post_thumbnail_id(); 
					$featImg = wp_get_attachment_image_src($thumbId,'large');
					$featThumb = wp_get_attachment_image_src($thumbId,'thumbnail');
					$content = get_the_content();
					$title = get_the_title();
					$divclass = (($content || $title) && $featImg) ? 'half':'full';
					$pagelink = get_permalink();
					$divclass .= ($i % 2) ? ' odd':' even';
					$divclass .= ($i==1) ? ' first':'';
					include( get_stylesheet_directory() . '/parts/content-post.php' );
					?>
				<?php
				$sec =  $sec + .1;
				$i++; endwhile; wp_reset_postdata(); ?>

			</div>
		</div>


		<?php
		$total_pages = $blogs->max_num_pages;
		if ($total_pages > 1){ ?>
			<div class="morebuttondiv">
				<span class="moreBtnSpan">
					<a class="moreBtn" id="loadMoreBtn" data-totalpages="<?php echo $total_pages?>" data-perpage="<?php echo $perPage?>" data-posttype="<?php echo $post_type?>" data-page="2" data-baseurl="<?php echo $pageLink?>"><span class="loadtxt">Load More</span></a>
					<div class="wait"><span class="fas fa-sync-alt rotate"></span></div>
				</span>
			</div>
		<?php } ?>
		<?php } ?>
	</div>
</div>