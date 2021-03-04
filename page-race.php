<?php
/**
 * Template Name: Race Series
 */

get_header(); 
$blank_image = THEMEURI . "images/square.png";
$square = THEMEURI . "images/square.png";
$rectangle = THEMEURI . "images/rectangle-lg.png";
?>

<div id="primary" data-post="<?php echo get_the_ID()?>" class="content-area-full festival-page race-series-page">
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

		<?php get_template_part("parts/race-series-filter"); ?>

</div><!-- #primary -->
<script type="text/javascript">
(function($) {

$(document).on('facetwp-refresh', function() {

 	var selected = $('.facetwp-facet-event_status option:selected').val();
 	if( typeof selected!='undefined' ) {
 		if( selected=='active' ) {
 			$(".facetwp-facet-event_status").addClass('is-active');
 			$(".facetwp-facet-event_status").attr('data-selected','Upcoming');
 		} else {
 			$(".facetwp-facet-event_status").removeClass('is-active');
 			$(".facetwp-facet-event_status").removeAttr('data-selected');
 		}
 	} else {
 		$(".facetwp-facet-event_status").removeClass('is-active');
 		$(".facetwp-facet-event_status").removeAttr('data-selected');
 	}


});
	// $(document).on("click",".facetwp-facet-event_status .fs-option",function(){
	// 	var selected = $(".fs-label").text();
	// 	if( selected.includes('active') ) {
	// 		console.log(selected);
	// 	}
		
	// });

})(jQuery);
</script>
<?php
get_footer();
