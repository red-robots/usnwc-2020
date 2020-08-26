<?php
/**
 * Template Name: Activity Schedule
 */

get_header(); 
$blank_image = THEMEURI . "images/square.png";
$square = THEMEURI . "images/square.png";
$flexslider = get_field( "flexslider_banner" );
$slidesCount = ($flexslider) ? count($flexslider) : 0;
$slideImages = array();
if($flexslider) {
	foreach($flexslider as $r) {
		if( isset($r['image']['url']) ) {
			$slideImages[] = $r['image']['url'];
		}
	}
}
$has_banner = ($slideImages) ? 'has-banner':'no-banner';
?>

<div id="primary" data-post="<?php echo get_the_ID()?>" class="content-area-full activity-schedule <?php echo $has_banner ?>">
		<?php while ( have_posts() ) : the_post(); ?>
			<div class="intro-text-wrap">
				<div class="wrapper">
					<h1 class="page-title"><span><?php the_title(); ?></span></h1>
				</div>
			</div>
		<?php endwhile;  ?>

		<div class="schedule-activities-info">
			<div class="subhead">
				
			</div>
			


			<?php
			$postype = 'activity_schedule';
			$post = get_current_activity_schedule($postype);
			if($post) { 
				$postID = $post->ID;
				$post_title = $post->post_title;
				$dateToday = date('l, F jS');
				$pass_hours = get_field("pass_hours",$postID);
				$note = get_field("note",$postID);
				$scheduled_activities = get_field("scheduled_activities",$postID);
				?>
				
				<div class="subhead">
					<h2 class="event-date"><?php echo $dateToday ?></h2>
					<?php if ($pass_hours) { ?>
					<div class="pass-hours"><?php echo $pass_hours ?></div>	
					<?php } ?>
					<?php if ($note) { ?>
					<div class="note"><?php echo $note ?></div>	
					<?php } ?>
				</div>

				<div class="entries">
					<div class="wrapper">
					<?php if ($scheduled_activities) { ?>
						<div class="activities">
							<?php foreach ($scheduled_activities as $a) { 
								$type = $a['type'];
								$activities = $a['activities'];
								if($type || $activities) { ?>
									<div class="info">
										<?php if ($type) { ?>
											<h3 class="type"><?php echo $type ?></h3>
										<?php } ?>
										<?php if ($activities) { ?>
											<ul class="list">
												<?php foreach ($activities as $e) { 
												$name = ($e['name']) ? $e['name']->post_title : '';
												$start = $e['time_start'];
												$end = $e['time_end'];
												$delimiter = '';
												if($start && $end) {
													$delimiter = '<span class="dashed">&ndash;</span>';
												}
												?>
												<li class="data">
													<div class="cell name"><?php echo $name ?></div>
													<div class="cell time">
														<?php if ($start) { ?>
														<span class="time-start"><?php echo $start ?></span>	
														<?php } ?>
														<?php echo $delimiter ?>
														<?php if ($end) { ?>
														<span class="time-end"><?php echo $end ?></span>	
														<?php } ?>
													</div>
												</li>	
												<?php } ?>
											</ul>
										<?php } ?>
									</div>	
								<?php } ?>
							<?php } ?>
						</div>
					<?php } ?>
					</div>
				</div>

			<?php } else { ?>
				
				<div class="subhead">
					<h2 class="event-date">No Scheduled Activity Today</h2>
				</div>
			
			<?php } ?>

		</div>

</div><!-- #primary -->

<?php
get_footer();
