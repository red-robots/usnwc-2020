<?php
/**
 * Template Name: FAQs
 */

$placeholder = THEMEURI . 'images/rectangle.png';
$banner = get_field("flexslider_banner");
$has_banner = ($banner) ? 'hasbanner':'nobanner';
get_header(); ?>

<div id="primary" class="content-area-full content-faqs-page <?php echo $has_banner ?>">
	<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>
			<section class="text-centered-section">
				<div class="wrapper text-center">
					<div class="page-header">
						<h1 class="page-title"><?php the_title(); ?></h1>
					</div>
					<?php the_content(); ?>
				</div>
			</section>
		<?php endwhile; ?>

		<?php
			$args = array(
				'posts_per_page'   => -1,
				'post_type'        => 'faqs',
				'post_status'      => 'publish'
			);
			$faqs = new WP_Query($args);
			$first_faq = '';
			if ( $faqs->have_posts() ) {  ?>
			<section class="main-faqs-icons">
				<div class="wrapper">
					<div class="flexwrap">
						<?php $i=1; while ( $faqs->have_posts() ) : $faqs->the_post(); 
								$id = get_the_ID();
								$icon = get_field("custom_icon");
								$title = get_the_title();
								if($i==1) {
									$first_faq = $id;
								}
							?>
							<a href="#" data-id="<?php echo $id ?>" class="faq faqGroup">
								<?php if ($icon) { ?>
								<span class="icon"><i class="<?php echo $icon ?>"></i></span>	
								<?php } ?>
								<?php if ($title) { ?>
								<span class="title"><?php echo $title ?></span>	
								<?php } ?>
							</a>
						<?php $i++; endwhile; wp_reset_postdata(); ?>
					</div>
				</div>
			</section>


			<div class="main-faq-items" id="faqItems">
				<div class="wrapper narrow">
					<div id="faqsContainer">
						<?php echo ($first_faq) ? getFaqs($first_faq) : ''; ?>
					</div>
				</div>
			</div>
			<?php } ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
include( locate_template('inc/faqs.php') );  
get_footer();
