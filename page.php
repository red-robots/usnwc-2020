<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
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
						<?php if(is_page('trail-stauts-test')) {
							echo 'this page';
							function get_ww_trail_status( $field_name ) {

							    // Get the API URL for the options page.
							    $url = rest_url( 'https://center.whitewater.org//wp/v3/options/page_settings' );

							    // Add the field name to the query string.
							    $url .= '?field=' . $field_name;

							    // Get the response from the API.
							    $response = wp_remote_get( $url );

							    // Check the response code.
							    if ( 200 !== wp_remote_retrieve_response_code( $response ) ) {
							        return null;
							    }

							    // Decode the JSON response body.
							    $body = wp_remote_retrieve_body( $response );
							    $data = json_decode( $body, true );

							    // Return the value of the ACF field.
							    return isset( $data[ $field_name ] ) ? $data[ $field_name ] : null;
							}

							$status = get_ww_trail_status('form_id');
							echo $status;
						} ?>
					</div>
				</div>
			</section>

		<?php endwhile; ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
