<?php
/**
 * The Header for our theme.
 */
$pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 
if ($pageURL=="http://telefire.com/online") {header("HTTP/1.1 301 Moved Permanently"); header("Location:http://telefire.com/my-account/?return=http://telefire.com/shop/"); exit();}
if ($pageURL=="http://telefire.com/online/") {header("HTTP/1.1 301 Moved Permanently"); header("Location:http://telefire.com/my-account/?return=http://telefire.com/shop/"); exit();}
if ($pageURL=="https://telefire.com/online") {header("HTTP/1.1 301 Moved Permanently"); header("Location:https://telefire.com/my-account/?return=https://telefire.com/shop/"); exit();}
if ($pageURL=="https://telefire.com/online/") {header("HTTP/1.1 301 Moved Permanently"); header("Location:https://telefire.com/my-account/?return=https://telefire.com/shop/"); exit();}
if ($pageURL=="https://telefire.com/he/") {header("HTTP/1.1 301 Moved Permanently"); header("Location:https://telefire.com/"); exit();}
if ($pageURL=="https://telefire.com/shop/") {header("HTTP/1.1 301 Moved Permanently"); header("Location:https://telefire.com/product-category/רכזות-גילוי-אש/"); exit();}


// Initialize Shortener class and pass PDO object

global $wpdb;

$db = shortener_db_connection($wpdb);

$shortener = new Shortener($db);

// Retrieve short code from URL
$shortCode = $_GET["c"];

try{
    // Get URL by short code
    $url = $shortener->shortCodeToUrl($shortCode);
    $clear_url = str_replace('#038;', '&' , $url);

    //echo $url;
    
    // Redirect to the original URL
    header("Location: ". $clear_url);
    exit;
}catch(Exception $e){
    // Display error
    //echo $e->getMessage();
}



$current_login_user_id = get_current_user_id();
$get_access = ( is_user_logged_in() && get_user_meta( $current_login_user_id, 'pw_user_status', true ) == 'approved' || current_user_can('editor') || current_user_can('administrator')) ? true : false;

if (!$get_access && (is_shop() || is_product() || is_product_category() || is_cart() || is_checkout())) {
    header('Location: '. add_query_arg( 'return', get_permalink( get_option('woocommerce_shop_page_id') ), get_permalink( get_option('woocommerce_myaccount_page_id') ) ));
    exit;
}

if (is_user_logged_in()) {
    $user = wp_get_current_user();
    $billing_first_name = get_user_meta( $user->ID, 'billing_first_name', true );
    $billing_last_name = get_user_meta( $user->ID, 'billing_last_name', true );
    $user_name = (!empty($billing_first_name) || !empty($billing_last_name)) ? $billing_first_name . ' ' . $billing_last_name : esc_html( $current_user->display_name );
} else $user_name = '';

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php wp_title('|', true, 'right'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <link rel="shortcut icon" type="image/x-icon" href="/wp-content/uploads/favicon.png">
    <?php wp_head(); ?>
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="alternate" type="application/rss+xml" title="<?php echo get_bloginfo('name'); ?> Feed" href="<?php echo esc_url(get_feed_link()); ?>">
    <?=get_field("code_in_head","option"); ?>
    <!-- Facebook Pixel Code -->
    <script>
      !function(f,b,e,v,n,t,s)
      {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
      n.callMethod.apply(n,arguments):n.queue.push(arguments)};
      if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
      n.queue=[];t=b.createElement(e);t.async=!0;
      t.src=v;s=b.getElementsByTagName(e)[0];
      s.parentNode.insertBefore(t,s)}(window, document,'script',
      'https://connect.facebook.net/en_US/fbevents.js');
      fbq('init', '669907476527771');
      fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
      src="https://www.facebook.com/tr?id=669907476527771&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Facebook Pixel Code -->
    <?php /*
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-TXJB76N');</script>
    <!-- End Google Tag Manager -->
    */ ?>
    
    <?php if ( function_exists( 'gtm4wp_the_gtm_tag' ) ) { gtm4wp_the_gtm_tag(); } ?>
<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '669907476527771');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=669907476527771&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->

<script type="text/javascript">
    function checkImage (src, good, bad) {
      var img = new Image();
      img.onload = good; 
      img.onerror = bad;
      img. src = src;
  }
  
