<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package bellaworks
 */

get_header(); 
$parent_page_id = ( isset($_GET['pp']) && $_GET['pp'] ) ? $_GET['pp'] : '';
if($parent_page_id) {
	include( locate_template('parts/slideshow.php') );
}

$obj = get_queried_object();
$current_term_id = $obj->term_id;
$current_term_name = $obj->name;
$taxonomy = $obj->taxonomy;
$child_terms = get_term_children($current_term_id,$taxonomy);
?>

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
