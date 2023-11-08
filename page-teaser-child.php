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

<!-- <div class="svg lottie" id="svgz">
<lottie-player
         id="svg"
         src="<?php bloginfo('template_url'); ?>/images/bg.json"
  >
  </lottie-player> 
</div> -->

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
		

		/*

			Lottie Player

		*/
		// let player = document.getElementById("svg");

		// player.addEventListener("ready", () => {
		//   LottieInteractivity.create({
		// 			  mode:"scroll",
		// 			  player: "#svg",
		// 			  actions: [
		// 		        {
		// 		            visibility:[0.5, 1.0],
		// 		            type: "seek",
		// 		            frames: [0, 60],
		// 		        },
		// 		        ]
		// 			});
		// });




class App {

	constructor() {
		this.heroImages = [...document.querySelectorAll('.image-container img')];
		this.myContainer = [...document.querySelectorAll('.image-container')];
		this._initialize();
		this._render();
	}

	_initialize() {
		this._setInitialStates();
		this._createLenis();
		this._createParallaxSections();
		this._createPinnedSection();
	}

	_setInitialStates() {
		gsap.set('.image-container img', {
			scale: 1
		})
		gsap.set('.fullwidth-image__text', {
			opacity: 0,
			y: 32
		})
		gsap.set('.fullwidth-image img', {
			scale: 1.3
		})
	}

	_createLenis() {
		this.lenis = new Lenis({
			lerp: 0.1
		})
	}

	_createParallaxSections() {
		gsap.utils.toArray(this.myContainer).forEach(function(container) {
		    let image = container.querySelector("img");
		  
		      gsap.to(image, {
		        y: () => image.offsetHeight - container.offsetHeight,
		        ease: "none",
		        scale: 1.1,
		        scrollTrigger: {
		          trigger: container,
		          scrub: true,
		          pin: false,
		          invalidateOnRefresh: true
		        },
		      }); 
		  });
		// const tl = gsap.timeline();

		// this.heroImages.forEach(image => {
		// 	tl.to(image, {
		// 		ease: 'none',
		// 		y: () => image.offsetHeight - this.container.offsetHeight,
		// 		scrollTrigger: {
		// 			trigger: this.heroImages,
		// 			scrub: true,
		// 			pin: false,
		// 			invalidateOnRefresh: true
		// 		}
		// 	}, 0)
		// })
	}

	_createPinnedSection() {
		const tl = gsap.timeline({
			scrollTrigger: {
				trigger: '.fullwidth-image',
				start: 'top top',
				end: '+=1500',
				scrub: true,
				pin: true
			}
		});
		tl.to('.fullwidth-image__overlay', {
			opacity: 0.4,

		}).to('.fullwidth-image', {
			"clip-path": "polygon(0% 0%, 100% 0%, 100% 100%, 0% 100%",
		}, 0).to('.fullwidth-image img', {
			scale: 1
		}, 0).to('.fullwidth-image__text', {
			y: 0,
			opacity: 1
		}, 0)
	}

	_render(time) {
		this.lenis.raf(time);
		requestAnimationFrame(this._render.bind(this))
	}

}

new App();

	</script>

<?php
get_footer();
