<?php
/*
Template name: My account
*/

if ( is_user_logged_in() && !is_user_role( 'administrator' ) ) {
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;

    if ( get_user_meta($user_id, 'pw_user_status', true )  === 'approved' ){ $approved = true; }
	else{ $approved = false; }

	if ( $approved ){ 
		if ( isset($_REQUEST['return']) ) {
			header("Location: " . $_REQUEST['return'] );
			exit;
		}
	}
    else{ //when user not approved yet, log them out
		wp_logout();
		header('Location: ' . add_query_arg( 'approved', 'false', get_permalink( get_option('woocommerce_myaccount_page_id') ) ) );
		exit;
    }
}


	get_header();
?>
<style type="text/css">
	.woocommerce-MyAccount-content .woocommerce-form-row label[for=account_email], .woocommerce-MyAccount-content .woocommerce-form-row #account_email{
			display: none;
		}
</style>

<div class="custom-container">
	<div class="woocommerce-account-page">	

			<?php //include ('wait-approve-msg.php'); ?>
		
<?php 
$uri = $_SERVER['REQUEST_URI'];
  $uri_array = explode( "/", $uri );
  if($uri_array[2] == 'orders'){

  	echo " <h3>היסטורית הזמנות</h3> ";
  }elseif($uri_array[2] == ''){

     // echo " <h3> לוח בקרה </h3>";
  }elseif($uri_array[2] == 'edit-address'){

      echo " <h3>פרטי חשבון</h3>";
  }elseif($uri_array[2] == 'edit-account'){

  	echo " <h3>פרטי חשבון</h3>";
  }



  פ
?>
		<?php 	
			the_content();
			?>

	</div>
</div>

<?php 

	//test_priority(); //Test Orders
	//test_priority();
	//tel_fetch_contact_persons_from_priority();

?>

<?php 
	get_footer();
?>

