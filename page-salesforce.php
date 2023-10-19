<?php
/**
 * Template Name: Salesforce
 */

$placeholder = THEMEURI . 'images/rectangle.png';
$banner = get_field("flexslider_banner");
$has_banner = ($banner) ? 'hasbanner':'nobanner';
get_header(); 

if( is_page('waiver') ) {
	$pageClass = 'waiver';
} else {
	$pageClass = '';
}
?>

<div id="primary" class="content-area-full content-default page-default-template <?php echo $has_banner ?>">
	<main id="main" class="site-main wrapper" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<section class="text-centered-section">
				<div class="wrapper text-center">
					<div class="page-header">
						<h1 class="page-title"><?php the_title(); ?></h1>
					</div>
					<div class="<?php echo $pageClass; ?>">
						<?php the_content(); ?>
						<!--  ----------------------------------------------------------------------  -->
<!--  NOTE: Please add the following <META> element to your page <HEAD>.      -->
<!--  If necessary, please modify the charset parameter to specify the        -->
<!--  character set of your HTML page.                                        -->
<!--  ----------------------------------------------------------------------  -->

<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=UTF-8">
<script src="https://www.google.com/recaptcha/api.js"></script>
<script>
 function timestamp() { var response = document.getElementById("g-recaptcha-response"); if (response == null || response.value.trim() == "") {var elems = JSON.parse(document.getElementsByName("captcha_settings")[0].value);elems["ts"] = JSON.stringify(new Date().getTime());document.getElementsByName("captcha_settings")[0].value = JSON.stringify(elems); } } setInterval(timestamp, 500); 
</script>

<!--  ----------------------------------------------------------------------  -->
<!--  NOTE: Please add the following <FORM> element to your page.             -->
<!--  ----------------------------------------------------------------------  -->

<form action="https://webto.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8&orgId=00D400000007IQu" method="POST">

<input type=hidden name='captcha_settings' value='{"keyname":"ww","fallback":"true","orgId":"00D400000007IQu","ts":""}'>
<input type=hidden name="oid" value="00D400000007IQu">
<input type=hidden name="retURL" value="https://center.whitewater.org/">

<!--  ----------------------------------------------------------------------  -->
<!--  NOTE: These fields are optional debugging elements. Please uncomment    -->
<!--  these lines if you wish to test in debug mode.                          -->
<!--  <input type="hidden" name="debug" value=1>                              -->
<!--  <input type="hidden" name="debugEmail"                                  -->
<!--  value="brenden@crmscenarios.com">                                       -->
<!--  ----------------------------------------------------------------------  -->

<label for="first_name">First Name</label><input  id="first_name" maxlength="40" name="first_name" size="20" type="text" /><br>

<label for="last_name">Last Name</label><input  id="last_name" maxlength="80" name="last_name" size="20" type="text" /><br>

<label for="company">Organization</label><input  id="company" maxlength="40" name="company" size="20" type="text" /><br>

<label for="email">Email</label><input  id="email" maxlength="80" name="email" size="20" type="text" /><br>

<label for="phone">Phone</label><input  id="phone" maxlength="40" name="phone" size="20" type="text" /><br>

Requested Event Date:<span class="dateInput"><input  id="00N40000001qO1l" name="00N40000001qO1l" size="20" type="text" /></span><br>

Is This Date Flexible?:<select  id="00N5a00000D0Y8U" name="00N5a00000D0Y8U" title="Is This Date Flexible?"><option value="">--None--</option><option value="Yes">Yes</option>
<option value="No">No</option>
</select><br>

Group Number:<input  id="00N40000001qNv4" name="00N40000001qNv4" size="20" type="text" /><br>

Interest in Venue:<select  id="00N40000001qNud" name="00N40000001qNud" title="Interest in Venue"><option value="">--None--</option><option value="Yes">Yes</option>
<option value="No">No</option>
</select><br>

Which activities are you interested in?:<select  id="00N5a00000D0Y8Z" multiple="multiple" name="00N5a00000D0Y8Z" title="Which activities are you interested in?"><option value="Day Passes">Day Passes</option>
<option value="Team Development">Team Development</option>
<option value="Educational Adventures">Educational Adventures</option>
</select><br>

How would you prefer to be contacted?:<select  id="00N5a00000D0Y8e" multiple="multiple" name="00N5a00000D0Y8e" title="How would you prefer to be contacted?"><option value="Email">Email</option>
<option value="Phone">Phone</option>
</select><br>

Catering Required:<select  id="00N40000001qO1g" name="00N40000001qO1g" title="Catering Required"><option value="">--None--</option><option value="Yes">Yes</option>
<option value="No">No</option>
</select><br>

<label for="description">Additional Information?</label><textarea name="description"></textarea><br>

<input type="hidden" id="lead_source" name="lead_source" value="Info Email" />

<div class="g-recaptcha" data-sitekey="6Le9UacoAAAAAK7BxLYJU6iPz9Cmky05QmFRO9_o"></div><br>
<input type="submit" name="submit">

</form>

					</div>
				</div>
			</section>

		<?php endwhile; ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
