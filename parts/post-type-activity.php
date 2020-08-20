<?php 
$postid = get_the_ID();
while ( have_posts() ) : the_post(); 
	$top_notification = get_field("top_notification");
	$main_description = get_field("activity_descr");
	$taxonomy = 'pass_type';
	$categories = get_the_terms($postid,$taxonomy);
	$catSlugs = array();
	if($categories) {
		foreach($categories as $c) {
			$catSlugs[] = $c->slug;
		}
	}

	/* Show description if category slug is 'all-access-pass' */
	$show_main_description = false;
	if( $categories &&  in_array('all-access-pass',$catSlugs) ) {
		$show_main_description = true;
	}

	$pageTabs = array('intro','options','what to wear','check-in','faq');
	?>
	
	<?php if ($show_main_description && $main_description) { ?>
	<section class="main-description">
		<div class="wrapper text-center">
			<h1 class="pagetitle"><span><?php echo get_the_title(); ?></span></h1>
			<?php echo $main_description ?>
		</div>
	</section>
	<?php } ?>

	<div id="pageTabs"></div>


	<?php 
	/* INTRO */
	$galleries = '';
	$galleryData = get_field("gallery_content");
	if( isset($galleryData['g_images']) && $galleryData['g_images'] ) {
		$galleries = $galleryData['g_images'];
	}
	$left_icon = ( isset($galleryData['g_icon']) && $galleryData['g_icon'] ) ? $galleryData['g_icon']:'';
	$left_text = ( isset($galleryData['g_description']) && $galleryData['g_description'] ) ? $galleryData['g_description']:'';
	$introClass = ($left_text && $galleries) ? 'half':'full';
	$placeholder = THEMEURI . 'images/rectangle.png';
	?>

	<?php if ($left_text || $galleries) { ?>
	<section id="section-intro" data-section="Intro" class="section-content intro-galleries <?php echo $introClass ?>">
		<div class="flexwrap">
			<?php if ($left_text) { ?>
			<div class="leftcol textcol">
				<div class="wrap">
					<div class="inner">
						<?php if ($left_icon) { ?>
						<div class="icon-col">
							<span style="background-image:url('<?php echo $left_icon['url'] ?>')"></span>
						</div>	
						<?php } ?>
						<?php echo $left_text ?>	
					</div>	
				</div>
			</div>	
			<?php } ?>

			<?php if ($galleries) { 
				$count = count($galleries); 
				$slider_class = ($count>1) ? 'subpage-sliders':'subpage-slider-static';
				?>
			<div id="subpageSlides" class="rightcol <?php echo $slider_class ?>">
				<ul class="slides">
					<?php foreach ($galleries as $g) { ?>
					<li class="sub-slide-item">
						<div class="slide-image" style="background-image:url('<?php echo $g['url']?>')">
							<img src="<?php echo $placeholder ?>" alt="">
						</div>
					</li>	
					<?php } ?>
				</ul>
			</div>	
			<?php } ?>
		</div>
	</section>	
	<?php } ?>


	<?php  
	/* OPTIONS */
	$activities = get_field("activities");
	$options_class = ($activities && $categories) ? 'half':'full';
	$legend = get_field("activity_legend","option");
	if($activities || $categories) { ?>
	<section id="section-options" data-section="Options" class="section-content <?php echo $options_class ?>">
		<div class="wrapper">
			<?php if ($activities) { ?>
			<div class="optcol activities">
			
				<?php if ($legend) { ?>
				<div class="legend-for-mobile">
					<?php foreach ($legend as $e) { 
						$color = $e['color'];
						$level = $e['level'];
						if($color && $level) { ?>
						<div class="levelblock"><span class="level"><em class="right"><span><?php echo $color ?></span></em><em class="left"><?php echo $level ?></em></span></div>
						<?php } ?>
					<?php } ?>
				</div>
				<?php } ?>

				<div class="flex-items">
					<div id="items-head" class="item headings">
						<div class="cell hd1">Options</div>
						<div class="cell hd2">
							<?php if ($legend) { ?>
								<span class="txt">Difficulty <i id="legend-info">i</i></span>
								<span id="legendData" class="legend">
									<?php foreach ($legend as $e) { 
										$color = $e['color'];
										$level = $e['level'];
										if($color && $level) { ?>
										<span><em class="right"><?php echo $color ?></em><em class="left"><?php echo $level ?></em></span>
										<?php } ?>
									<?php } ?>
								</span>
							<?php } else { ?>
								Difficulty
							<?php } ?>
						</div>
						<div class="cell hd3">Age</div>
					</div>

					<?php $i=1; foreach ($activities as $a) {
						$a_name = $a['name'];
						$a_description = $a['description'];
						$a_difficulty = $a['difficulty'];
						$a_qualifiers = $a['qualifiers'];
						$a_show = $a['show']; 
						$show_this_option = ($a_show=='yes') ? true : false;
						if($show_this_option) { ?>
						<div id="item-<?php echo $i?>" class="item">

							<?php /* OPTIONS */ ?>
							<?php if ($a_name) { ?>
								<div class="item-title"><h2 class="type"><?php echo $a_name ?></h2></div>
							<?php } ?>
							<div class="cell desc-col">
								<?php if ($a_description) { ?>
								<div class="desc"><?php echo $a_description ?></div>	
								<?php } ?>
							</div>
							
							<?php /* DIFFICULTY */ ?>
							<div class="cell diff-col">
								<span class="cell-label">Difficulty:</span>
								<?php if ($a_difficulty) { ?>
									<?php foreach ($a_difficulty as $diff) { 
										$dSlug = sanitize_title($diff); ?>
										<span class="diff <?php echo $dSlug ?>"></span>
									<?php } ?>
								<?php } ?>
							</div>

							<?php /* AGE */ ?>
							<div class="cell age-col">
								<span class="cell-label">Age:</span>
								<?php if ($a_qualifiers) { ?>
								<span class="age"><?php echo $a_qualifiers ?></span>
								<?php } ?>
							</div>
						</div>	
						<?php $i++; } ?>
					<?php } ?>
				</div>

			</div>	
			<?php } ?>

			<?php 
			$purchase_link = get_field("purchase_link");
			$reservation = get_field("reservation_data");
			?>
			<?php if ($categories || $reservation) { ?>
			<div class="optcol categories">
				<?php if ($categories) { ?>
					<div class="inner graybox">
						<h2 class="box-title">Pass Options</h2>
						<div class="box-content">
							<ul class="cats">
							<?php foreach ($categories as $cat) {
								$cat_id = $cat->term_id;
								$pass_types = get_pass_type_category($cat_id); 
								$pass_types_list = '';
								if($pass_types) {
									foreach($pass_types as $k=>$v) {
										$comma = ($k>0) ? ', ':'';
										$pass_types_list .= $comma . ucwords( strtolower($v->post_title)); 
									}
								}
								?>
								<li class="cat-item">
									<span class="icon"></span>
									<span class="catName">
										<?php echo $cat->name; ?>
										<?php if ($pass_types_list) { ?>
										<small>(<?php echo $pass_types_list ?>)</small>	
										<?php } ?>
									</span>
								</li>
							<?php } ?>
							</ul>

							<?php if ($purchase_link) { 
								$btn_title = $purchase_link['title'];
								$btn_link = $purchase_link['url'];
								$btn_target = $purchase_link['target'];
								$target = ($btn_target) ? ' target="'.$btn_target.'"':'';
							?>
							<div class="button text-center">
								<a href="<?php echo $btn_link ?>" class="btn-border"<?php echo $target ?>>
									<span><?php echo $btn_title ?></span>
								</a>
							</div>	
							<?php } ?>
						</div>
					</div>
				<?php } ?>

				<?php if ($reservation) {
					$res_title =  ( isset($reservation['title']) && $reservation['title'] ) ? $reservation['title']:'';
					$res_text =  (isset($reservation['text']) && $reservation['text']) ? $reservation['text']:'';
					$res_button =  ( isset($reservation['button']) && $reservation['button'] ) ? $reservation['button']:'';
					$res_target = ( isset($res_button['target']) && $res_button['target'] ) ? ' target="'.$res_button['target'].'"':'';
					?>
					<div class="inner redbox">
						<div class="wrap">
							
							
							<?php if ($res_text || $res_button || $res_title) { ?>
								<div class="box-content">
									<div class="inner-wrap">
										<?php if ($res_title) { ?>
											<h2 class="box-title"><?php echo $res_title ?></h2>
										<?php } ?>
										<?php if ($res_text) { ?>
											<div class="text"><?php echo $res_text ?></div>
										<?php } ?>
										<?php if ($res_button) { ?>
											<div class="button">
												<a href="<?php echo $res_button['link'] ?>" class="btn-border-white"<?php echo $res_target ?>>
													<span><?php echo $res_button['title'] ?></span>
												</a>
											</div>
										<?php } ?>
									</div>
								</div>
							<?php } ?>

						</div>
					</div>	
				<?php } ?>
			</div>	
			<?php } ?>
		</div>
	</section>
	<?php } ?>


	<?php
	/* WHAT TO WEAR */ 
	$wtw_section_title = get_field("wtw_section_title");  
	$wtw_default_image = get_field("wtw_default_image");  
	$wtw_options = get_field("wtw_options");  
	$wtw_class = ($wtw_default_image && $wtw_options) ? 'half':'full';
	if ($wtw_options) { ?>
	<section id="section-whattowear" data-section="What To Wear" class="section-content <?php echo $wtw_class ?>">
		<div class="wrapper">
			<div class="flexwrap">
				<?php if ($wtw_default_image) { ?>
				<div class="col model">
					<div id="defaultModel" class="default" data-default="<?php echo $wtw_default_image['url'] ?>" style="background-image:url('<?php echo $wtw_default_image['url'] ?>')">
						<?php if ($wtw_options) { ?>
							<?php $i=1; foreach ($wtw_options as $m) { 
								$wImg = $m['w_image']; 
								if($wImg) { ?>
								<div id="partImg<?php echo $i?>" class="part partImg animated" data-src="<?php echo $wImg['url'] ?>" style="background-image:url('<?php echo $wImg['url'] ?>')"></div>
								<?php } ?>
							<?php $i++; } ?>
						<?php } ?>
					</div>
				</div>	
				<?php } ?>

				<?php if ($wtw_options) { ?>
				<div class="col options">
					<?php if ($wtw_section_title) { ?>
					<div class="titlediv"><h2 class="sectionTitle"><?php echo $wtw_section_title ?></h2></div>	
					<?php } ?>

					<?php if ($wtw_options) { ?>
					<div class="wtw-options">
						<?php $n=1; foreach ($wtw_options as $m) { 
							$title = $m['w_title'];
							$description = $m['w_text'];
							$image_part = $m['w_image']; 
							$hasMapImage = ($image_part) ? 'has-map-image':'no-map-image';
							if($title) { ?>
							<div id="wtw<?php echo $n?>" data-part="#partImg<?php echo $n?>" class="wtw-row collapsible <?php echo $hasMapImage ?><?php echo ($n==1) ? ' first':''; ?>">
								<?php if ($title) { ?>
									<h3 class="option-name"><?php echo $title ?> <span class="arrow"></span></h3>
								<?php } ?>

								<?php if ($description) { ?>
									<div class="option-text"><?php echo $description ?></div>
								<?php } ?>
							</div>
							<?php } ?>
						<?php $n++; } ?>
					</div>	
					<?php } ?>
				</div>	
				<?php } ?>
			</div>
		</div>
	</section>
	<?php } ?>

	
