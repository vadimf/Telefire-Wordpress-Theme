<?php

function get_product_by_sku( $sku ) {
  global $wpdb;

  $product_id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' AND meta_value='%s' LIMIT 1", $sku ) );

  if ( $product_id ) return new WC_Product( $product_id );

  return null;
}

/**
*   Send user email with password reset link
**/

function tel_send_password_reset_mail($user_id){

    $user = get_user_by('id', $user_id);
    $firstname = $user->first_name;
    $email = $user->user_email;
    $adt_rp_key = get_password_reset_key( $user );
    $user_login = $user->user_login;
    $rp_link = '<a href="' . home_url() ."/my-account/lost-password/?key=$adt_rp_key&id=" . $user_id . '">' . home_url() ."/my-account/lost-password/?key=$adt_rp_key&id=" . $user_id . '</a>';

    if ($firstname == "") $firstname = "gebruiker";
    $message .= "שלום  " .$firstname ."<br><br>";
    $message .= "חשבון משתמש הוקם עבורך במערכת של טלפייר לכתובת המייל  ".$email."<br>";
    $message .= "ע&quot;מ להפעיל את החשבון אנא היכנס ללינק ואפס את הסיסמא אשר תשמש אותך בכניסה למערכת ההזמנות <br>";
    $message .= $rp_link ."<br><br>";
    $message .= "תודה" ;
    $subject = __("החשבון שלך בטלפייר  ");
    $headers = array();

    add_filter( 'wp_mail_content_type', function( $content_type ) {return 'text/html';});
    $headers[] = 'From: Telefire <info@telefire.co.il>'."\r\n";
    wp_mail( $email, $subject, $message, $headers);
    remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
}

/**
*   Create account for new user
**/
function tel_create_user($email, $firstname='', $lastname=''){
    $user_name = $email;
    $user_id = 0;   
    //check if the email is not in use yet
    if (!email_exists($email)) {
        $random_password = wp_generate_password(16);
        //create the user 
        $user_id = wp_create_user($user_name, $random_password, $email);
        if (!is_wp_error($user_id)) {
          
            //Not required: update user with details, role, firstname, lastname.
            $userdata = array(
                "ID" => $user_id,
                "first_name" => $firstname,
                "last_name" => $lastname,
                "role" => "customer",
                "locale" => "he_IL",
            );
            $user_id = wp_update_user($userdata);         
            //send password reset to user.
            //Commited for test

            $current_user = 'user_'. $user_id;
            //update_field('wc_confirm', true, $current_user);
            update_user_meta( $user_id, 'pw_user_status', 'approved' );
                
            tel_send_password_reset_mail($user_id);


            echo '<pre style="direction:ltr;">';
            echo 'We created NEW user '.$user_name.' | '.$firstname.' | '.$lastname;
            echo '</pre>';
        }

    }
    $user = get_user_by('email', $email);

    $user_id = $user->ID;

    //echo '<pre style="direction:ltr;">';
    //echo 'We returned user id: '.$user_id;
    //echo '</pre>';

    return $user_id;
}



/**
*   Fetch users from priority and save in WP
**/

