<?php
$placeholder = THEMEURI . 'images/rectangle.png';
// Check value exists.
 if ( have_rows('section_type') ) :

    // Loop through rows.
    while ( have_rows('section_type') ) : the_row(); 
    	$cards = get_sub_field('card');
        $card_w_anchor = get_sub_field('card_w_anchor');
    	// $sTitle = get_sub_field('section_title');
    	$parallax = get_sub_field('parallax');

    	// echo '<pre>';
    	// print_r($cards);
    	// echo '</pre>';



    	if( get_row_layout() == 'section_title' ): 
    		$sTitle = get_sub_field('title');
            // $dataTitle = get_sub_field();
            $anchor_name = get_sub_field('anchor_name');
            $sDesc = get_sub_field('short_description');
            $link_type = get_sub_field('link_type');
            $popup_button_text = get_sub_field('popup_button_text');
            $popup_contents = get_sub_field('popup_contents');
            $sLink = get_sub_field('calls_to_action_buttons');
            $pop_unique = sanitize_title_with_dashes($popup_button_text);
            if( $anchor_name ) {
                $sani = sanitize_title_with_dashes($anchor_name);
                $dataTitle = $anchor_name;
            } else {
                $sani = sanitize_title_with_dashes($sTitle);
                $dataTitle = $sTitle;
            }
    		?>
    		<section class="section-title" id="section-<?php echo $sani; ?>" data-section="<?php echo $dataTitle; ?>">
    			<h2><?php echo $sTitle; ?></h2>
                <?php if( $sDesc ){ echo '<p class="sdesc">'.$sDesc.'</p>';} ?>
                <?php if( $sLink ){ 
                    // echo '<pre>';
                    // print_r($sLink);
                    // echo '</pre>';

                    ?>
                    <br>
                    <?php if( $link_type == 'popup' ){ ?>
                        <div class="button">
                            <a href="#view-this-shit" class="btn-sm inline <?php echo $pop_unique; ?>">
                                <span><?php echo $popup_button_text; ?></span>
                            </a>
                        </div>
                    <?php } else { ?>
                        <div class="btn-wrapper">
                            <?php foreach( $sLink as $nLink ){ ?>
                                <div class="button">
                                    <a href="<?php echo $nLink['cta_link']['url']; ?>" target="<?php echo $nLink['cta_link']['target']; ?>" class="btn-sm">
                                        <span><?php echo $nLink['cta_link']['title']; ?></span>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                <?php } ?>
                <div style="display: none;">
                    <div id="" class="pup-rules <?php echo $pop_unique; ?> inline">
                        <?php echo $popup_contents; ?>
                    </div>
                </div>
                <script type="text/javascript">
                    // $('.inline').colorbox({
                    //     inline:true, 
                    //     width:"50%",
                    //     // href:".instr",
                    //     // innerWidth: 300
                    //   });
                </script>
    		</section>


    	<?php
    	elseif( get_row_layout() == 'alternating_cards' ): ?>
    		
    		<?php foreach( $cards as $c ) {

    			$media_type = $c['media_type'];
                $creative = $c['creative'];
    			$title = $c['title'];
    			$description = $c['description'];
    			$cta = $c['cta'];
                $gallery = $c['gallery'];
                $video = $c['video'];
    			?>
    			<section class="child-card" id="ho"  >
    				<div class="creative image-container">
                         <?php if( $media_type == 'gallery' ) { ?>
                            <div id="subpageSlides" class="subpageSlides rightcol <?php echo $slider_class ?>">
                                <ul class="slides">
                                    <?php foreach ($gallery as $g) { ?>
                                    <li class="sub-slide-item">
                                        <a href="<?php echo $g['url'] ?>" class="zoomPic zoom-image" data-fancybox="gallery">
                                            <div class="slide-image" style="background-image:url('<?php echo $g['url']?>')">
                                                <img src="<?php echo $g['url']?>" alt="">
                                            </div>
                                        </a>
                                    </li>   
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php } elseif( $media_type == 'video' ) { ?>
                            <div class="embed-container">
                                <?php echo $video; ?>
                            </div>
                        <?php } else { ?>
                            <div class="full-bleed-img">
                               <img src="<?php echo $creative['url']; ?>">
                            </div>
                        <?php } ?>
                    </div>
    				<div class="info wow fadeIn" data-wow-duration="2s" data-wow-delay="0.5s">
    					<h2><?php echo $title; ?></h2>
            			<div class="desc"><?php echo $description; ?></div>
            			<div class="btn-wrapper">
		    				<?php if( $cta ){ ?>
		            			<div class="button">
		            				<a href="<?php echo $cta['url']; ?>" target="<?php echo $cta['target']; ?>" class="btn-sm">
		            					<span><?php echo $cta['title']; ?></span>
		            				</a>
		            			</div>
		            		<?php } ?>
		            	</div>
    				</div>

    			</section>
    			
    		<?php } ?>


            <?php
        elseif( get_row_layout() == 'alternating_cards_with_anchors' ): ?>
            
            <?php foreach( $card_w_anchor as $c ) {
                $media_type_w = $c['media_type'];
                $creative_w = $c['creative'];
                $title_w = $c['title'];
                $description_w = $c['description'];
                $cta_w = $c['cta'];
                $gallery_w = $c['gallery'];
                $video_w = $c['video'];

                    $sani_w = sanitize_title_with_dashes($title_w);
                    $dataTitle_w = $title_w;
                
                ?>
                <section class="child-card"  id="section-<?php echo $sani_w; ?>" data-section="<?php echo $dataTitle_w; ?>" >
                    <div class="creative image-container">
                         <?php if( $media_type_w == 'gallery' ) { ?>
                            <div id="subpageSlides" class="subpageSlides rightcol <?php echo $slider_class ?>">
                                <ul class="slides">
                                    <?php foreach ($gallery_w as $g) { ?>
                                    <li class="sub-slide-item">
                                        <a href="<?php echo $g['url'] ?>" class="zoomPic zoom-image" data-fancybox="gallery">
                                            <div class="slide-image" style="background-image:url('<?php echo $g['url']?>')">
                                                <img src="<?php echo $g['url']?>" alt="">
                                            </div>
                                        </a>
                                    </li>   
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php } elseif( $media_type_w == 'video' ) { ?>
                            <div class="embed-container">
                                <?php echo $video_w; ?>
                            </div>
                        <?php } else { ?>
                            <div class="full-bleed-img" >
                               <img src="<?php echo $creative_w['url']; ?>">
                            </div>
                        <?php } ?>
                    </div>
                    <div class="info wow fadeIn" data-wow-duration="2s" data-wow-delay="0.5s">
                        <h2><?php echo $title_w; ?></h2>
                        <div class="desc"><?php echo $description_w; ?></div>
                        <div class="btn-wrapper">
                            <?php if( $cta_w ){ ?>
                                <div class="button">
                                    <a href="<?php echo $cta_w['url']; ?>" target="<?php echo $cta_w['target']; ?>" class="btn-sm">
                                        <span><?php echo $cta_w['title']; ?></span>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                </section>
                
            <?php } ?>

    		
        <?php
        elseif( get_row_layout() == 'full_bleed_image' ):
            $fb_image = get_sub_field('full_image');
            $fb_image_title = get_sub_field('title');
            $fb_image_icon = get_sub_field('icon');
            if( $fb_image_title ) {
                $fb_sani = sanitize_title_with_dashes($fb_image_title);
                $fb_dataTitle = $fb_image_title;
            }
            ?>
            <section class="full-bleed"  id="section-<?php echo $fb_sani; ?>" data-section="<?php echo $fb_dataTitle; ?>" >
                <div class="wrapper">
                    <div class="icon">
                        <img src="<?php echo $fb_image_icon['url']; ?>">
                    </div>
                    <h2 class="stitle"><?php echo $fb_image_title; ?></h2>
                </div>
                
                <div class="full-bleed-img " style="--aspect-ratio: 16/9">
                    <img src="<?php echo $fb_image['url']; ?>">
                </div>
            </section>

    	<?php 
    	elseif( get_row_layout() == 'parallax' ):
    		$title = get_sub_field('title');
    		$description = get_sub_field('description');
    		$pImage = get_sub_field('background_image');
    		$textColor = get_sub_field('text_color');
    		if( $textColor == 'white' ){
    			$tC = '#fff;';
    		} else {
    			$tC = '#000;';
    		}
    		?>
    		
    		<!-- <div class="parallax h">
    			
    			<div class="hero__inner">
    				<div class="hero__images">
    					<img src="<?php echo $pImage['url']; ?>" alt="<?php echo $pImage['alt']; ?>" class="hero__image">
    				</div>
    				<div class="hero__content">
    					<div class="hero__headline">
	    				<span>
	    					<?php if( $title ){ ?>
		    					<h3 style="color:<?php echo $tC; ?>">
		    						<?php echo $title; ?>
		    					</h3>
		    				<?php } ?>
	    				</span>
	    				</div>
	    			</div>
    			</div>
    		</div> -->
            <section class="fullwidth-image">
                <div class="fullwidth-image__overlay"></div>
                <div class="fullwidth-image__text zzz">
                  <?php if( $title ){ ?>
                        <h3 style="color:<?php echo $tC; ?>">
                            <?php echo $title; ?>
                        </h3>
                        <!-- <h3 style="color:<?php echo $tC; ?>" class="mobile"><?php echo $title; ?></h3> -->
                    <?php } ?>
                </div>
                <img src="<?php echo $pImage['url']; ?>" alt="<?php echo $pImage['alt']; ?>" class="hero__image">
            </section>
    		

    	<?php
    	elseif( get_row_layout() == 'mailchimp_signup' ):
    		$mc_form = get_sub_field('form');
    		$mc_title = get_sub_field('title');
    		$mc_desc = get_sub_field('description');

    		if( $mc_form == 'general' ) { 
    			include( locate_template('parts/mc-embed-form.php') );
    		} ?>
    	<?php
    	elseif( get_row_layout() == 'video' ):
    		$vid_url = get_sub_field('video');
    		?>
    		<div class="video-wrapper">
	    		<video class="desktop" autoPlay loop muted playsinline  poster="https://center.whitewater.org/wp-content/uploads/2023/02/Homepage-Spring-02.jpg">
					<source src="<?php echo $vid_url['url']; ?>" type="video/mp4">
				</video>
			</div>
        <?php elseif( get_row_layout() == 'faqs'): 
                $faq_icon = get_sub_field('faq_section_icon');
                $faq_title = get_sub_field('faq_section_title');
                $faq_items = get_sub_field('the_faqs');

                // echo '<pre>';
                // print_r($faq_items);
                // echo '</pre>';
            ?>
            <section id="section-faqs" data-section="FAQ" class="section-content no-image faqs-race">
                <div class="wrapper">
                    <div class="col faqs">
                        
                        <?php if ($faq_title) { ?>
                        <div class="titlediv">
                            <?php if ($faq_icon) { ?>
                                <div class="icon-img text-center"><span style="background-image:url('<?php echo  $faq_icon['url']?>')"></span></div>
                            <?php } ?>
                            <h2 class="sectionTitle text-center"><?php echo $faq_title ?></h2>
                        </div>
                        <?php } ?>

                        <div class="faqsItems">
                            <?php //foreach ($faqs as $q) { 
                                // $faq_id = $q['ID'];
                                // $faq_title = $q['title'];
                                // $faq_items = $q['faqs'];
                                if($faq_items) { ?>
                                        <?php $n=1; foreach ($faq_items as $f) { 
                                            $question = $f['question'];
                                            $answer = $f['answer'];
                                            $isFirst = ($n==1) ? ' first':'';
                                            if($question && $answer) { ?>
                                            <div class="faq-item collapsible <?php echo $isFirst ?>">
                                                <h3 style="text-align: left;" class="option-name"><?php echo $question ?><span class="arrow"></span></h3>
                                                <div style="text-align: left;" class="option-text"><?php echo $answer ?></div>
                                            </div>
                                            <?php } ?>

                                        <?php $n++; } ?>
                                   
                                <?php } ?>
                            <?php //} ?>
                        </div>  

                    </div>
                </div>

            </section>
    	<?php endif;
endwhile; 
else:
endif;