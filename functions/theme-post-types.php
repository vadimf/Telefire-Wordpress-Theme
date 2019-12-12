<?php 

function wptp_create_post_type() {
  $labels = array(
    'name' => __( 'Products' ),
    'singular_name' => __( 'Products' ),
    'add_new' => __( 'New Product' ),
    'add_new_item' => __( 'Add New Product' ),
    'edit_item' => __( 'Edit Product' ),
    'new_item' => __( 'New Product' ),
    'view_item' => __( 'View Product' ),
    'search_items' => __( 'Search Product' ),
    'not_found' =>  __( 'No Product Found' ),
    'not_found_in_trash' => __( 'No Product found in Trash' ),
    );
  $args = array(
    'labels' => $labels,
    'has_archive' => true,
    'public' => true,
    'hierarchical' => false,
    'rewrite' => array('slug' => 'products', 'with_front' => false),
    'menu_position' => 5,
    'supports' => array(
      'title',
      'editor',
      'excerpt',
      'custom-fields',
      'thumbnail'
      ),
    //'taxonomies' => array('category'),
    );
  register_post_type( 'products', $args );

  $labels = array(
    'name' => __( 'Standarts' ),
    'singular_name' => __( 'Standart' ),
    'add_new' => __( 'New Standart' ),
    'add_new_item' => __( 'Add New Standart' ),
    'edit_item' => __( 'Edit Standart' ),
    'new_item' => __( 'New Standart' ),
    'view_item' => __( 'View Standart' ),
    'search_items' => __( 'Search Standart' ),
    'not_found' =>  __( 'No Standart Found' ),
    'not_found_in_trash' => __( 'No Standart found in Trash' ),
    );
  $args = array(
    'labels' => $labels,
    'has_archive' => true,
    'public' => true,
    'hierarchical' => false,
    'menu_position' => 5,
    'supports' => array(
      'title',
      'editor',
      // 'excerpt',
      // 'custom-fields',
      'thumbnail'
      ),
    //'taxonomies' => array('category'),
    );
  register_post_type( 'standarts', $args );

  $labels = array(
    'name' => __( 'Companies' ),
    'singular_name' => __( 'Company' ),
    'add_new' => __( 'New Company' ),
    'add_new_item' => __( 'Add New Company' ),
    'edit_item' => __( 'Edit Company' ),
    'new_item' => __( 'New Company' ),
    'view_item' => __( 'View Company' ),
    'search_items' => __( 'Search Company' ),
    'not_found' =>  __( 'No Company Found' ),
    'not_found_in_trash' => __( 'No Company found in Trash' ),
    );
  $args = array(
    'labels' => $labels,
    'has_archive' => true,
    'public' => true,
    'hierarchical' => false,
    'menu_position' => 6,
    'supports' => array(
      'title',
      'editor',
      // 'excerpt',
      // 'custom-fields',
      'thumbnail'
      ),
    //'taxonomies' => array('category'),
    );
  register_post_type( 'companies', $args );  

}
add_action( 'init', 'wptp_create_post_type' );


/**
  * Add REST API support to an already registered taxonomy.
  */
  add_action( 'init', 'my_custom_taxonomy_rest_support', 25 );
  function my_custom_taxonomy_rest_support() {
  	global $wp_taxonomies;
  
  	//be sure to set this to the name of your taxonomy!
  	$taxonomy_name = 'companies';
  
  	if ( isset( $wp_taxonomies[ $taxonomy_name ] ) ) {
  		$wp_taxonomies[ $taxonomy_name ]->show_in_rest = true;
  		$wp_taxonomies[ $taxonomy_name ]->rest_base = $taxonomy_name;
  		$wp_taxonomies[ $taxonomy_name ]->rest_controller_class = 'WP_REST_Terms_Controller';
  	}
  
  
  }

function sb_add_cpts_to_api( $args, $post_type ) {
	if ( 'companies' === $post_type ) {
		$args['show_in_rest'] = true;
	}
	return $args;
}
add_filter( 'register_post_type_args', 'sb_add_cpts_to_api', 10, 2 );


function wptp_register_taxonomy() {
  register_taxonomy( 'products_category', 'products',
    array(
      'labels' => array(
        'name'              => 'Product Categories',
        'singular_name'     => 'Product Category',
        'search_items'      => 'Search Product Categories',
        'all_items'         => 'All Product Categories',
        'edit_item'         => 'Edit Product Categories',
        'update_item'       => 'Update Product Category',
        'add_new_item'      => 'Add New Product Category',
        'new_item_name'     => 'New Product Category Name',
        'menu_name'         => 'Product Category',
      ),
      'hierarchical' => true,
      'sort' => true,
      'args' => array( 'orderby' => 'term_order' ),
      'rewrite' => array( 'slug' => 'productscat' ),
      'show_admin_column' => true
    )
  );
  register_taxonomy( 'products_category_2', 'products',
    array(
      'labels' => array(
        'name'              => 'Second Product Categories',
        'singular_name'     => 'Second Product Category',
        'search_items'      => 'Search Second Product Categories',
        'all_items'         => 'All Second Product Categories',
        'edit_item'         => 'Edit Second Product Categories',
        'update_item'       => 'Update Second Product Category',
        'add_new_item'      => 'Add New Second Product Category',
        'new_item_name'     => 'New Second Product Category Name',
        'menu_name'         => 'Second Product Category',
      ),
      'hierarchical' => true,
      'sort' => true,
      'args' => array( 'orderby' => 'term_order' ),
      'rewrite' => array( 'slug' => 'productscat2' ),
      'show_admin_column' => true
    )
  );
}
add_action( 'init', 'wptp_register_taxonomy' );
?>
