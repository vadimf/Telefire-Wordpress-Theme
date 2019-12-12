<?php



/*

* Register Options Pages

*/

if( function_exists('acf_add_options_page') ) {



    acf_add_options_page(array(

        'page_title'     => 'Theme General Settings',

        'menu_title'     => 'Theme Settings',

        'menu_slug'      => 'theme-general-settings',

        'capability'     => 'manage_options',

        'redirect'       => false

    ));



}



function cc_mime_types($mimes) {

  $mimes['svg'] = 'image/svg+xml';

  return $mimes;

}

add_filter('upload_mimes', 'cc_mime_types');



if ( ! function_exists( 'itc_setup' ) ) :

/**

 * Sets up theme defaults and registers support for various WordPress features.

 */

	function itc_setup() {



		/*

		 * Make theme available for translation.

		 */

		//load_theme_textdomain( 'itc', get_template_directory() . '/languages' );



		// Add default posts and comments RSS feed links to head.

		add_theme_support( 'automatic-feed-links' );



		/*

		 * Enable support for Post Thumbnails on posts and pages.

		 */

		add_theme_support( 'post-thumbnails' );



		/*

		 * Switch default core markup for search form, comment form, and comments

		 * to output valid HTML5.

		 */

		add_theme_support( 'html5', array(

			'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'

		) );



		/*

		 * Enable support for Post Formats.

		 */

		add_theme_support( 'post-formats', array(

			'aside', 'image', 'video', 'quote', 'link'

		) );



	}

endif; // itc_setup

add_action( 'after_setup_theme', 'itc_setup' );



/**
* 	Pagination
**/
if( ! function_exists( 'sac_pagination' ) ) {

	function sac_pagination( $query = false ){
		global $wp_query;	
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : ( ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1 );
	
		// default $wp_query
		if( ! $query ) $query = $wp_query;
		
		$translate['first'] = '<i class="fa fa-chevron-left"></i><i class="fa fa-chevron-left"></i>';
		$translate['prev'] = '<i class="fa fa-chevron-left"></i>';
		$translate['next'] = '<i class="fa fa-chevron-right"></i>';
		$translate['last'] = '<i class="fa fa-chevron-right"></i><i class="fa fa-chevron-right"></i>';
		
		$query->query_vars['paged'] > 1 ? $current = $query->query_vars['paged'] : $current = 1;  
		
		if( empty( $paged ) ) $paged = 1;
		$prev = $paged - 1;							
		$next = $paged + 1;
		
		$end_size = 1;
		$mid_size = 1;
	
		if( ! $total = $query->max_num_pages ) $total = 1;
		
		$output = '';
		if( $total > 1 ) {
				
			$output .= '<div class="pagenav">';
				$output .= '<ul class="page">';
					
					if( $paged >1 ){
						$output .= '<li class="firstbtn"><a href="'. get_pagenum_link( 1 ) .'">'. $translate['first'] .'</a></li>';
						$output .= '<li class="prevbtn"><a href="'. get_pagenum_link( $prev ) .'">'. $translate['prev'] .'</a></li>';
					}
			
					for( $i=1; $i <= $total; $i++ ){
						if ( $i == $current ){
							$output .= '<li class="current">'. $i .'</li>';
						} else if ( $current && $i >= $current - $mid_size && $i <= $current + $mid_size ) {
							$output .= '<li><a href="'. get_pagenum_link($i) .'">'. $i .'</a></li>';
						} else if ($i > ($total - $end_size)) {
							if ($total - ($mid_size + $current) > 1) $output .= '<li class="pagination_dots">...</li>';
							$output .= '<li><a href="'. get_pagenum_link($i) .'">'. $i .'</a></li>';
						} else if ($i == 1) {
							$output .= '<li><a href="'. get_pagenum_link($i) .'">'. $i .'</a></li>';
							if ($i < ($current - $mid_size - 1)) $output .= '<li class="pagination_dots">...</li>';
						}
					}
					
					if( $paged < $total ){
						$output .= '<li class="nextbtn"><a href="'. get_pagenum_link( $next ) .'">'. $translate['next'] .'</a></li>';
						$output .= '<li class="lastbtn"><a href="'. get_pagenum_link( $total ) .'">'. $translate['last'] .'</a></li>';
					}
					
				$output .= '</ul>';
			$output .= '</div>'."\n";

		}
		return $output;
	}
}



