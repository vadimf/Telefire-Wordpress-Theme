<?php

function itc_widgets_init() {

	register_sidebar( array(
		'name' => __( 'Footer Socials icons', 'itc' ),
		'id' => 'footer-social-icons',
		'description' => __( 'Footer social icons', 'itc' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<span>',
		'after_title' => '</span>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Address', 'itc' ),
		'id' => 'footer-address',
		'description' => __( 'Footer address', 'itc' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<span>',
		'after_title' => '</span>',
	) );

}

add_action( 'widgets_init', 'itc_widgets_init' );

?>