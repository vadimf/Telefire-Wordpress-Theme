<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>

<?php wc_print_notices(); ?>
<style>.woocommerce-message{display: block!important;}</style>

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php /*
<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>
<?php endif; ?>
*/ ?>


<div class="col-md-6" id="customer_login">



	<div class="telefire-auth-form">
		<div class="head-form">
			<h2><?php esc_html_e( 'Login', 'woocommerce' ); ?></h2>
		</div>
		<form class="woocommerce-form woocommerce-form-login login" method="post">

			<?php do_action( 'woocommerce_login_form_start' ); ?>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="username"></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" placeholder="<?php esc_html_e( 'Username or email address', 'woocommerce' ); ?> &nbsp;*" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
			</p>
			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide" style="position: relative;">
				<i class="fa fa-eye toggle-password" aria-hidden="true"></i>
				<label for="password"></label>
				<input class="woocommerce-Input woocommerce-Input--text input-text" placeholder="<?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;*" type="password" name="password" id="password" autocomplete="current-password" />
			</p>

			<?php do_action( 'woocommerce_login_form' ); ?>

			<p class="form-row wrap-cust-tel-btn">
				<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
				
				<span class="woocommerce-LostPassword lost_password">
					<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>
				</span>

				<label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline">
					<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
				</label>

				<button type="submit" class="woocommerce-Button button btn-telefire" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Log in', 'woocommerce' ); ?></button>

				<!-- <span class="wrap-cust-label-span"></span> -->
			</p>
			

			<?php do_action( 'woocommerce_login_form_end' ); ?>

		</form>
	</div>

</div>

<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>
<div class="col-md-6">

	<div class="telefire-auth-form">
		<div class="head-form">
			<h2><?php esc_html_e( 'לקוח חדש?', 'woocommerce' ); ?></h2>
		</div>
		<div class="cf7-register">
			<button class="button btn-telefire open-reg-form" type="button">הרשם עכשיו</button>
			<div style="display: none;">
				<div class="wrap_user_role_select">
					<select class="user_role_select">
						<option value="installer" selected="">חברת התקנה ותחזוקה</option>
						<option value="consultant">יועצים ומתכננים</option>
						<option value="other">אחר</option>
					</select>
				</div>
				<div class="user_role_block" data-role="installer" style="display: block;">
					<?php echo do_shortcode('[contact-form-7 id="1867" title="Registration"]'); ?>
				</div>
				<div class="user_role_block" data-role="consultant">
					<?php echo do_shortcode('[contact-form-7 id="17337" title="Registration consultant"]'); ?>
				</div>
				<div class="user_role_block" data-role="other">
					<?php echo do_shortcode('[contact-form-7 id="17338" title="Registration other"]'); ?>
				</div>
			</div>
		</div>
	</div>
</div>


<?php endif; ?>




<?php do_action( 'woocommerce_after_customer_login_form' ); ?>