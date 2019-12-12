<?php
/* */

$current_login_user_id = get_current_user_id();
$get_access = ( is_user_logged_in() && get_user_meta( $current_login_user_id, 'pw_user_status', true ) == 'approved' || current_user_can('editor') || current_user_can('administrator')) ? true : false;

if (!$get_access) {
	header('Location: '. add_query_arg( 'return', get_permalink( get_option('woocommerce_shop_page_id') ), get_permalink( get_option('woocommerce_myaccount_page_id') ) ));
	exit;
}

get_header();

if (is_user_logged_in()) {
    $user = wp_get_current_user();
    $billing_first_name = get_user_meta( $user->ID, 'billing_first_name', true );
    $billing_last_name = get_user_meta( $user->ID, 'billing_last_name', true );
    $user_name = (!empty($billing_first_name) || !empty($billing_last_name)) ? $billing_first_name . ' ' . $billing_last_name : esc_html( $current_user->display_name );
} else $user_name = '';

?>
<?php
//echo get_field('user_verified', 'user_'.$current_login_user_id);
if ( is_user_logged_in() && get_user_meta( $current_login_user_id, 'pw_user_status', true ) == 'approved' || current_user_can('editor') || current_user_can('administrator')) { 

	$page_id = get_option( 'woocommerce_shop_page_id' );

	if(is_product_category()) {
		$product_category = get_queried_object();
	}
?>

<div class="shop-container" style="<?php if (is_product()) echo "background-image: url('../../../wp-content/uploads/2018/06/single-product-bg.png');"; else echo "background-image: url('../../../wp-content/uploads/2018/06/shop_bg.png');"; ?>">

	<?php if ($get_access && is_user_logged_in() && is_shop() || is_product() || is_product_category()) : ?>

	<?php /* ?>
	<div class="registrant_info_mobile">
		<div class="top-part" style="background: #2d3696 url('<?php echo home_url(); ?>/wp-content/uploads/2018/07/grdgdr22.png') no-repeat right center">
			<span class="user_info"><?php echo $user_name; ?></span>
			<div class="registrant-buttons">
				<span class="account_info"><img src="<?php echo site_url() . '/wp-content/uploads/2018/06/icon_account_info.png'; ?>" alt="Icon"> <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="text">הגדרות</a>
				</span>
	            <span class="log_out"><img src="<?php echo site_url() . '/wp-content/uploads/2018/06/icon_log_out.png'; ?>" alt="Icon"> <a href="<?php echo wp_logout_url( home_url() ); ?>" class="text">התנתק</a>
	            </span>
                <?php if( has_bought() ){ ?>
                    <div class="history-orders on-mobile">
                        <span><a href="/my-account/orders/">ההזמנות שלי</a></span>
                    </div>
                <?php }  ?>
	            <span class="cart_info">
	            	<span class="cart_items">
                        <?php echo WC()->cart->get_cart_contents_count(); ?>
                        <?php //echo count(WC()->cart->get_cart()); ?> </span>
	            	<a href="<?php echo get_permalink( wc_get_page_id( 'cart' ) ); ?>" class="text last">מוצרים בסל</a>
	            </span>
	        </div>
		</div>

	</div>
	<?php */ ?>

	<div class="fixed-mobile-cart">
		<a href="<?php echo get_permalink( wc_get_page_id( 'checkout' ) ); //cart ?>">
			<span><?php echo WC()->cart->get_cart_contents_count(); ?></span>
		</a>
	</div>

	<div class="user_info_mobile">
		<span><?php echo $user_name; ?></span>
	</div>
	<?php endif; ?>
	<!-- Products Category only example show active/notactive icon category, please change links -->
	<div class="our-products">
		<div class="custom-container">
			<div class="our-products-inner">
			
				<div class="search-form-products">

					<?php //get_product_search_form(); ?>
					<style type="text/css">
div.asl_w .probox .proloading, div.asl_w .probox .proclose, div.asl_w .probox .promagnifier, div.asl_w .probox .prosettings {
    width: 28px;
    height: 28px;
    padding-top: 35px;
    padding-left: 15px;
}						
div[id*='ajaxsearchlite'].wpdreams_asl_container{
	    max-width: 686px;
    margin: 0 auto!important;
    height: 68px;
    position: relative;
}

div.asl_w {
    width: 100%;
    height: auto;
    border-radius: 5px;
    background: #f9f9f9!important;
    background-image: -moz-radial-gradient(center,ellipse cover,#e1635c,#e1635c);
    background-image: -webkit-gradient(radial,center center,0,center center,100%,#e1635c,#e1635c);
    background-image: -webkit-radial-gradient(center,ellipse cover,#e1635c,#e1635c);
    background-image: -o-radial-gradient(center,ellipse cover,#e1635c,#e1635c);
    background-image: -ms-radial-gradient(center,ellipse cover,#e1635c,#e1635c);
    background-image: none!important;
    overflow: hidden;
    border: none;
    border-radius: 0 0 0 0;
    box-shadow: 0 0 0 0 #000;
}

#ajaxsearchlite1 .probox .proinput input, div.asl_w .probox .proinput input {
        font-weight: normal;
    font-family: Open Sans;
    color: #818181 !important;
    font-size: 24px;
    line-height: normal !important;
    text-shadow: 0 0 0 rgba(255,255,255,0);
    border: 0;
    box-shadow: none;
    height: 68px;
    background: #f9f9f9!important;
    margin-left: 98px!Important;
    direction: rtl;
    text-align: right;
    padding-right: 40px!important;
}

#ajaxsearchlite1 .probox, div.asl_w .probox {
    margin: 0;
    height: 68px!important;
    background-color: #f9f9f9!important;
    background-image: -moz-radial-gradient(center,ellipse cover,#e1635c,#e1635c);
    background-image: -webkit-gradient(radial,center center,0,center center,100%,#e1635c,#e1635c);
    background-image: -webkit-radial-gradient(center,ellipse cover,#e1635c,#e1635c);
    background-image: -o-radial-gradient(center,ellipse cover,#e1635c,#e1635c);
    background-image: -ms-radial-gradient(center,ellipse cover,#e1635c,#e1635c);
    background-image: none!important;
    border: 0!important;
    border-radius: 0 0 0 0;
    box-shadow: none!important;
        margin-left: 80px!Important;
    direction: rtl;
}
div.asl_w .probox .promagnifier {
    margin-left: 20px;
    width: 52px;
    height: 52px;
    background-color: #d5302a!important;
    background-image: -o-linear-gradient(180deg,#be4c46,#be4c46);
    background-image: -ms-linear-gradient(180deg,#be4c46,#be4c46);
    background-image: -webkit-linear-gradient(180deg,#be4c46,#be4c46);
    background-image: none!important;
    background-position: center center;
    background-repeat: no-repeat;
    border: 0 solid #000;
    border-radius: 0 0 0 0;
    box-shadow: 0 0 0 0 rgba(255,255,255,.61);
    cursor: pointer;
    background-size: 100% 100%;
    background-position: center center;
    background-repeat: no-repeat;
    cursor: pointer;
    position: absolute;
    z-index: 11;
    top: 0;
    background: transparent;
    border: 0;
    line-height: 60px;
    padding: 0;
    cursor: pointer;
    left: 0;
    height: 52px;
    width: 52px;
    display: inline-block;
    border-radius: 50%;
    background: #d5302a;
    margin-top: 8px;
    margin-left: 20px;
}
div[id*='ajaxsearchliteres'].wpdreams_asl_results .results div.asl_image {
display: none;
}

div.asl_r .results .item .asl_content {
    font-weight: 500;
    font-family: inherit;
    color: #4a4a4a;
    font-size: 20px;
    line-height: 18px;
    text-shadow: 0 0 0 rgba(255,255,255,0);
    direction: rtl;
    text-align: right;
}

div.asl_r .results .item .asl_content .asl_desc {
    margin-top: 4px;
    font-size: 14px;
    line-height: 18px;
    text-align: right;
}

div.asl_m .probox .promagnifier .innericon svg, div.asl_m .probox .prosettings .innericon svg, div.asl_m .probox .proloading svg {
    height: 100%;
    width: 32px!important;
    vertical-align: baseline;
    display: inline-block;
}
div.asl_w .probox .promagnifier .innericon svg {
    fill: #fff;
}

div.asl_w .probox .proclose{
    width: 28px;
    height: 28px;
    padding-top: 42px;
    padding-left: 15px;
}

div.asl_w .probox div.asl_simple-circle {

    border: 10px solid #000!important;
}

div.asl_m .probox div.asl_simple-circle {
    margin: 0;
    height: 100%;
    width: 100%;
    animation: rotate-simple .8s infinite linear;
    -webkit-animation: rotate-simple .8s infinite linear;
    border: 4px solid #fff;
    border-right-color: transparent !important;
    border-radius: 50%;
    box-sizing: border-box;
    margin: 0;
    height: 20px!important;
    width: 20px!important;
    animation: rotate-simple .8s infinite linear;
    -webkit-animation: rotate-simple .8s infinite linear;
    border: 4px solid #fff;
    border-radius: 50%;
    box-sizing: border-box;
    /* background: #ff0000; */
}
					</style>
					<?php echo do_shortcode('[wpdreams_ajaxsearchlite]'); ?>


				</div>


				<div class="">
					<div class="categories-list">
					<?php 
					// $current_prod_cat_id = get_queried_object();
					// $current_prod_cat_id = $current_prod_cat_id->term_id;
					// //echo $current_prod_cat_id;


					// if ( has_term_have_children( $current_prod_cat_id) ) {
										
					// 		//$catsArray = get_field('products_category_sort', 426);		
					// 		$taxonomy = 'products_category';
					// 		$terms = get_terms(
					// 			array(
					// 				'taxonomy'      => array( 'product_cat' ), 
					// 				'parent'      => $current_prod_cat_id, 
					// 				//'include' => $catsArray,
					// 				//'orderby'  => 'include',
					// 				// 'orderby'       => 'id', 
					// 				// 'order'         => 'ASC',
					// 			) 
					// 		); 


					// }else{


							//print_r(get_field('products_category_sort', 426));
							$category_active_by_default =  get_field('products_category_active',426);
							//echo "/****/";					
							
							//$catsArray = get_field('products_category_sort', 426);		
							$taxonomy = 'products_category';
							$terms = get_terms(
								array(
									'taxonomy'      => array( 'product_cat' ), 
									'parent'      => 0, 
									//'include' => $catsArray,
									//'orderby'  => 'include',
									// 'orderby'       => 'id', 
									// 'order'         => 'ASC',
								) 
							); 

					//}


					if ( $terms && !is_wp_error( $terms ) ) :
					
						$key = 1;
						foreach ( $terms as $term ) {

						//$term = get_queried_object();
						$category_id = $term->term_id;
					 ?>


									<?php if( $term->slug=="%d7%9b%d7%99%d7%91%d7%95%d7%99%d7%99%d7%9d"){

										$category_image = '/wp-content/uploads/2018/06/category4_no_active.png';
										$category_image_active = '/wp-content/uploads/2018/06/category4_active.png';

									}elseif( $term->slug=="%d7%a8%d7%9b%d7%96%d7%95%d7%aa-%d7%92%d7%99%d7%9c%d7%95%d7%99-%d7%90%d7%a9"){
										
										$category_image = '/wp-content/uploads/2018/05/products-cat-1.png';
										$category_image_active = '/wp-content/uploads/2018/05/products-cat-1-active.png';


									}elseif( $term->slug=="%d7%9e%d7%a2%d7%a8%d7%9b%d7%95%d7%aa-%d7%9e%d7%a9%d7%aa%d7%9c%d7%91%d7%95%d7%aa"){

										$category_image = '/wp-content/uploads/2018/06/category5_no_active.png';
										$category_image_active = '/wp-content/uploads/2018/06/category5_active.png';

									}elseif( $term->slug=="%d7%92%d7%9c%d7%90%d7%99%d7%9d"){
										
										$category_image = '/wp-content/uploads/2018/05/products-cat-2.png';
										$category_image_active = '/wp-content/uploads/2018/05/products-cat-2-active.png';
										
									}elseif( $term->slug=="%d7%9e%d7%95%d7%93%d7%95%d7%9c%d7%99%d7%9d-%d7%95%d7%90%d7%91%d7%99%d7%96%d7%a8%d7%99%d7%9d"){
										
										$category_image = '/wp-content/uploads/2018/06/category6_no_active.png';
										$category_image_active = '/wp-content/uploads/2018/06/category6_active.png';
										
									}else{
										$category_image = '';
									}
									
									//if(get_field('category_icon', 'products_category_'.$category_id)==""){
										$cat_img =  site_url() .$category_image; 	
										$cat_img_active =  site_url() .$category_image_active; 	
									
										/*
									}else{
										$cat_img = get_field('category_icon', 'products_category_'.$category_id);
										$cat_img_active = get_field('category_icon_active', 'products_category_'.$category_id);
									}
									*/
									?>					 
					 <style>
					  	a .cat-icon<?php echo $category_id; ?> {
					        width: 140px;
					        height: 150px;
					        background: url("<?php echo $cat_img ?>") no-repeat;
					        display: inline-block;
					        -webkit-transition: all 0.5s ease 0s;
    						transition: all 0.5s ease 0s;
					    }
					    a:hover .cat-icon<?php echo $category_id; ?> {
					        background: url("<?php echo $cat_img_active; ?>") no-repeat;
					    }

					    .active a .cat-icon<?php echo $category_id; ?> {
					        background: url("<?php echo $cat_img_active; ?>") no-repeat;
					    }
					    @media only screen and (max-width: 520px) {
					    	a .cat-icon<?php echo $category_id; ?> {
						        width: 100%;
								height: 100px;
								background-size: contain;
								background-position: center;
						    }
						    a:hover .cat-icon<?php echo $category_id; ?> {
						    	background-size: contain;
								background-position: center;
						    }
						    .active a .cat-icon<?php echo $category_id; ?> {
						    	background-size: contain;
						    	background-position: center;
						    }
					    }
					 </style>
					 
					    <div class="item id<?php echo $category_id; ?> <?php if(isset($product_category) && $product_category->term_id == $category_id){ echo " active"; }?>">
							<a href="<?php echo get_term_link( $term->slug, 'product_cat' ); ?>#to-poducts">
								<div class="cat-icon<?php echo $category_id; ?>">
									
									<img class="shop-cat-icon" src="<?php echo $cat_img; ?>" alt="Icon">
									<img class="shop-cat-icon hover" src="<?php echo $cat_img_active; ?>" alt="Icon">
								</div>
								<h3 class="title">
									<?php echo $term->name; ?>
									
								</h3>
							</a>
						</div>
							
					<?php 
						$key++;
						} 
					
						endif;
					?>
					
					</div>
				</div>
			</div>
		</div>
	</div>
	<a name="to-poducts"></a>
	<?php if (!is_product()) : ?>
	
	<div class="custom-container shop-section">


        <?php

        $cate = get_queried_object();
        $cateID = $cate->term_id;
        //echo $cateID;
        //$catsArray = get_field('products_category_sort', 426);
        $taxonomy = 'products_category';
        $terms_sub = get_terms(
            array(
                'taxonomy'      => array( 'product_cat' ),
                'parent'      => $cateID,
                //'include' => $catsArray,
                //'orderby'  => 'include',
                // 'orderby'       => 'id',
                // 'order'         => 'ASC',
            )
        );

        $queried_object = get_queried_object();
        $current_term_id = $queried_object->term_id;

        if ( isset($cateID) && $terms_sub && !is_wp_error( $terms_sub ) ) : ?>
        <div class="product-sub-category">
        <?php

            $key = 1;
            foreach ( $terms_sub as $term_sub ) {

                //$term = get_queried_object();
                $category_id = $term_sub->term_id;
                ?>




                    <a href="<?php echo get_term_link( $term_sub->slug, 'product_cat' ); ?>#to-poducts" class="<?php if($current_term_id==$term_sub->term_id){ echo "current";} ?>">
                        <h3 class="title">
                            <?php echo $term_sub->name; ?>

                        </h3>
                    </a>

                <?php
                $key++;
            }
        ?>
        </div>
        <?php
        endif;
        ?>

		<?php woocommerce_content(); ?>
	</div>
	<div class="shop_cta_banner woocommerce-cta">
		<div class="cta-contact-us-block">
			<div class="custom-container">
				<div class="cta-container" style="background: url('<?php echo get_field('background_image', $page_id)['url']; ?>') left center no-repeat;	height: 120px; width: 100%;">
					<div class="contact-us-content">								
						<div class="btn-block <?php if (!get_field('contact_us_btn_text', $page_id)) {echo 'no-button';} ?>">
							<?php echo get_field('contact_us_ask', $page_id); ?>
							<?php if (get_field('contact_us_btn_text', $page_id)) : ?>
							<a href="<?php echo get_field('contact_us_btn_link', $page_id)['url']; ?>" class="btn-telefire" <?php if (!empty(get_field('contact_us_btn_link', $page_id)['target'])) {echo 'target="_blank"'; } ?>><span><?php echo get_field('contact_us_btn_text', $page_id); ?></span></a>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php else: ?>
	<div class="custom-container shop-section">
		<?php do_action( 'woocommerce_before_single_product' ); ?>
		<a href="<?php echo get_permalink( get_option( 'woocommerce_shop_page_id' ) ); ?>" class="page-title"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i> חזרה לרכזות גילוי וכיבוי אש</a>
		
<?php global $product;

					if ( ! $product->is_purchasable() ) {
						return;
					}

					echo wc_get_stock_html( $product ); // WPCS: XSS ok.

					if ( $product->is_in_stock() ) : ?>

						<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>
<form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>

		<div class="row">


			<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 extra-margin-mobile product-image-block">
				<div class="single-product-info">
					<?php 
						//$product_id = get_the_ID();
						//$priority_image = "/wp-content/uploads/priority-products/". get_field('priority_image', $product_id ).".jpg"; 
						$product_id = get_the_ID();
    					$product_image = get_field('priority_image', $product_id );
    					$priority_image = "/wp-content/uploads/priority-products/". $product_image.".jpg";

						    //echo $priority_image;

					    if(empty($product_image)){

					        $priority_image = get_site_url()."/wp-content/themes/telefire/woocommerce/assets/images/placeholder.png";
					    }

					    if(@getimagesize(get_site_url().'/wp-content/uploads/priority-products/'. $product_image.'.jpg')){
					        //image exists!
					        //echo "Image is";
					    }else{
					        //image does not exist.
					        $priority_image = get_site_url()."/wp-content/themes/telefire/woocommerce/assets/images/placeholder.png";
					    }
						//echo $priority_image; 
					?>

					<div class="product-image-list woocommerce-placeholder wp-post-image" style="background: url('<?php echo $priority_image; ?>') #fff;
			            width: 100%;
			            height: 300px;
			            background-size: cover;
			            background-repeat: no-repeat;
			            background-position: center center;
			            -webkit-box-shadow: 0px 15px 30px rgba(186,201,199,1);
			    		-moz-box-shadow: 0px 15px 30px rgba(186,201,199,1);
			    		box-shadow: 0px 15px 30px rgba(186,201,199,1);
			            ">
			            <button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_buttone on-hover-image button alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>

    </div>


		<!-- 			<img width="300" height="209" src="<?php echo $priority_image; ?>" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail wp-post-image" alt="" srcset="<?php echo $priority_image; ?> 421w, <?php echo $priority_image; ?> 300w" sizes="(max-width: 300px) 100vw, 300px"> -->
					<h2 class="woocommerce-loop-product__title">
						<?php echo get_the_title(); ?><br>
						<p>
							<?php 
							//$custom_partdesc = get_post_meta( $product->ID, 'custom_partdesc', true );
							echo get_the_content(); ?>
						</p>

						<?php echo get_woocommerce_currency_symbol(); ?> <?php echo $product->get_price(); ?> 
					</h2>
				</div>
			</div>
			<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 product-info-block">
				<div class="single-product-add-to-cart single-product-qt">
					

						
							
							<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

							<?php
							do_action( 'woocommerce_before_add_to_cart_quantity' );

							woocommerce_quantity_input( array(
								'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
								'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
								'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
							) );

							do_action( 'woocommerce_after_add_to_cart_quantity' );
							?>

							<button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button button alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>

							<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
						

						
				</div>
			</div>
		</div>
		
	</div>
</form>
	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

					<?php endif; ?>
	
	<?php endif; ?>
</div>
<?php 
} else {
?>	


<?php   
}
?>

<?php if(Is_product()){ ?>
<script type="text/javascript">
	//alert('Single product page');
	jQuery(document).ready(function () {
	    // Handler for .ready() called.
	    jQuery('html, body').animate({
	        scrollTop: jQuery('.woocommerce-notices-wrapper').offset().top
	    }, 'slow');
	});

</script>
<?php } ?>

<?php 

//echo $_GET['add-to-cart'];

//echo "/****************************/";
if($_GET['add-to-cart']!=""){

    $product_added_id = '.post-'.$_GET['add-to-cart'];
    ?>
<script type="text/javascript">
		jQuery(document).ready(function () {
		    console.log('ACTIOOON <?php echo $product_added_id; ?>');
		    // Handler for .ready() called.
		    jQuery('html, body').animate({
		        scrollTop: jQuery('<?php echo $product_added_id; ?>').offset().top - 140
		    }, 'slow');


		});

</script>

<?php } ?>

<?php if($_GET['post_type']!=""){ ?>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            console.log('Scroollll');


            jQuery('html, body').animate({
                scrollTop: jQuery('.shop_cta_banner').offset().top - 140
            }, 'slow');
        });

    </script>
<?php } ?>



<?php 
get_footer();
?>