<?php endwhile; ?>


	
	<?php
	/* CHECK-IN */ 
	$rectangle = THEMEURI . "images/rectangle.png";
	$square = THEMEURI . "images/square.png";
	$checkin_images = array();
	$checkin_rows = array();
	if( have_rows('checkin_box') ) { 
		$ctr=0; while ( have_rows('checkin_box') ) : the_row(); 
			$has_text = get_sub_field('has_text'); 
			$has_text = ($has_text=='yes') ? true : false;
			$text = get_sub_field('flex_content'); 
			$c_img = get_sub_field('flex_image'); 
			if( ($has_text && $text) || $c_img ) {
				$checkin_rows[] = $ctr;
			}
		$ctr++; endwhile;

		$countImages = ($checkin_rows) ? count($checkin_rows) : 0;
		$checkin_classes = '';
		if($countImages==1) {
			$checkin_classes = ' has-one-image';
		}
		if($countImages==2) {
			$checkin_classes = ' has-two-images';
		}
	?>
	<section id="section-checkin" data-section="Check-In" class="section-content<?php echo $checkin_classes;?>">
		<div class="wrapper-full">
			<div class="flexwrap">
				<?php  $i=1; while ( have_rows('checkin_box') ) : the_row(); 
					$has_text = get_sub_field('has_text'); 
					$has_text = ($has_text=='yes') ? true : false;
					$image = get_sub_field('flex_image'); 
					$text = get_sub_field('flex_content'); 
					$classList = '';
					$flex_class = '';
					$has_text_image = false;
					$verbiage = '';
					if($has_text && $text) {
						$verbiage = ($text) ? $text : '';
						$classList = ($text && $image) ? ' text-and-image':'';
						$classList .= ' has-text ';
						if($text && $image) {
							$has_text_image = true;
						}
					}
					if($image) {
						$classList .= ' has-image';
					}
					?>

					<?php /* LEFT COLUMN */ ?>
					<?php if($i==1) { ?>
					<div class="col-left">
					<?php } ?>

					<?php if($i<3) { ?>
					<div class="flex-content largebox <?php echo $flex_class.$classList ?>">
						<div class="inside">
						<?php if ($has_text_image) { ?>
							<div class="imagediv" style="background-image:url('<?php echo $image['url'] ?>')">
								<img src="<?php echo $rectangle ?>" alt="">
							</div>
							<div class="caption">
								<div class="text"><?php echo $verbiage ?></div>
							</div>
						<?php } else { ?>
							
							<?php if ($verbiage) { ?>
								<div class="caption">
									<div class="text"><?php echo $verbiage ?></div>
								</div>
							<?php } ?>

							<?php if ($image) { ?>
								<div class="image-only" style="background-image:url('<?php echo $image['url'] ?>')">
									<img src="<?php echo $image['url'] ?>" alt="<?php echo $image['title'] ?>">
								</div>
							<?php } ?>

						<?php } ?>
						</div>
					</div>
					<?php } ?>
					
					<?php if($i==2) { ?>
					</div>
					<?php } ?>

					
					<?php /* RIGHT COLUMN */ ?>
					<?php if($i==3) { ?>
					<div class="col-right">
						<div class="flex-content largebox <?php echo $flex_class.$classList ?>">
							<div class="inside">
							<?php if ($has_text_image) { ?>
								<div class="imagediv" style="background-image:url('<?php echo $image['url'] ?>')">
									<img src="<?php echo $rectangle ?>" alt="">
								</div>
							<?php } else { ?>
								<?php if ($verbiage) { ?>
									<div class="caption">
										<div class="text"><?php echo $verbiage ?></div>
									</div>
								<?php } ?>

								<?php if ($image) { ?>
									<div class="image-only" style="background-image:url('<?php echo $image['url'] ?>')">
										<img src="<?php echo $image['url'] ?>" alt="<?php echo $image['title'] ?>" class="actual">
									</div>
								<?php } ?>
							<?php } ?>
							</div>
						</div>
					</div>
					<?php } ?>

				<?php $i++; endwhile; ?>
			</div>
		</div>
	</section>
	<?php } ?>


	<?php /* FAQ */ ?>
	<?php 
	$faq_image = get_field("faq_image"); 
	//$faqsIds = get_faqs_by_single_post($postid);
	//$faqs = get_faqs_by_assigned_page_id($faqsIds);
	$faqs = get_faq_listings($postid);
	$faq_class = ($faqs && $faq_image) ? 'half':'full';
	if($faqs) { ?>
	<section id="section-faqs" data-section="FAQ" class="section-content <?php echo $faq_class ?>">
		<div class="wrapper">
			<div class="flexwrap">

				<div class="col faqs">
					<div class="titlediv"><h2 class="sectionTitle">FAQ</h2></div>
					<div class="faqsItems">
						<?php foreach ($faqs as $q) { 
							$faq_id = $q['ID'];
							$faq_title = $q['title'];
							$faq_items = $q['faqs'];
							if($faq_items) { ?>
								<div id="faq-<?php echo $faq_id?>" class="faq-group">
									<?php $n=1; foreach ($faq_items as $f) { 
										$question = $f['question'];
										$answer = $f['answer'];
										$isFirst = ($n==1) ? ' first':'';
										if($question && $answer) { ?>
										<div class="faq-item collapsible<?php echo $isFirst ?>">
											<h3 class="option-name"><?php echo $question ?><span class="arrow"></span></h3>
											<div class="option-text"><?php echo $answer ?></div>
										</div>
										<?php } ?>

									<?php $n++; } ?>
								</div>
							<?php } ?>
						<?php } ?>
					</div>	
				</div>

				<?php if ($faq_image) { ?>
				<div class="col faq-image">
					<img src="<?php echo $faq_image['url'] ?>" alt="<?php echo $faq_image['title'] ?>" />
				</div>
				<?php } ?>
			</div>
		</div>
	</section>
	<?php } ?>

	<?php /* Featured Articles */ ?>
	<?php get_template_part("parts/bottom-content-activity"); ?>


