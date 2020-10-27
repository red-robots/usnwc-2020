<?php
$placeholder = THEMEURI . 'images/rectangle.png';
$imageHelper = THEMEURI . 'images/rectangle-narrow.png'; 
$perPage = -1;
$paged = ( get_query_var( 'pg' ) ) ? absint( get_query_var( 'pg' ) ) : 1;
$args = array(
	'posts_per_page'   => $perPage,
	'orderby'          => 'date',
	'order'            => 'DESC',
	'post_type'        => 'post',
	'post_status'      => 'publish',
	// 'paged'			   => $paged
);
$blogs = new WP_Query($args);
if ( $blogs->have_posts() ) {  ?>
<div class="alternate-posts">
	<div class="posts-inner">

		<?php $sec=.1; $i=1; while ( $blogs->have_posts() ) : $blogs->the_post();
			$thumbId = get_post_thumbnail_id(); 
			$featImg = wp_get_attachment_image_src($thumbId,'large');
			$featThumb = wp_get_attachment_image_src($thumbId,'thumbnail');
			$content = get_the_content();
			$title = get_the_title();
			$divclass = (($content || $title) && $featImg) ? 'half':'full';
			$pagelink = get_permalink();
			$divclass .= ($i % 2) ? ' odd':' even';
			$divclass .= ($i==1) ? ' first':'';
			?>
			<article id="post-id-<?php the_ID(); ?>" class="entry <?php echo $divclass ?>">
				<div class="flexwrap">
					<?php if ($content || $title) { ?>
					<div class="textcol">
						<div class="inside fadeIn wow" data-wow-delay="<?php echo $sec;?>s">
							<div class="wrap">
								<h2 class="title"><?php echo $title; ?></h2>
								<?php if ($content) { ?>
									<div class="text"><?php echo shortenText($content,500,' ','...'); ?></div>
								<?php } ?>
								<div class="buttondiv">
									<a href="<?php echo $pagelink ?>" class="btn-sm"><span>Read More</span></a>
								</div>
							</div>
						</div>
					</div>
					<?php } ?>

					<?php if ($featImg) { ?>
					<div class="imagecol">
						<div class="blurred" style="background-image:url('<?php echo $featThumb[0] ?>')"></div>
						<div class="image fadeIn wow" data-wow-delay="<?php echo $sec;?>s" style="background-image:url('<?php echo $featImg[0] ?>')">
							<img src="<?php echo $imageHelper ?>" alt="" aria-hidden="true" class="helper">
						</div>
					</div>
					<?php } ?>
				</div>
			</article>
		<?php
		$sec =  $sec + .1;
		$i++; endwhile; wp_reset_postdata(); ?>

	</div>
</div>

<?php } ?>