</script>
<style>
@media only screen and (max-width: 767px){
  #carouselFront2.home-slider .slider-text h1 span:nth-of-type(1) {
      line-height: 37px;
      font-size: 45px;
      display: inline-block;
      font-weight: 700;
      margin-left: 0;
      padding-left: 0;
      margin-left: 15px;
  }  
}

@media only screen and (max-width: 520px){
  #carouselFront {
      height: 1580px;
  }
}
</style>
</head>

<body <?php body_class(); ?>>

  <div id="main_wrapper">
	<div id="wptime-plugin-preloader"></div>
    <?=get_field("code_in_body","option"); ?>
	<header id="header" class="headroom">
		<div class="main_header">
            <div class="custom-container">
                <div class="site_logo">
                    <a href="<?php echo home_url(); ?>">
                        <img src="<?php echo get_field('setting_logo', 'option'); ?>" alt="Logo" />
                    </a>
                </div>
                    
                <div class="tools">

                    <?php /*if( has_bought() ){ ?>
                        <div class="history-orders-in-tools">
                            <span><a href="/my-account/orders/">ההזמנות שלי</a></span>
                        </div>
                    <?php } */ ?>

                    <?php wp_nav_menu( array( 'menu' => 'Tools','menu_class' => 'tools-menu sf-menu sf-navbar','theme_location' => 'tools', 'container' => false, ) ); ?>
                    
                    <?php get_search_form(); ?>
                </div>

                <?php if ($get_access && is_user_logged_in() && is_shop() || is_product() || is_product_category()) : ?>

                  <?php wp_nav_menu(array(
                      'menu' => 'Shop menu', 
                      'menu_class' => 'sf-menu sf-navbar',
                      'container_id' => 'main-menu', 
                      'walker' => new CSS_Menu_Walker()
                  )); ?>

                <?php else: ?>

                  <?php wp_nav_menu(array(
                      'menu' => 'Main', 
                      'menu_class' => 'sf-menu sf-navbar',
                      'theme_location' => 'main',
                      'container_id' => 'main-menu', 
                      'walker' => new CSS_Menu_Walker()
                  )); ?>

                <?php endif; ?>

                <div class="pie">
                    <span class="icon-bar first"></span>
                    <span class="icon-bar second"></span>
                    <span class="icon-bar third"></span>
                </div>

                <?php if ($get_access && is_user_logged_in() && is_shop() || is_product() || is_product_category()) : ?>
                <div class="registrant_info hide_on_tablets">
                    <div class="top_section" style="background-image: url('/wp-content/uploads/2018/06/mini-cart-bg-image.png');">
                        <p><?php echo $user_name; ?></p>
                    </div>
                    <div class="settings">
                        <span class="account_info"><img src="<?php echo site_url() . '/wp-content/uploads/2018/06/icon_account_info.png'; ?>" alt="Icon"> <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="text">הגדרות</a></span>
                        <span class="log_out"><img src="<?php echo site_url() . '/wp-content/uploads/2018/06/icon_log_out.png'; ?>" alt="Icon"> <a href="<?php echo wp_logout_url( home_url() ); ?>" class="text">התנתק</a></span>
                    </div>
                    <div class="cart_section">
                        <?php if( has_bought() ){ ?>
                            <div class="history-orders">
                                <span><a href="/my-account/orders/">היסטוריית הזמנות</a></span>
                            </div>
                        <?php }  ?>
                        <span class="cart_items"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                        <a href="<?php echo get_permalink( wc_get_page_id( 'checkout' ) ); //cart ?>" class="text">מוצרים בסל</a>
                    </div>
                </div>
                <?php endif; ?>

            </div>
		</div>
        <div class="mobile-menu">
            
            <?php if ($get_access && is_user_logged_in() && is_shop() || is_product() || is_product_category()) : ?>

              <?php wp_nav_menu(array(
                  'menu' => 'Shop menu', 
                  'menu_class' => 'sf-menu sf-navbar',
                  'container_id' => 'mobile-menu', 
                  //'walker' => new CSS_Menu_Walker()
              )); ?>

            <?php else: ?>

              <?php wp_nav_menu(array(
                  'menu' => 'Mobile', 
                  'menu_class' => 'sf-menu sf-navbar',
                  'theme_location' => 'mobile',
                  'container_id' => 'mobile-menu',
              )); ?>

            <?php endif; ?>
        </div>
	</header><!-- /header -->