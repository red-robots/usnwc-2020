<?php
/**
 * Template Name: River Jam
 */

get_header(); 
$blank_image = THEMEURI . "images/square.png";
$square = THEMEURI . "images/square.png";
$rectangle = THEMEURI . "images/rectangle-lg.png";
?>


<div id="primary" data-post="<?php echo get_the_ID()?>" class="content-area-full riverjam">
	<?php while ( have_posts() ) : the_post(); ?>
		<section class="text-centered-section">
			<div class="wrapper text-center">
				<div class="page-header">
					<h1 class="page-title"><?php the_title(); ?></h1>
				</div>
				<?php if ( get_the_content() ) { ?>
				<div class="text"><?php the_content(); ?></div>
				<?php } ?>
			</div>
		</section>
	<?php endwhile;  ?>

	<?php get_template_part("parts/subpage-tabs"); ?>

	<?php /* UPCOMING */ ?>
	<?php if( $upcoming = get_upcoming_bands() ) { ?>
	<section id="upcoming" data-section="Upcoming" class="section-content">
		<div class="redDiv text-center">
			<h2 class="stitle">Upcoming</h2>
		</div>
		<div class="upcoming-posts">
			<div class="flexwrap">
				<?php foreach ($upcoming as $row) { 
					$pid = $row->ID;
					$title = $row->post_title;
					$start_date = ( isset($row->start_date) && $row->start_date ) ? $row->start_date : '';
					$start_day = ($start_date) ? date('l',strtotime($start_date)) : '';
					$image = get_field("thumbnail_image",$pid);
					$helper = THEMEURI . "images/rectangle-lg.png";
					$has_image = ($image) ? 'has-image':'no-image';
					$style = ($image) ? ' style="background-image:url('.$image['url'].')"':'';
					$start_date_format = '';
					if($start_date) {
						$start_date_format = date('M',strtotime($start_date)) . '. ' . date('j',strtotime($start_date));
					}
					$short_description = get_field("short_description",$pid);
					$schedule = get_field("schedule_repeater",$pid);
					$schedule_title = get_field("schedule_title",$pid);
				?>
				<div data-postid='<?php echo $pid ?>' data-startdate="<?php echo $start_date ?>" class="entry <?php echo $has_image ?>">
					<div class="inside">
						<div class="titlediv">
							<h2><?php echo $start_day ?></h2>
							<p class="date"><?php echo $start_date_format ?></p>
							<h3 class="title"><span><?php echo $title ?></span></h3>
						</div>
						<div class="photo <?php echo $has_image ?>"<?php echo $style ?>>
							<img src="<?php echo $helper ?>" alt="" aria-hidden="true" class="helper">
						</div>
						<?php if ($short_description) { ?>
						<div class="description text-center js-blocks">
							<div class="text"><?php echo $short_description ?></div>
						</div>
						<?php } ?>
						<?php if ($schedule) { ?>
						<div class="schedule schedules-list">
							<h3 class="t1"><?php echo ($schedule_title) ? $schedule_title : 'Schedule' ?></h3>
							<ul class="items">
							<?php foreach ($schedule as $s) { 
								$time = $s['time'];
								$altText = ( isset($s['alt_text']) && $s['alt_text'] ) ? $s['alt_text']:'';
								$is_pop_up = ( isset($s['popup_info'][0]) && $s['popup_info'][0]=='yes' ) ? true : false;
								$act = ( isset($s['program']) && $s['program'] ) ? $s['program']:'';
								$activityName = '';
								$pageLink = '';
								$pid = '';
								if($act) {
									$pid = $act->ID;
									$activityName = $act->post_title;
									$pageLink = get_permalink($id);
									$altText = ($altText) ? '('.$altText.')' : '';
								}
								?>
								<li class="item">
									<div class="time"><?php echo $time ?></div>
									<div class="event">
										<?php if ($is_pop_up) { ?>
											<?php if ($act) { ?>
												<a href="#" data-url="<?php echo $pageLink ?>" data-action="ajaxGetPageData" data-id="<?php echo $pid ?>" class="actname popdata"><?php echo $activityName ?></a>	
											<?php } ?>
										<?php } else { ?>
											<span class="actname"><?php echo $activityName ?></span>	
										<?php } ?>

										<?php if ($altText) { ?>
										<span class="alttext"><?php echo $altText ?></span>
										<?php } ?>
									</div>
								</li>
							<?php } ?>
							</ul>
						</div>
						<?php } ?>
					</div>
				</div>	
				<?php } ?>
			</div>
		</div>
	</section>
	<?php } ?>

	<?php /* UPCOMING BANDS BY DATE */ ?>
	<?php get_template_part("parts/filter-river-jam"); ?>

	<?php 
	$paged = ( get_query_var( 'pg' ) ) ? absint( get_query_var( 'pg' ) ) : 1;
	$offset = 0;
	$perpage = 12;
	if($paged>1) {
		$offset = ($paged * $perpage) - $perpage;
	}
	if( $result = upcoming_bands_by_date($offset,$perpage) ) { 
		$bands = $result['records'];
		$total = $result['total'];
	?>
	<section id="upcoming-bands-by-date" data-section="Bands Schedule" class="section-content menu-sections">
		<div class="post-type-entries music">
			<div id="data-container">
				<div class="posts-inner animate__animated animate__fadeIn">
					<div class="flex-inner result">
						<?php foreach ($bands as $b) { 
							$id = $b->ID;
							$title = $b->post_title;
							$text = $b->post_content;
							$status = get_field("eventstatus",$id);
							$eventStatus = ($status) ? $status:'upcoming';
							$thumbImage = get_field("thumbnail_image",$id);
							$pagelink = get_permalink($id);
							$start = get_field("start_date",$id);
							$end = get_field("end_date",$id);
							$event_date = get_event_date_range($start,$end,true);
							$short_description = ( get_the_content() ) ? shortenText( strip_tags($text),300,' ','...' ) : '';
							if($event_date) {
								if(strpos($event_date,'-') !== false){
									// Has multiple dates...
								} else {
									$dayOfWeek = date('l',strtotime($start));
									$event_date = $dayOfWeek .', ' . date('F j',strtotime($start));
								}
							}
							
						?>
						<div class="postbox <?php echo ($thumbImage) ? 'has-image':'no-image' ?> <?php echo $eventStatus ?>">
							<div class="inside">
								<a href="#" data-url="<?php echo $pagelink ?>" data-action="ajaxGetPageData" data-id="<?php echo $id ?>" class="photo popdata">
									<?php if ($thumbImage) { ?>
										<span class="imagediv" style="background-image:url('<?php echo $thumbImage['sizes']['medium_large'] ?>')"></span>
										<img src="<?php echo $rectangle ?>" alt="" class="feat-img placeholder">
										<img src="<?php echo $thumbImage['url']; ?>" alt="<?php echo $thumbImage['title'] ?>" class="feat-img" style="display:none">
									<?php } else { ?>
										<span class="imagediv"></span>
										<img src="<?php echo $rectangle ?>" alt="" class="feat-img placeholder">
									<?php } ?>
								</a>
								<div class="details">
									<div class="info">
										<h3 class="event-name"><?php echo $title ?></h3>
										<?php if ($event_date) { ?>
										<div class="event-date"><?php echo $event_date ?></div>
										<?php } ?>
										<div class="button">
											<a href="#" data-url="<?php echo $pagelink ?>" data-action="ajaxGetPageData" data-id="<?php echo $id ?>" class="btn-sm xs popdata"><span>See Details</span></a>
										</div>
									</div>
								</div>
							</div>
						</div>	
						<?php } ?>
					</div>
				</div>
			</div>
		</div>

		<div class="next-posts" style="display:none;"></div>
		<?php 
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
	</section>
	<?php } ?>

	<?php  
	/* PROGRAMS */
	$args = array(
		'post_type'				=> 'jam-programs',
		'posts_per_page'	=> -1,
		'post_status'			=> 'publish'
	);
	$programs = new WP_Query($args);
	if( $programs->have_posts() ) { ?>	
	<section id="riverjam-programs" data-section="Programs" class="section-content menu-sections">
		<div class="wrapper">
			<div class="shead-icon text-center">
				<div class="icon"><span class="ci-task"></span></div>
				<h2 class="stitle">PROGRAMS</h2>
			</div>
		</div>
		<div class="columns-2 text-and-images">
			<?php $i=1;  while ( $programs->have_posts() ) : $programs->the_post();
			$slides = get_field("featured_images");
			$boxClass = ( $slides ) ? 'half':'full'; 
			$colClass = ($i % 2) ? ' odd':' even';
			$xid = get_the_ID();
			$excerpt = ( get_the_content() ) ? shortenText( strip_tags(get_the_content()),300,' ','...' ) : '';
			?>
			<div id="section<?php echo $i?>" class="mscol <?php echo $boxClass.$colClass ?>">
				<div class="textcol">
					<div class="inside">
						<div class="info">
							<h3 class="mstitle"><?php the_title(); ?></h3>
							<?php if ( $excerpt ) { ?>
							<div class="textwrap"><?php echo $excerpt; ?></div>
							<div class="buttondiv">
								<a href="#" data-url="<?php echo get_permalink(); ?>" data-action="ajaxGetPageData" data-id="<?php echo $xid ?>" class="btn-sm xs popdata"><span>See More</span></a>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>

				<?php if ( $slides ) { ?>
				<div class="gallerycol">
					<div class="flexslider">
						<ul class="slides">
							<?php $helper = THEMEURI . 'images/rectangle-narrow.png'; ?>
							<?php foreach ($slides as $s) { ?>
								<li class="slide-item" style="background-image:url('<?php echo $s['url']?>')">
									<img src="<?php echo $helper ?>" alt="" aria-hidden="true" class="placeholder">
									<img src="<?php echo $s['url'] ?>" alt="<?php echo $s['title'] ?>" class="actual-image" />
								</li>
							<?php } ?>
						</ul>
					</div>
				</div>	
				<?php } ?>
			</div>
			<?php  $i++; endwhile; wp_reset_postdata(); ?>
		</div>
	</section>
	<?php } ?>

	<?php
	/* FAQs */
	$customFAQTitle = 'FAQ';
	$customFAQClass = 'custom-class-faq graybg';
	include( locate_template('parts/content-faqs.php') );
	include( locate_template('inc/faqs.php') );
	?>

</div><!-- #primary -->

<div id="activityModal" class="modal customModal fade">
	<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="modalBodyText" class="modal-body">
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
jQuery(document).ready(function($){
	$("#activityModal").appendTo('body');

	// $('#gallery').flexslider({
 //    animation: "slide"
 //  });

	$(document).on("click",".popdata",function(e){
		e.preventDefault();
		var pageURL = $(this).attr('data-url');
		var actionName = $(this).attr('data-action');
		var pageID = $(this).attr('data-id');

		$.ajax({
			url : frontajax.ajaxurl,
			type : 'post',
			dataType : "json",
			data : {
				'action' : actionName,
				'ID' : pageID
			},
			beforeSend:function(){
				$("#loaderDiv").show();
			},
			success:function( obj ) {
			
				var content = '';
				if(obj) {
					content += '<div class="modaltitleDiv text-center"><h5 class="modal-title">'+obj.post_title+'</h5></div>';
					if(obj.featured_image) {
						var img = obj.featured_image;
						content += '<div class="modalImage"><img src="'+img.url+'" alt="'+img.title+'p" class="feat-image"></div>';
					}
					content += '<div class="modalText"></div>';

					if(content) {
						$("#modalBodyText").html(content);
					}

					$.get(obj.postlink,function(data){
						var textcontent = '<div class="text">'+data+'</div></div>';
						$("#modalBodyText .modalText").html(textcontent);
						$("#activityModal").modal("show");
						$("#loaderDiv").hide();
						if( $("#activityModal .flexslider").length > 0 ) {
							$('.flexslider').flexslider({
								animation: "fade",
								smoothHeight: true,
								start: function(){

								}
							});
						}
					});
					
				}
				
			},
			error:function() {
				$("#loaderDiv").hide();
			}
		});

	});
});
</script>
<?php
include( locate_template('inc/pagetabs-script.php') );
get_footer();
?>

