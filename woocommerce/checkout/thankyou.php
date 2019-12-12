<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="woocommerce-order">


    <?php
    //        $cur_user_id = get_current_user_id();
    //        echo $cur_user_id;
    //        echo "<hr>";
    //        echo $order->get_id();
    //
    //        if($cur_user_id==27){
    //            echo "<br><hr>
    //                |<br><div style='direction: ltr'>";
    //            //echo "Delivery code:".get_post_meta( $order->get_id(), 'order_delivery', true );
    //            echo get_post_meta( $order->get_id(), '_delivery_date', true );
    //            $delivery_date = get_post_meta( $order->get_id(), '_delivery_date', true );
    //
    //            //echo date('d/m/Y', strtotime($delivery_date));
    //
    //            echo "</div><br>|<hr><br>";
    //        }
    ?>
  
	<?php if ( $order ) : ?>

        <?php 
            // Redirect to thank you page, without re-confirmation.
            wp_redirect(get_site_url().'/order-complete/?order_id='.$order->get_id()); exit; 
        ?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php _e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
				<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php _e( 'Pay', 'woocommerce' ) ?></a>
				<?php if ( is_user_logged_in() ) : ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php _e( 'My account', 'woocommerce' ); ?></a>
				<?php endif; ?>
			</p>

		<?php else : ?>

        <?php
        $order_id = $order->get_id();
        //echo "Get order ID".$order_id;

        /*
         * Moving this funtion to ThanksPage body */
        $delivery_date = get_post_meta( $order_id, '_delivery_date', true );
        $delivery_code = get_post_meta( $order_id, 'order_delivery', true );
        $refference_code = get_post_meta( $order_id, 'customised_refference', true );
        $print_delivery_date =  $delivery_date;

        ?>


        <?php $order_id = $order->get_id();

            $order = wc_get_order( $order_id );

            $order_items = $order->get_items();

            $order_user_id = $order->get_user_id();

            $products_count = count( $order_items );

            //echo "<hr>";
            //print_r($_POST);

            //echo "</pre>";

        ?>

        <div class="custom-container">



        <div class="pre-order-print">
            <div class="pre-order-print-header">
                <h2>
                    סל מוצרים</h2>
                <div class="pre-order-total">
                    נבחרו
                    <span><?php echo $products_count; ?></span>
                    מוצרים, סה"כ
                    <span><?php echo $order->get_item_count();?></span>
                    יחידות
                </div>

            </div>
            <div class="pre-order-body">
                <div class="print-header">

                        <?php echo get_field('contact_detail'); ?>

                        <img src="<?php echo get_field('contact_logo'); ?>" class="print-header-logo">

                </div>
                <div class="print-order-title">
                    <h2>סיכום <br> הזמנה</h2>


                    <h6><?php _e( 'Date:', 'woocommerce' ); ?>
                        <strong><?php echo wc_format_datetime( $order->get_date_created() ); ?></strong></h6>
                </div>


                <div class="print-order-details">
                    <div class="print-detail-who">
                        <div class="row">
                            <div class="col-md-4 title">שם חברה</div>
                            <div class="col-md-8 detail-title">
                                <?php
                                    $order_user_id = 'user_'.$order_user_id;
                                    echo $order->get_billing_company();
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 title">כתובת</div>
                            <div class="col-md-8 detail-title">
                                <?php
                                echo $order->get_billing_address_1();
                                echo ", ".$order->get_billing_city();

                                if($order->get_billing_postcode()!=""){
                                    echo ", ".$order->get_billing_postcode();
                                }

                                echo $order->get_billing_address_2();
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 title"></div>
                            <div class="col-md-8 detail-title">
                                <?php
                                echo $order->get_billing_state();
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 title">&nbsp;</div>
                            <div class="col-md-8 detail-title">
                                &nbsp;
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 title">שיטת משלוח</div>
                            <div class="col-md-8 detail-title">
                                &nbsp;<?php if($delivery_code==12){ echo "אספקה במשלוח"; }else{ echo "איסוף עצמי"; } ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 title">מספר הזמנתך</div>
                            <div class="col-md-8 detail-title">
                                <?php echo $refference_code; ?>
                            </div>
                        </div>

                        <?php if($order->get_shipping_city()!=""){ ?>
                        <div class="row">
                            <div class="col-md-4 title">&nbsp;כתובת למשלוח</div>
                            <div class="col-md-8 detail-title">
                                <?php
                                echo $order->get_shipping_address_1();

                                if($order->get_shipping_city()!=""){
                                    echo ", ".$order->get_shipping_city();
                                }
                                if($order->get_shipping_postcode()!=""){
                                    echo ", ".$order->get_shipping_postcode();
                                }
                                ?>&nbsp;
                            </div>
                        </div>
                        <?php } ?>

                    </div>
                    <div class="print-detail-delivery">
                        <div class="row">
                            <div class="col-md-4 title">מספר לקוח</div>
                            <div class="col-md-8 detail-title">
                                <?php


                                echo get_field('custname',$order_user_id);

                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 title">מבצע ההזמנה</div>
                            <div class="col-md-8 detail-title">
                                <?php
                                echo $order->get_billing_first_name()." ";
                                echo $order->get_billing_last_name();
                                ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 title">&nbsp;</div>
                            <div class="col-md-8 detail-title">
                                &nbsp;
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 title" style="line-height: 1;">שם מקבל המשלוח</div>
                            <div class="col-md-8 detail-title">
                                <?php
                                echo $order->get_shipping_first_name()." ";
                                echo $order->get_shipping_last_name();

                                ?>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="print-order-items">
                <table>
                    <tr class="head-title">

                            <td style="line-height: 1;">פירוט<br> המוצרים</td>
                            <td>מק״ט</td>
                            <td>שם המוצר</td>
                            <td>כמות</td>

                    </tr>

                <?php


                foreach( $order_items as $item_id => $item ){

                    $item_id = $item->get_id();

                    // методы класса WC_Order_Item_Product

                    $item_name = $item->get_name(); // Name of the product
                    $item_type = $item->get_type(); // Type of the order item ("line_item")


                    $product_id = $item->get_product_id(); // the Product id
                    $wc_product = $item->get_product(); // the WC_Product object

                    // данные элемента заказа в виде массива
                    $item_data = $item->get_data();
                    ?>
                    <tr>

                        <td>&nbsp;</td>
                        <td><?php echo $item_data['name']; ?></td>
                        <td><?php echo get_post_field('post_content', $product_id); ?></td>
                        <td><?php echo $item_data['quantity']; ?></td>
                    </tr>
                <?php
                    //print_r($item_data);
                    }
                ?>
                </table>
                </div>
                <div class="col-md-6 delive-date-block">
                    <div class="row">
                        <div class="col-md-6 title" style="line-height: 1; font-weight: bold;">תאריך מבוקש לקבלת משלוח</div>
                        <div class="col-md-6 detail-title">
                            <?php echo $print_delivery_date; ?>
                        </div>
                    </div>
                </div>

                <div class="print-order-total">
                    נבחרו
                    <span><?php echo $products_count; ?></span>
                    מוצרים, סה"כ
                    <span><?php echo $order->get_item_count();?></span>
                    יחידות
                </div>


            </div>



            <div class="order-accept-block">
                <div class="row terms-block">
                    <input type="checkbox" id="complete-accept" class="complete-accept"><?php echo get_field('accept'); ?>
                </div>

                <div class="btn-block-thanks">
                    <p class="order-print display">
                        <form action="/order-complete/">
                        <button type="submit" class="btn-complete checkout-button button alt wc-forward" disabled>שליחת הזמנה</button>
                        <input type="hidden" name="order_id" value="<?php echo $order->get_id(); ?>">
                        </form>
                    </p>

                    <p class="order-print-gohome display">
                        <a href="/order-canceled/?order_id=<?php echo $order->get_id(); ?>" class="button  btn-canceled">בטל הזמנה</a>
                    </p>
                </div>

            </div>

        </div>

