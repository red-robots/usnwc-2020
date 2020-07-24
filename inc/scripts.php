<?php
/**
 * Enqueue scripts and styles.
 */
function bellaworks_scripts() {
	wp_enqueue_style( 'bellaworks-style', get_stylesheet_uri() );

	wp_deregister_script('jquery');
		wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js', false, '3.5.1', true);
		wp_enqueue_script('jquery');

	

	wp_enqueue_script( 
			'bellaworks-blocks', 
			get_template_directory_uri() . '/assets/js/vendors.min.js', 
			array(), '20200713', 
			true 
		);

	wp_enqueue_script( 
			'vimeo-player', 
			'https://player.vimeo.com/api/player.js', 
			array(), '2.12.2', 
			true 
		);

	wp_enqueue_script( 
			'bellaworks-custom', 
			get_template_directory_uri() . '/assets/js/custom.js', 
			array(), '20200713', 
			true 
		);

	wp_enqueue_script( 
		'font-awesome', 
		'https://use.fontawesome.com/8f931eabc1.js', 
		array(), '20180424', 
		true 
	);



	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'bellaworks_scripts' );