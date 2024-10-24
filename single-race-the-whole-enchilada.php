<?php
/*
* Template Name: Whole Enchilada
* Template Post Type: race
*/

get_header(); 
$post_type = get_post_type();
$heroImage = get_field("full_image");
$flexbanner = get_field("flexslider_banner");
$has_hero = 'no-banner';
if($heroImage) {
	$has_hero = ($heroImage) ? 'has-banner':'no-banner';
} else {
	if($flexbanner) {
		$has_hero = ($flexbanner) ? 'has-banner':'no-banner';
	}
}

get_template_part("parts/subpage-banner");

$rectangle_placeholder = get_bloginfo("template_url") . '/images/video-helper.png';
$post_id = get_the_ID(); ?>
	


	<div id="primary" class="content-area-full content-default <?php echo $has_hero;?> post-type-<?php echo $post_type;?>">

		<?php 
		//get_template_part('parts/post-type-race-enchillada'); 
		get_template_part('parts/post-type-race'); 
		?>
	
	</div><!-- #primary -->





<script type="text/javascript">
jQuery(document).ready(function($){

	$(".view-photo-credit").hover(function(){
	  $(this).next(".photo-credit").addClass("show");
	  }, function(){
	  $(this).next(".photo-credit").removeClass("show");
	});

	$("#videoCustomImage").on("click",function(){
		var src = $("#vimeoVideoFrame").attr("src");
		var newURL = src + '&autoplay=1';
		$("#vimeoVideoFrame").attr("src",newURL);
		$(this).hide();
	});

	if( $("#section-checkin").length>0 ) {
		var nextEL = $("#section-checkin").next();
		if( nextEL.length>0 ) {
			var className = nextEL[0].className;
			if(className=='explore-other-stuff') {
				$("#section-checkin").css("margin-bottom","0");
			}
		}
	}

});
</script>

<?php
get_footer();
