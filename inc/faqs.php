<script type="text/javascript">
jQuery(document).ready(function ($) {
	/* FAQS */
	$(".faqsItems .collapsible").on("click",function(){

		if( $(this).hasClass('active') ) {
			$(this).removeClass("active fadeIn");
		} else {
			$(".faqsItems .collapsible").removeClass("active fadeIn");
			$(this).addClass("active fadeIn");
		}
	}); 
});
</script>