function sac_breadcrumbs() {



	$sep = ' <img src="'. THEME_URI .'/assets/images/icon-right.png" alt="Icon"> ';

    if (!is_front_page()) {

	

	// Start the breadcrumb with a link to your homepage

        echo '<div class="breadcrumbs"><div class="custom-container">';

        echo '<a href="';

        echo get_option('home');

        echo '">';

        _e('Home', 'itc');

        echo '</a>' . $sep;

	

	// Check if the current page is a category, an archive or a single page. If so show the category or archive name.

        if (is_category() || is_single() ){

            the_category('title_li=');

        } elseif (is_archive() || is_single()){

            if ( is_day() ) {

                printf( __( '%s', 'text_domain' ), get_the_date() );

            } elseif ( is_month() ) {

                printf( __( '%s', 'text_domain' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'text_domain' ) ) );

            } elseif ( is_year() ) {

                printf( __( '%s', 'text_domain' ), get_the_date( _x( 'Y', 'yearly archives date format', 'text_domain' ) ) );

            } else {

                _e( 'Blog Archives', 'text_domain' );

            }

        }

	

	// If the current page is a single post, show its title with the separator

        if (is_single()) {

        	global $post;

        	if ($post->$post_type == 'products') {
        		echo $sep;
        		echo home_url() . '/products/';
        		echo $sep;
	            the_title();
        	}

        	else {

	            echo $sep;

	            the_title();
	        }

        }

	

	// If the current page is a static page, show its title.

        if (is_page()) {

        	global $post;

            if ($post->$post_parent == 0) echo the_title();

            else {

            	$ancestors = get_post_ancestors( $post->ID );

            	if (count($ancestors)) {

            		$ancestors = array_reverse($ancestors);

            		foreach($ancestors as $item) {

            			echo '<a href="';

				        echo get_permalink($item);

				        echo '">';

				        echo get_the_title($item);

        				echo '</a>' . $sep;

            		}

            	}

            	echo the_title();

            }

        }

	

	// if you have a static page assigned to be you posts list page. It will find the title of the static page and display it. i.e Home >> Blog

        if (is_home()){

            global $post;

            $page_for_posts_id = get_option('page_for_posts');

            if ( $page_for_posts_id ) { 

                $post = get_page($page_for_posts_id);

                setup_postdata($post);

                the_title();

                rewind_posts();

            }

        }

        echo '</div></div>';

    }



}



/* Salesforce integration */



//add_action( 'wpcf7_before_send_mail', 'sac_salesforce_integration' );



