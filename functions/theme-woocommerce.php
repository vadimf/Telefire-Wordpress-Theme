<?php 

add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {

	add_theme_support( 'woocommerce' );

}

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');

/*Check user role*/
function is_user_role( $role, $user_id = null ) {
	$user = is_numeric( $user_id ) ? get_userdata( $user_id ) : wp_get_current_user();

	if( ! $user )
		return false;

	return in_array( $role, (array) $user->roles );
}

add_action( 'wp_print_scripts', 'remove_wc_password_meter', 100 );
function remove_wc_password_meter() {
	wp_dequeue_script('wc-password-strength-meter');
}

if ( isset( $wp->query_vars['customer-logout'] ) && 'true' === $wp->query_vars['customer-logout'] ) {
		// Redirect to the correct logout endpoint.
		wp_redirect( esc_url_raw( wc_get_account_endpoint_url( 'customer-logout' ) ) );
		exit;

}

function ws_new_user_approve_autologout($redirect_url){
    if ( is_user_logged_in() && !is_user_role( 'administrator' ) ) {
        $current_user = wp_get_current_user();
        $user_id = $current_user->ID;

        if ( get_user_meta($user_id, 'pw_user_status', true )  === 'approved' ){ $approved = true; }
		else{ $approved = false; }

		if ( $approved ){ 
			if ( isset($_REQUEST['return']) ) return $_REQUEST['return'];
			else return $redirect_url;
		}
        else{ //when user not approved yet, log them out
			wp_logout();
            return add_query_arg( 'approved', 'false', get_permalink( get_option('woocommerce_myaccount_page_id') ) );
        }
    }
}
//add_filter('woocommerce_registration_redirect', 'ws_new_user_approve_autologout', 10, 1);

function ws_new_user_approve_registration_message(){
    //$not_approved_message = __('<p class="note_registration">Send in your registration application today!<br /> NOTE: Your account will be held for moderation and you will be unable to login until it is approved.</p>', 'telefire');

    if( isset($_REQUEST['approved']) ){
            $approved = $_REQUEST['approved'];
            if ($approved == 'false')  _e('<p class="note_registration successful">Registration successful! You will be notified upon approval of your account.</p>', 'telefire');
            else echo $not_approved_message;
    }
    else echo $not_approved_message;
}
add_action('woocommerce_before_customer_login_form', 'ws_new_user_approve_registration_message', 2);

/**
 * This function adds custom columns in user listing screen in wp-admin area.
 */
function tele_update_user_table( $column ) {
	$column['wuev_verified']            = __( 'Verification Status', 'telefire' );
	$column['wuev_manual_verified']     = __( 'Manual Verify', 'telefire' );
	$column['wuev_manual_confirmation'] = __( 'Confirmation Email', 'telefire' );

	return $column;
}

add_filter( 'manage_users_columns', 'tele_update_user_table', 10, 1 );

/**
 * This function adds custom values to custom columns in user listing screen in wp-admin area.
 */
