<?php
/*
 * Template name: Order canceled
  */
get_header(); ?>

    <div class="custom-container main-content" style="min-height: 600px;">
        <br>
        <br>
        <?php the_content(); ?>

        <br>
<?php /*
        <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( '<strong>תודה על הזמנתך!</strong><br> ההזמנה נקלטה במערכת ותטופל בהקדם. לפרטים, שינויים או בירורים נוספים אנא פנה לחנות המכר ב<br>	<span>טלפון 03-9700414.</span>', 'woocommerce' ), $order ); ?></p>
*/ ?>



    </div>

<?php

if($_GET['order_id']!="") {
    $order_id = $_GET['order_id'];
    $order = wc_get_order( $order_id );
    if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) {


        $order = new WC_Order($order_id);
        //print_r($order);
        $order->update_status('cancelled', 'Client cancelled order on last stage');


    }
}
?>

<?php get_footer(); ?>