function tel_fetch_contact_persons_from_priority() {

    //Set default status all users before sychronization
    
    $args1 = array(
        'role' => 'customer',
        'orderby' => 'user_nicename',
        'order' => 'ASC'
    );
    $subscribers = get_users($args1);
    echo "<hr>";
    echo "Check all users with Role customer and set: priority_status 0 as default";
    echo '<ul>';
    foreach ($subscribers as $user) {
        $user_id = $user->ID;
        update_field('priority_status', 0, 'user_'.$user_id.'');
        echo '<li>'.$user->ID.'|' . $user->display_name.'['.$user->user_email . ']  | '.get_field('priority_status', 'user_'.$user_id.'').'</li>';

        //priority_status
    }
    echo '</ul>';
    
    

    /*Work script */
    $login = 'apiuser';
    $password = 'tel0303';
    //$url = "https://opr.telefire.com/odata/Priority/tabula.ini/a301105/PHONEBOOK/?$filter=TELE_INTERFLAG%20eq%20%27Y%27";  // Contact Persons
    $filter = '$filter';
    $url = "https://opr.telefire.com/odata/Priority/tabula.ini/a301105/PHONEBOOK/?$filter=TELE_INTERFLAG%20eq%20%27Y%27";  // Contact Persons
    
    echo "Do by this link: ".$url;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json')
    );
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");

    $result = curl_exec($ch);
    curl_close($ch);
    $users = json_decode($result)->value;

    echo '<pre style="direction:ltr;">';
    print_r($users);
    echo '</pre>';

    //echo '<pre style="direction:ltr;">';
    //echo "<br>";
    //echo "List CUSTOMERS with flag on Priory: TELE_INTERFLAG == 'Y'";
    ?>




    <table>
    <tr>
        <td># |</td>
        <td>CUSTNAME |</td>
        <td>CUSTDES |</td>
    </tr>
    <?php
    $user_key = 1;
    foreach($users as $user) {
        if ($user->TELE_INTERFLAG == 'Y') {

            ?>
            <tr>
                <td><?php echo $user_key; ?></td>
                <td><?php echo $user->CUSTNAME; ?></td>
                <td><?php echo $user->CUSTDES; ?> / <?php echo $user->PHONE; ?></td>
            </tr>
            <tr>
                <td colspan="8">

                    <?php
                    $company_id = $user->CUSTNAME;
                    echo "<pre style='direction: ltr'>";

                    $filter = '$filter';
                    $expand = '$expand';
                    $login = 'apiuser';
                    $password = 'tel0303';
                    $url_d = "https://opr.telefire.com/odata/Priority/tabula.ini/a301105/CUSTOMERS?$filter=CUSTNAME%20eq%20%27$company_id%27&$expand=CUSTPERSONNEL_SUBFORM";  // Contact Persons

                    //echo "<br>";
                    echo "User ID in WC:".$url_d;

                    $ch_d = curl_init();
                    curl_setopt($ch_d, CURLOPT_URL,$url_d);
                    curl_setopt($ch_d, CURLOPT_HTTPHEADER, array(
                            'Content-Type: application/json')
                    );
                    curl_setopt($ch_d, CURLOPT_CUSTOMREQUEST, "GET");
                    curl_setopt($ch_d, CURLOPT_RETURNTRANSFER,1);
                    curl_setopt($ch_d, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                    curl_setopt($ch_d, CURLOPT_USERPWD, "$login:$password");

                    $result_d = curl_exec($ch_d);
                    curl_close($ch_d);
                    $company_staf = json_decode($result_d)->value;

                    //print_r($company_staf);

                    foreach($company_staf as $stafs) {

                        $stafs_detail = $stafs->CUSTPERSONNEL_SUBFORM;
                        foreach($stafs_detail as $staf) {

                            $user_id = tel_create_user($staf->EMAIL, $staf->NAME);

                            //Update user status: isset or not isset in priority
                            update_field('priority_status', 1, 'user_'.$user_id.'');
                            //echo "<hr>";

                            echo '<li>'.$user_id.'|'.get_field('priority_status', 'user_'.$user_id.'').'</li>';

                            //echo $user_id;
                            //echo "<hr>";

                            if ($user_id) {
                                if (!empty($staf->FIRSTNAME)) update_user_meta($user_id, 'first_name', $staf->FIRSTNAME);
                                if (!empty($staf->LASTNAME)) update_user_meta($user_id, 'last_name', $staf->LASTNAME);
                                if (!empty($staf->EMAIL)) update_user_meta($user_id, 'billing_email', $staf->EMAIL);
                                if (!empty($staf->FIRSTNAME)) update_user_meta($user_id, 'billing_first_name', $staf->FIRSTNAME);
                                if (!empty($staf->LASTNAME)) update_user_meta($user_id, 'billing_last_name', $staf->LASTNAME);
                                if (!empty($staf->CELLPHONE)) update_user_meta($user_id, 'billing_phone', $staf->CELLPHONE);
                                if (!empty($staf->FIRSTNAME)) update_user_meta($user_id, 'shipping_first_name', $staf->FIRSTNAME);
                                if (!empty($staf->LASTNAME)) update_user_meta($user_id, 'shipping_last_name', $staf->LASTNAME);
                                if (!empty($staf->FIRM)) update_field('firm', $staf->FIRM, 'user_' . $user_id);

                                // Additional data from COMPANY Desc
                                if (!empty($stafs->CUSTDES)) update_field('custdes', $stafs->CUSTDES, 'user_' . $user_id);
                                if (!empty($stafs->CUSTNAME)) update_field('custname', $stafs->CUSTNAME, 'user_' . $user_id);
                                if (!empty($stafs->CELLPHONE)) update_field('cellphone', $stafs->CELLPHONE, 'user_' . $user_id);
                                if (!empty($stafs->COUNTRYNAME)) update_field('state', $stafs->COUNTRYNAME, 'user_' . $user_id);
                                // Billing data from COMPANY Desc
                                if (!empty($stafs->CUSTDES)) update_user_meta($user_id, 'billing_company', $stafs->CUSTDES);
                                if (!empty($stafs->ADDRESS)) update_user_meta($user_id, 'billing_address_1', $stafs->ADDRESS);
                                if (!empty($stafs->STATE)) update_user_meta($user_id, 'billing_city', $stafs->STATE);
                                if (!empty($stafs->ZIP)) update_user_meta($user_id, 'billing_postcode', $stafs->ZIP);
                                if (!empty($stafs->COUNTRYNAME)) update_user_meta($user_id, 'billing_state', $stafs->COUNTRYNAME);
                                // Shipping data from COMPANY Desc
                                if (!empty($stafs->CUSTDES)) update_user_meta($user_id, 'shipping_company', $stafs->CUSTDES);
                                if (!empty($stafs->ADDRESS)) update_user_meta($user_id, 'shipping_address_1', $stafs->ADDRESS);
                                if (!empty($stafs->STATE)) update_user_meta($user_id, 'shipping_city', $stafs->STATE);
                                if (!empty($stafs->ZIP)) update_user_meta($user_id, 'shipping_postcode', $stafs->ZIP);
                                if (!empty($stafs->COUNTRYNAME)) update_user_meta($user_id, 'shipping_state', $stafs->COUNTRYNAME);
                                //Manual verified
                                update_field('user_verified', 1, 'user_' . $user_id);

                            }
                        }
                    }

                    echo "</pre>";
                    ?>
                </td>
            </tr>

            <?php


            $user_key++;
        }
    }
    ?>

    </table>
    <?php
    
    //Set default status all users before sychronization
    $args2 = array(
        'role' => 'customer',
        'orderby' => 'user_nicename',
        'order' => 'ASC'
    );
    $subscribers2 = get_users($args2);
    echo "<hr>";
    echo "Check all users with Role customer and delete if user not isset in priority:";
    echo '<ul>';
    /*foreach ($subscribers2 as $user) {
        $user_id = $user->ID;

        $priority_status = get_field('priority_status', 'user_'.$user_id.'');

        if($priority_status != 1){
            wp_delete_user( $user_id );
        }
        echo '<li>'.$user->ID.'|' . $user->display_name.'['.$user->user_email . ']  | '.get_field('priority_status', 'user_'.$user_id.'').'</li>';


        //priority_status
    } */
    echo '</ul>';
    

    echo '</pre>';

    
}


