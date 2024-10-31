<?php
if ( ! defined( 'ABSPATH' ) ) exit; 
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://icanwp.com
 * @since      1.0.0
 *
 * @package    Portfolio_Gallery_Master
 * @subpackage Portfolio_Gallery_Master/admin/partials
 */
?>
<h2>Portfolio Gallery Master Settings</h2>
<div id="wp-master-info-panel">
	<div class="wp-master-info-section">
		<h3>Our plugins are developed to support our actual clients with over 10+ years of in Website Development.</h3>
		<p>&bull; Run a light weight, full-screen, responsive <a href="https://codecanyon.net/item/icanwp-background-slider-gallery/16820854?ref=iCanWP" target="_blank">WordPress Background Slider</a> from our development team.</p>
		<p>&bull; Checkout the must have WordPress plugin for displaying your posts like a pro. <a href="https://codecanyon.net/item/wp-post-ticker-pro/15578349?ref=iCanWP" target="_blank">WordPress Post Ticker</a></p>
		<p>&bull; Impress your website visitors with the advanced <a href="https://codecanyon.net/item/icanwp-portfolio-gallery/17699457?ref=iCanWP" target="_blank">WordPress Portfolio Gallery</a> that give you full freedom of control and multiple portfolios handling feature.</p>
	</div>
	<div class="wp-master-promo-section">
		<h3>Best of the best services we recommend for your business website</h3>
		<p>&bull; Run your WordPress with all the optimization you need on a managed <a href="http://wpmaster.com/wp-engine/" target="_blank">WordPress hosting</a>.</p>
		<p>&bull; Most economic and well supported <a href="http://wpmaster.com/namecheap/" target="_blank">domain registrar</a> that we use for our clients.</p>
		<p>&bull; Constantly getting better and simply the best email <a href="http://wpmaster.com/email-marketing/" target="_blank">marketing solution</a></p>
	</div>
</div>
<hr />
<p>Copy and paste the following shortcode in the contents area:</p>
<input type="text" name="pgm_shortcode" value="[show-portfolio-gallery]" class="pgm-shortcode-display" readonly="readonly" />
<br />
<form class="pgm-settings" method="post" action="options.php"> 
<?php 
	settings_fields( 'pgm_settings_menu' );
	do_settings_sections( 'pgm_settings_menu' ); 
	submit_button(); 
?>
</form>