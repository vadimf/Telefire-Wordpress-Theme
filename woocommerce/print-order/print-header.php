<?php
/**
 * Print order header
 *
 * @package WooCommerce Print Invoice & Delivery Note/Templates
 */
 
if ( !defined( 'ABSPATH' ) ) exit;
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title><?php wcdn_document_title(); ?></title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-rtl/3.4.0/css/bootstrap-rtl.min.css" />
    <link rel='stylesheet' id='main-css'  href='/wp-content/themes/telefire/assets/css/main.css?ver=1.0' type='text/css' media='all' />
	<?php
		// wcdn_head hook
		do_action( 'wcdn_head' );
	?>

</head>

<body class="<?php echo wcdn_get_template_type(); ?>">
	
	<div id="container">
	
		<?php
			// wcdn_head hook
			do_action( 'wcdn_before_page' );
		?>
				
		<div id="page">