function tele_new_modify_user_table_row( $val, $column_name, $user_id ) {
	$user_role = get_userdata( $user_id );
	if ( 'wuev_verified' == $column_name ) {

		if ( 'administrator' != $user_role->roles[0] ) {
			if ( get_user_meta( $user_id, 'pw_user_status', true ) == 'approved' ) {
				return '<span class="wuev-circle wuev-iconright" title="' . __( 'Verified', 'telefire' ) . '"></span>';
			} else {
				return '<span class="wuev-circle wuev-iconwrong" title="' . __( 'Not Verified', 'telefire' ) . '"></span>';
			}
		} else {
			return 'Admin';
		}
	} else if ( 'wuev_manual_verified' == $column_name ) {
		if ( 'administrator' != $user_role->roles[0] ) {
			if ( get_user_meta( $user_id, 'pw_user_status', true ) != 'approved' ) {
				$text = __( 'Verify', 'telefire' );

				return '<a href=' . add_query_arg(
						array(
							'user_id'    => $user_id,
							'wp_nonce'   => wp_create_nonce( 'wc_email' ),
							'wc_confirm' => 'true',
						), get_admin_url() . 'users.php'
					) . '>' . __( 'Verify', 'telefire' ) . '</a>';
			}
			else{
				$text = __( 'Unverify', 'woo-confirmation-email' );

				return '<a href=' . add_query_arg(
						array(
							'user_id'    => $user_id,
							'wp_nonce'   => wp_create_nonce( 'wc_email' ),
							'wc_confirm' => 'false',
						), get_admin_url() . 'users.php'
					) . '>' . __( 'Unverify', 'telefire' ) . '</a>';
            }
		}
	} else if ( 'wuev_manual_confirmation' == $column_name ) {
		if ( 'administrator' != $user_role->roles[0] ) {
			$text = __( 'Send Email', 'telefire' );

			// if ( get_user_meta( $user_id, 'pw_user_status', true ) == 'approved' ) {
			//     return '';
			// }
			return '<a href=' . add_query_arg(
					array(
						'user_id'         => $user_id,
						'wp_nonce'        => wp_create_nonce( 'wc_email_confirmation' ),
						'wc_confirmation' => 'true',
					), get_admin_url() . 'users.php'
				) . '>' . __( 'Resend Email', 'telefire' ) . '</a>';
		}
	}

	return $val;
}

add_filter( 'manage_users_custom_column', 'tele_new_modify_user_table_row', 10, 3 );

/**
 * This function manually verifies a user from wp-admin area.
 */
function tele_manual_verify_user() {
	if ( isset( $_GET['user_id'] ) && isset( $_GET['wp_nonce'] ) && wp_verify_nonce( $_GET['wp_nonce'], 'wc_email' ) ) {
	    if(isset($_GET['wc_confirm']) && 'true' == $_GET['wc_confirm']){
		    update_user_meta( $_GET['user_id'], 'pw_user_status', 'approved' );
		    tele_send_confirmation_email($_GET['user_id']);
		    add_action( 'admin_notices', 'tele_manual_verify_email_success_admin' );
        }
        else{
            delete_user_meta( $_GET['user_id'], 'pw_user_status' );
            add_action( 'admin_notices', 'tele_manual_verify_email_unverify_admin' );
        }
	}

	if ( isset( $_GET['user_id'] ) && isset( $_GET['wp_nonce'] ) && wp_verify_nonce( $_GET['wp_nonce'], 'wc_email_confirmation' ) ) {
		tele_send_confirmation_email($_GET['user_id']);
		add_action( 'admin_notices', 'tele_manual_confirmation_email_success_admin' );
	}

}

add_action( 'admin_head', 'tele_manual_verify_user' );

function tele_send_confirmation_email($user_id) {
	$email_subject = __('Your Account is already verified', 'telefire');
	$current_user = get_user_by( 'id', $user_id );

	$email_body = 'Your account is already approved. You can access your account to view your orders and change your password here: ' . get_permalink( get_option('woocommerce_myaccount_page_id') );
	$mailer     = WC()->mailer();
	ob_start();
	$mailer->email_header( 'Your account approved' );
	echo $email_body;
	$mailer->email_footer();
	$email_body            = ob_get_clean();
	$email_abstract_object = new WC_Email();
	$email_body            = apply_filters( 'woocommerce_mail_content', $email_abstract_object->style_inline( wptexturize( $email_body ) ) );

	$email_body = apply_filters( 'tele_decode_html_content', $email_body );

	$mailer = WC()->mailer();
	$result = $mailer->send( $current_user->user_email, $email_subject, $email_body );
}

function tele_manual_verify_email_success_admin() {
	$text = __( 'User Verified Successfully. Confirmation Email has been sent to user.', 'telefire' );
	?>
    <div class="updated notice">
        <p><?php echo $text; ?></p>
    </div>
	<?php
}