/******************* Additional import users */
/*https://opr.telefire.com/odata/Priority/tabula.ini/a301105/CUSTOMERS*/


function tel_fetch_contact_persons_additional_from_priority() {

    /*Work script */
    $login = 'apiuser';
    $password = 'tel0303';
    $url = "https://opr.telefire.com/odata/Priority/tabula.ini/a301105/PHONEBOOK/?$filter=TELE_INTERFLAG%20eq%20%27Y%27";  // Contact Persons
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json')
    );
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");

    $result = curl_exec($ch);
    curl_close($ch);
    $users = json_decode($result)->value;


    /**
    "CUSTNAME" => "3255186",
    "CUSTDES" => "HB SPORT",
    "PHONE" => "03-66677788",
    "EMAIL" => "etamaro@gmail.com",
    "ADDRESS" => "address 45",
    "NAME" => "Ethan (Joyn Toys)",
    "STATE" => "some city",
    "TELE_INTERFLAG" => "Y"
     */

    echo '<pre style="direction:ltr;">';
    print_r($users);
    echo '</pre>';

    echo '<pre style="direction:ltr;">';
    echo "<br>";
    echo "List CUSTOMERS with flag on Priory: TELE_INTERFLAG == 'Y'";
    ?>

    <table>
        <tr>
            <td># |</td>
            <td>CUSTNAME |</td>
            <td>CUSTDES |</td>
            <td>PHONE |</td>
            <td>EMAIL |</td>
            <td>ADDRESS |</td>
            <td>NAME |</td>
            <td>STATE |</td>
            <td>FIRM</td>
        </tr>

        <?php
        $user_key = 1;
        foreach($users as $user) {

            if ($user->TELE_INTERFLAG == 'Y') {

                $user_id = tel_create_user($user->EMAIL, $user->NAME);
                //echo 'We have user ID: '.$user_id.' for UPDATE';

                if ($user_id) {
                    if (!empty($user->FIRSTNAME)) update_user_meta( $user_id, 'first_name', $user->FIRSTNAME );
                    if (!empty($user->LASTNAME)) update_user_meta( $user_id, 'last_name', $user->LASTNAME );
                    if (!empty($user->EMAIL)) update_user_meta( $user_id, 'billing_email', $user->EMAIL );
                    if (!empty($user->FIRSTNAME)) update_user_meta( $user_id, 'billing_first_name', $user->FIRSTNAME );
                    if (!empty($user->LASTNAME)) update_user_meta( $user_id, 'billing_last_name', $user->LASTNAME );
                    if (!empty($user->FIRMPHONE)) update_user_meta( $user_id, 'billing_phone', $user->CELLPHONE );
                    if (!empty($user->STATE)) update_user_meta( $user_id, 'billing_city', $user->STATE );
                    if (!empty($user->ADDRESS)) update_user_meta( $user_id, 'billing_address_1', $user->ADDRESS );
                    if (!empty($user->FIRSTNAME)) update_user_meta( $user_id, 'shipping_first_name', $user->FIRSTNAME );
                    if (!empty($user->LASTNAME)) update_user_meta( $user_id, 'shipping_last_name', $user->LASTNAME );
                    if (!empty($user->STATE)) update_user_meta( $user_id, 'shipping_city', $user->STATE );
                    if (!empty($user->ADDRESS)) update_user_meta( $user_id, 'shipping_address_1', $user->ADDRESS );
                    if (!empty($user->CUSTDES)) update_field('custdes', $user->CUSTDES, 'user_' . $user_id);
                    if (!empty($user->CUSTNAME)) update_field('custname', $user->CUSTNAME, 'user_' . $user_id);
                    if (!empty($user->CUSTNAME)) update_field('firm', $user->FIRM, 'user_' . $user_id);

                    if (!empty($user->CUSTNAME)) update_field('cellphone', $user->CELLPHONE, 'user_' . $user_id);
                    if (!empty($user->CUSTNAME)) update_field('state', $user->STATE, 'user_' . $user_id);

                    update_field('user_verified', 1, 'user_' . $user_id);


                    //echo 'We updated user ID: '.$user_id. $user->FIRSTNAME.' '.$user->LASTNAME.'<br>';

                    //Default Verify
                    //$user_acf = "user_".$user_id;
                    //update_field('user_verified', 1, $user_acf);

                }

                ?>
                <tr>

                    <td><?php echo $user_key; ?></td>
                    <td><?php echo $user->CUSTNAME; ?></td>
                    <td><?php echo $user->CUSTDES; ?></td>
                    <td><?php echo $user->CELLPHONE; ?></td>
                    <td><?php echo $user->EMAIL; ?></td>
                    <td><?php echo $user->ADDRESS; ?></td>
                    <td><?php echo $user->NAME; ?></td>
                    <td><?php echo $user->STATE; ?></td>

                </tr>

                <?php
                $user_key++;
            }
        }
        ?>

    </table>
    <?php

    echo '</pre>';
}




