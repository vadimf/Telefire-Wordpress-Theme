<?php get_header(); ?>

<div class="custom-container">
<?php the_content(); ?>

<?php if ( WC()->cart->get_cart_contents_count() != 0 ) { ?>
	<div class="checkout-page additional-cart-notice">
	   
       <?php echo get_field('additional_notice'); ?>

    </div>
<?php } ?>

</div>
<script type="text/javascript">

    jQuery("#billing_postcode_field label").html("מיקוד <abbr class=\"required\" title=\"נדרש\">*</abbr>");

jQuery(function() {
    //$('#row_dim').hide(); 
    jQuery('#order_delivery').change(function(){
        if(jQuery('#order_delivery').val() == 11 || jQuery('#order_delivery').val() == '11') { //jQuery('#order_delivery').val() == 'local pickup'
            jQuery('#billing_address_1_field').hide(); 


            jQuery('#billing_address_2_field').hide(); 
			jQuery('#billing_postcode_field').hide(); 
			jQuery('#billing_city_field').hide(); 


            jQuery('.woocommerce-shipping-fields').hide(); 
            //jQuery('.add_delivery_date').hide(); 

            //jQuery('.delivery_date').hide(); 

            
            

        } else {
            jQuery('#billing_address_1_field').show(); 
            jQuery('#billing_address_2_field').show(); 
            jQuery('#billing_postcode_field').show(); 
            jQuery('#billing_city_field').show(); 

            jQuery('.woocommerce-shipping-fields').show(); 

            //jQuery('.add_delivery_date').show(); 

            //jQuery('.delivery_date').show(); 

        } 
    });
});


jQuery( window ).on( "load", function() {

    jQuery("#shipping_first_name").val("");
    jQuery("#shipping_last_name").val("");
    jQuery("#shipping_company").val("");
    jQuery("#shipping_address_1").val("");

    jQuery("#shipping_postcode").val("");
    jQuery("#shipping_city").val("");
    jQuery("#shipping_phone").val("");





    jQuery("#shipping_address_1").attr("placeholder", "").val("").focus().blur();
    /*
    
    
    */

});

    jQuery( 'form.checkout #place_order' ).on( 'checkout_place_order', function() {
        alert( 'Before check if shipping date selected!' );
        // allow the submit AJAX call
        return true;
    });

</script>
<?php get_footer(); ?>