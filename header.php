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
				<div class="topinfo">
					<span class="trail-status el active">
						<span class="t">Trail Status</span>
						<span class="s"></span>
					</span>
					<span class="today el">
						<a href="#"><i class="txt">TODAY</i><i class="arrow"></i></a>
						<div class="businessHours">
							<ul>
								<li class="info">
									<div class="icon"><i class="ci-clock"></i></div>
									<div class="text">
										<div class="n">Hours of Operation</div>
										<div class="v">8AM - 4AM</div>
										<div class="d">* individual activity times vary</div>
									</div>
								</li>
								<li class="info">
									<div class="icon"><i class="ci-silverware"></i></div>
									<div class="text">
										<div class="n">Food & Beverage</div>
										<div class="v">11AM - 10PM</div>
									</div>
								</li>
								<li class="info">
									<div class="icon"><i class="ci-tshirt2"></i></div>
									<div class="text">
										<div class="n">Outfitters Store</div>
										<div class="v">8AM - 8PM</div>
									</div>
								</li>
							</ul>
						</div>
					</span>
					<span class="el">
						<a class="search"><i class="fas fa-search"></i></a>
					</span>
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