/**
*   Fetch products from priority and save in WP
**/

function tel_fetch_products_price_from_priority(){


    /*Work script */
    $login = 'apiuser';
    $password = 'tel0303';

    $filter = '$filter';
    $expand = '$expand';

    $url = "https://opr.telefire.com/odata/Priority/tabula.ini/a301105/PRICELIST?".$filter."=TELE_PLINFLAG%20eq%20%27Y%27&".$expand."=PARTPRICE2_SUBFORM";  // Contact Persons


    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json')
    );
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");

    $result = curl_exec($ch);
    curl_close($ch);
    $prices = json_decode($result)->value;



    echo "/**********/";
    echo "<pre style='direction: ltr;'>";
    //echo $url;
    //print_r($prices);


    echo "</pre>";



    echo "<table>";

    $key = 1;
    foreach($prices as $price) {
        if ($price->TELE_PLINFLAG == 'Y') {
            //echo "<pre style='direction: ltr;'>";
            //print_r($price->PARTPRICE2_SUBFORM);

            //print_r($price);

            $oneprice = $price->PARTPRICE2_SUBFORM;
            echo "<tr><td>ID</td><td>SKU</td><td>PRICE</td></tr>";

            foreach($oneprice as $one) {

                $sku = $one->PARTNAME;
                $product_id = wc_get_product_id_by_sku( $sku );
                echo "<tr><td>".$key." - " . $product_id."</td><td>".$one->PARTNAME."-".$sku."</td><td>".$one->PRICE."</td></tr>";
                update_post_meta($product_id, '_price', (float)$one->PRICE);
                update_post_meta($product_id, '_regular_price', (float)$one->PRICE);
                
                $key++;
            }




            echo "</pre>";
        }

    }


    echo "<hr>";

    //$sku = "ADR-3000";
    //$product_id_one = wc_get_product_id_by_sku( $sku );
    //echo "/*************/".$product_id_one;
    //echo "/*************/".$product_id_one;
}




