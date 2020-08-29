<?php 
$postid = get_the_ID();
while ( have_posts() ) : the_post(); ?>
	
	<?php if ( get_the_content() ) { ?>
	<section class="main-description">
		<div class="wrapper text-center">
			<h1 class="pagetitle"><span><?php echo get_the_title(); ?></span></h1>
			<div class="main-text"><?php the_content(); ?></div>
		</div>
	</section>
	<?php } ?>

	<div id="pageTabs"></div>

	<?php 
	/* REGISTRATION */
	$register_section_icon = get_field("register_section_icon"); 
	$register_section_title = get_field("register_section_title"); 
	$race_types = get_field("race_types"); 
	$registration_note = get_field("registration_note"); 
	if($register_section_title || $race_types) { ?>
	<section id="section-registration" data-section="Registration" class="section-content">
		
		<?php if ($register_section_title) { ?>
		<div class="title-w-icon">
			<div class="wrapper">
				<?php if ($register_section_icon) { ?>
					<div class="title-icon"><span style="background-image:url('<?php echo $register_section_icon['url']?>')"></span></div>
				<?php } ?>
					<h2><?php echo $register_section_title ?></h2>
			</div>
		</div>
		<?php } ?>


		<?php if ($race_types) { 
			$count = count($race_types); 
			$type_class = 'one-col';
			if($count==2) {
				$type_class = 'two-col';
			} 
			elseif($count==3) {
				$type_class = 'three-col';
			} 
			elseif($count>3) {
				$type_class = 'multi-col';
			}
			?>
		<div class="race-types <?php echo $type_class; ?>">
			<div class="inner-wrap">
				<div class="flexwrap">
					<?php foreach ($race_types as $r) { 
						$name = $r['name'];
						$details = $r['details'];
						$button = $r['button'];
						$button_target = ( isset($button['target']) && $button['target'] ) ? $button['target']:'_self';
						?>
						<div class="type">
							<div class="inside">
								<?php if ($name) { ?>
									<div class="type-name"><h3><?php echo $name ?></h3></div>
								<?php } ?>

								<?php if ($details) { ?>
									<div class="type-details">
										<ul class="info">
											<?php foreach ($details as $d) { 
												$d_title = $d['title'];
												$d_text = $d['text'];
												$d_note = $d['note'];
												if ($d_title) { ?>
												<li>
													<p class="i-title"><?php echo $d_title ?></p>
													<?php if ($d_note) { ?>
													<p class="i-note"><?php echo $d_note ?></p>	
													<?php } ?>
													<?php if ($d_text) { ?>
													<p class="i-text"><?php echo $d_text ?></p>	
													<?php } ?>
												</li>	
												<?php } ?>
											<?php } ?>
										</ul>

										<?php if ($button) { ?>
										<div class="button">
											<a href="<?php echo $button['url'] ?>" target="<?php echo $button_target ?>" class="btn-sm"><span><?php echo $button['title'] ?></span></a>
										</div>
										<?php } ?>
										
									</div>
								<?php } ?>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<?php } ?>


		<?php if ($registration_note) { ?>
		<div class="black-section">
			<div class="wrapper text-center"><?php echo $registration_note; ?></div>
		</div>	
		<?php } ?>
		
	</section>
	<?php } ?>


	<?php 
	/* SCHEDULE */
	$sched_section_icon = get_field("sched_section_icon"); 
	$sched_section_title = get_field("sched_section_title"); 
	$start = get_field("start_date");
	$end = get_field("end_date");
	$event_date = get_event_date_range($start,$end,true);
	if($sched_section_title || $race_types) { ?>
	<section id="section-schedule" data-section="Schedule" class="section-content">
		<?php if ($sched_section_title) { ?>
			<div class="title-w-icon">
				<div class="wrapper">
					<?php if ($sched_section_icon) { ?>
						<div class="title-icon"><span style="background-image:url('<?php echo $sched_section_icon['url']?>')"></span></div>
					<?php } ?>
						<h2><?php echo $sched_section_title ?></h2>
						<?php if ($event_date) { ?>
						<div class="event-date"><?php echo $event_date ?></div>	
						<?php } ?>
				</div>
			</div>
		<?php } ?>

		<?php if ($race_types) { ?>
		<div class="filter-section">
			<div class="wrapper">
				<div class="filterBy">
					<div class="filter-input">
						<span>Filter By</span>
						<select id="race-type-option" class="filter-select">
						<?php $i=1; foreach ($race_types as $r) { 
							$actualName = $r['name']; 
							$alias = $r['alias'];
							$name = ($alias) ? $alias : $actualName;
							$slug = sanitize_title($name);
							$schedule = $r['schedule'];
							?>
							<option value="race-opt<?php echo $i?>"><?php echo $name ?></option>
						<?php $i++; } ?>
						</select>
					</div>
				</div>


				<div class="schedule-information">

					<?php $i=1; foreach ($race_types as $r) { 
						$actualName = $r['name']; 
						$alias = $r['alias'];
						$name = ($alias) ? $alias : $actualName;
						$slug = sanitize_title($name);
						$sched = $r['schedule'];
						$date = ( isset($sched['date']) && $sched['date'] ) ? $sched['date'] : '';
						$day = ($date) ? date('l',strtotime($date)) : '';
						$activities = ( isset($sched['schedule']) && $sched['schedule'] ) ? $sched['schedule'] : '';
						$is_active = ($i==1) ? ' active':'';
						?>
						<div id="race-opt<?php echo $i?>" class="schedule-info schedule <?php echo $is_active ?>">
							<?php if ($day) { ?>
							<div class="day"><span><?php echo $day ?></span></div>	
							<?php } ?>

							<?php if ($activities) { ?>
							<ul class="activities">
								<?php foreach ($activities as $a) { 
									$time = $a['time'];
									$event = $a['action'];
									if($time || $action) { ?>
									<li class="info">
										<div class="wrap">
											<span class="time"><span><?php echo $time ?></span></span>
											<span class="event"><span><?php echo $event ?></span></span>
										</div>
									</li>	
									<?php } ?>
								<?php } ?>
							</ul>	
							<?php } ?>
						</div>
					<?php $i++; } ?>

					
				</div>
			</div>
		</div>
		<?php } ?>

	</section>
	<?php } ?>

<?php endwhile; ?>

<script>
jQuery(document).ready(function($){
	$("#race-type-option").on('change',function(){
		var opt = $(this).val();
		$(".schedule-info").removeClass("active");
		$(".schedule-info#" + opt).addClass('active');
	});
});	
</script>