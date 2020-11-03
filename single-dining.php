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
$heroImage = get_field("post_image_full");
$has_hero = ($heroImage) ? 'has-banner':'no-banner';
//$customPostTypes = array('activity','festival');
//get_template_part("parts/subpage-banner");
$post_id = get_the_ID(); 
$registerLink = get_field('adventure_dining_register_link','option');
$registerButton = ( isset($registerLink['title']) && $registerLink['title'] ) ? $registerLink['title'] : '';
$registerLink = ( isset($registerLink['url']) && $registerLink['url'] ) ? $registerLink['url'] : '';
$registerTarget = ( isset($registerLink['target']) && $registerLink['target'] ) ? $registerLink['target'] : '_self';

$registration_status = get_field("registration_status",$post_id); 
$status = ($registration_status) ? $registration_status : 'open';
?>
	
<div id="primary" class="content-area-full content-default single-post <?php echo $has_hero;?> post-type-<?php echo $post_type;?>">

		<?php if ($heroImage) { ?>
		<div class="post-hero-image">
			<?php if ($status=='open') { ?>

				<?php if ($registerButton && $registerLink) { ?>
					<div class="stats open"><a href="<?php echo $registerLink ?>" target="<?php echo $registerTarget ?>" class="registerBtn"><?php echo $registerButton ?></a></div>
				<?php } ?>
			
			<?php } else if($status=='closed') { ?>
			<div class="stats closed">SOLD OUT</div>
			<?php } ?>
			<img src="<?php echo $heroImage['url'] ?>" alt="<?php echo $heroImage['title'] ?>" class="featured-image">
		</div>
		<?php } ?>

		<main id="main" data-postid="post-<?php the_ID(); ?>" class="site-main" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
				
				<?php
				$short_description = get_the_content();
				
			
				if($short_description) { ?>
				<section class="text-centered-section">
					<div class="wrapper text-center">
						<div class="page-header">
							<h1 class="page-title"><?php the_title(); ?></h1>
						</div>
						<?php echo anti_email_spam($short_description); ?>
					</div>
				</section>
				<?php } ?>

				<div id="pageTabs"></div>

			<?php endwhile; ?>
		</main>

	</div>

<?php
get_footer();
