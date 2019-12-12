<?php
/**
 * Print order content. Copy this file to your themes
 * directory /woocommerce/print-order to customize it.
 *
 * @package WooCommerce Print Invoice & Delivery Note/Templates
 */

if ( !defined( 'ABSPATH' ) ) exit;
?>




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
        <div class="pre-order-body" style="margin-top: 0;">
            <div class="print-header">

                <?php echo get_field('contact_detail', 704); ?>

                <img src="<?php echo get_field('contact_logo', 704); ?>" class="print-header-logo">

            </div>
            <div class="print-order-title">
                <h2>סיכום <br> הזמנה</h2>


                <h6><?php _e( 'Date:', 'woocommerce' ); ?>
                    <strong><?php echo wc_format_datetime( $order->get_date_created() ); ?></strong></h6>
            </div>


            <div class="print-order-details print-version-order-details" style="min-height: 300px;">
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
                            if($order->get_billing_postcode()!=""){
                                echo $order->get_billing_postcode().", ";
                            }
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

                    <?php if($order->get_shipping_city()!=""){ ?>
                        <div class="row">
                            <div class="col-md-4 title">&nbsp;כתובת למשלוח</div>
                            <div class="col-md-8 detail-title">
                                <?php

                                echo $order->get_shipping_address_1();

                                if($order->get_shipping_city()!=""){
                                    echo $order->get_shipping_city().", ";
                                }
                                if($order->get_shipping_postcode()!=""){
                                    echo $order->get_shipping_postcode().", ";
                                }
                                ?>&nbsp;
                            </div>
                        </div>
                    <?php } ?>





                </div>
                <div class="print-detail-delivery">
                    <div class="row">
                        <div class="col-md-4 title">
                            מספר לקוח

                        </div>
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
	<div class="order-branding">
		<div class="company-logo">
			<?php if( wcdn_get_company_logo_id() ) : ?><?php wcdn_company_logo(); ?><?php endif; ?>
		</div>


		<div class="company-info">
			<?php if( !wcdn_get_company_logo_id() ) : ?><h1 class="company-name"><?php wcdn_company_name(); ?></h1><?php endif; ?>
			<div class="company-address"><?php wcdn_company_info(); ?></div>
		</div>
		
		<?php do_action( 'wcdn_after_branding', $order ); ?>
	</div><!-- .order-branding -->


	<div class="order-addresses<?php if( !wcdn_has_shipping_address( $order ) ) : ?> no-shipping-address<?php endif; ?>">
		<div class="billing-address">
			<h3><?php _e( 'Billing Address', 'woocommerce-delivery-notes' ); ?></h3>
			<address>
				
				<?php if( !$order->get_formatted_billing_address() ) _e( 'N/A', 'woocommerce-delivery-notes' ); else echo apply_filters( 'wcdn_address_billing', $order->get_formatted_billing_address(), $order ); ?>
				
			</address>
		</div>
		
		<div class="shipping-address">						
			<h3><?php _e( 'Shipping Address', 'woocommerce-delivery-notes' ); ?></h3>
			<address>

				<?php if( !$order->get_formatted_shipping_address() ) _e( 'N/A', 'woocommerce-delivery-notes' ); else echo apply_filters( 'wcdn_address_shipping', $order->get_formatted_shipping_address(), $order ); ?>
			
			</address>
		</div>
							
		<?php do_action( 'wcdn_after_addresses', $order ); ?>
	</div><!-- .order-addresses -->


	<div class="order-info">
		<h2><?php wcdn_document_title(); ?></h2>

		<ul class="info-list">
			<?php $fields = apply_filters( 'wcdn_order_info_fields', wcdn_get_order_info( $order ), $order ); 
			?>
			<?php foreach( $fields as $field ) : ?>
				<li>
					<strong><?php echo apply_filters( 'wcdn_order_info_name', $field['label'], $field ); ?></strong>
					<span><?php echo apply_filters( 'wcdn_order_info_content', $field['value'], $field ); ?></span>
				</li>
			<?php endforeach; ?>
		</ul>
		
		<?php do_action( 'wcdn_after_info', $order ); ?>
	</div><!-- .order-info -->
	
	
	<div class="order-items">
		<table>
			<thead>
				<tr>
					<th class="head-name"><span><?php _e('Product', 'woocommerce-delivery-notes'); ?></span></th>
					<th class="head-item-price"><span><?php _e('Price', 'woocommerce-delivery-notes'); ?></span></th>
					<th class="head-quantity"><span><?php _e('Quantity', 'woocommerce-delivery-notes'); ?></span></th>
					<th class="head-price"><span><?php _e('Total', 'woocommerce-delivery-notes'); ?></span></th>
				</tr>
			</thead>
			
			<tbody>
				<?php 

				if( sizeof( $order->get_items() ) > 0 ) : ?>
					<?php foreach( $order->get_items() as $item ) : ?>
						
						<?php
							$product = apply_filters( 'wcdn_order_item_product', $order->get_product_from_item( $item ), $item );
							
							if ( version_compare( get_option( 'woocommerce_version' ), '3.0.0', ">="  ) ) {
							    $item_meta = new WC_Order_Item_Product( $item['item_meta'], $product );
							}else{
							    $item_meta = new WC_Order_Item_Meta( $item['item_meta'], $product );    
							}							
						?>
						<tr>
							<td class="product-name">
								<?php do_action( 'wcdn_order_item_before', $product, $order ); ?>
								<span class="name">
								<?php
								
								$addon_name  	= $item->get_meta( '_wc_pao_addon_name', true );
								$addon_value 	= $item->get_meta( '_wc_pao_addon_value', true );
								$is_addon 		= ! empty( $addon_value );

								if ( $is_addon ) { // Displaying options of product addon
									$addon_html = '<div class="wc-pao-order-item-name">' . esc_html( $addon_name ) . '</div><div class="wc-pao-order-item-value">' . esc_html( $addon_value ) . '</div></div>';

									echo $addon_html;
								} else {

									$product_id   =  $item['product_id'];
	                                $prod_name    = get_post( $product_id );
	                                $product_name = $prod_name->post_title;
	                                

									echo apply_filters( 'wcdn_order_item_name', $product_name, $item ); ?></span>

									<?php 
									// if ( version_compare( get_option( 'woocommerce_version' ), '3.1.0', ">="  ) ) {
									//     $item_meta->get_product(); 
									
									// }else {
									    
									//     $item_meta->display(); 
									// }

									if ( version_compare( get_option( 'woocommerce_version' ), '3.0.0', ">="  ) ) {
										if( isset( $item[ 'variation_id' ] ) && $item[ 'variation_id' ] != 0 ) {
											$variation = wc_get_product( $item[ 'product_id' ] );
											foreach ( $item[ 'item_meta' ] as $key => $value ) {
												if( !( 0 === strpos($key, '_' ) ) ) {
												    if( is_array( $value ) ){
												        continue;
												    }
													$term = get_term_by( 'slug', $value, $key );
													$attribute_name = wc_attribute_label( $key, $variation );
													if( isset( $term->name ) ) {
														echo '<br>'.$attribute_name.':'.$term->name;
													} else {
														echo '<br>'.$attribute_name.':'.$value;
													}
												}
											}
										} else {
											foreach ( $item[ 'item_meta' ] as $key => $value ) {
												if( !( 0 === strpos( $key, '_' ) ) ) {
												    if( is_array( $value ) ){
												        continue;
												    }
													echo '<br>' . $key . ':' . $value;
												}
											}
										}
									} else {
									    $item_meta_new = new WC_Order_Item_Meta( $item['item_meta'], $product );   
	                                	$item_meta_new->display( );

									} 
									?>
									<br>
									<dl class="extras">
										<?php if( $product && $product->exists() && $product->is_downloadable() && $order->is_download_permitted() ) : ?>
											
											<dt><?php _e( 'Download:', 'woocommerce-delivery-notes' ); ?></dt>
											<dd><?php printf( __( '%s Files', 'woocommerce-delivery-notes' ), count( $item->get_item_downloads() ) ); ?></dd>
												
										<?php endif; ?>
										
										<?php 

											$fields = apply_filters( 'wcdn_order_item_fields', array(), $product, $order ); 

											foreach ( $fields as $field ) : 
										?>
										
											<dt><?php echo $field['label']; ?></dt>
											<dd><?php echo $field['value']; ?></dd>
												
										<?php endforeach; ?>
									</dl>
								<?php } ?>
							</td>
							<td class="product-item-price">
								<span><?php echo wcdn_get_formatted_item_price( $order, $item ); ?></span>
							</td>
							<td class="product-quantity">
								<span><?php echo apply_filters( 'wcdn_order_item_quantity', $item['qty'], $item ); ?></span>
							</td>
							<td class="product-price">
								<span><?php echo $order->get_formatted_line_subtotal( $item ); ?></span>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
			
			<tfoot>							
				<?php if( $totals = $order->get_order_item_totals() ) : ?>
					<?php 


					foreach( $totals as $total ) : ?>
						<tr>
							<td class="total-name"><span><?php echo $total['label']; ?></span></td>
							<td class="total-item-price"></td>
							<td class="total-quantity"></td>
							<td class="total-price"><span><?php echo $total['value']; ?></span></td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tfoot>
		</table>
							
		<?php do_action( 'wcdn_after_items', $order ); ?>
	</div><!-- .order-items -->
	
	
	<div class="order-notes">
		<?php if( wcdn_has_customer_notes( $order ) ) : ?>
			<h4><?php _e( 'Customer Note', 'woocommerce-delivery-notes' ); ?></h4>
			<?php wcdn_customer_notes( $order ); ?>
		<?php endif; ?>
		
		<?php do_action( 'wcdn_after_notes', $order ); ?>
	</div><!-- .order-notes -->
		
	
	<div class="order-thanks">
		<?php wcdn_personal_notes(); ?>
		
		<?php do_action( 'wcdn_after_thanks', $order ); ?>
	</div><!-- .order-thanks -->
		
		
	<div class="order-colophon">
		<div class="colophon-policies">
			<?php wcdn_policies_conditions(); ?>
		</div>
		
		<div class="colophon-imprint">
			<?php wcdn_imprint(); ?>
		</div>	
		
		<?php do_action( 'wcdn_after_colophon', $order ); ?>
	</div><!-- .order-colophon -->

 */ ?>