function sac_salesforce_integration( $cf7 ) {



	$form = WPCF7_Submission::get_instance();



	if ( $form ) {



        $black_list   = array('_wpcf7', '_wpcf7_version', '_wpcf7_locale', '_wpcf7_unit_tag',

        '_wpcf7_is_ajax_call','cfdb7_name', '_wpcf7_container_post');



        $data        = $form->get_posted_data();

        $form_data   = array();



        foreach ($data as $key => $d) {

            if ( !in_array($key, $black_list ) ) {

                

                $tmpD = $d;

                

                if ( ! is_array($d) ){



                    $bl   = array('\"',"\'",'/','\\');

                    $wl   = array('&quot;','&#039;','&#047;', '&#092;');



                    $tmpD = str_replace($bl, $wl, $tmpD );

                } 



                $form_data[$key] = $tmpD; 

            }

        }



        $subject = (isset($form_data['subject'])) ? $form_data['subject'] : '';

	  	$first_name = (isset($form_data['first_name'])) ? $form_data["first_name"] : $form_data["full_name"];

		$last_name = (isset($form_data['last_name'])) ? $form_data["last_name"] : '';

		$job_title = (isset($form_data['job_title'])) ? $form_data["job_title"] : '';

		$institution = (isset($form_data['institution'])) ? $form_data["institution"] : '';

		$phone = (isset($form_data['phone'])) ? $form_data["phone"] : '';

		$email = (isset($form_data['email'])) ? $form_data["email"] : '';

		$country = (isset($form_data['country'])) ? $form_data["country"] : '';

		$state = (isset($form_data["state"])) ? $form_data["state"] : '';

		$message = (isset($form_data['message'])) ? $form_data["message"] : '';

		$ckey =  (isset($form_data['ckey'])) ? $form_data["ckey"] : '';

		

		$post_items[] = 'oid=00DK000000XGIGZMA5'; //'.get_option('sf_oid','option');

		$post_items[] = 'subject=' . $subject;

		$post_items[] = 'first_name=' . $first_name;

		$post_items[] = 'last_name=' . $last_name;

		$post_items[] = 'title=' . $job_title;

		$post_items[] = 'company=' . $institution;

		$post_items[] = 'campaign_id=' . $ckey;

		$post_items[] = 'country=' . $country;

		$post_items[] = 'state=' . $state;

		$post_items[] = 'description='.$message;

		$post_items[] = 'email=' . $email;

		$post_items[] = 'phone=' . $phone;

		//$post_items[] = 'debug=1';

		//$post_items[] = 'debugEmail=avniyayin2@gmail.com';

		

		

	  	if(!empty($email) ) {

		    $post_string = implode ('&', $post_items);

		    // Create a new cURL resource

		    $ch = curl_init();

		  

		    if (curl_error($ch) != "")

		    {

		      // error handling

		    }

				

		    curl_setopt($ch, CURLOPT_URL, 'https://test.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8'); // SANDBOX

		    //curl_setopt($ch, CURLOPT_URL, 'https://www.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8'); // PRODUCTION

				

		    // Set the method to POST

		    curl_setopt($ch, CURLOPT_POST, 1);

		    // Pass POST data

		    curl_setopt( $ch, CURLOPT_POSTFIELDS, $post_string);

		    $sf_res = curl_exec($ch); // Post to Salesforce

				$fp = fopen('sf_log.txt', 'w');

				fwrite($fp, print_r($post_items,true));

				fclose($fp);

		    curl_close($ch); // close cURL resource

	  	}

    }

}


// Custom Post Type - courses *******************************************
// *******************************************************************************

function courses_custom_post_type (){

    $labels = array(
        'name' => 'Courses',
        'singular_name' => 'Course',
        'add_new' => 'Add course',
        'all_items' => 'All courses',
        'add_new_item' => 'Add course',
        'edit_item' => 'Edit course',
        'new_item' => 'New course',
        'view_item' => 'View course',
        'search_item' => 'Search course',
        'non_found' => 'No courses found',
        'not_found_in_trash' => 'No courses found in trash',
        'parent_item_colon' => 'Parent course'
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'publicly_queryable' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'supports' => array(
                'title',
                'editor',
                'excerpt',
                'thumbnail',
                'revisions',
                'post-formats',
                'custom-fields'
            ),
        'menu_position' => 10,
        'exclude_from_search' => false
    );
    register_post_type('courses',$args); 
}
add_action('init','courses_custom_post_type');

// Custom Taxonomies for courses *******************************************
// *******************************************************************************
function custom_taxonomies_for_courses() {

    // add new taxonomy - type
    $labels = array(
        'name' => 'Type',
        'singular_name' => 'Type',
        'search_items' => 'Search',
        'all_items' => 'All',
        'parent_item' => 'Parent',
        'parent_item_colon' => 'Parent type:',
        'edit_item' => 'Edit',
        'update_item' => 'Update',
        'add_new_item' => 'Add new',
        'new_item_name' => 'New Type Field',
        'menu_name' => 'Type'
    );

    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'type')
    );

    register_taxonomy('type', array('courses'), $args);

}

add_action( 'init', 'custom_taxonomies_for_courses');

add_image_size( 'products-lobby', 421, 293, true ); // 4Products Lobby list page

function sac_sort_terms_by_description($x,$y) {
	$desc_x = (int)$x->description;
	$desc_y = (int)$y->description;
	
	return $desc_x - $desc_y;
}

?>