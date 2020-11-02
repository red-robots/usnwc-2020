<?php 
$res = update_post_status_if_expired();
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Nunito+Sans:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?php bloginfo("template_url") ?>/css/jquery.fancybox.min.css">


<?php if ( is_singular(array('post')) ) { 
global $post;
$post_id = $post->ID;
$thumbId = get_post_thumbnail_id($post_id); 
$featImg = wp_get_attachment_image_src($thumbId,'full'); ?>
<!-- SOCIAL MEDIA META TAGS -->
<meta property="og:url"		content="<?php echo get_permalink(); ?>" />
<meta property="og:type"	content="article" />
<meta property="og:title"	content="<?php echo get_the_title(); ?>" />
<meta property="og:description"	content="<?php echo (get_the_excerpt()) ? strip_tags(get_the_excerpt()):''; ?>" />
<?php if ($featImg) { ?>
<meta property="og:image"	content="<?php echo $featImg[0] ?>" />
<?php } ?>
<!-- end of SOCIAL MEDIA META TAGS -->
<?php } ?>

<script defer src="<?php bloginfo( 'template_url' ); ?>/assets/svg-with-js/js/fontawesome-all.js"></script>
<script>var currentURL = '<?php echo get_permalink();?>';</script>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site cf">
	<div id="overlay"></div>
	<a class="skip-link sr" href="#content"><?php esc_html_e( 'Skip to content', 'bellaworks' ); ?></a>

	<?php
	/* NAVIGATION */
	get_template_part("parts/navigation");
	?>


	<div class="topbar">
		<div class="wrapper">
			<?php
			$trail_status_option = get_field("trail_status","option");
			$trail_status = ($trail_status_option=='open') ? 'active':'inactive';
			$toplink = get_field("toplink","option");
			?>
			<div class="topinfo">
				<span class="trail-status el <?php echo $trail_status ?>">
					<span class="t">Trail Status</span>
					<span class="s"></span>
				</span>
				<span id="todayLink" class="today el">
					<?php $today_options = get_field("today","option"); ?>
					<?php if ($today_options) { ?>
						<a href="#" id="todayToggle" class="spanlink"><i id="todayTxt" class="txt">TODAY</i><i class="arrow"></i></a>
						<div id="businessHours" class="businessHours">
							<ul id="today-options" class="today-options">
								<?php foreach ($today_options as $t) { 
									$text1 = $t['text1'];
									$text2 = $t['text2'];
									$link = $t['link'];
									$icon_class = ($t['icon_class']) ? $t['icon_class']:'no-icon';
									$link_open = '';
									$link_close = '';
									if($link) {
										$target = (isset($link['target']) && $link['target']) ? $link['target']:'_self';
										$link_open = '<a href="'.$link['url'].'" target="'.$target.'" class="tdlink">';
										$link_close = '</a>';
									}
								?>
								<li class="info <?php echo ($t['icon_class']) ? 'hasIcon':'noIcon'; ?>">
									<div class="icon"><i class="<?php echo $icon_class ?>"></i></div>
									<div class="text">
										<?php echo $link_open; ?>
											<?php if ($text1) { ?>
											<div class="n t1"><?php echo $text1 ?></div>
											<?php } ?>
											<?php if ($text2) { ?>
											<div class="d t2"><?php echo $text2 ?></div>
											<?php } ?>
										<?php echo $link_close; ?>
									</div>
								</li>
								<?php } ?>
							</ul>
						</div>
					<?php } ?>
				</span>
				<span class="srchLink el">
					<a id="searchHereBtn" class="search"><i class="fas fa-search"></i></a>
				</span>
			</div>
		</div>
	</div>

	<header id="masthead" class="site-header" role="banner">
		
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
	</header><!-- #masthead -->

	<?php get_template_part("parts/slideshow"); ?>

	<div id="content" class="site-content">
