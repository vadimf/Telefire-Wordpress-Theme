<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product, $woocommerce_loop;
// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
    $woocommerce_loop['loop'] = 0;
// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
    $woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 3 );
// Ensure visibility
if ( ! $product->is_visible() )
    return;
// Increase loop count
$woocommerce_loop['loop'] = $woocommerce_loop['loop']++;
$classes = array();
$classes[] = $woocommerce_loop['loop'];

?>


<li <?php wc_product_class(); ?>>
    <?php
        $product_id = $product->get_id();
        $product_image = get_field('priority_image', $product_id );
        $priority_image = "/wp-content/uploads/priority-products/". $product_image.".jpg";

        if(empty($product_image)){
            $priority_image = "/wp-content/plugins/woocommerce/assets/images/placeholder.png";
        }
    ?>
<span   class="gtm4wp_productdata" 
        style="display:none;visibility:hidden;" 
        data-gtm4wp_product_id="<?php echo $product_id; ?>" 
        data-gtm4wp_product_name="<?php echo get_the_title(); ?>" 
        data-gtm4wp_product_price="<?php echo $product->get_price(); ?> " 
        data-gtm4wp_product_cat="" 
        data-gtm4wp_product_url="<?php echo get_permalink(); ?>" 
        data-gtm4wp_product_listposition="<?php echo $woocommerce_loop['loop']; ?>" 
        data-gtm4wp_productlist_name="General Product List" 
        data-gtm4wp_product_stocklevel="" 
        data-gtm4wp_product_brand=""        

        >            
        </span>
    <div class="product-wrap-image product-image-list woocommerce-placeholder wp-post-image product-<?php echo  $product->id; ?>" style="background: url('<?php echo $priority_image; ?>') #fff;
            width: 100%;
            height: 300px;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            ">

        <div class="bg-default">
            <?php ob_start(); ?>
            <div class="q-ty-block">
                <div class="q-ty-bg"></div>
                <div class="single-product-qt">
                    <?php do_action( 'woocommerce_before_add_to_cart_quantity' );
                        woocommerce_quantity_input( array(
                            'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
                            'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
                            'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
                        ) );
                        do_action( 'woocommerce_after_add_to_cart_quantity' );
                    ?>

                    <?php woocommerce_template_loop_add_to_cart(); ?>
                </div>
            </div>
            <?php 
                $q_ty_block = ob_get_contents(); 
                ob_end_clean(); 
                echo $q_ty_block;
            ?>

        </div>

    </div>

    <img class="product-mob-image" src="<?php echo $priority_image; ?>" alt="<?php echo get_the_title(); ?>">

    <div class="product-wrap-content">

    <?php
    	/**
    	 * Hook: woocommerce_shop_loop_item_title.
    	 *
    	 * @hooked woocommerce_template_loop_product_title - 10
    	 */
    	do_action( 'woocommerce_shop_loop_item_title' );

    	/**
    	 * Hook: woocommerce_after_shop_loop_item_title.
    	 *
    	 * @hooked woocommerce_template_loop_rating - 5
    	 * @hooked woocommerce_template_loop_price - 10
    	 */
    	do_action( 'woocommerce_after_shop_loop_item_title' );
	?>
    </div>
    <div style="clear: both;"></div>

    <div class="bg-default-mob"><?php echo $q_ty_block; ?></div>

</li>


