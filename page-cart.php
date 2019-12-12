<?php get_header(); ?>

<div class="custom-container">
<?php the_content(); ?>

<?php if ( WC()->cart->get_cart_contents_count() != 0 ) { ?>
	<div class="additional-cart-notice">
	<?php echo get_field('additional_notice'); ?>
	</div>
<?php } ?>

</div>

<?php get_footer(); ?>