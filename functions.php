<?php

/**

 * Theme Functions

 */



/**

 * Hide admin bar

 */



add_action('after_setup_theme', 'remove_admin_bar');
 
function remove_admin_bar() {
	if (!current_user_can('administrator') && !is_admin()) {
	  	show_admin_bar(false);
	} else if (current_user_can('administrator') && !is_admin()) {
		show_admin_bar(true);
	}
}

function my_login_logo_one() { 
?> 
<style type="text/css"> 
body.login div#login h1 a {
 background-image: url('/wp-content/themes/telefire/assets/images/logo.png');
background-size: 190px!important;
    background-position: center top;
    background-repeat: no-repeat;
    color: #444;
    height: 50px!important;
    font-size: 20px;
    font-weight: 400;
    line-height: 1.3em;
    margin: 0 auto 25px;
    padding: 0;
    text-decoration: none;
    width: 200px!important;
} 
</style>
 <?php 
} add_action( 'login_enqueue_scripts', 'my_login_logo_one' );



add_action( 'wp', 'sp_custom_notice' );

function sp_custom_notice() {
if ( is_admin() && ! defined( 'DOING_AJAX' ) ) return;

    //to display notice only on cart page
    if ( ! is_cart() ) {
        return;
    }

    global $product;

    $product_id = method_exists( $product, 'get_id' ) ? $product->get_id() : $product->id;
    if($product_id == 702){
        //check for quantify if equal to 1 in cart


        wc_clear_notices();
        wc_add_notice( __("Add one more to get 50% off on 2nd product"), 'notice');
    }
}

/**

 * Theme constants

 */



define( 'THEME_DIR', get_template_directory() );

define( 'THEME_URI', get_template_directory_uri() );



define( 'THEME_NAME', 'exlibris' );

define( 'THEME_VERSION', '1.0' );



define( 'LIBS_DIR', THEME_DIR. '/functions' );

define( 'LIBS_URI', THEME_URI. '/functions' );

define( 'LANG_DIR', THEME_DIR. '/languages' );



// Config --------------------------------------------------------------------

//require_once( LIBS_DIR .'/theme-config.php' );



// General --------------------------------------------------------------------

require_once( LIBS_DIR .'/theme-general.php' );



// Widgets --------------------------------------------------------------------

require_once( LIBS_DIR .'/theme-widgets.php' );



// Include scripts and styles -------------------------------------------------

require_once( LIBS_DIR .'/theme-head.php' );



// Priority -----------------------------------------------------------------

require_once( LIBS_DIR .'/theme-priority.php' );



// Menu -----------------------------------------------------------------------

require_once( LIBS_DIR .'/theme-menu.php' );



// Duplicate post and pages ---------------------------------------------------

//require_once( LIBS_DIR .'/theme-duplicator.php' );



// Custom post type -----------------------------------------------------------

require_once( LIBS_DIR .'/theme-post-types.php' );



// Woocommerce -----------------------------------------------------------

require_once( LIBS_DIR .'/theme-woocommerce.php' );


// Meta box -------------------------------------------------------------------

//require_once( LIBS_DIR .'/theme-metabox.php' );



// Social Share --------------------------------------------------------------

//require_once( LIBS_DIR .'/theme-social.php' );


require_once( LIBS_DIR .'/theme-companies.php' );



add_action('wp_footer', 'hide_admin_bar_prefs');
function hide_admin_bar_prefs() {
    $op = '
    <style type="text/css">        
        @media (max-width: 600px) {
            html {margin-top: 0!important;}
            #wpadminbar {display: none;}
        }
    </style> ';
    echo $op;
}


function register_scripts() {
    if ( !is_admin() ) {
        // include your script
        wp_enqueue_script( 'email-confirm', get_bloginfo( 'template_url' ) . '/assets/js/email-confirm.js' );
    }
}
add_action( 'wp_enqueue_scripts', 'register_scripts' );



add_action( 'wp_footer', 'my_custom_popup_scripts', 500 );
/**
 * Add a script to automatically close a popup after X seconds.
 *
 * @since 1.0.0
 *
 * @return void
 */
