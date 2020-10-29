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

	if( isset($_GET['category']) || $_GET['activity_types'] ) {
		$cat_id = ($_GET['category'] && $_GET['category']!='all') ? $_GET['category'] : 0;
		$activity_type_id = ($_GET['activity_type'] && $_GET['activity_type']!='all') ? $_GET['activity_type'] : 0;

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
				<form action="" id="filter-form" method="GET">
						<input type="hidden" id="baseurl_input" value="<?php echo $pageLink ?>">
						<div class="filterbytxt">Filter By:</div>
						<div class="flexwrap">
							<?php if ($terms) { ?>
							<div class="select-wrap">
								<label for="category">Category</label>
								<div class="selectdiv">
									<select name="category" id="category" class="select-single select-filter">
										<option value="all">All</option>
										<?php foreach ($terms as $term) { 
											$is_cat_selected = ( isset($_GET['category']) && ($_GET['category']==$term->term_id) ) ? ' selected':'';
										?>
										<option value="<?php echo $term->term_id ?>"<?php echo $is_cat_selected ?>><?php echo $term->name ?></option>	
										<?php } ?>
									</select>
								</div>
							</div>
							<?php } ?>

							<?php if ($types) { ?>
							<div class="select-wrap">
								<label for="activity_type">Type</label>
								<div class="selectdiv">
									<select name="activity_type" id="activity_type" class="select-single select-filter">
										<option value="all">All</option>
										<?php foreach ($types as $type) { 
											$is_type_selected = ( isset($_GET['activity_type']) && ($_GET['activity_type']==$type->term_id) ) ? ' selected':'';
										?>
										<option value="<?php echo $type->term_id ?>"<?php echo $is_type_selected ?>><?php echo $type->name ?></option>	
										<?php } ?>
									</select>
								</div>
							</div>
							<?php } ?>
						</div>
						<input type="submit" id="filterBtn" value="Filter" style="display:none;">
				</form>
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
					<a class="moreBtn" id="loadMoreBtn" data-totalpages="<?php echo $total_pages?>" data-perpage="<?php echo $perPage?>" data-posttype="<?php echo $post_type?>" data-page="<?php echo $paged?>" data-baseurl="<?php echo $pageLink?>"><span class="loadtxt">Load More</span></a>
					<div class="wait"><span class="fas fa-sync-alt rotate"></span></div>
				</span>
			</div>
		<?php } ?>
		<?php } ?>
	</div>
</div>