//function sac_add_meta_value_to_order_func( $order_id ) {}
/*
 * Moving this funtion to ThanksPage body */
/*
function tel_send_order_to_priority($order_id) {
    //Get order Id;
    //$order_id = $order->get_id();
    $order = new WC_Order( $order_id );
    $delivery_code = get_post_meta( $order_id, 'order_delivery', true );
    $delivery_date = get_post_meta( $order_id, '_delivery_date', true );

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


    //echo "<hr>";
    // If need show reading data
    //    echo "<code>";
    //    print_r($order_data);
    //    echo "</code>";
    //    echo "<hr>";

    $acf_user_id = 'user_'.$order->get_user_id();
    //echo $acf_user_id;
    $custname = get_field('custname', $acf_user_id);

    //echo $custname;
    $current_date_ymd = date("y-m-d");
    //Get order_id and make order list products for array
    $items = $order->get_items();

    foreach ( $items as $item ) {
        $product_name = $item['name'];
        $product_id = $item['product_id'];
        $product = new WC_Product($item['product_id']);
        $SKU = $product->get_sku();
        $refference = $item['refference'];
        $qty = $item['qty'];
        $json_decoded = json_decode($item);
        $order_products[] = array('PARTNAME' => $SKU, 'DUEDATE' => $current_date_ymd."T00:00:00+03:00", 'TQUANT' => $qty);
        //'TQUANT' => "1"//Quantity

    }
    //echo "<hr>";
    //print_r($order_products);
    //echo "<hr>";
    // END Get order_id and make order list products for array

    $data = array(
        "CUSTNAME" => $custname,
        "CURDATE" => $current_date_ymd."T00:00:00+03:00",
        "BOOKNUM" => $order_id, // wp order_id
        "REFERENCE" => $refference, // customer order-id. they can input their own reference number
        "ORDSTATUSDES" => "הז. אינטרנט", // constant
        "STCODE" => $delivery_code, // constant
        "TYPECODE" => "999", // constant
        "DETAILS" => $order_comments,
        "DUEDATE" => $delivery_date,
        "SHIPTO2_SUBFORM" => array(
            "CUSTDES" => "venue", // where the order is to be shipped to
            "NAME" => $order_billing_first_name, // contact person on site
            "PHONENUM" => $order_billing_phone, // phone number of he contact person
            "ADDRESS" => $order_billing_address_1,
            "ADDRESS2" => $order_billing_address_2,
            "ADDRESS3" => "",
            "STATE" => $order_billing_city // yes the city goes into state. dont ask me why...

        ),

        "ORDERITEMS_SUBFORM" => $order_products,

    );

    $data_string = json_encode($data);
    //If need show result
    //print_r($data);

    $login = 'apiuser';
    $password = 'tel0303';

    //$url = "https://opr.telefire.com/odata/Priority/tabula.ini/a301105/";
    //$url = "https://opr.telefire.com/odata/Priority/tabula.ini/a301105/CUSTOMERS/";
    $url = "https://opr.telefire.com/odata/Priority/tabula.ini/a301105/ORDERS/";
    //$url = "https://opr.telefire.com/odata/Priority/tabula.ini/a301105/PHONEBOOK/";  // Contact Persons
    //$url = "https://opr.telefire.com/odata/Priority/tabula.ini/a301105/LOGPART/";  //Products

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json')
    );
    // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
    $result = curl_exec($ch);
    curl_close($ch);
    //echo '<pre style="direction:ltr;">'; print_r(json_decode($result)); echo '</pre>';
}
*/



