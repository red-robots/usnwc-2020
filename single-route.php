<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package bellaworks
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

		<?php get_template_part('parts/post-type-'.$post_type); ?>
	
	</div><!-- #primary -->



<?php
get_footer();
