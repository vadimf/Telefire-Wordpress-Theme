<?php
/*
 * Template name: Order complete
  */
get_header();

?>

    <div class="custom-container main-content">

        <div class="print-btn btn-block-thanks">
            <p class="order-print display">
                <a href="/my-account/print-order/<?php echo $_GET['order_id']; ?>/" class="button print">הדפס הזמנה</a>
            </p>

            <p class="order-print-gohome display">
                <a href="/shop/" class="button print">להזמנה חדשה</a>
            </p>
        </div>

        <?php the_content(); ?>


        <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received">
            <?php 
                $additional_messages = get_field('additional_messages');

                $link = '';
                if($_GET['order_id']){
                    $order = wc_get_order($_GET['order_id']);
                        
                    $link = '<a href="'.esc_url( $order->get_view_order_url() ).'">';
                    $link.= _x( '#', 'hash before order number', 'woocommerce' ) . $order->get_order_number();
                    $link.= '</a>';
                }

                echo str_replace('%order_link%', $link, $additional_messages);
            ?>
        </p>




    </div>

<?php


    if($_GET['order_id']!="") {
        $order_id = $_GET['order_id'];
        $order = new WC_Order($order_id);
        if (is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email()) {


            $order->update_status('completed', 'Client completed order on last stage');


            function tel_send_order_to_priority($order_id)
            {
                //Get order Id;
                //$order_id = $order->get_id();
                $order = new WC_Order($order_id);
                $delivery_code = get_post_meta($order_id, 'order_delivery', true);
                //$delivery_date = get_post_meta($order_id, '_delivery_date', true);
                $delivery_date = get_post_meta($order_id, '_delivery_date', true);

                $customised_refference = get_post_meta($order_id, 'customised_refference', true);
                $shipping_phone = get_post_meta($order_id, 'shipping_phone', true);

                //Fully data by current order
                $order_data = $order->get_data(); // The Order data

                //$order_id = $order_data['id'];
                $order_parent_id = $order_data['parent_id'];
                $order_status = $order_data['status'];
                $order_currency = $order_data['currency'];
                $order_version = $order_data['version'];
                $order_payment_method = $order_data['payment_method'];
                $order_payment_method_title = $order_data['payment_method_title'];
                $order_payment_method = $order_data['payment_method'];
                $order_payment_method = $order_data['payment_method'];

                ## Creation and modified WC_DateTime Object date string ##

                // Using a formated date ( with php date() function as method)
                $order_date_created = $order_data['date_created']->date('Y-m-d H:i:s');
                $order_date_modified = $order_data['date_modified']->date('Y-m-d H:i:s');

                // Using a timestamp ( with php getTimestamp() function as method)
                $order_timestamp_created = $order_data['date_created']->getTimestamp();
                $order_timestamp_modified = $order_data['date_modified']->getTimestamp();


                $order_discount_total = $order_data['discount_total'];
                $order_discount_tax = $order_data['discount_tax'];
                $order_shipping_total = $order_data['shipping_total'];
                $order_shipping_tax = $order_data['shipping_tax'];
                $order_total = $order_data['cart_tax'];
                $order_total_tax = $order_data['total_tax'];
                $order_customer_id = $order_data['customer_id']; // ... and so on


                $order_comments = $order_data['customer_note'];

                ## BILLING INFORMATION:

                $order_billing_first_name = $order_data['billing']['first_name'];
                $order_billing_last_name = $order_data['billing']['last_name'];
                $order_billing_company = $order_data['billing']['company'];
                $order_billing_address_1 = $order_data['billing']['address_1'];
                $order_billing_address_2 = $order_data['billing']['address_2'];
                $order_billing_city = $order_data['billing']['city'];
                $order_billing_state = $order_data['billing']['state'];
                $order_billing_postcode = $order_data['billing']['postcode'];
                $order_billing_country = $order_data['billing']['country'];
                $order_billing_email = $order_data['billing']['email'];
                $order_billing_phone = $order_data['billing']['phone'];

                ## SHIPPING INFORMATION:

                $order_shipping_first_name = $order_data['shipping']['first_name'];
                $order_shipping_last_name = $order_data['shipping']['last_name'];
                $order_shipping_company = $order_data['shipping']['company'];
                $order_shipping_address_1 = $order_data['shipping']['address_1'];
                $order_shipping_address_2 = $order_data['shipping']['address_2'];
                $order_shipping_city = $order_data['shipping']['city'];
                $order_shipping_state = $order_data['shipping']['state'];
                $order_shipping_postcode = $order_data['shipping']['postcode'];
                $order_shipping_country = $order_data['shipping']['country'];
                $order_shipping_phone = $order_data['shipping']['phone'];
                $order_shipping_zip = $order_data['shipping']['zip'];

                if($order_shipping_first_name == $order_billing_first_name){
                    $order_shipping_first_name = '';
                }
                if($order_shipping_last_name == $order_billing_last_name){
                    $order_shipping_last_name = '';
                }

                if($order_shipping_company == $order_billing_company){
                    $order_shipping_company = '';
                }

                if($shipping_phone == $order_billing_phone){
                    $shipping_phone = '';
                }

                $shipping_address = $order->get_shipping_address_1();

                if( $shipping_address == $order_billing_address_1){
                    $shipping_address = '';
                }

                $shipping_zipcode = $order->get_shipping_postcode();

                if($shipping_zipcode == $order_billing_postcode){
                    $shipping_zipcode = '';
                }

                if($order_shipping_city == $order_billing_city){
                    $order_shipping_city = '';
                }





//
//                echo "Billing name:". $order_billing_first_name;
//                echo "<br>";
//                echo "Shipping name:". $order_shipping_first_name;
//
//
//                echo "<hr>";
                // If need show reading data
                //    echo "<code>";
                //    print_r($order_data);
                //    echo "</code>";
                //    echo "<hr>";

                $acf_user_id = 'user_' . $order->get_user_id();
                //echo $acf_user_id;
                $custname = get_field('custname', $acf_user_id);

                //echo $custname;
                $current_date_ymd = date("Y-m-d");
                //Get order_id and make order list products for array
                $items = $order->get_items();

                foreach ($items as $item) {
                    $product_name = $item['name'];
                    $product_id = $item['product_id'];
                    $product = new WC_Product($item['product_id']);
                    $SKU = $product->get_sku();
                    $refference = $item['refference'];
                    $qty = $item['qty'];
                    $json_decoded = json_decode($item);
                    $order_products[] = array('PARTNAME' => $SKU, 'DUEDATE' => $current_date_ymd . "T00:00:00+03:00", 'TQUANT' => $qty);
                    //'TQUANT' => "1"//Quantity

                }
                //echo "<hr>";
                //print_r($order_products);
                //echo "<hr>";
                // END Get order_id and make order list products for array

                //$curdate = $current_date_ymd . "T00:00:00+03:00";
                $curdate = $current_date_ymd . "T00:00:00+03:00";

                // $delivery_date = str_replace('/', '-', $delivery_date);
                // $delivery_date = explode("-", $delivery_date);
                // $delivery_date = $delivery_date[2]."-".$delivery_date[1]."-".$delivery_date[0];
                // $delivery_date = $delivery_date . "T00:00:00+03:00";

                $delivery_date = date('Y-m-d', strtotime($delivery_date));
                $delivery_date = $delivery_date . "T00:00:00+03:00";


                $data = array(

                    "CUSTNAME" => "" . $custname . "",
                    "CURDATE" => "" . $curdate . "",
                    "BOOKNUM" => "" . $order_id . "", // wp order_id
                    "REFERENCE" => "".$customised_refference."", // customer order-id. they can input their own reference number
                    //"ORDSTATUSDES" => "טיוטא", // constant
                    "ORDSTATUSDES" => "הז. אינטרנט", // constant
                    "NAME" => "".$order_billing_first_name." ".$order_billing_last_name."", // contact person on site
					//"ORDSTATUS" => "2",
                    "STCODE" => "" . $delivery_code . "", // constant
                    "TYPECODE" => "999", // constant
                    "DETAILS" => "" . str_replace('\n', ' ', $order_comments) . "",
                    "DUEDATE" => "" . $delivery_date . "",
                    "SHIPTO2_SUBFORM" => array(
                        "CUSTDES" => "".$order_shipping_company."", // where the order is to be shipped to
                        "NAME" => "".$order_shipping_first_name." ".$order_shipping_last_name."", // contact person on site
                        "PHONENUM" => "" . $shipping_phone . "", // phone number of he contact person
                        "ADDRESS" => "" . $shipping_address . "",
                        "ADDRESS2" => "" . $order_shipping_address_2 . "",
                        "ADDRESS3" => "",
                        "ZIP" => "" . $shipping_zipcode . "",
                        "STATE" => "" . $order_shipping_city . "" // yes the city goes into state. dont ask me why...
                    ),

                    "ORDERITEMS_SUBFORM" => $order_products,

                );

                $data_string_unsanitized = json_encode($data);
                $data_string = str_replace('\n', ' ', $data_string_unsanitized);
                //If need show result//
                //echo "<div style='direction: ltr;'><pre>";
                //echo "<hr>";
                //echo $order->get_shipping_postcode();
                //echo "<hr>";
                //print_r($data);
                //echo "</pre></div>";

                $login = 'apiuser';
                $password = 'tel0303';

                //$url = "https://opr.telefire.com/odata/Priority/tabula.ini/a301105/";
                //$url = "https://opr.telefire.com/odata/Priority/tabula.ini/a301105/CUSTOMERS/";
                $url = "https://opr.telefire.com/odata/Priority/tabula.ini/a301105/ORDERS/";
                //$url = "https://opr.telefire.com/odata/Priority/tabula.ini/a301105/PHONEBOOK/";  // Contact Persons
                //$url = "https://opr.telefire.com/odata/Priority/tabula.ini/a301105/LOGPART/";  //Products

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Content-Type: application/json')
                );
                // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
                $result = curl_exec($ch);
                $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                $info =    curl_getinfo($ch);
				$err = curl_error($ch);
                curl_close($ch);
                /*
                echo "<hr>";
                echo '<pre style="direction:ltr;">'; print_r(json_decode($result)); echo '</pre>';

                echo "<br> //<br>";

                 
    			echo "<pre>";
    			print_r($info);
    			echo "</pre>";
                echo 'HTTP code: ' . $httpcode;
                echo "<br> //<br>";
                */
                

				$fp = fopen('/home/telefnew/domains/telefire.com/public_html/lidn.txt', 'a');
				$text = "\n \n ordered: ".$data_string.", \n result: ".$result.", \n httpcode: ".$httpcode.", \n info:".serialize($info).", \n err: ".$err;
				?><div style="display:none"><?php echo $text; ?></div><?php
				fwrite($fp, $text);
				fclose($fp);



                $data_string_view = json_decode($data_string, true);

        
                if($httpcode!=200 && $httpcode!=201){

                    $to = 'genia@telefire.com, shelly@telefire.com, etamaro@gmail.com, eli@afikim-c.co.il, or@afikim-c.co.il, tamarb@telefire.com';
                    //$to = 'anatoliy.dovgun@gmail.com';
                    $subject = 'Telefire order: '.$order->get_id().' with code:'.$httpcode;
                    $body = $text."\n \n <br><br><hr><div style='direction: ltr;'><strong>ordered:</strong><pre>". print_r($data_string_view, true) ."</pre><hr><strong>result:</strong><pre>". print_r($result, true) ."</pre><hr><strong>httpcode:</strong><pre>". print_r($httpcode, true) ."</pre><hr><strong>info:</strong><pre>". print_r($info, true) ."</pre>";
                    $headers = array('Content-Type: text/html; charset=UTF-8');
                     
                    wp_mail( $to, $subject, $body, $headers );

					/* Redoind submit message if we got an error 500 */
					if($httpcode == 500){
					$ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Content-Type: application/json')
                );
                // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
                $result = curl_exec($ch);
                $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                $info =    curl_getinfo($ch);
				$err = curl_error($ch);
                curl_close($ch);
                /*
                echo "<hr>";
                echo '<pre style="direction:ltr;">'; print_r(json_decode($result)); echo '</pre>';

                echo "<br> //<br>";

                 
    			echo "<pre>";
    			print_r($info);
    			echo "</pre>";
                echo 'HTTP code: ' . $httpcode;
                echo "<br> //<br>";
                */
                

				$fp = fopen('/home/telefnew/domains/telefire.com/public_html/lidn.txt', 'a');
				$text = "\n \n ordered: ".$data_string.", \n result: ".$result.", \n httpcode: ".$httpcode.", \n info:".serialize($info).", \n err: ".$err;
				?><div style="display:none"><?php echo $text; ?></div><?php
				fwrite($fp, $text);
				fclose($fp);



                $data_string_view = json_decode($data_string, true);
				
				if($httpcode==200 || $httpcode==201){

                    $to = 'genia@telefire.com, shelly@telefire.com, etamaro@gmail.com, eli@afikim-c.co.il, or@afikim-c.co.il, tamarb@telefire.com';
                    //$to = 'anatoliy.dovgun@gmail.com';
                    $subject = 'Telefire order: '.$order->get_id().' retry after error 500 accepted with code:'.$httpcode;
                    $body = $text."\n \n <br><br><hr><div style='direction: ltr;'><strong>ordered:</strong><pre>". print_r($data_string_view, true) ."</pre><hr><strong>result:</strong><pre>". print_r($result, true) ."</pre><hr><strong>httpcode:</strong><pre>". print_r($httpcode, true) ."</pre><hr><strong>info:</strong><pre>". print_r($info, true) ."</pre>";
                    $headers = array('Content-Type: text/html; charset=UTF-8');
                     
                    wp_mail( $to, $subject, $body, $headers );


                }
        
                if($httpcode!=200 && $httpcode!=201){

                    $to = 'genia@telefire.com, shelly@telefire.com, etamaro@gmail.com, eli@afikim-c.co.il, or@afikim-c.co.il, tamarb@telefire.com';
                    //$to = 'anatoliy.dovgun@gmail.com';
                    $subject = '2nd time in a row Telefire order: '.$order->get_id().' with code:'.$httpcode;
                    $body = $text."\n \n <br><br><hr><div style='direction: ltr;'><strong>ordered:</strong><pre>". print_r($data_string_view, true) ."</pre><hr><strong>result:</strong><pre>". print_r($result, true) ."</pre><hr><strong>httpcode:</strong><pre>". print_r($httpcode, true) ."</pre><hr><strong>info:</strong><pre>". print_r($info, true) ."</pre>";
                    $headers = array('Content-Type: text/html; charset=UTF-8');
                     
                    wp_mail( $to, $subject, $body, $headers );


                }
                
                /* redoing is done */
                }
                }
                

            }

        }


        $order_send_priority = get_field('sended_in_priority_crm', $order->get_id());
        if ($order_send_priority != 1) {
            tel_send_order_to_priority($order_id);
            update_field('sended_in_priority_crm', 1, $order->get_id());

            //completed_new_order_notification($order_id);
            completed_new_order_notification($order_id);

        }

        //echo "<pre style='direction: ltr'>";
        //

        //echo "</pre>";
        //echo "<div class='center'><h1>Order sended to priority</h1></div>";
    }

        