function tele_manual_verify_email_unverify_admin() {
	$text = __( 'User Unverified.', 'telefire' );
	?>
    <div class="updated notice">
        <p><?php echo $text; ?></p>
    </div>
	<?php
}

function tele_manual_confirmation_email_success_admin() {
		$text = __( 'Confirmation Email Successfully resent.', 'telefire' );
		?>
        <div class="updated notice">
            <p><?php echo $text; ?></p>
        </div>
		<?php
	}

/*
 * This function removes backslashes from the textfields and textareas of the plugin settings.
 */
function tele_decode_html_content_func( $content ) {
	if ( empty( $content ) ) {
		return '';
	}
	$content = preg_replace( '#<script(.*?)>(.*?)</script>#is', '', $content );

	return html_entity_decode( stripslashes( $content ) );
}

add_filter( 'tele_decode_html_content', 'tele_decode_html_content_func', 1 );

add_filter('loop_shop_columns', 'loop_columns');
if (!function_exists('loop_columns')) {
	function loop_columns() {
		return 3; // 3 products per row
	}
}

remove_action( 'woocommerce_shop_loop_item_title','woocommerce_template_loop_product_title', 10 );
add_action('woocommerce_shop_loop_item_title', 'abChangeProductsTitle', 10 );
function abChangeProductsTitle() {

    //3500

    $loop_price = get_post_meta( get_the_ID(), '_price', true );
    $loop_price = number_format($loop_price, 0, '.', ',');

    echo '<h2 class="woocommerce-loop-product__title">' . get_the_title() . '<br>'. apply_filters('the_content', get_the_content()) .'<div class="loop-price">₪ '. $loop_price .'</div></h2>';
}



/**
 * Add additional field REFFERENCE for priora to the checkout page
 */
 add_action('woocommerce_after_order_notes', 'customise_checkout_field', 30, 20);

 function customise_checkout_field($checkout)
 {
     //echo '<div id="customise_checkout_field"><h2>' . __('REFFERENCE') . '</h2>';
     woocommerce_form_field('customised_refference', array(
         'type' => 'text',
         'class' => array(
             'my-field-class form-row-wide'
         ) ,
         'label' => __(" הזן מס' הזמנת לקוח") ,
         'placeholder' => __("הזן מס' הזמנת לקוח") ,
         'required' => false,
     ) , $checkout->get_value('customised_refference'));
     //echo '</div>';
 }



// function order_phone_backend($order){
//     echo "<p><strong>REFFERENCE:</strong> " . get_post_meta( $order->id, 'customised_refference', true ) . "</p><br>";
// }

add_action( 'woocommerce_admin_order_data_after_billing_address', 'order_phone_backend', 10, 1 );
/**
* Add trigger to BTN CHECK OUT
 */



/*Send to PRIORITY Order*/
//add_action( 'woocommerce_checkout_order_processed', 'tel_send_order_to_priority', 1, 1 );




function has_term_have_children( $term_id = '', $taxonomy = 'product_cat' )
{
    // Check if we have a term value, if not, return false
    if ( !$term_id ) 
        return false;
    // Get term children
    $term_children = get_term_children( filter_var( $term_id, FILTER_VALIDATE_INT ), filter_var( $taxonomy, FILTER_SANITIZE_STRING ) );
    // Return false if we have an empty array or WP_Error object
    if ( empty( $term_children ) || is_wp_error( $term_children ) )
    return false;
    return true;
}


function Generate_Featured_Image( $image_url, $post_id  ){
    $upload_dir = wp_upload_dir();
    $image_data = file_get_contents($image_url);
    $filename = basename($image_url);
    if(wp_mkdir_p($upload_dir['path']))     $file = $upload_dir['path'] . '/' . $filename;
    else                                    $file = $upload_dir['basedir'] . '/' . $filename;
    file_put_contents($file, $image_data);

    $wp_filetype = wp_check_filetype($filename, null );
    $attachment = array(
        'post_mime_type' => $wp_filetype['type'],
        'post_title' => sanitize_file_name($filename),
        'post_content' => '',
        'post_status' => 'inherit'
    );
    $attach_id = wp_insert_attachment( $attachment, $file, $post_id );
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
    $res1= wp_update_attachment_metadata( $attach_id, $attach_data );
    $res2= set_post_thumbnail( $post_id, $attach_id );
}


