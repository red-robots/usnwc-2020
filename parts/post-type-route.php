<?php 
$blank_image = THEMEURI . "images/square.png";
$placeholder = THEMEURI . 'images/rectangle.png';
$page_title = get_the_title();
while ( have_posts() ) : the_post(); ?>
	
	<section class="main-description">
    <div class="wrapper text-center">
      <h1 class="pagetitle"><span><?php echo get_the_title(); ?></span></h1>
      <?php if ( $short_description = get_field("short_description") ) { ?>
        <div class="main-text"><?php echo $short_description; ?></div>
      <?php } ?>
    </div>
  </section>
	
	<div id="pageTabs"></div>


  <?php  
  if( have_rows('route') ) { ?>  
  <?php while ( have_rows('route') ) : the_row(); ?>

    <?php //Case: Details with icons ?>
    <?php if ( get_row_layout() == 'detail' ) { 
      
      $detail = get_sub_field('detail');
      if( have_rows('detail') ) { ?>
      <section class="route-details fw-left">
        <div class="wrapper">
          <div class="flexwrap">
          <?php while( have_rows('detail') ): the_row(); 
            $icon = get_sub_field('icon');
            $dTitle = get_sub_field('detail_title');
            $dDesc  = get_sub_field('detail');
            ?>
            <div class="flexcol">
              <?php if ($icon) { ?>
              <div class="icon">
                <img src="<?php echo $icon['url'] ?>" alt="<?php echo $icon['title'] ?>" />
              </div> 
              <?php } ?>

              <?php if ($dTitle) { ?>
              <div class="title"><?php echo $dTitle ?></div> 
              <?php } ?>

              <?php if ($dDesc) { ?>
              <div class="desc"><?php echo $dDesc ?></div> 
              <?php } ?>
            </div>
            <?php endwhile; ?>
          </div>
        </div>
      </section>
      <?php } ?>
    <?php } 

    //Case: Display Map 
    elseif( get_row_layout() == 'map' ) { ?>
      <?php if( $map = get_sub_field('map_shortcode') ) { 
        if( do_shortcode( $map ) ) { ?>
        <section id="route-map" class="route-map fw-left section-content" data-section="Map">
          <div class="shead-icon text-center fw-left">
            <div class="wrapper">
              <div class="icon"><span class="ci-map"></span></div>
              <h2 class="stitle">Map</h2>
            </div>
          </div>
          <div class="map-container fw-left">
            <div class="map-frame"><?php echo do_shortcode( $map ); ?></div>
          </div>
        </section>
        <?php } ?>
      <?php } ?>
    <?php }  

    //Case: Display Gallery 
    elseif( get_row_layout() == 'gallery' ) { ?>
      <?php if( $imgs = get_sub_field('gallery') ) { ?>
      <section id="route-gallery" class="route-gallery fw-left">
        <div class="carousel-wrapper-section full">
          <div id="carousel-images">
            <div class="loop owl-carousel owl-theme">
            <?php foreach( $imgs as $img ) { ?>
              <div class="item">
                <div class="image">
                  <div class="bg" style="background-image:url('<?php echo $img['url']?>')"></div>
                  <img src="<?php echo $placeholder ?>" alt="" aria-hidden="true" />
                </div>
              </div>
            <?php } ?>
            </div>
          </div>
        </div>
      </section>
      <?php } ?>
    <?php } 

    //Case: Download layout / information section
    elseif( get_row_layout() == 'information' ) { ?>
      <?php if ( $info = get_sub_field('information') ) { ?>
        <?php if( have_rows('information') ) { ?>
        <section id="route-information" class="route-information fw-left section-content" data-section="Information">
          <div class="shead-icon text-center fw-left">
            <div class="wrapper">
              <div class="icon"><span class="ci-info"></span></div>
              <h2 class="stitle">Information</h2>
            </div>
          </div>
          <div class="information-tabs-wrap">
            <div id="tabs-info" class="tabs-info">
              <div class="wrapper">
                <ul id="tabs">
                <?php $j=1; while( have_rows('information') ): the_row(); 
                  $tabTitle = get_sub_field('tab_title');
                  $panel = get_sub_field('tab_info');
                  if( $tabTitle && $panel ) { ?>
                    <li class="tab<?php echo ($j==1) ? ' active':'';?>"><a href="#" data-rel="#info-panel-<?php echo $j?>" class="tablink"><span class="link"><span><?php echo $tabTitle ?></span></span><span class="arrow"></span></a></li>
                  <?php $j++; } ?>
                 <?php  endwhile; ?>
                </ul>
              </div>
            </div>
            <div class="tabs-content">
              <?php $i=1; while( have_rows('information') ): the_row(); 
                $tabTitle = get_sub_field('tab_title');
                $panel = get_sub_field('tab_info');
                if( $tabTitle && $panel ) { ?>
                  <div id="info-panel-<?php echo $i?>" class="info-panel<?php echo ($i==1) ? ' active':'';?>">
                    <h3 class="info-title"><?php echo $tabTitle ?></h3>
                    <div class="wrapper info-inner animated<?php echo ($i==1) ? ' fadeIn':'';?>"<?php echo ($i==1) ? ' style="display:block"':'';?>>
                      <div class="flexwrap">
                        <div class="wrap">
                          <div class="info"><?php echo $panel ?></div>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php $i++; } ?>
              <?php  endwhile; ?>
            </div>
          </div>
        </section>
        <?php } ?>
      <?php } ?>
    <?php } 

    //Case: Long Form Stroy
    elseif( get_row_layout() == 'long_form_story' ) { ?> 
      <?php if ( $story = get_sub_field('story') ) { ?>
      <section class="route-long-form fw-left">
        <div class="wrapper"><?php echo $story; ?></div>
      </section>
      <?php } ?>
    <?php } ?>


  <?php endwhile; ?>
  <?php } ?>


