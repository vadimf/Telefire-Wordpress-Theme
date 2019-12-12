<?php
/**
 * Customer processing order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-processing-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates/Emails
 * @version     2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @hooked WC_Emails::email_header() Output the email header
 */
//do_action( 'woocommerce_email_header', $email_heading, $email ); ?>
<?php
/*
echo "<pre style='direction: ltr;'>";
//print_r($order->data);
echo "</pre>";
echo "<hr>";

echo $order->get_id();
echo "<hr>";
*/

$order_id = $order->get_id();

$delivery_date = get_post_meta( $order_id, '_delivery_date', true );
$delivery_code = get_post_meta( $order_id, 'order_delivery', true );
$refference_code = get_post_meta( $order_id, 'customised_refference', true );
$print_delivery_date =  $delivery_date;

$order = wc_get_order( $order_id );

$order_items = $order->get_items();

$order_user_id = $order->get_user_id();

$products_count = count( $order_items );
?>
<style>

	html,body,table, div,p,td,.em-main {      
		direction: rtl !important;  
	}  
	td,th.td,.em-unsubscribe,  
	.em-image-caption-content{  
		text-align:right !important; 
	} 

    .pre-order-print{
        text-align: right;
        direction: rtl!important;
    }


    .pre-order-print .pre-order-print-header .pre-order-total{
        float: left;
        padding-top: 15px;
    }

    .pre-order-print .pre-order-print-header h2{
        float: right;
    }

    .pre-order-print .pre-order-print-header{
        border-bottom: 1px solid #c8ccd1;
        min-height: 60px;
        display: inherit;
    }

    .pre-order-print .pre-order-print-header .pre-order-total span{
        color: #e9132f;
    }

    .pre-order-body {
        margin-top: 60px;
        margin-bottom: 60px;
        /* margin-right: 5%; */
        /* margin-left: 5%; */
        background: #fff;
        padding: 15px;
        position: relative;
        max-width: 900px;
        left: 0;
        right: 0;
        margin: 0 auto;
        margin-top: 60px;
        line-height: 1.8;

    }

    .print-header .print-header-logo{

        position: absolute;
        left: 30px;
        top: 30px;
    }

    .print-header-logo{

        position: absolute;
        top: 30px;
        left: 30px;
    }

    .print-header {
        padding-top: 30px;
        padding-bottom: 60px;
    }

    .print-order-title{
        display: flex;
    }

    .print-order-title h2{
        color: #19191a;
        line-height: 1;
        font-size: 30px;
        padding-right: 0px;
        display: inline-block;
        float: right;
    }

    .print-order-title h6{
        float: right;
        text-align: left;
        position: absolute;
        left: 30px;
    }

    .print-order-details {
        position: relative;
        padding-top: 30px;
        padding-bottom: 30px;
        padding-right: 80px;
        display: -webkit-box;
        margin-bottom: 30px;
    }


    .print-detail-who, .print-detail-delivery{
        width: 50%;
        float: right;
    }


    .print-order-details .print-detail-who .title, .print-detail-delivery .title{
        color: #19191a;
        font-weight: 600!important;
    }

    .print-order-items .head-title{
        font-weight: 600;
    }

    .print-order-items .head-title td:first-child{
        color: #cccccc;
    }

    .print-order-items{

    }

    .print-order-items .head-title td:first-child{
        width: 15%;
        font-weight: normal;
        color: #19191a;
        font-weight: 600!important;
    }


    .print-order-items .head-title td:nth-child(2){
        width: 25%;
    }

    .print-order-items .head-title td:nth-child(3){
        width: 50%;
    }
    .print-order-items .head-title td:first-child{

        font-weight: bold;
    }


    .print-order-total{
        padding-right: 80px;
        padding-top: 15px;
        padding-bottom: 60px;

        padding-left: 15px;
    }

    .pre-order-print{
        /*width: 640px;*/
        background: #fff;
        left: 0;
        right: 0;
        margin: 0 auto;
    }

    .print-order-total{
        /*width: 640px;*/
    }

    .print-header{
        font-size: 16px;
    }
    .print-order-title{
        /*width: 640px;*/
    }
    .print-order-title h2{
        font-size: 18px;
    }

    .order-detail{
        font-size: 14px;
    }

    .print-order-items{
        font-size: 14px;
    }
    @media only screen and (max-width: 768px) {
        .print-header td, .order-body-info td {
            display: block;
            width: 99.9%!important;
            clear: both
        }
    }


    .delive-date-block{
        padding-right: 75px;
        padding-top: 30px;
        padding-bottom: 15px;
    }
</style>

