<?php
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
		$postype = 'camp';
		$perpage = 16;
		$paged = ( get_query_var( 'pg' ) ) ? absint( get_query_var( 'pg' ) ) : 1;
		$result = custom_query_posts($postype,$perpage,$paged,'ASC');
		$posts = ( isset($result['records']) && $result['records'] ) ? $result['records']:'';
		$total = ( isset($result['total']) && $result['total'] ) ? $result['total']:0;
		$canceledImage = THEMEURI . "images/canceled.svg";
		$total_pages = ($posts) ? ceil($total / $perpage):0;

		if ( $posts ) { ?>
		<div class="post-type-entries <?php echo $postype ?>">
			<div id="data-container">
				<div class="posts-inner">
					<div class="flex-inner">
						<?php $i=1; foreach ($posts as $p) { 
							$id = $p->ID;
							$title = $p->post_title;
							$pagelink = get_permalink($id);
							$short_description = get_field("short_description",$id);
							$eventStatus = get_field("eventstatus",$id);
							$thumbImage = get_field("thumbnail_image",$id);
							$price = get_field("price",$id);
							$ages = get_field("ages",$id);
							$date_range = get_field("date_range",$id);
							$dates = ($date_range) ?  array_filter( explode(",",$date_range) ):'';
							$age_prices = array($ages,$price);
							$agePriceInfo = ($age_prices && array_filter($age_prices)) ? true : false;
							?>
							<div class="postbox animated fadeIn <?php echo ($thumbImage) ? 'has-image':'no-image' ?> <?php echo $eventStatus ?>">
								<div class="inside">
									
									<?php if ($eventStatus=='completed') { ?>
										<!-- <div class="event-completed"><span>Event Complete</span></div> -->
									<?php } ?>
									
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
						<?php $i++; } ?>
					</div>
				</div>
			</div>

			<div class="hidden-entries" style="display:none;"></div>

		</div>
		<?php } ?>

		<?php if ($total > $perpage) { ?> 
		<div class="loadmorediv text-center">
			<div class="wrapper"><a href="#" id="nextPostsBtn" data-current="1" data-baseurl="<?php echo $currentPageLink ?>" data-end="<?php echo $total_pages?>" class="btn-sm wide"><span>Load More Festivals</span></a></div>
		</div>
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