<?php endwhile; ?>

<?php  
/* Similar Events */ 
get_template_part("parts/similar-posts"); 
?>


<script>
jQuery(document).ready(function($){

  /* Carousel */
  $('.loop').owlCarousel({
    center: true,
    items:2,
    nav: true,
    loop:true,
    margin:15,
    autoplay:true,
    autoplayTimeout:3000,
    autoplayHoverPause:true,
    responsive:{
      600:{
        items:2
      },
      400:{
        items:1
      }
    }
  });

	/* page anchors */
	if( $('[data-section]').length > 0 ) {
		var tabs = '';
		$('[data-section]').each(function(){
			var name = $(this).attr('data-section');
			var id = $(this).attr("id");
			tabs += '<span class="mini-nav"><a href="#'+id+'">'+name+'</a></span>';
		});
		$("#pageTabs").html('<div class="wrapper"><div id="tabcontent">'+tabs+'</div></div>');
	}

  $("#tabs a").on("click",function(e){
    e.preventDefault();
    var panel = $(this).attr('data-rel');
    $("#tabs li").not(this).removeClass('active');
    $(this).parents("li").addClass('active');
    if( $(panel).length ) {
      $(".info-panel").not(panel).removeClass('active');
      $(".info-panel").not(panel).find('.info-inner').removeClass('fadeIn');
      $(panel).addClass('active');
      //$(panel).find('.info-inner').addClass('fadeIn').slideToggle();
      $(panel).find('.info-inner').toggleClass('fadeIn');
    }
  });

  $(".info-title").on("click",function(e){
    var parent = $(this).parents('.info-panel');
    var parent_id = parent.attr("id");
    $("#tabs li").removeClass('active');
    $('.info-panel').not(parent).find('.info-inner').hide();
    $('.info-panel').not(parent).removeClass('active');
    parent.find('.info-inner').toggleClass('fadeIn').slideToggle();
    if( parent.hasClass('active') ) {
      parent.removeClass('active');
      
      $('#tabs a[data-rel="#'+parent_id+'"]').parents('li').removeClass('active');
    } else {
      parent.addClass('active');
      //parent.find('.info-inner').addClass('fadeIn').slideToggle();
      $('#tabs a[data-rel="#'+parent_id+'"]').parents('li').addClass('active');
    }
  });

});	
</script>