</div>
<script>
    jQuery('input:checkbox').change(function(){
        if(jQuery(this).is(":checked")) {
            jQuery('.btn-complete').removeAttr("disabled");
            //alert('Goo');
        } else {
            jQuery('.btn-complete').attr("disabled");
            //alert('Stopp');
        }
    });
</script>




       <?php /*
	<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( '<strong>תודה על הזמנתך!</strong><br> ההזמנה נקלטה במערכת ותטופל בהקדם. לפרטים, שינויים או בירורים נוספים אנא פנה לחנות המכר ב<br>	<span>טלפון 03-9700414.</span>', 'woocommerce' ), $order ); ?></p>

			<div class="btn-block-thanks">
				<p class="order-print display">
					<a href="/my-account/print-order/<?php echo $order->get_id(); ?>/" class="button print">הדפס הזמנה</a>
				</p>

				<p class="order-print-gohome display">
					<a href="/" class="button print">חזרה למערכת</a>
				</p>
			</div>
			<ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">

				<li class="woocommerce-order-overview__order order">
					<?php _e( 'Order number:', 'woocommerce' ); ?>
					<strong><?php echo $order->get_order_number(); ?></strong>
				</li>

				<li class="woocommerce-order-overview__date date">
					<?php _e( 'Date:', 'woocommerce' ); ?>
					<strong><?php echo wc_format_datetime( $order->get_date_created() ); ?></strong>
				</li>

				<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
					<li class="woocommerce-order-overview__email email">
						<?php _e( 'Email:', 'woocommerce' ); ?>
						<strong><?php echo $order->get_billing_email(); ?></strong>
					</li>
				<?php endif; ?>

				<li class="woocommerce-order-overview__total total">
					<?php _e( 'Total:', 'woocommerce' ); ?>
					<strong><?php echo $order->get_formatted_order_total(); ?></strong>
				</li>

				<?php if ( $order->get_payment_method_title() ) : ?>
					<li class="woocommerce-order-overview__payment-method method">
						<?php _e( 'Payment method:', 'woocommerce' ); ?>
						<strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
					</li>
				<?php endif; ?>

			</ul>
            */ ?>
		<?php endif; ?>

		<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
		<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

	<?php else : ?>

		<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you. Your order has been received.', 'woocommerce' ), null ); ?></p>

	<?php endif; ?>

</div>


<?php

//if($_GET['order_id']!="") {
    //$order_id = $_GET['order_id'];
    //$order = wc_get_order( $order_id );
    if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) {


        $order = new WC_Order($order_id);
        //print_r($order);
        $order->update_status('on-hold', 'Client leave checkout page without actions');


    }
//}
?>