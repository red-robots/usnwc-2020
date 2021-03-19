<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package bellaworks
 */

get_header(); ?>
<main id="main" class="site-main wrapper page404" role="main">
	<section class="error-404 not-found">
		<header class="page-header">
			<div class="small">404 Error</div>
			<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'bellaworks' ); ?></h1>
		</header><!-- .page-header -->

		<div class="entry-content">
			<?php get_search_form(); ?>
		</div>
	</section>
</main>
<?php
get_footer();
