<?php
/*
  * Template name: Priority test: Products
  * */
get_header(); ?>



<div class="custom-container" style="direction:ltr;">
<h1>June23rd</h1>
<?php
function tel_fetch_products_from_priority_june23rd() {

    $login = 'apiuser';
    $password = 'tel0303';
    $url = "https://opr.telefire.com/odata/Priority/tabula.ini/a301105/TELE_PARTWEB";  // Products
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json')
    );
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");

    $result = curl_exec($ch);
    curl_close($ch);
    $products = json_decode($result)->value;


    echo '<pre style="direction:ltr;">';
    echo "<br>";
    echo "List PRODUCTS with flag on Priory: SHOWINWEB == 'Y'";

    $key = 1;


    ?>
    * Its specific field for WooCommerce
    <table>
        <tr>
            <td># |</td>
            <td>ShowInWEB</td>
            <td>PARTNAME |</td>
            <td>PARTDES |</td>
            <td>COST |</td>
            <td>SKY* |</td>
            <td>ACTIONS |</td>

            <td>FTNAME |</td>
            <td>FAMILYDES |</td>
            <td>EXTFILENAME </td>



        </tr>
        <?php
        $products_skus = array();
        foreach($products as $product) {
        	array_push($products_skus,$product->PARTNAME);
        	
        
            if ($product->SHOWINWEB != 'Y') {
                $sku  = $product->PARTNAME;

                $current_product = get_product_by_sku($product->PARTNAME);

                if($current_product){
                    $my_post = array();
                    $my_post['ID'] = $current_product->id;
                    $my_post['post_status'] = 'draft';
                    wp_update_post( wp_slash($my_post) );
                        }
                }
                
                


            if ($product->SHOWINWEB == 'Y') {
                $sku  = $product->PARTNAME;

                $current_product = get_product_by_sku($product->PARTNAME);

                if($current_product){


                    // Создаем массив данных
                    $my_post = array();
                    $my_post['ID'] = $current_product->id;
                    $my_post['post_title'] = $product->PARTNAME;
                    $my_post['post_content'] = $product->PARTDES;
                    $my_post['post_status'] = 'publish';

                    // Обновляем данные в БД
                    wp_update_post( wp_slash($my_post) );

                    //echo "Need update product";
                    $product_actions = "Update";
                    update_post_meta($current_product->id, '_regular_price', $product->PRICE);
                    update_post_meta($current_product->id, '_price', $product->PRICE);
                    update_post_meta($current_product->id, 'priority_image', 'image-name' );

                    //Create category

                    $category_name = $product->FTNAME;
                    $child_category_name = $product->FAMILYDES;

                    if(!empty($category_name)) {


                        $term_parent = term_exists($category_name, 'product_cat');
                        //Get parent ID
                        $parent_cat_id = $term_parent['term_id'];
                        if ($term_parent !== 0 && $term_parent !== null) {
                            //echo __( $category_name." category exists!", "textdomain" );
                        } else {
                            // Insert parent
                            $parent_cat_id = wp_insert_term(
                                $category_name, // the term
                                'product_cat', // the taxonomy
                                array(
                                    'description' => '',
                                    'slug' => $category_name,
                                    'parent' => 0  // get numeric term id
                                )
                            );

                            //print_r($parent_cat_id);
                            //echo "Parent: ";
                            //echo $parent_cat_id;
                            $parent_cat_id = $parent_cat_id['term_id'];
                        }

                        if(!empty($child_category_name)){

                            //Child Category
                            $term_child = term_exists($child_category_name, 'product_cat');
                            $child_cat_id = $term_child['term_id'];
                            if ($term_child !== 0 && $term_child !== null) {
                                //echo __( $child_category_name." category exists!", "textdomain" );
                            } else {

                                // Insert parent
                                $child_cat_id = wp_insert_term(
                                    $child_category_name, // the term
                                    'product_cat', // the taxonomy
                                    array(
                                        'description' => '',
                                        'slug' => $child_category_name,
                                        'parent' => $parent_cat_id  // get numeric term id
                                    )
                                );
                            }
                        }
                    }

                    $categories = [ $child_category_name ];
                    wp_set_object_terms( $current_product->id, $categories, 'product_cat' );
                    echo "<hr>";
                }else{
                    $product_actions = "Add";
                    $post = array(
                        'post_author' => 1,
                        'post_content' => $product->PARTDES,
                        'post_status' => "publish",
                        'post_title' => $product->PARTNAME,
                        'post_parent' => '',
                        'post_type' => "product",
                    );

                    //Create post
                    $post_id = wp_insert_post( $post );
                    // if($post_id){
                    //     $attach_id = get_post_meta($product->parent_id, "_thumbnail_id", true);
                    //     update_post_meta($post_id, '_thumbnail_id', 1966);
                    // }



                    update_post_meta( $post_id, '_visibility', 'visible' );
                    update_post_meta( $post_id, '_stock_status', 'instock');
                    update_post_meta( $post_id, 'total_sales', '0');
                    update_post_meta( $post_id, '_downloadable', 'no');
                    update_post_meta( $post_id, '_virtual', 'no');
                    update_post_meta( $post_id, '_regular_price', 0);
                    update_post_meta( $post_id, '_price', 0);
                    update_post_meta( $post_id, '_sale_price', "" );
                    update_post_meta( $post_id, '_purchase_note', 'image-name' );
                    update_post_meta( $post_id, '_featured', "no" );
                    update_post_meta( $post_id, '_weight', "" );
                    update_post_meta( $post_id, '_length', "" );
                    update_post_meta( $post_id, '_width', "" );
                    update_post_meta( $post_id, '_height', "" );
                    update_post_meta( $post_id, '_sku', $product->PARTNAME);
                    update_post_meta( $post_id, '_product_attributes', array());
                    update_post_meta( $post_id, '_sale_price_dates_from', "" );
                    update_post_meta( $post_id, '_sale_price_dates_to', "" );
                    update_post_meta( $post_id, '_sold_individually', "" );
                    update_post_meta( $post_id, '_manage_stock', "no" );
                    update_post_meta( $post_id, '_backorders', "no" );
                    update_post_meta( $post_id, '_stock', "" );
                    update_post_meta( $post_id, 'custom_partdesc', $product->PARTDE );
                    //update_post_meta( $post_id, '_thumbnail_id', 1966);



                    //Generate_Featured_Image( 'http://telefire.eoidev3.co.il/wp-content/uploads/2018/09/%D7%98%D7%9C%D7%A4%D7%95%D7%9F-%D7%9B%D7%91%D7%90%D7%99%D7%9D-1-300x293.png',   $post_id );
                };
                ?>
                <tr>
                    <td><?php echo $key; ?></td>
                    <td>| <?php echo $product->SHOWINWEB; ?> |</td>
                    <td><?php echo $product->PARTNAME; ?></td>
                    <td><?php echo $product->PARTDES; ?></td>
                    <td><?php echo $product->COST; ?></td>
                    <td><?php echo $sku; ?></td>
                    <td><?php echo $product_actions; ?> / <?php echo get_post_status ( $current_product->id ); ?></td>
                    <td><?php echo $product->FTNAME; ?></td>
                    <td><?php echo $product->FAMILYDES; ?></td>
                    <td>

                        <hr>
                        <div style="direction: ltr;">
                            <?php
                            $path = $product->EXTFILENAME;
                            $name = basename($path);
                            $info = pathinfo($path);

                            update_post_meta($current_product->id, 'priority_image', $info['filename'] );


                            //var_dump($info);
                            //echo "<hr>";
                            //echo $info['filename'];

                            ?>
                        </div>

                    </td>
                </tr>
                <?php
                $key++;
            }
        }
        ?>
    </table>
<?php
    echo '</pre>';
    
    
    // print_r($products_skus);
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 1000
    );
    $loop = new WP_Query( $args );
    if ( $loop->have_posts() ) {
        while ( $loop->have_posts() ) : $loop->the_post();

            $my_post = array();
            $my_post['ID'] = get_the_ID();
            $my_post_sku = get_sku();
            echo $my_post_sku;
            $my_post['post_status'] = 'draft';
            if (!in_array($my_post_sku, $products_skus)) {
            	echo "out". $my_post_sku."wasnt found </br>";
            	wp_update_post( wp_slash($my_post) );}
            if (in_array($my_post_sku, $products_skus)) {
            	echo "in". $my_post_sku."was found </br>";}

        ?>
            <?php echo get_the_ID(); ?> - <?php echo get_the_title(); ?><br>
        <hr>

    <?php
        endwhile;
    } else {
        echo __( 'No products found' );
    }
    wp_reset_postdata();


}

tel_fetch_products_from_priority_june23rd();

?>


    <?php the_content(); ?>

</div>



<?php wp_footer(); ?>

</body>

</html>



