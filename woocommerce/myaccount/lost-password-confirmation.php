<?php
/**
 * Lost password confirmation text.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/lost-password-confirmation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wc_print_notices();
//wc_print_notice( __( 'Password reset email has been sent.', 'woocommerce' ) );

$new_message = '<strong>קיבלת?</strong><br>';
$new_message.= 'לקוח יקר, קישור לאיפוס הסיסמה נשלח אליך במייל ובמסרון למספר הטלפון הנייד הרשום במערכת.<br>';
$new_message.= 'אם לא קיבלת תוך <span class="password-reset-counter">30</span> שניות.';
$new_message.= '<div class="password-reset-message">';
$new_message.= '<a href="'.esc_url(wp_lostpassword_url()).'">נסה שוב</a><br>';
$new_message.= 'או לפנות אל מנהל חנות המכר באימייל<br>';
$new_message.= 'genya@telefire.com<br>';
$new_message.= 'או בטל: 039700414 - ג׳ניה';
$new_message.= '</div>';

wc_print_notice($new_message);
?>
<style>.woocommerce-message{display: block!important;} .password-reset-message{display: none;}</style>
<script>
	jQuery(document).ready(function($){
		var prc = $('.password-reset-counter'),
			prm = $('.password-reset-message');
		var timerId = setInterval(function(){
			var pr_counter = Number(prc.text());
			if(pr_counter > 0){
				prc.text(pr_counter - 1);
			}else{
				prm.show();
				clearTimeout(timerId);
			}
		}, 1000);
	});
</script>

<?php /* ?>
<p><?php echo apply_filters( 'woocommerce_lost_password_message', __( 'A password reset email has been sent to the email address on file for your account, but may take several minutes to show up in your inbox. Please wait at least 10 minutes before attempting another reset.', 'woocommerce' ) ); ?></p>
<?php */ ?>