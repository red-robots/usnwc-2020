<?php if ( isset($_GET['cron']) && $_GET['cron']=='1' ) { ?>
	<?php echo 'CRON JOB IS RUNNING!!!!'; ?>
<?php } ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<!-- <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet"> -->
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Nanum+Gothic:wght@400;700;800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<script defer src="<?php bloginfo( 'template_url' ); ?>/assets/svg-with-js/js/fontawesome-all.js"></script>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site cf">
	<a class="skip-link sr" href="#content"><?php esc_html_e( 'Skip to content', 'bellaworks' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="topbar">
			<div class="wrapper">
				<?php
				$trail_status_option = get_field("trail_status","option");
				$trail_status = ($trail_status_option=='open') ? 'active':'inactive';
				?>
				<div class="topinfo">
					<span class="trail-status el <?php echo $trail_status ?>">
						<span class="t">Trail Status</span>
						<span class="s"></span>
					</span>
					<span class="today el">
						<?php $today_options = get_field("today","option"); ?>
						<?php if ($today_options) { ?>
							<a href="#" id="todayToggle"><i id="todayTxt" class="txt">TODAY</i><i class="arrow"></i></a>
							<div id="businessHours" class="businessHours">
								<ul id="today-options">
									<?php foreach ($today_options as $t) { 
										$text1 = $t['text1'];
										$text2 = $t['text2'];
										$icon_class = ($t['icon_class']) ? $t['icon_class']:'no-icon';
									?>
									<li class="info <?php echo ($t['icon_class']) ? 'hasIcon':'noIcon'; ?>">
										<div class="icon"><i class="<?php echo $icon_class ?>"></i></div>
										<div class="text">
											<?php if ($text1) { ?>
											<div class="n t1"><?php echo $text1 ?></div>
											<?php } ?>
											<?php if ($text2) { ?>
											<div class="d t2"><?php echo $text2 ?></div>
											<?php } ?>
										</div>
									</li>
									<?php } ?>
								</ul>
							</div>
						<?php } ?>
					</span>
					<span class="el">
						<a id="searchHereBtn" class="search"><i class="fas fa-search"></i></a>
					</span>
				</div>
			</div>
		</div>
		<div id="topSearchBar" class="top-search-bar">
			<div class="wrapper">
				<div class="form-wrapper">
					<?php echo get_search_form(); ?>
					<a href="#" id="topsearchBtn"><i class="fas fa-search"></i></a>
					<a href="#" id="closeTopSearch"><span>Close</span></a>
				</div>
			</div>
		</div>
		<div class="navbar">
			<div class="wrapper cf">
				<?php if( get_custom_logo() ) { ?>
		            <div class="logo">
		            	<?php the_custom_logo(); ?>
		            </div>
		        <?php } else { ?>
		            <h1 class="logo">
			            <a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a>
		            </h1>
		        <?php } ?>
				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><span class="sr"><?php esc_html_e( 'MENU', 'bellaworks' ); ?></span><span class="bar"></span></button>
			</div>
		</div>
		<nav id="site-navigation" class="main-navigation" role="navigation">
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<?php get_template_part("parts/home-banner"); ?>

	<div id="content" class="site-content">