function completed_new_order_notification( $order_id ) {
    // Get an instance of the WC_Order object
    $order = wc_get_order( $order_id );
    //var_dump($order);
    //echo "<hr>";
    //echo "/****************/<br>";
    $user_id = get_post_meta($order_id, '_customer_user', true);
    //echo $user_id;
    $user = "user_".$user_id;
    // Only for "completed" order status
    //if( ! $order->has_status( 'completed' ) ) return;
    // Get an instance of the WC_Email_New_Order object
    $wc_email = WC()->mailer()->get_emails()['WC_Email_New_Order'];
    //print_r($wc_email);
    //echo "<hr>";    
    ## -- Customizing Heading, subject (and optionally add recipients)  -- ##
    // Change Subject
    $wc_email->settings['subject'] = __('{site_title} - order #{order_number} COMPLETED - CUSTNAME  '.get_field('firm', $user).'-'.get_field('custdes', $user).', date: {order_date}');
    // Change Heading
    $wc_email->settings['heading'] = __('New customer completed Order'); 
    // $wc_email->settings['recipient'] .= ',name@email.com'; // Add email recipients (coma separated)
    // Send "New Email" notification (to admin)
    $wc_email->trigger( $order_id );
}    

//echo "<hr>";
  global $wpdb;
  global $woocommerce;
  $order = new WC_Order($order_id);


  // echo "<pre><code>";

  // print_r($order);

  // echo "</code></pre>";

  //echo "<hr>";
  $items = $order->get_items();
    // echo "<pre><code>";
    // print_r($items);
    // echo "</code></pre>";