function woocommerce_button_proceed_to_checkout() {
    $checkout_url = WC()->cart->get_checkout_url(); ?>
    <a href="<?php echo esc_url( wc_get_checkout_url() );?>" class="checkout-button button alt wc-forward">
        <?php esc_html_e( ' המשך להזמנה ', 'woocommerce' ); ?>
    </a>
    <?php
}


function wc_billing_field_strings( $translated_text, $text, $domain ) {
    switch ( $translated_text ) {
        case 'פרטי חיוב' :
            $translated_text = __( 'פרטי הזמנה', 'woocommerce' );
            break;
    }
    return $translated_text;
}
add_filter( 'gettext', 'wc_billing_field_strings', 20, 3 );


function sv_require_wc_company_field( $fields ) {
    $fields['company']['required'] = true;
    return $fields;
}
add_filter( 'woocommerce_default_address_fields', 'sv_require_wc_company_field' );


add_filter( 'woocommerce_checkout_fields' , 'custom_add_checkout_fields', 10, 2 );
// Our hooked in function - $fields is passed via the filter!
function custom_add_checkout_fields( $fields ) {
     //unset($fields['order']['order_comments']);
     $fields['order']['order_delivery']['priority'] = 1;
     $fields['order']['order_delivery'] = array(
        'label'     => __('סוג מסירה', 'woocommerce'), //
    
    'required'  => true,
    'class'     => array('form-row-wide'),
    'clear'     => true,
     'type'          => 'select',
     'options'     => array(
    '' => _('בחירת שיטת משלוח'),
    '12' => __('-אספקה במשלוח  '),
    '11' => __('-איסוף עצמי '),
    
    )
     );  
     return $fields;
}

/**
 * Update the order meta with field value
 */
add_action( 'woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta' );

function my_custom_checkout_field_update_order_meta( $order_id ) {
    if ( ! empty( $_POST['order_delivery'] ) ) {
        update_post_meta( $order_id, 'order_delivery', sanitize_text_field( $_POST['order_delivery'] ) );
    }

    if ( ! empty( $_POST['customised_refference'] ) ) {
        update_post_meta( $order_id, 'customised_refference', sanitize_text_field( $_POST['customised_refference'] ) );
    }

    if ( ! empty( $_POST['shipping_phone'] ) ) {
        update_post_meta( $order_id, 'shipping_phone', sanitize_text_field( $_POST['shipping_phone'] ) );
    }
}




