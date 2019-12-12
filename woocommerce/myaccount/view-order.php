<?php
/**
 * View Order
 *
 * Shows the details of a particular order on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/view-order.php.
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
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<p><?php
	/* translators: 1: order number 2: order date 3: order status */
	printf(
		__( 'Order #%1$s was placed on %2$s and is currently %3$s.', 'woocommerce' ),
		'<mark class="order-number">' . $order->get_order_number() . '</mark>',
		'<mark class="order-date">' . wc_format_datetime( $order->get_date_created() ) . '</mark>',
		'<mark class="order-status">' . wc_get_order_status_name( $order->get_status() ) . '</mark>'
	);
?></p>


<?php
$order_id = $order->get_id();
//echo "Get order ID".$order_id;

/*
 * Moving this funtion to ThanksPage body */
$delivery_date = get_post_meta( $order_id, '_delivery_date', true );
$delivery_code = get_post_meta( $order_id, 'order_delivery', true );
$refference_code = get_post_meta( $order_id, 'customised_refference', true );
$print_delivery_date =  $delivery_date;

$order = wc_get_order( $order_id );
$order_items = $order->get_items();
$order_user_id = $order->get_user_id();
$products_count = count( $order_items );

//echo "<hr>";
//print_r($_POST);

//echo "</pre>";

?>

<div class="custom-container">

    <p class="order-print display" style="float: left;
    margin-top: -90px;
    margin-left: 30px;">
        <a href="/my-account/print-order/<?php echo $order_id; ?>/" class="button print">הדפס הזמנה</a>
    </p>


    <div class="pre-order-print">
        <?php /*
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
        */ ?>
        <div class="pre-order-body">
            <div class="print-header">

                <?php echo get_field('contact_detail', 704); ?>

                <img src="<?php echo get_field('contact_logo', 704); ?>" class="print-header-logo">

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
                            echo $order->get_billing_city().", ";
                            echo $order->get_billing_address_1();
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

                    <div class="row">
                        <div class="col-md-4 title">&nbsp;</div>
                        <div class="col-md-8 detail-title">
                            &nbsp;
                        </div>
                    </div>




                </div>
                <div class="print-detail-delivery">
                    <div class="row">
                        <div class="col-md-4 title">ח.פ.</div>
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
                            echo $order->get_billing_first_name();
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
            <div class="col-md-8 delive-date-block">
                <div class="row">
                    <div class="col-md-4 title" style="line-height: 1; font-weight: bold">תאריך מבוקש לקבלת משלוח</div>
                    <div class="col-md-8 detail-title">
                        <?php echo $print_delivery_date; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12 print-order-total">
                נבחרו
                <span><?php echo $products_count; ?></span>
                מוצרים, סה"כ
                <span><?php echo $order->get_item_count();?></span>
                יחידות
            </div>


        </div>




    </div>

</div>

<?php /*

<?php if ( $notes = $order->get_customer_order_notes() ) : ?>
	<h2><?php _e( 'Order updates', 'woocommerce' ); ?></h2>
	<ol class="woocommerce-OrderUpdates commentlist notes">
		<?php foreach ( $notes as $note ) : ?>
		<li class="woocommerce-OrderUpdate comment note">
			<div class="woocommerce-OrderUpdate-inner comment_container">
				<div class="woocommerce-OrderUpdate-text comment-text">
					<p class="woocommerce-OrderUpdate-meta meta"><?php echo date_i18n( __( 'l jS \o\f F Y, h:ia', 'woocommerce' ), strtotime( $note->comment_date ) ); ?></p>
					<div class="woocommerce-OrderUpdate-description description">
						<?php echo wpautop( wptexturize( $note->comment_content ) ); ?>
					</div>
	  				<div class="clear"></div>
	  			</div>
				<div class="clear"></div>
			</div>
		</li>
		<?php endforeach; ?>
	</ol>
<?php endif; ?>
*/ ?>
<?php //do_action( 'woocommerce_view_order', $order_id ); ?>