function test_priority() {

    $login = 'apiuser';
    $password = 'tel0303';

    //$url = myUrlEncode("https://opr.telefire.com/odata/Priority/tabula.ini/a301105/PRICELIST?$filter=TELE_PLINFLAG%20eq%20%27Y%27&$expand=PARTPRICE2_SUBFORM");

    //echo $url;

    //$url = "https://opr.telefire.com/odata/Priority/tabula.ini/a301105/";
    //$url = "https://opr.telefire.com/odata/Priority/tabula.ini/a301105/CUSTOMERS/";
    //$url = "https://opr.telefire.com/odata/Priority/tabula.ini/a301105/PRICELIST?$filter=TELE_PLINFLAG%20eq%20%27Y%27&$expand=PARTPRICE2_SUBFORM";
    //$url = "https://opr.telefire.com/odata/Priority/tabula.ini/a301105/PHONEBOOK/";  // Contact Persons
    //$url = "https://opr.telefire.com/odata/Priority/tabula.ini/a301105/LOGPART/";  //Products



    $ch = curl_init();
    $location = curl_escape($ch, '$filter=TELE_PLINFLAG%20eq%20%27Y%27&$expand=PARTPRICE2_SUBFORM');

    $url = myUrlEncode("https://opr.telefire.com/odata/Priority/tabula.ini/a301105/PRICELIST?{$location}");


    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json')
    );
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    // curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
    $result = curl_exec($ch);
    curl_close($ch);


    echo '<pre style="direction:ltr;">'; print_r(json_decode($result)->value); echo '</pre>';



}


