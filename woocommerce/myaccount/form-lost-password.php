<?php
/**
 * Lost password form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-lost-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

wc_print_notices(); ?>


<div class="col-md-6  waiting-approve-messages">
	<div class="telefire-auth-form">
		<div class="head-form">
			<h2><?php echo apply_filters( 'woocommerce_lost_password_message', esc_html__( 'Lost your password?', 'woocommerce')); ?></h2>	
		</div>

		<p><?php echo apply_filters( 'woocommerce_lost_password_message', esc_html__( 'Please enter your username or email address. You will receive a link to create a new password via email.', 'woocommerce' ) ); ?></p>

			<form method="post" class="woocommerce-ResetPassword lost_reset_password">

				<?php // @codingStandardsIgnoreLine ?>

				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="user_login"></label>
					<input class="woocommerce-Input woocommerce-Input--text input-text" placeholder="<?php esc_html_e( 'Username or email', 'woocommerce' ); ?>" type="text" name="user_login" id="user_login" autocomplete="username" />
				</p>

				

				<?php do_action( 'woocommerce_lostpassword_form' ); ?>

				<p class="form-row" style="display: block;">
					<input type="hidden" name="wc_reset_password" value="true" />
					<button type="submit" class="woocommerce-Button button btn-telefire" value="<?php esc_attr_e( 'Reset password', 'woocommerce' ); ?>"><?php esc_html_e( 'Reset password', 'woocommerce' ); ?></button>
				</p>

				<?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>

			</form>


		</div>

</div>