function my_custom_popup_scripts() { ?>
    <script type="text/javascript">
        (function ($, document, undefined) {

            $('#pum-9036')
                .on('pumAfterOpen', function () {
                    var $popup = $(this);
                    setTimeout(function () {
                        $popup.popmake('close');
                    }, 10000); // 10 Seconds
                });

        }(jQuery, document))
    </script><?php
}



remove_action( 'add_option_new_admin_email', 'update_option_new_admin_email' );
remove_action( 'update_option_new_admin_email', 'update_option_new_admin_email' );

/**
 * Disable the confirmation notices when an administrator
 * changes their email address.
 *
 * @see http://codex.wordpress.com/Function_Reference/update_option_new_admin_email
 */
function wpdocs_update_option_new_admin_email( $old_value, $value ) {

    update_option( 'admin_email', $value );
}
add_action( 'add_option_new_admin_email', 'wpdocs_update_option_new_admin_email', 10, 2 );
add_action( 'update_option_new_admin_email', 'wpdocs_update_option_new_admin_email', 10, 2 );

add_filter('use_block_editor_for_post', '__return_false');



/* Hide Wp-emoji from front */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

/* Hide Wp-embed */
function my_deregister_scripts(){
  wp_deregister_script( 'wp-embed' );
}
add_action( 'wp_footer', 'my_deregister_scripts' );



/* I add an empty "add-to-cart" parameter to the redirect of the link so that there is no re-addition of the product to the cart when the page is updated. */
function my_custom_add_to_cart_redirect( $url ) {
    $url .= (strpos($url, '?') ? '&' : '?') . 'add-to-cart';

    return $url;
}
add_filter( 'woocommerce_add_to_cart_redirect', 'my_custom_add_to_cart_redirect' );


// Return short url
function get_bitly_short_link($long_url){
    // $bitly_login = 'o_aae9hdvkr';
    // $bitly_apikey = 'R_a8f6e43385a844fdb6c24d352b13b122';

    // $long_url2 = rawurlencode($long_url);

    // $bitly_response = json_decode(file_get_contents("http://api.bit.ly/v3/shorten?login={$bitly_login}&apiKey={$bitly_apikey}&longUrl={$long_url2}&format=json"), 1);

    // if($bitly_response['data']){
    //     return $bitly_response['data']['url'];
    // }else{
    //     return false;
    // }

    global $wpdb;

    $db = shortener_db_connection($wpdb);

    $shortener = new Shortener($db);

    // Prefix of the short URL 
    $shortURL_Prefix = 'https://telefire.com/'; // with URL rewrite
    $shortURL_Prefix = 'https://telefire.com/?c='; // without URL rewrite

    try{
        // Get short code of the URL
        $shortCode = $shortener->urlToShortCode($long_url);
        
        // Create short URL
        $shortURL = $shortURL_Prefix.$shortCode;

        return $shortURL;

    }catch(Exception $e){
        // Display error
        //echo $e->getMessage();
        return false;
    }
}

// Send sms nexmo
function send_sms_nexmo($link = '', $user_id){
    if(!$link || !$user_id){ return false; }

    if($phone = get_user_meta($user_id, 'billing_phone', true)){
        $phone = str_replace(array(' ','(',')','-','_','*','+'),"", $phone);

        $search = '05';
        $pos = strpos($phone, $search);
        if($pos === 0){
            $phone = substr_replace($phone, '9725', $pos, strlen($search));
        }
    }else{
        return false;
    }

    $short_link = get_bitly_short_link($link);
    if(!$short_link){ return false; } 

    $url = 'https://rest.nexmo.com/sms/json?' . http_build_query([
        'api_key' => 'fed69f86',
        'api_secret' => 'pG15CA4BM9oTbOls',
        'type' => 'unicode',
        'to' => $phone,
        'from' => 'Telefire.com',
        'text' => 'איפוס סיסמה טלפייר '.$short_link
    ]);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    //print_r($response);

    return true;
}

function shortener_db_connection($wpdb) {

    $dbHost     = "localhost";
    $dbUsername = $wpdb->dbuser;
    $dbPassword = $wpdb->dbpassword;
    $dbName     = $wpdb->dbname;

    try{
        $db = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
    }catch(PDOException $e){
        echo "Connection failed: " . $e->getMessage();
    }

    return $db;
}


