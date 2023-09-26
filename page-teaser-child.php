<?php
/**
 * Template Name: Teaser Child
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package bellaworks
 */

$placeholder = THEMEURI . 'images/rectangle.png';
$banner = get_field("flexslider_banner");
$has_banner = ($banner) ? 'hasbanner':'nobanner';
get_header(); 

if( is_page('waiver') ) {
	$pageClass = 'waiver';
} else {
	$pageClass = '';
}
?>

<div class="svg lottie" id="svgz">
<lottie-player
         id="svg"
         src="<?php bloginfo('template_url'); ?>/images/bg.json"
  >
  </lottie-player> 
</div>

<div id="primary" class="content-area-full content-default page-default-template <?php echo $has_banner ?>">
	<main id="main" class="site-main wrapper" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<section class="text-centered-section">
				<div class="wrapper text-center">
					<div class="page-header">
						<h1 class="page-title"><?php the_title(); ?></h1>
					</div>
					<div class="<?php echo $pageClass; ?>">
						<?php the_content(); ?>
					</div>
					
				</div>
			</section>



		<?php endwhile; ?>

	</main><!-- #main -->
	
	<section class="text-centered-section" >
		<div class=" text-center">
			<section class="teasers">
				<?php get_template_part('parts/teasers-child'); ?>
			</section>
		</div>
	</section>

</div><!-- #primary -->
<script type="text/javascript">
		
		let player = document.getElementById("svg");

		player.addEventListener("ready", () => {
		  LottieInteractivity.create({
					  mode:"scroll",
					  player: "#svg",
					  actions: [
				        {
				            visibility:[0.5, 1.0],
				            type: "seek",
				            frames: [0, 60],
				        },
				        ]
					});
		});


	</script>

<?php
get_footer();
