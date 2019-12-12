<?php
/*
  * Template name: Priority test: Price
  * */
get_header(); ?>



<div class="custom-container" style="direction:ltr;">

    <?php //test_priority(); ?>


    <?php /*

    <h2>Actions for CRON tab:</h2>

    <h4>1. Update CUSTOMERS:</h4>
    <?php tel_fetch_contact_persons_from_priority(); ?>


    <?php

    // echo "<pre>";
    // print_r(get_user_meta(26));
    // echo "</pre>";

    // echo get_field('field_5b1e6edbd1d11', 'user_26');
    ?>
    */ ?>
    <hr>
    <h4>Show products PRICE from CRM Priority:</h4>
    <code>
        Action: "tel_fetch_products_price_from_priority();"<br>
        $url = "https://opr.telefire.com/odata/Priority/tabula.ini/a301105/PRICELIST?$filter=TELE_PLINFLAG%20eq%20%27Y%27&$expand=PARTPRICE2_SUBFORM";  // Products
    </code>
    <?php tel_fetch_products_price_from_priority(); ?>

    /**************/
    <? /*
    <pre>
    ADR-3000.jpg\תמונות לפריוריטי\אתי\שיווק_ישראל\:L
	</pre>
<?php
$path = 'ADR-3000.jpg\תמונות לפריוריטי\אתי\שיווק_ישראל\:L';
$name = basename($path);
$info = pathinfo($path);
var_dump($info);
echo "<hr>";
echo $info['filename'];

*/
    ?>
    <?php
    //Generate_Featured_Image( 'http://telefire.eoidev3.co.il/wp-content/uploads/2018/08/telefire-new-logo.png', 5745 );

    ?>


    <?php
    //tel_fetch_contact_persons_from_priority();

    ?>


    <?php the_content(); ?>

</div>



<?php wp_footer(); ?>

</body>

</html>