<script>
jQuery(document).ready(function ($) {
	$(document).on("click",".wtw-options .collapsible",function(){
		//var parent = $(this).parents(".collapsible")
		var image_part = $(this).attr("data-part");
		var default_image = ( $("#defaultModel").length> 0 ) ? $("#defaultModel").attr('data-default') : '';

		if( $(this).hasClass('active') ) {
			$(this).removeClass("active fadeIn");
			$(".partImg").removeClass("fadeIn");
		} else {
			$(".wtw-options .collapsible").removeClass("active fadeIn");
			$(this).addClass("active fadeIn");

			if( default_image ) {
				if( $(image_part).length > 0 ) {
					var img_src = $(image_part).attr('data-src');
					$(".partImg").removeClass("fadeIn");
					$(image_part).addClass("fadeIn");
				} else {
					$(".partImg").removeClass("fadeIn");
				}
			}
		}		

		
	}); 

	/* FAQS */
	$(".faqsItems .collapsible").on("click",function(){

		if( $(this).hasClass('active') ) {
			$(this).removeClass("active fadeIn");
		} else {
			$(".faqsItems .collapsible").removeClass("active fadeIn");
			$(this).addClass("active fadeIn");
		}
		
	}); 

	if( $(".col.options").length>0 && $("#defaultModel").length>0 ) {
		var optionsHeight = $(".col.options").height();
		$("#defaultModel").css("height",optionsHeight+"px");
	}

	/* page anchors */
	if( $('[data-section]').length > 0 ) {
		var tabs = '';
		$('[data-section]').each(function(){
			var name = $(this).attr('data-section');
			var id = $(this).attr("id");
			tabs += '<a href="#'+id+'">'+name+'</a>';
		});
		$("#pageTabs").html('<div class="wrapper"><div id="tabcontent">'+tabs+'</div></div>');
	}


	$("#legend-info").on("click",function(){
		$("#legendData").toggleClass('show');
	});
	$(document).on("click",function(e) {
    var selectors = ['#legend-info','#legendData'];
    var target = e.target;
    var is_legend = [];
    if( $(target).attr("id")!=undefined && $(target).attr("id")=='legend-info' ) {
    	is_legend.push(1);
    }

    $(target).parents().each(function(k,v){
    	if( $(this).hasClass("legend") ) {
    		is_legend.push(1);
    	}
    });

    if(is_legend.length==0) {
    	$("#legendData").removeClass('show');
    }
});
	
});
</script>