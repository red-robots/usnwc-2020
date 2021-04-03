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
			
				<div class="intro-text-wrap">
					<div class="wrapper">
						<h1 class="page-title"><span><?php the_title(); ?></span></h1>
						<?php if( get_the_content() ) { ?>
						<div class="intro-text"><?php the_content(); ?></div>
						<?php } ?>
					</div>
				</div>
			
		<?php endwhile;  ?>

		<?php get_template_part("parts/race-series-filter"); ?>

</div><!-- #primary -->
<script type="text/javascript">
(function($) {

var hasFilter = '<?php echo ( isset($_GET['_race_event_status']) || isset($_GET['_race_series_discipline']) ) ? '1':''?>';
if(hasFilter) {
	$("#resetBtn").removeClass('hide');
}
// $(document).on('facetwp-refresh', function() {
//  	var selected = $('.facetwp-facet-race_event_status option:selected').val();
//  	if( typeof selected!='undefined' ) {
//  		if( selected=='active' ) {
//  			$(".facetwp-facet-race_event_status").addClass('is-active');
//  			$(".facetwp-facet-race_event_status").attr('data-selected','Upcoming');
//  		} else {
//  			$(".facetwp-facet-race_event_status").removeClass('is-active');
//  			$(".facetwp-facet-race_event_status").removeAttr('data-selected');
//  		}
//  	} else {
//  		$(".facetwp-facet-race_event_status").removeClass('is-active');
//  		$(".facetwp-facet-race_event_status").removeAttr('data-selected');
//  	}

// });
})(jQuery);
</script>
<?php
get_footer();
