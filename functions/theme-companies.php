<?php 


add_action('wp_ajax_nopriv_get_companies', 'get_companies_callback');
add_action( 'wp_ajax_get_companies', 'get_companies_callback' );
function get_companies_callback() {

	global $wpdb;

	if (empty($_POST['title']))
		die ( json_encode(array('status' => 'fail', 'message' => get_field('messages_if_empty', 'option'))));


	$title = $_POST['title'];

	
	$search_exclude = array(

'אש',
'גילוי אש',
'גלוי אש',
'מערכות',
'מערכות גילוי אש',
'מערכות גלוי אש',
'עשן',
'ע.מ',
'מספרים',
'ח.פ',
'בע"מ'
	);
	

	//print_r($search_exclude);
	//print $title;
	if (in_array($title, $search_exclude, true)) {
		//echo "exclude from search";
	   $title = " NOT FOUND ";
	}


	$query = "
        SELECT      ID, post_title
        FROM        ".$wpdb->posts."
        WHERE       post_title LIKE '%".$title."%'
        AND         post_type = 'companies'
		AND			post_status = 'publish'
        ORDER BY    post_title
	";
	
	$res = $wpdb->get_results($query);
	//print_r($res);
	$r['data'] = $res;
	if(empty($res)){
		$r['status'] = 'not-found';
	}else{
		$r['status'] = 'success';	
	}
	
	echo json_encode($r);
	die; 
}

add_action('wp_ajax_nopriv_get_company_by_id', 'get_company_by_id_callback');
add_action( 'wp_ajax_get_company_by_id', 'get_company_by_id_callback' );
function get_company_by_id_callback() {
	if (empty($_POST['id']))
		die ( json_encode(array('status' => 'fail', 'message' => 'No company ID')));
	
	$post = get_post($_POST['id']);
	//$post->post_content = apply_filters('the_content', $post->post_content);
	$post->title = get_the_title($_POST['id']);
	$post->type = get_field('type_of_approval', $_POST['id']);
	$post->addres .= get_field('company_address', $_POST['id']);
	$post->products .= get_field('approved_products', $_POST['id']);
	$post->date .= get_field('expiration_date', $_POST['id']);

	$r = array();
	$r['status'] = 'success';
	$r['data'] = $post;
	echo json_encode($r);
	die; 
}


?>