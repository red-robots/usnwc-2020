<?php
// Check value exists.
 if ( have_rows('section_type') ) :

    // Loop through rows.
    while ( have_rows('section_type') ) : the_row(); 
    	$cards = get_sub_field('card');
    	// $sTitle = get_sub_field('section_title');
    	$parallax = get_sub_field('parallax');

    	// echo '<pre>';
    	// print_r($cards);
    	// echo '</pre>';



    	if( get_row_layout() == 'section_title' ): 
    		$sTitle = get_sub_field('title');
            $sDesc = get_sub_field('short_description');
            $sani = sanitize_title_with_dashes($sTitle);
    		?>
    		<section class="section-title" id="section-<?php echo $sani; ?>" data-section="<?php echo $sTitle; ?>">
    			<h2><?php echo $sTitle; ?></h2>
                <?php if( $sDesc ){ echo '<p>'.$sDesc.'</p>';} ?>
    		</section>


    	<?php
    	elseif( get_row_layout() == 'alternating_cards' ): ?>
    		
    		<?php foreach( $cards as $c ) {
    			$creative = $c['creative'];
    			$title = $c['title'];
    			$description = $c['description'];
    			$cta = $c['cta'];
    			?>
    			<section class="child-card"  >
    				<div class="creative image-container">
                        <div class="full-bleed-img" style="--aspect-ratio: 16/9">
    					<img src="<?php echo $creative['url']; ?>">
                        </div>
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
        elseif( get_row_layout() == 'full_bleed_image' ):
            $fb_image = get_sub_field('full_image');
            ?>
            <section class="full-bleed">
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
    	<?php endif;
endwhile; 
else:
endif;