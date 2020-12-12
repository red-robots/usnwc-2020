<?php 
	$postid = get_the_ID();
	$faq_image = get_field("faq_image"); 
	//$faqsIds = get_faqs_by_single_post($postid);
	//$faqs = get_faqs_by_assigned_page_id($faqsIds);
	
	$faqs = get_faq_listings($postid);
	$faq_class = ($faqs && $faq_image) ? 'half':'full';
	$has_faq_image = ($faq_image) ? ' has-image':' no-image';
	$show_default_title = ( isset($customFAQTitle) && $customFAQTitle ) ? false : true;
	$faqTitle = ( isset($customFAQTitle) && $customFAQTitle ) ? $customFAQTitle : "FAQ";
	$customClass = ( isset($customFAQClass) && $customFAQClass ) ? " ".$customFAQClass : "";

	if($faqs) { ?>
	<section id="section-faqs" data-section="<?php echo $faqTitle ?>" class="section-content <?php echo $faq_class.$has_faq_image.$customClass ?>">
		<div class="wrapper">
			<div class="flexwrap">

				<div class="col faqs">

					<?php if ($show_default_title) { ?>
						<div class="titlediv">
							<?php if ($faq_image) { ?>
							<h2 class="sectionTitle">FAQ</h2>
							<?php } else { ?>
							<h2 class="sectionTitle text-center">FAQ</h2>
							<?php } ?>
						</div>
					<?php } else { ?>

							<?php if ( isset($customFAQTitle) && $customFAQTitle ) { ?>
							<div class="shead-icon text-center">
								<div class="icon"><span class="ci-help"></span></div>
								<h2 class="stitle"><?php echo $customFAQTitle ?></h2>
							</div>
							<?php } ?>

					<?php } ?>
					
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