function has_bought( $user_id = 0 ) {
    global $wpdb;
    $customer_id = $user_id == 0 ? get_current_user_id() : $user_id;
    $paid_order_statuses = array_map( 'esc_sql', wc_get_is_paid_statuses() );

    $results = $wpdb->get_col( "
        SELECT p.ID FROM {$wpdb->prefix}posts AS p
        INNER JOIN {$wpdb->prefix}postmeta AS pm ON p.ID = pm.post_id
        WHERE p.post_status IN ( 'wc-" . implode( "','wc-", $paid_order_statuses ) . "' )
        AND p.post_type LIKE 'shop_order'
        AND pm.meta_key = '_customer_user'
        AND pm.meta_value = $customer_id
    " );

    // Count number of orders and return a boolean value depending if higher than 0
    return count( $results ) > 0 ? true : false;
}


add_action( 'woocommerce_checkout_update_shipping_meta', 'add_order_shipping' , 10, 1);
function add_order_shipping ( $order_id ) {
    if ( isset( $_POST ['_shipping_first_name'] ) &&  '' != $_POST ['_shipping_first_name'] ) {
        update_post_meta( $order_id, '_shipping_first_name', sanitize_text_field(  $_POST ['_shipping_first_name']  ) );
    }
}


function custom_my_account_menu_items( $items ) {
    unset($items['downloads']);
    return $items;
}
add_filter( 'woocommerce_account_menu_items', 'custom_my_account_menu_items' );


/*Max leight on order_comments*/
add_action("wp_footer", "cod_set_max_length");
function cod_set_max_length(){
	?>
		<script>
			jQuery(document).ready(function($){
				$("#order_comments").attr('maxlength','24');
			});
		</script>
	<?php
	}


function md_custom_woocommerce_checkout_fields( $fields ) 
{
    $fields['order']['order_comments']['placeholder'] = ' הערות על ההזמנה, לדוגמה, הערות מיוחדות למסירה. (עד 24 תוים) ';
    //$fields['order']['order_comments']['label'] = 'Add your special note';

    return $fields;
}
add_filter( 'woocommerce_checkout_fields', 'md_custom_woocommerce_checkout_fields' );





/*
 * Change the order of the endpoints that appear in My Account Page - WooCommerce 2.6
 * The first item in the array is the custom endpoint URL - ie http://mydomain.com/my-account/my-custom-endpoint
 * Alongside it are the names of the list item Menu name that corresponds to the URL, change these to suit
 */

function wpb_woo_my_account_order() {
    $myorder = array(
        //'my-custom-endpoint' => __( 'My Stuff', 'woocommerce' ),

        //'dashboard'          => __( 'מידע אישי', 'woocommerce' ), //'הגדרות'
        'orders'             => __( 'היסטורית הזמנות', 'woocommerce' ),
        //'edit-address'          => __( 'כתובת', 'woocommerce' ),
        'edit-account'       => __( 'שינוי סיסמא', 'woocommerce' ),
        //'edit-address'       => __( 'Addresses', 'woocommerce' ),
        //'payment-methods'    => __( 'Payment Methods', 'woocommerce' ),
        'customer-logout'    => __( 'התנתקות', 'woocommerce' ),
    );
    return $myorder;
}
add_filter ( 'woocommerce_account_menu_items', 'wpb_woo_my_account_order' );

/*Redirect After login to shop page*/
function wc_custom_user_redirect( $redirect, $user ) {
// Get the first of all the roles assigned to the user
    $role = $user->roles[0];
    $dashboard = admin_url();
    $myaccount = get_permalink( wc_get_page_id( 'shop' ) );
    if( $role == 'administrator' ) {
//Redirect administrators to the dashboard
        $redirect = $dashboard;
    } elseif ( $role == 'shop-manager' ) {
//Redirect shop managers to the dashboard
        $redirect = $dashboard;
    } elseif ( $role == 'editor' ) {
//Redirect editors to the dashboard
        $redirect = $dashboard;
    } elseif ( $role == 'author' ) {
//Redirect authors to the dashboard
        $redirect = $dashboard;
    } elseif ( $role == 'customer' || $role == 'subscriber' ) {
//Redirect customers and subscribers to the "My Account" page
        $redirect = $myaccount;
    } else {
//Redirect any other role to the previous visited page or, if not available, to the home
        $redirect = wp_get_referer() ? wp_get_referer() : home_url();
    }
    return $redirect;
}
add_filter( 'woocommerce_login_redirect', 'wc_custom_user_redirect', 10, 2 );



/* Redirects to the Orders List instead of Woocommerce My Account Dashboard */
function custom_woocommerce_account_redirect() {
    global $wp;
    $current_url = home_url($wp->request.'/');
    $dashboard_url = get_permalink(get_option('woocommerce_myaccount_page_id'));
    
    if(is_user_logged_in() && $dashboard_url == $current_url){
        $orders = get_option('woocommerce_myaccount_orders_endpoint', 'orders');
        $url = get_home_url().'/my-account/'.$orders;
        wp_redirect($url);
        exit;
    }
}
add_action('template_redirect', 'custom_woocommerce_account_redirect');







//add_action( 'woocommerce_checkout_update_order_meta', 'display_extra_fields_after_billing_address' , 10, 1);
add_action('woocommerce_after_order_notes', 'display_extra_fields_after_billing_address' , 10, 1 );
function display_extra_fields_after_billing_address () {
    ?>
    <div class="delivery_date">
      <?php /*echo _e( " תאריך משלוח/איסוף עצמי <abbr class='required'>*</abbr>", "add_extra_fields");  ?>
        <input type="text" name="add_delivery_date" autocomplete="off" class="add_delivery_date" placeholder="בחר תאריך">
      <?php */?>

        <?php woocommerce_form_field( 'add_delivery_date', array(
            'type'          => 'text',
            'id'            => 'add_delivery_date',
            'class'         => array('form-row-wide'),
            'input_class'       => array('add_delivery_date'),
            'label'         => __( " תאריך משלוח/איסוף עצמי ", "add_extra_fields"),
            'required'  => true,
            'placeholder' => 'בחר תאריך',
            'autocomplete' => 'off',
            ), '');
        ?>

     <script>
         jQuery(document).ready(function($) {
            
            var date = new Date();
            var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

            jQuery('.add_delivery_date').datepicker({
                dateFormat: 'dd/mm/yy',
                minDate: today
            });
            //


          // $(".add_delivery_date").datepicker({
          //     minDate: 0,    
          // });
          });
      </script>


    </div>
     <?php
}
add_action( 'wp_enqueue_scripts', 'enqueue_datepicker' );
function enqueue_datepicker() {
    if ( is_checkout() ) {
        // Load the datepicker script (pre-registered in WordPress).
        wp_enqueue_script( 'jquery-ui-datepicker' );
        // You need styling for the datepicker. For simplicity I've linked to Google's hosted jQuery UI CSS.
        wp_register_style( 'jquery-ui', '//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css' );
        wp_enqueue_style( 'jquery-ui' );  
    }
}
add_action( 'woocommerce_checkout_update_order_meta', 'add_order_delivery_date_to_order' , 10, 1);
function add_order_delivery_date_to_order ( $order_id ) {
     if ( isset( $_POST ['add_delivery_date'] ) &&  '' != $_POST ['add_delivery_date'] ) {
         add_post_meta( $order_id, '_delivery_date',  sanitize_text_field( $_POST ['add_delivery_date'] ) );
     }
}
add_filter( 'woocommerce_email_order_meta_fields', 'add_delivery_date_to_emails' , 10, 3 );
function add_delivery_date_to_emails ( $fields, $sent_to_admin, $order ) {
    if( version_compare( get_option( 'woocommerce_version' ), '3.0.0', ">=" ) ) {            
        $order_id = $order->get_id();
    } else {
        $order_id = $order->id;
    }
    $delivery_date = get_post_meta( $order_id, '_delivery_date', true );
    if ( '' != $delivery_date ) {
        $fields[ 'Delivery Date' ] = array(
        'label' => __( 'Delivery Date', 'add_extra_fields' ),
        'value' => $delivery_date,

        );
     }
    return $fields;
}

/**
 * Process the checkout
 */
add_action('woocommerce_checkout_process', 'my_custom_checkout_field_process_woocommerce');
function my_custom_checkout_field_process_woocommerce() {
    if ( ! $_POST ['add_delivery_date'] ){
        wc_add_notice(__( 'Delivery Date Is Required.', 'add_extra_fields' ), 'error'); 
    }
}


/**
 * Update the order meta with field value
 */




add_filter( 'woocommerce_order_details_after_order_table', 'add_delivery_date_to_order_received_page', 10 , 1 );
function add_delivery_date_to_order_received_page ( $order ) {
    if( version_compare( get_option( 'woocommerce_version' ), '3.0.0', ">=" ) ) {            
        $order_id = $order->get_id();
    } else {
        $order_id = $order->id;
    }
    $delivery_date = get_post_meta( $order_id, '_delivery_date', true );
    
    if ( '' != $delivery_date ) {
        echo '<p class="delivery_date"><strong>' . __( 'Delivery Date', 'add_extra_fields' ) . ':</strong> ' . $delivery_date;
    }




}



function example_price_free_delivery_note() {
    ?>
    <style>
        .order .billing-address {
            width: 50%;
            float: right;
        }
        .order .company-logo img{
            width: 235px!important;
            height: auto!important;
        }
        .order .order-info ul {
            border-top: 0.24em solid black;
            text-align: right;
        }

        .order th {
            text-align: right;
        }

        .order .order-items .head-quantity, .order-items .product-quantity, .order-items .total-quantity, .order-items .head-item-price, .order-items .product-item-price, .order-items .total-item-price {
            width: 15%;
            text-align: right;
        }

        .order .order-items .head-price, .order-items .product-price, .order-items .total-price {
            width: 20%;
            text-align: right;
        }

        .order .order-branding, .order-addresses, .order-info, .order-items, .order-notes, .order-thanks, .order-colophon {
            margin-bottom: 3em;
            text-align: right;
        }
        .order .extras{
            display: none;
        }

        /*.order .total-name, .order .total-item-price, .order .total-quantity, .order .total-price{*/
            /*display: none;*/
        /*}*/
    </style>
    <?php
}
add_action( 'wcdn_head', 'example_price_free_delivery_note', 20 );


//Disable default checked same address
add_filter( 'woocommerce_ship_to_different_address_checked', '__return_false' );

/**
* Display field value on the order page after shipping details
**/
add_action( 'woocommerce_admin_order_data_after_shipping_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );



add_filter( 'woocommerce_shipping_fields' , 'my_additional_shipping_fields' );
function my_additional_shipping_fields( $fields ) {

    $fields['shipping_phone'] = array(
        'label'         => __( 'מספר טלפון למשלוח', 'woocommerce' ),
        'required'      => true,
        'class'         => array( '' ),
        'clear'         => true,
        'validate'      => array( 'phone' ),
    );
    return $fields;
}


add_action( 'woocommerce_before_cart', 'auto_select_free_shipping_by_default' );
function auto_select_free_shipping_by_default() {
    if ( ! WC()->session->has_session() )
        WC()->session->set_customer_session_cookie( true );

    // Check if "free shipping" is already set
    if ( strpos( WC()->session->get('chosen_shipping_methods')[0], 'free_shipping' ) !== false )
        return;

    // Loop through shipping methods
    foreach( WC()->session->get('shipping_for_package_0')['rates'] as $key => $rate ){
        if( $rate->method_id === 'free_shipping' ){
            // Set "Free shipping" method
            WC()->session->set( 'chosen_shipping_methods', array($rate->id) );
            return;
        }
    }
}



add_filter( 'woocommerce_checkout_fields' , 'custom_remove_woo_checkout_fields' );

function custom_remove_woo_checkout_fields( $fields ) {

    unset($fields['billing']['billing_address_2']);
    unset($fields['shipping']['shipping_address_2']);
    unset($fields['shipping']['shipping_country']);

    return $fields;
}

add_filter('woocommerce_billing_fields', 'my_woocommerce_billing_fields');
function my_woocommerce_billing_fields($fields)
{
    $fields['billing_first_name']['custom_attributes'] = array('readonly'=>'readonly');
    $fields['billing_last_name']['custom_attributes'] = array('readonly'=>'readonly');
    $fields['billing_company']['custom_attributes'] = array('readonly'=>'readonly');
    $fields['billing_address_1']['custom_attributes'] = array('readonly'=>'readonly');
    $fields['billing_postcode']['custom_attributes'] = array('readonly'=>'readonly');
    $fields['billing_city']['custom_attributes'] = array('readonly'=>'readonly');
    $fields['billing_phone']['custom_attributes'] = array('readonly'=>'readonly');
    $fields['billing_email']['custom_attributes'] = array('readonly'=>'readonly');

    return $fields;
}


function my_text_strings( $translated_text, $text, $domain ) {
    switch ( $translated_text ) {
        case 'מיקוד / תא דואר' :
            $translated_text = __( 'מיקוד', 'woocommerce' );

//        case "מספר בית ושם רחוב" :
//            $translated_text = __( 'כתובת אחרת למשלוח', 'woocommerce' );



            break;
    }
    return $translated_text;
}
add_filter( 'gettext', 'my_text_strings', 20, 3 );


// Hook in
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields_shipping' );

// Our hooked in function - $fields is passed via the filter!
function custom_override_checkout_fields_shipping( $fields ) {
    //$fields['order']['order_comments']['placeholder'] = 'My new placeholder';
    $fields['shipping']['shipping_address_1']['label'] = ' כתובת אחרת למשלוח';
    return $fields;
}

add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
function custom_override_checkout_fields( $fields ) {
    $fields['billing']['billing_address_1']['required'] = false;
    $fields['billing']['billing_postcode']['required'] = false;
    $fields['billing']['billing_city']['required'] = false;


    $fields['shipping']['shipping_first_name']['required'] = false;
    $fields['shipping']['shipping_last_name']['required'] = false;
    $fields['shipping']['shipping_company']['required'] = false;
    $fields['shipping']['shipping_address_1']['required'] = false;
    $fields['shipping']['shipping_postcode']['required'] = false;
    $fields['shipping']['shipping_city']['required'] = false;
    $fields['shipping']['shipping_city']['priority'] = 60;
    $fields['shipping']['shipping_postcode']['required'] = false;

    //$fields['additional']['add_delivery_date']['required'] = true;

    return $fields;
}


add_filter( 'woocommerce_email_headers', 'mycustom_headers_filter_function', 10, 2);

function mycustom_headers_filter_function( $headers, $object ) {
    if ($object == 'customer_completed_order') {
        $headers .= 'BCC: info@telefire.com, shelly@telefire.com, genia@telefire.com, dganit@telefire.com, linor@telefire.com, adovgun@gmail.com, tamarb@telefire.com' . "\r\n";
    }

    return $headers;
}



add_filter( 'woocommerce_email_subject_customer_completed_order', 'change_completed_email_subject', 1, 2 );

function change_completed_email_subject( $subject, $order ) {
    global $woocommerce;

    $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

    //$subject = sprintf( 'Hi %s, thanks for your order on %s', $order->billing_first_name, $blogname );

    /*********/
    $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
    $order_id = $order->id;
    $user_id = get_post_meta($order_id, '_customer_user', true);
    $user = "user_".$user_id;
    $user_info = get_userdata($user_id);
    $custdes = get_field('custdes', $user);
    $subject = sprintf( "הזמנה מס': #%s, טלפייר אונליין (%s) - %s %s", $order_id , $custdes, $user_info->first_name, $user_info->last_name);

    return $subject;
}

// Clear Wp rocket cache 
add_action('woocommerce_add_to_cart', 'custom_clear_wprocket_cache');
add_action('woocommerce_cart_item_removed', 'custom_clear_wprocket_cache');
add_action('woocommerce_cart_updated', 'custom_clear_wprocket_cache');
function custom_clear_wprocket_cache() {
    if ( function_exists( 'rocket_clean_domain' ) ) {
        rocket_clean_domain();
    }
}

// Return cart coun
add_action('wp_ajax_ajax_get_cart_count', 'ajax_get_cart_count');
add_action('wp_ajax_nopriv_ajax_get_cart_count', 'ajax_get_cart_count');
function ajax_get_cart_count() {
    if($qty = WC()->cart->get_cart_contents_count()){
      echo $qty; 
    }else{
      echo '';
    }
    exit;
}


 


?>