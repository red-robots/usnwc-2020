<article id="post-id-<?php the_ID(); ?>" class="entry <?php echo $divclass ?>">
				<div class="inner-wrap">

					<?php if ($featImg) { ?>
					<div class="imagecol">
						<div class="blurred" style="background-image:url('<?php echo $featThumb[0] ?>')"></div>
						<div class="image fadeIn wow" data-wow-delay="<?php echo $sec;?>s" style="background-image:url('<?php echo $featImg[0] ?>')">
							<img src="<?php echo $placeholder ?>" alt="" aria-hidden="true" class="helper">
						</div>
					</div>
					<?php } ?>

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

				</div>
</article>