class Shortener
{
    protected static $chars = "abcdfghjkmnpqrstvwxyz|ABCDFGHJKLMNPQRSTVWXYZ|0123456789";
    protected static $table = "tele_short_urls";
    protected static $checkUrlExists = false;
    protected static $codeLength = 7;

    protected $pdo;
    protected $timestamp;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
        $this->timestamp = date("Y-m-d H:i:s");
    }

    public function urlToShortCode($url){
        if(empty($url)){
            throw new Exception("No URL was supplied.");
        }

        if($this->validateUrlFormat($url) == false){
            throw new Exception("URL does not have a valid format.");
        }

        if(self::$checkUrlExists){
            if (!$this->verifyUrlExists($url)){
                throw new Exception("URL does not appear to exist.");
            }
        }

        $shortCode = $this->urlExistsInDB($url);
        if($shortCode == false){
            $shortCode = $this->createShortCode($url);
        }

        return $shortCode;
    }

    protected function validateUrlFormat($url){
        return filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED);
    }

    protected function verifyUrlExists($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch,  CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return (!empty($response) && $response != 404);
    }

    protected function urlExistsInDB($url){
        $query = "SELECT short_code FROM ".self::$table." WHERE long_url = :long_url LIMIT 1";
        $stmt = $this->pdo->prepare($query);
        $params = array(
            "long_url" => $url
        );
        $stmt->execute($params);

        $result = $stmt->fetch();
        return (empty($result)) ? false : $result["short_code"];
    }

    protected function createShortCode($url){
        $shortCode = $this->generateRandomString(self::$codeLength);
        $id = $this->insertUrlInDB($url, $shortCode);
        return $shortCode;
    }
    
    protected function generateRandomString($length = 6){
        $sets = explode('|', self::$chars);
        $all = '';
        $randString = '';
        foreach($sets as $set){
            $randString .= $set[array_rand(str_split($set))];
            $all .= $set;
        }
        $all = str_split($all);
        for($i = 0; $i < $length - count($sets); $i++){
            $randString .= $all[array_rand($all)];
        }
        $randString = str_shuffle($randString);
        return $randString;
    }

    protected function insertUrlInDB($url, $code){
        $query = "INSERT INTO ".self::$table." (long_url, short_code, created) VALUES (:long_url, :short_code, :timestamp)";
        $stmnt = $this->pdo->prepare($query);
        $params = array(
            "long_url" => $url,
            "short_code" => $code,
            "timestamp" => $this->timestamp
        );
        $stmnt->execute($params);

        return $this->pdo->lastInsertId();
    }
    
    public function shortCodeToUrl($code, $increment = true){
        if(empty($code)) {
            throw new Exception("No short code was supplied.");
        }

        if($this->validateShortCode($code) == false){
            throw new Exception("Short code does not have a valid format.");
        }

        $urlRow = $this->getUrlFromDB($code);
        if(empty($urlRow)){
            throw new Exception("Short code does not appear to exist.");
        }

        if($increment == true){
            $this->incrementCounter($urlRow["id"]);
        }

        return $urlRow["long_url"];
    }

    protected function validateShortCode($code){
        $rawChars = str_replace('|', '', self::$chars);
        return preg_match("|[".$rawChars."]+|", $code);
    }

    protected function getUrlFromDB($code){
        $query = "SELECT id, long_url FROM ".self::$table." WHERE short_code = :short_code LIMIT 1";
        $stmt = $this->pdo->prepare($query);
        $params=array(
            "short_code" => $code
        );
        $stmt->execute($params);

        $result = $stmt->fetch();
        return (empty($result)) ? false : $result;
    }

    protected function incrementCounter($id){
        $query = "UPDATE ".self::$table." SET hits = hits + 1 WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $params = array(
            "id" => $id
        );
        $stmt->execute($params);
    }
}


