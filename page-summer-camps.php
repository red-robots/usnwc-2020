<?php
/**
 * Template Name: Summer Camp
 */

get_header(); 
$blank_image = THEMEURI . "images/rectangle.png";
$square = THEMEURI . "images/square.png";
$currentPageLink = get_permalink();
?>

<div id="primary" data-post="<?php echo get_the_ID()?>" class="content-area-full summer-camp-page">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php if( get_the_content() ) { ?>
				<div class="intro-text-wrap">
					<div class="wrapper">
						<h1 class="page-title"><span><?php the_title(); ?></span></h1>
						<div class="intro-text"><?php the_content(); ?></div>
					</div>
				</div>
			<?php } ?>
		<?php endwhile;  ?>


		<?php
		$canceledImage = THEMEURI . "images/canceled.svg";
		$postype = 'camp';
		$perpage = 16;
		$paged = ( get_query_var( 'pg' ) ) ? absint( get_query_var( 'pg' ) ) : 1;
		$arg = array(
					'post_type'				=> $postype,
					'posts_per_page'	=> $perpage,
					'paged'						=> $paged,
					'post_status'			=> 'publish'
				);
		$posts = new WP_Query($arg);
		if ( $posts->have_posts() ) { 
			$total = $posts->found_posts;
			$total_pages = $posts->max_num_pages;
			?>
			<div class="post-type-entries <?php echo $postype ?>">
				<div id="data-container">
					<div class="posts-inner">
						<div class="flex-inner">
							<?php while ( $posts->have_posts() ) : $posts->the_post(); 
								$id = get_the_ID();
								$title = get_the_title();
								$pagelink = get_permalink();
								$short_description = get_field("short_description");
								$eventStatus = get_field("eventstatus");
								$thumbImage = get_field("thumbnail_image");
								$price = get_field("price");
								$ages = get_field("ages");
								$date_range = get_field("date_range");
								$dates = ($date_range) ?  array_filter( explode(",",$date_range) ):'';
								$age_prices = array($ages,$price);
								$agePriceInfo = ($age_prices && array_filter($age_prices)) ? true : false;
								?>
								<div class="postbox animated fadeIn <?php echo ($thumbImage) ? 'has-image':'no-image' ?> <?php echo $eventStatus ?>">
									<div class="inside">
										<a href="<?php echo $pagelink ?>" class="photo wave-effect js-blocks">
											<?php if ($thumbImage) { ?>
												<span class="imagediv" style="background-image:url('<?php echo $thumbImage['sizes']['medium_large'] ?>')"></span>
												<img src="<?php echo $thumbImage['url']; ?>" alt="<?php echo $thumbImage['title'] ?>" class="feat-img" style="display:none;">
												<img src="<?php echo $blank_image ?>" alt="" class="feat-img placeholder">
											<?php } else { ?>
												<span class="imagediv"></span>
												<img src="<?php echo $blank_image ?>" alt="" class="feat-img placeholder">
											<?php } ?>
											<span class="boxTitle">
												<span class="twrap">
													<span class="t1"><?php echo $title ?></span>
												</span>
											</span>

											<?php include( locate_template('images/wave-svg.php') ); ?>

											<?php if ($eventStatus=='canceled') { ?>
											<span class="canceledStat">
												<img src="<?php echo $canceledImage ?>" alt="" aria-hidden="true">
											</span>	
											<?php } ?>
										</a>

										<div class="details">
											<div class="info">
												<h3 class="event-name"><?php echo $title ?></h3>
												<?php if ($agePriceInfo) { ?>
												<div class="pricewrap">
													<div class="price-info">
														<?php if ($ages) { ?>
														<span class="age"><?php echo $ages ?></span>	
														<?php } ?>
														<?php if ($price) { ?>
														<span class="price"><?php echo $price ?></span>	
														<?php } ?>
													</div>
												</div>
												<?php } ?>

												<?php if ($dates) { ?>
												<ul class="dates">
													<?php foreach ($dates as $date) { ?>
														<li class="date"><?php echo $date ?></li>	
													<?php } ?>
												</ul>
												<?php } ?>

												<?php if ($short_description) { ?>
												<div class="short-description">
													<?php echo $short_description ?>
												</div>
												<?php } ?>

												<div class="button">
													<a href="<?php echo $pagelink ?>" class="btn-sm"><span>See Details</span></a>
												</div>
												
											</div>
										</div>

									</div>
								</div>
							<?php endwhile; wp_reset_postdata(); ?>
						</div>
					</div>
				</div>
			</div>

			<?php if ($total_pages > 1) { ?> 
			<div class="loadmorediv text-center">
				<div class="wrapper"><a href="#" id="nextPostsBtn" data-current="1" data-baseurl="<?php echo $currentPageLink ?>" data-end="<?php echo $total_pages?>" class="btn-sm wide"><span>Load More Festivals</span></a></div>
			</div>
			<?php } ?>

			<div class="hidden-entries" style="display:none;"></div>

		<?php } ?>

		

</div><!-- #primary -->

<script type="text/javascript">
jQuery(document).ready(function($){
	$(document).on("click","#nextPostsBtn",function(e){
		e.preventDefault();
		var button = $(this);
		var baseURL = $(this).attr("data-baseurl");
		var currentPageNum = $(this).attr("data-current");
		var nextPageNum = parseInt(currentPageNum) + 1;
		var pageEnd = $(this).attr("data-end");
		var nextURL = baseURL + '?pg=' + nextPageNum;
		button.attr("data-current",nextPageNum);
		if(nextPageNum==pageEnd) {
			$(".loadmorediv").remove();
		}
		$(".hidden-entries").load(nextURL+" #data-container",function(){
			if( $(this).find(".posts-inner .flex-inner").length>0 ) {
				var entries = $(this).find(".posts-inner .flex-inner").html();
				$("#loaderDiv").addClass("show");
				if(entries) {
					$("#data-container .flex-inner").append(entries);
					setTimeout(function(){
						$("#loaderDiv").removeClass("show");
					},500);
				}
			}
		});
	});
});
</script>
<?php
get_footer();