/*
foreach ( $items as $item ) {
    $product_name = $item->get_name();
    $product_id = $item->get_product_id();
    $product_variation_id = $item->get_variation_id();
}
*/

?>
<script>
// Send transaction data with a pageview if available
// when the page loads. Otherwise, use an event when the transaction
// data becomes available.
dataLayer.push({
  'event': 'gtm4wp.purchaseCompleted',  
  'ecommerce': {
    'purchase': {
      'actionField': {
        'id': '<?php echo $_GET["order_id"]; ?>',                         // Transaction ID. Required for purchases and refunds.
        'affiliation': '<?php echo get_bloginfo("name"); ?>',
        'revenue': '<?php echo $order->total; ?>',                     // Total transaction value (incl. tax and shipping)
        'tax':'0',
        'shipping': '0',
        'coupon': ''
      },


      'products': [
       <?php foreach ( $items as $item ) { ?>
      {                            // List of productFieldObjects.
        'name': '<?php echo $item->get_name(); ?>',     // Name or ID is required.
        'id': '<?php echo $item->get_product_id(); ?>',
        //'price': '<?php echo $items->quantity; ?>',            
        'quantity': <?php echo $item->get_quantity(); ?>,    
       },
       <?php } ?>
       ]
    }
  }
});
</script>

<?php get_footer(); ?>