<table class="pre-order-print" style="position: relative; direction: rtl!important;">
        <tr>
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
            <td class="pre-order-body">
                <div class="print-header">

                    <table style="width:640px;  direction: rtl!important;">
                        <tr>
                            <td style="width: 85%; float: right; line-height: 1;">

                                <?php echo get_field('contact_detail', 704); ?>

                            </td>
                            <td style="text-align: left;">
                                <img src="<?php echo get_field('contact_logo', 704); ?>">


                            </td>
                        </tr>
                    </table>


                </div>
                <div class="print-order-title" style="width: 640px; direction: rtl!important;">
                    <h2>סיכום <br> הזמנה</h2>


                    <h6 style="text-align: left; float: left; width: 100%;  margin-top: -30px;"><?php _e( 'Date:', 'woocommerce' ); ?>
                        <strong><?php echo wc_format_datetime( $order->get_date_created() ); ?></strong></h6>
                </div>


                <table width="640px" class="order-body-info" style=" direction: rtl!important;">
                    <tr>
                        <td style="width: 50%;" class="order-detail full-width-table">

                        <table>
                            <tr>
                                <td class="title" style="width: 35%; font-weight: bold;">שם חברה</td>
                                <td class="detail-title" style="width: 65%;"><?php
                                    $order_user_id = 'user_'.$order_user_id;
                                    echo $order->get_billing_company();
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="title" style="width: 35%; font-weight: bold;">כתובת</td>
                                <td class="detail-title" style="width: 65%;">
                                    <?php
                                    if($order->get_billing_postcode()!=""){
                                        echo $order->get_billing_postcode().",&nbsp;&nbsp;";
                                    }
                                    echo $order->get_billing_city().",&nbsp;&nbsp;";
                                    echo $order->get_billing_address_1()."&nbsp;&nbsp;";
                                    
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="title" style="width: 35%; font-weight: bold;"></td>
                                <td class="detail-title" style="width: 65%;">
                                    <?php
                                    echo $order->get_billing_state();
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="title" style="width: 35%; font-weight: bold;">שיטת משלוח</td>
                                <td class="detail-title" style="width: 65%;">
                                    &nbsp;<?php if($delivery_code==12){ echo "אספקה במשלוח"; }else{ echo "איסוף עצמי"; } ?>
                                </td>
                            </tr>
                            <?php if($refference_code!=""){ ?>
                            <tr>
                                <td class="title" style="width: 35%; font-weight: bold;">
                                    מספר הזמנתך

                                </td>
                                <td class="detail-title" style="width: 65%;">
                                    <?php echo $refference_code; ?>
                                </td>
                            </tr>
                            <?php } ?>

                            <?php if($order->get_shipping_city()!=""){ ?>
                                <tr>
                                <td class="title" style="width: 35%; font-weight: bold;">&nbsp;כתובת למשלוח</td>
                                    <td class="detail-title" style="width: 65%;">
                                        <?php
                                        if($order->get_shipping_address_1()!=""){
                                        echo $order->get_shipping_address_1().",&nbsp;&nbsp;";	
                                        }
                                        

                                        if($order->get_shipping_city()!=""){
                                            echo $order->get_shipping_city().",&nbsp;&nbsp;";
                                        }

                                        if($order->get_shipping_postcode()!=""){
                                            echo $order->get_shipping_postcode()."&nbsp;&nbsp;";
                                        }
                                        ?>&nbsp;
                                    </td>
                                </tr>
                            <?php } ?>


                        </table>


                        </td>
                        <td style="width: 50%;" class="full-width-table">

                            <table>
                                <?php if(get_field('custname',$order_user_id)!=""){ ?>
                                <tr>
                                    <td style="width: 35%;  font-weight: bold;">
                                        מספר לקוח
                                    </td>
                                    <td>

                                        <?php echo get_field('custname',$order_user_id); ?>
                                    </td>
                                </tr>
                                <?php } ?>

                                <tr>
                                    <td style="width: 35%;  font-weight: bold;">
                                        מבצע ההזמנה
                                    </td>
                                    <td>

                                        <?php
                                        echo $order->get_billing_first_name()." ";
                                        echo $order->get_billing_last_name();
                                        ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="width: 35%;  font-weight: bold; line-height: 1;">שם מקבל המשלוח

                                    </td>
                                    <td>

                                        <?php
                                        echo $order->get_shipping_first_name()." ";
                                        echo $order->get_shipping_last_name();

                                        ?>
                                    </td>
                                </tr>
                            </table>



                        </td>
                    </tr>
                </table>
                <br>
                <br>



                <div class="print-order-items">
                    <table style="width: 640px;  direction: rtl!important;">
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
                                <td><a href="<?php echo get_permalink($product_id); ?>" style="color: #d22624;"><?php echo $item_data['name']; ?></a></td>
                                <td><?php echo get_post_field('post_content', $product_id); ?></td>
                                <td><?php echo $item_data['quantity']; ?></td>
                            </tr>
                            <?php
                            //print_r($item_data);
                        }
                        ?>
                    </table>
                </div>

                <?php if($print_delivery_date!=""){ ?>
                    <table style="width: 640px;  direction: rtl!important;">
                        <tr>
                            <td class="title" style="width: 35%; line-height: 1; font-weight: bold;">תאריך מבוקש לקבלת משלוח


                            </td>
                            <td class="detail-title" style="width: 65%;">
                                <?php echo $print_delivery_date; ?>
                            </td>
                        </tr>
                    </table>
                <?php } ?>
                <div class="print-order-total" style=" direction: rtl!important;">
                    נבחרו
                    <span><?php echo $products_count; ?></span>
                    מוצרים, סה"כ
                    <span><?php echo $order->get_item_count();?></span>
                    יחידות
                </div>


            </td>





    </tr>
</table>

<?php

/**
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
//do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
//do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/**
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
//do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
