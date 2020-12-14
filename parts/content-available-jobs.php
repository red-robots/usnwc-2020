<?php
$title4 = get_field("title4");
?>

<section id="section4" data-section="<?php echo $title4 ?>" class="section-content section-available-jobs">
	<div class="wrapper">
		<?php if ($title4) { ?>
		<div class="shead-icon text-center">
			<div class="icon"><span class="ci-menu"></span></div>
			<h2 class="stitle"><?php echo $title4 ?></h2>
		</div>
		<?php } ?>
	</div>

	<?php

	// $terms = get_terms( array(
	//     'taxonomy' => 'jobtype',
	//     'post_types'=> array('job'),
	//     'hide_empty' => false,
	// ));

	$args1 = array(
		'post_type'				=> 'job',
		'post_status'			=> 'publish',
		'facetwp'					=> true
	);
	$jobs = new WP_Query($args1);
	if( $jobs->have_posts() ) { ?>

	<?php } ?>


							
</section>