/*Give products from PRIORITY*/
function tel_fetch_products_from_priority() {

    $login = 'apiuser';
    $password = 'tel0303';
    $url = "https://opr.telefire.com/odata/Priority/tabula.ini/a301105/LOGPART?$filter=SHOWINWEB%20eq%20%27Y%27";  // Products
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json')
    );
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");

    $result = curl_exec($ch);
    curl_close($ch);
    $products = json_decode($result)->value;

    /*
    echo "<pre style='direction: ltr;'>";
    print_r($products);
    echo "</pre>";
    */
    //echo '<pre style="direction:ltr;">';
    /*
    $products = array('0' => (object) [
            "PARTNAME" => "ADR-3000",
            "PARTDES" => "מערכת אנלוגית ל-127 כתובות 1A ",
            "EPARTDES" => " Analog addressable Control Panel-4A/Single loop ",
            "STATDES" => "פעיל ",
            "SHOWINWEB" => "Y",
            "OWNERLOGIN" => "oshrit",
            "CREATEDDATE" => "2007-05-30T00:00:00+03:00",
            "BASEPLPRICE" => "1200",
            "BASEPLCODE" => "USD",
            "CODE" => "ש'ח ",
            "CURDATE" => "2018-07-30T00:00:00+03:00",
            "CFNAME" => "מחושב ",
            "PRICE" => "599.25",
            "COST" => "599.25",
            "UDATE" => "2018-12-05T09:38:00+02:00",
              ]
      );
      */

    //print_r($products);




    echo '<pre style="direction:ltr;">';
    echo "<br>";
    echo "List PRODUCTS with flag on Priory: SHOWINWEB == 'Y'";

    $key = 1;


    ?>
    * Its specific field for WooCommerce
    <table>
        <tr>
            <td># |</td>
            <td>ShowInWEB</td>
            <td>PARTNAME |</td>
            <td>PARTDES |</td>
            <td>COST |</td>
            <td>SKY* |</td>
            <td>ACTIONS |</td>

            <td>FTNAME |</td>
            <td>FAMILYDES |</td>
            <td>EXTFILENAME </td>



        </tr>
        <?php
        foreach($products as $product) {
        
            if ($product->SHOWINWEB != 'Y') {
                $sku  = $product->PARTNAME;

                $current_product = get_product_by_sku($product->PARTNAME);

                if($current_product){
                    $my_post = array();
                    $my_post['ID'] = $current_product->id;
                    $my_post['post_status'] = 'draft';
                    wp_update_post( wp_slash($my_post) );
                        }
                }
                
                


            if ($product->SHOWINWEB == 'Y') {
                $sku  = $product->PARTNAME;

                $current_product = get_product_by_sku($product->PARTNAME);

                if($current_product){


                    // Создаем массив данных
                    $my_post = array();
                    $my_post['ID'] = $current_product->id;
                    $my_post['post_title'] = $product->PARTNAME;
                    $my_post['post_content'] = $product->PARTDES;
                    $my_post['post_status'] = 'publish';

                    // Обновляем данные в БД
                    wp_update_post( wp_slash($my_post) );

                    //echo "Need update product";
                    $product_actions = "Update";
                    update_post_meta($current_product->id, '_regular_price', 0);
                    update_post_meta($current_product->id, '_price', 0);
                    update_post_meta($current_product->id, 'priority_image', 'image-name' );

                    //Create category

                    $category_name = $product->FTNAME;
                    $child_category_name = $product->FAMILYDES;

                    if(!empty($category_name)) {


                        $term_parent = term_exists($category_name, 'product_cat');
                        //Get parent ID
                        $parent_cat_id = $term_parent['term_id'];
                        if ($term_parent !== 0 && $term_parent !== null) {
                            //echo __( $category_name." category exists!", "textdomain" );
                        } else {
                            // Insert parent
                            $parent_cat_id = wp_insert_term(
                                $category_name, // the term
                                'product_cat', // the taxonomy
                                array(
                                    'description' => '',
                                    'slug' => $category_name,
                                    'parent' => 0  // get numeric term id
                                )
                            );

                            //print_r($parent_cat_id);
                            //echo "Parent: ";
                            //echo $parent_cat_id;
                            $parent_cat_id = $parent_cat_id['term_id'];
                        }

                        if(!empty($child_category_name)){

                            //Child Category
                            $term_child = term_exists($child_category_name, 'product_cat');
                            $child_cat_id = $term_child['term_id'];
                            if ($term_child !== 0 && $term_child !== null) {
                                //echo __( $child_category_name." category exists!", "textdomain" );
                            } else {

                                // Insert parent
                                $child_cat_id = wp_insert_term(
                                    $child_category_name, // the term
                                    'product_cat', // the taxonomy
                                    array(
                                        'description' => '',
                                        'slug' => $child_category_name,
                                        'parent' => $parent_cat_id  // get numeric term id
                                    )
                                );
                            }
                        }
                    }

                    $categories = [ $child_category_name ];
                    wp_set_object_terms( $current_product->id, $categories, 'product_cat' );
                    echo "<hr>";
                }else{
                    $product_actions = "Add";
                    $post = array(
                        'post_author' => 1,
                        'post_content' => $product->PARTDES,
                        'post_status' => "publish",
                        'post_title' => $product->PARTNAME,
                        'post_parent' => '',
                        'post_type' => "product",
                    );

                    //Create post
                    $post_id = wp_insert_post( $post );
                    // if($post_id){
                    //     $attach_id = get_post_meta($product->parent_id, "_thumbnail_id", true);
                    //     update_post_meta($post_id, '_thumbnail_id', 1966);
                    // }



                    update_post_meta( $post_id, '_visibility', 'visible' );
                    update_post_meta( $post_id, '_stock_status', 'instock');
                    update_post_meta( $post_id, 'total_sales', '0');
                    update_post_meta( $post_id, '_downloadable', 'no');
                    update_post_meta( $post_id, '_virtual', 'no');
                    update_post_meta( $post_id, '_regular_price', 0);
                    update_post_meta( $post_id, '_price', 0);
                    update_post_meta( $post_id, '_sale_price', "" );
                    update_post_meta( $post_id, '_purchase_note', 'image-name' );
                    update_post_meta( $post_id, '_featured', "no" );
                    update_post_meta( $post_id, '_weight', "" );
                    update_post_meta( $post_id, '_length', "" );
                    update_post_meta( $post_id, '_width', "" );
                    update_post_meta( $post_id, '_height', "" );
                    update_post_meta( $post_id, '_sku', $product->PARTNAME);
                    update_post_meta( $post_id, '_product_attributes', array());
                    update_post_meta( $post_id, '_sale_price_dates_from', "" );
                    update_post_meta( $post_id, '_sale_price_dates_to', "" );
                    update_post_meta( $post_id, '_sold_individually', "" );
                    update_post_meta( $post_id, '_manage_stock', "no" );
                    update_post_meta( $post_id, '_backorders', "no" );
                    update_post_meta( $post_id, '_stock', "" );
                    update_post_meta( $post_id, 'custom_partdesc', $product->PARTDE );
                    //update_post_meta( $post_id, '_thumbnail_id', 1966);



                    //Generate_Featured_Image( 'http://telefire.eoidev3.co.il/wp-content/uploads/2018/09/%D7%98%D7%9C%D7%A4%D7%95%D7%9F-%D7%9B%D7%91%D7%90%D7%99%D7%9D-1-300x293.png',   $post_id );
                };
                ?>
                <tr>
                    <td><?php echo $key; ?></td>
                    <td>| <?php echo $product->SHOWINWEB; ?> |</td>
                    <td><?php echo $product->PARTNAME; ?></td>
                    <td><?php echo $product->PARTDES; ?></td>
                    <td><?php echo $product->COST; ?></td>
                    <td><?php echo $sku; ?></td>
                    <td><?php echo $product_actions; ?> / <?php echo get_post_status ( $current_product->id ); ?></td>
                    <td><?php echo $product->FTNAME; ?></td>
                    <td><?php echo $product->FAMILYDES; ?></td>
                    <td>

                        <hr>
                        <div style="direction: ltr;">
                            <?php
                            $path = $product->EXTFILENAME;
                            $name = basename($path);
                            $info = pathinfo($path);

                            update_post_meta($current_product->id, 'priority_image', $info['filename'] );


                            //var_dump($info);
                            //echo "<hr>";
                            //echo $info['filename'];

                            ?>
                        </div>

                    </td>
                </tr>
                <?php
                $key++;
            }
        }
        ?>
    </table>
    <?php
    echo '</pre>';

}



?>