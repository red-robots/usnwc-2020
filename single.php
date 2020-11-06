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

//$customPostTypes = array('activity','festival');
get_template_part("parts/subpage-banner");
$post_id = get_the_ID(); ?>
	
<?php if ($post_type=='post') { ?>

	<?php  
	$thumbId = get_post_thumbnail_id($post_id); 
	$featImg = wp_get_attachment_image_src($thumbId,'full');
	$has_feat_image = ($featImg) ? 'has-banner':'no-banner';
	?>

	<div id="primary" class="content-area-full content-default single-post <?php echo $has_feat_image;?> post-type-<?php echo $post_type;?>">

		<?php if ($featImg) { $hero_alt = get_the_title($thumbId); ?>
		<div class="post-hero-image">
			<img src="<?php echo $featImg[0] ?>" alt="<?php echo $hero_alt ?>" class="featured-image">
		</div>
		<?php } ?>

		<main id="main" data-postid="post-<?php the_ID(); ?>" class="site-main" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
				
				<?php
				$short_description = get_field("short_description_text");
				if($short_description) { ?>
				<section class="text-centered-section dark">
					<div class="wrapper text-center">
						<div class="page-header">
							<h1 class="page-title"><?php the_title(); ?></h1>
							<p class="author">By <?php echo ucwords(get_the_author_meta('display_name')); ?></p>
						</div>
						<?php echo anti_email_spam($short_description); ?>
					</div>
				</section>
				<?php } ?>


				<?php  
				$galleries = get_field("image_gallery");
				$main_content = get_the_content();
				$authorId = '';
				$author_description = get_the_author_meta('description');
				$main_class = ($main_content && $galleries) ? 'half':'full';
				if($main_content || $galleries) { ?>
				<section class="main-post-text <?php echo $main_class ?>">
					<div class="flexwrap">
						<?php if ($main_content) { ?>
						<div class="textcol">
							<div class="inside">
								<div class="textwrap"><?php echo anti_email_spam( $main_content ); ?></div>
								<?php if ($author_description) { ?>
								<div class="author-bio"><?php echo $author_description ?></div>	
								<?php } ?>
								<div class="post-social-share"><?php echo do_shortcode('[addtoany]') ?></div>
							</div>
						</div>	
						<?php } ?>

						<?php if ($galleries) { ?>
						<div class="imagescol">

							<?php if ( count($galleries)>1 ) { ?>
								
								<?php  
									$imgMain = $galleries[0];
									$imgMainID = $imgMain['ID'];
									$imgClass = get_field("media_custom_class",$imgMainID);
								?>
								<div class="masonry top<?php echo ($imgClass) ? ' ' . $imgClass:'' ?>">
									<div class="block first">
										<img src="<?php echo $imgMain['url'] ?>" alt="<?php echo $imgMain['title'] ?>">
									</div>
								</div>
								<div class="masonry">
									<?php foreach ($galleries as $g) { 
										$g_ID = $g['ID'];
										$g_class = get_field("media_custom_class",$g_ID);
										?>
										<div class="block<?php echo ($g_class) ? ' ' . $g_class:'' ?>">
											<img src="<?php echo $g['url'] ?>" alt="<?php echo $g['title'] ?>">
										</div>
									<?php } ?>
								</div>

							<?php } else { ?>

							<?php } ?>
							
						</div>	
						<?php } ?>
					</div>
				</section>
				<?php } ?>

			<?php endwhile; ?>
		</main>

	</div>


<?php } else { ?>

	<div id="primary" class="content-area-full content-default <?php echo $has_hero;?> post-type-<?php echo $post_type;?>">

		<?php get_template_part('parts/post-type-'.$post_type); ?>
	
	</div><!-- #primary -->

<?php } ?>




<?php
get_footer();
