<?php

/**

 * Header functions.

 */



/* ---------------------------------------------------------------------------

 * Styles

 * --------------------------------------------------------------------------- */

if( ! function_exists( 'sac_styles' ) ) {

	

	function sac_styles() {

		

		// wp_enqueue_style ------------------------------------------------------

		wp_enqueue_style( 'style',					get_stylesheet_uri(), false, THEME_VERSION, 'all' );

		

		// bootstrap 4.0.0: 

  		wp_enqueue_style( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css');

		wp_enqueue_style( 'aos',			        THEME_URI .'/assets/css/aos.css', false, THEME_VERSION, 'all' );

		wp_enqueue_style( 'fancybox',			    THEME_URI .'/assets/css/jquery.fancybox.min.css', false, THEME_VERSION, 'all' );
		//wp_enqueue_style( 'fancyboxpack',		    THEME_URI .'/assets/fancybox/jquery.fancybox-1.3.4.css', false, THEME_VERSION, 'all' );

		wp_enqueue_style( 'slick', 					THEME_URI .'/assets/css/slick.css', false, THEME_VERSION, 'all');

		wp_enqueue_style( 'main',			        THEME_URI .'/assets/css/main.css', false, THEME_VERSION, 'all' );

		wp_enqueue_style( 'blog',			        THEME_URI .'/assets/css/blog.css', false, THEME_VERSION, 'all' );

		if ( is_rtl() ) {
			/*Add custom style by current lang*/
			wp_enqueue_style( 'custom',				THEME_URI .'/assets/css/custom-rtl.css', false, THEME_VERSION, 'all' );
		} else {
			wp_enqueue_style( 'custom2',			THEME_URI .'/assets/css/custom-ltr.css', false, THEME_VERSION, 'all' );
		} 

		/* Добавил Евгений Андрусенко 02.05.2019 */
		wp_enqueue_style( 'custom3',				THEME_URI .'/assets/css/custom-evgeniy.css', false, THEME_VERSION, 'all' );
		wp_enqueue_style( 'fontawesome',			THEME_URI .'/assets/css/font-awesome.min.css', false, THEME_VERSION, 'all' );

		/*Hide cdn*/
		//wp_enqueue_style( 'fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');

	}

}

add_action( 'wp_enqueue_scripts', 'sac_styles' );



/* ---------------------------------------------------------------------------

 * Styles and scripts for admin panel

 * --------------------------------------------------------------------------- */

if( ! function_exists( 'sac_styles_admin' ) ) {

	

	function sac_styles_admin($hook) {

		wp_enqueue_style( 'admin-main',			THEME_URI .'/assets/css/admin-main.css', false, THEME_VERSION, 'all' );

	}

}

add_action( 'admin_enqueue_scripts', 'sac_styles_admin' );



/* ---------------------------------------------------------------------------

 * Scripts

 * --------------------------------------------------------------------------- */

if( ! function_exists( 'sac_scripts' ) )

{

	function sac_scripts() 

	{

		

		wp_enqueue_script( 'jquery', 			THEME_URI .'/assets/js/jquery.min.js', false, THEME_VERSION, true );

		wp_enqueue_script( 'headroom', 			THEME_URI .'/assets/js/headroom.min.js', false, THEME_VERSION, true );

		// popper - required by bootstrap: https://popper.js.org/

  		wp_enqueue_script( 'popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.13.0/umd/popper.min.js', array(), THEME_VERSION, true );

		// bootstrap js

  		wp_enqueue_script( 'bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js', array('jquery'), THEME_VERSION, true );

		wp_enqueue_script( 'aos', 				THEME_URI . '/assets/js/aos.js', false, THEME_VERSION, true );

		wp_enqueue_script( 'fancybox-js', 		THEME_URI . '/assets/js/jquery.fancybox.min.js', false, THEME_VERSION, true );
		//wp_enqueue_script( 'fancybox-js-pack', 		THEME_URI . '/assets/fancybox/jquery.fancybox-1.3.4.pack.js', false, THEME_VERSION, true );



		wp_enqueue_script( 'slick-js', 			THEME_URI . '/assets/js/slick.min.js', false, THEME_VERSION, true );



		wp_enqueue_script( 'custom', 			THEME_URI . '/assets/js/custom.js', false, THEME_VERSION, true );

		wp_enqueue_script( 'theme-script', 		THEME_URI . '/assets/js/script.js', array('jquery', 'bootstrap-js'), THEME_VERSION, true );

			

	}

}

add_action('wp_enqueue_scripts', 'sac_scripts');



/**

 * Load Select2. Copy paste this into functions.php, then use this jQuery to init:

 * jQuery('select').select2();

 */

// add_action('wp_enqueue_scripts', function(){

//  	wp_enqueue_style( 'select2_css', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css' );

//  	wp_register_script( 'select2_js', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js', array('jquery'), '4.0.3', true );

//  	wp_enqueue_script('select2_js');

// });



/**
 * Generate breadcrumbs 
 */
// function get_breadcrumb() {
//     echo '<a href="'.home_url().'" rel="nofollow">'. __('עמוד בית', 'telefire').'</a>';
//     if (is_category() || is_single()) {
//         echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;";
//         the_category(' &bull; ');
//             if (is_single()) {
//                 echo " &nbsp;&nbsp;&#187;&nbsp;&nbsp; ";
//                 the_title();
//             }
//     } elseif (is_page()) {
//         echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;";
//         echo the_title();
//     } elseif (is_search()) {
//         echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;Search Results for... ";
//         echo '"<em>';
//         echo the_search_query();
//         echo '</em>"';
//     }
// }

?>