/* Redirect to home if a user with the consultant or other role is trying to access the woocommerce store */
function role_consultant_and_other_close_shop() {
    if(is_user_logged_in() && class_exists('WooCommerce')){
        if($user = wp_get_current_user()){
            $user_roles = (array) $user->roles;
            $user_allcaps = (array) $user->allcaps;
            if(in_array('consultant', $user_roles) || in_array('other', $user_roles)){
                if($user_allcaps['close_access_to_the_shop'] && (is_woocommerce() || is_cart() || is_checkout() || is_account_page()) ){

                    wp_redirect(get_home_url());
                    exit;
                }
            }
        }
    }
}
add_action('template_redirect', 'role_consultant_and_other_close_shop', 8);


/* Redirect to home if page custom field "for_auo" = true */
function custom_access_to_the_page() {
    if(!is_user_logged_in() && function_exists('get_field')){
        if($for_auo = get_field('for_auo')){
            $url = get_home_url();

            if(function_exists('wc_get_page_permalink')){
                if($permalink = get_permalink(get_the_ID())){ $url = $permalink; }
                $url = wc_get_page_permalink('myaccount').'?return='.$url;
            }

            wp_redirect($url);
            exit;
        }
    }
}
add_action('template_redirect', 'custom_access_to_the_page', 7);


/* Register a woocommerce user with a specific role */
function custom_reg_consultant_or_other_user($form) {
    if ($form->id == 17337 || $form->id == 17338){
        $submission = WPCF7_Submission::get_instance();
        $posted_data = $submission->get_posted_data();

        $user_email = $posted_data['login_email'];
        $user_role = $posted_data['role'];

        $user_name = $posted_data['your-name'];
        $user_lastname = $posted_data['your-lastname'];
        $user_telephone = $posted_data['tel-telephone'];
        $user_company = $posted_data['your-company'];

        if($user_email && $user_role){
            $user_login = explode("@", $user_email)[0];
            if(username_exists($user_login)){
                for($u=2; $u<50; $u++){ 
                    $new_user_login = $user_login.$u;
                    if(!username_exists($new_user_login)){
                        $user_login = $new_user_login;
                        break;
                    } 
                }
            }

            $user_id = register_new_user($user_login, $user_email);
            if(!is_wp_error($user_id)){
                $args = array(
                    'ID' => $user_id, 
                    'role' => $user_role
                );

                if($user_name){ $args['first_name'] = $user_name; }
                if($user_lastname){ $args['last_name'] = $user_lastname; }
                if($user_telephone){ update_user_meta($user_id, 'billing_phone', $user_telephone); }
                if($user_company){ update_user_meta($user_id, 'billing_company', $user_company); }

                wp_update_user($args);
            }
        }  
    }
}
add_action('wpcf7_mail_sent', 'custom_reg_consultant_or_other_user');


/* Custom email for new users */
function custom_new_user_email( $email_data, $user, $blogname ) {
    $key = get_password_reset_key($user);
    if ( !is_wp_error($key) ) {
        $email_data['subject'] = 'ברוכים הבאים לאתר טלפייר';

        $message = "הי  " .$user->user_login. "\r\n\r\n";
        $message.= "תודה על הרשמתך לאתר טלפייר.לצורך השלמת הרישום הקש כאן". "\r\n\r\n";
        $message .= '<' . network_site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user->user_login ), 'login' ) . ">\r\n\r\n";
        $email_data['message'] = $message;
    }

    return $email_data;
}
add_filter( 'wp_new_user_notification_email', 'custom_new_user_email', 10, 3);


/* We return an error if a user with this email address is already registered. */
function custom_wpcf7_validate($result, $tag) {
    $tag = new WPCF7_Shortcode($tag);

    $value = isset($_POST[$tag->name]) ? trim(wp_unslash(strtr((string) $_POST[$tag->name], "\n", " "))) : '';
    if ('login_email' == $tag->name) {
        if ($tag->is_required() && $value != '' && email_exists($value)){
            $result->invalidate($tag, 'כתובת דוא״ל זו כבר רשומה למערכת');
        }
    }

    return $result;
}
add_filter('wpcf7_validate_email*', 'custom_wpcf7_validate', 10, 2);

include_once get_template_directory() . "/functions-globalbit.php";
