<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package bellaworks
 */

get_header(); 
//$parent_page_id = ( isset($_GET['pp']) && $_GET['pp'] ) ? $_GET['pp'] : '';


$obj = get_queried_object();
$current_term_id = $obj->term_id;
$current_term_name = $obj->name;
$taxonomy = $obj->taxonomy;
$child_terms = get_term_children($current_term_id,$taxonomy);
$blank_image = THEMEURI . "images/rectangle-narrow.png";

$category_image = get_field("category_image",$taxonomy.'_'.$current_term_id);
if($category_image) { ?>
<div id="banner" class="taxonomy-banner">
	<div class="slides-wrapper static-banner" style="background-image:url('<?php echo $category_image['url'] ?>')">
		<img src="<?php echo $category_image['url'] ?>" alt="<?php echo $category_image['title'] ?>" class="actual-image">
		<img src="<?php echo $blank_image ?>" alt="" aria-hidden="true" class="helper">
	</div>
</div>
<?php	} ?>

<div id="primary" data-term-id="" class="content-area-full boxedImagesPage instruction-taxonomy-page">
	<div class="intro-text-wrap">
		<div class="wrapper">
			<h1 class="page-title" style="margin-bottom:0;"><span><?php echo $current_term_name; ?></span></h1>
		</div>
	</div>

	<?php /* If has children terms */ ?>
	<?php 
	if ($child_terms) { 
		include( locate_template('instructions/instruction-child-terms.php') );
	} else {  
		include( locate_template('instructions/instruction-posts.php') );
	} 
	?>
</div><!-- #primary -->
<?php
get_footer();
