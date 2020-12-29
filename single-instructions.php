<?php
get_header(); 
$post_type = get_post_type();
$post_id = get_the_ID();
$heroImage = get_field("full_image");
$has_banner = ($banner) ? 'hasbanner':'nobanner';
$template = ( get_field("instruction_template") ) ? get_field("instruction_template") : 'default';
?>	
<div id="primary" class="content-area-full content-default <?php echo $has_banner;?>">
	<?php get_template_part('parts/instructions-'.$template); ?>
</div><!-- #primary -->

<?php
get_footer();
