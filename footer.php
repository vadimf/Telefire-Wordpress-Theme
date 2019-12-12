<?php
/**
 * The template for displaying the footer.
 */
?>
<footer>

	<div class="custom-container">
		<div class="row">

		<div class="col-md-3 col-sm-12 col-xs-12 footer-logo">
			<div class="footer-logo-section">
				<a class="footer-logo" href="<?php echo home_url(); ?>">
					<img src="<?php echo get_field("setting_logo", "option"); ?>" alt="Logo">
				</a>
			</div>
		</div>

		<div class="col-md-7 col-sm-12 col-xs-12 pull-bottom footer-menu">
			<div class="nav-footer-menu-section">

				<nav id="footer-navigation_1" class="one-third">
	                <?php wp_nav_menu( array( 'menu' => 'Footer column 1','menu_class' => 'sf-menu sf-navbar','theme_location' => 'footer_1', 'container' => false, ) ); ?>
	            </nav>
	            

	            <div class="clearfix"></div>

			</div>
		</div>

		<div class="col-md-2 col-sm-12 col-xs-12 pull-bottom footer-social">
			<div class="social-icons pull-bottom">
			

				<?php if(get_field('setting_li','option')!=""){ ?><a href="<?php echo get_field('setting_li','option'); ?>" target="_blank"><span class="fa fa-linkedin fa-refresh-hover"></span></a><?php } ?>

				<?php if(get_field('setting_yt','option')!=""){ ?><a href="<?php echo get_field('setting_yt','option'); ?>" target="_blank"><span class="fa fa-youtube fa-refresh-hover"></span></a><?php } ?>
				
				<?php if(get_field('setting_fb','option')!=""){ ?><a href="<?php echo get_field('setting_fb','option'); ?>" target="_blank"><span class="fa fa-facebook fa-refresh-hover"></span></a><?php } ?>

	            
        	</div>
    	</div>
	</div>
	<?php if (is_page_template('templates/template-courses.php')) : ?>
	<a href="#header" id="back_to_top"><img src="<?php echo home_url(); ?>/wp-content/uploads/2018/07/back_to_top.png" alt="Back to top"></a>
	<?php endif; ?>
</footer>

</div>

<script>
//wpcf7-submit on contact page
jQuery("#wpcf7-f281-o1").on( 'wpcf7:submit', function( event ){
    console.log( 'Contact form - Contact page submited.' );
    dataLayer.push({'Category':'lead','Action':'submit','Label':'contact page' ,'event':'auto_event'});
    console.log( dataLayer );
} );




jQuery("#wpcf7-f1867-o1 .wpcf7-submit").on('click', function() {
    //alert('Click register');
    setTimeout(function(){
        //alert('Secod action');
        //additionaluser1
        document.getElementById('additionaluser1').click();
        document.getElementById('additionaluser2').click();

    }, 2000);
});

    console.log('Ready 4 search');
    jQuery( ".innericon" ).click(function() {
        console.log('Goo search');
        jQuery( "#ajaxsearchlite1" ).submit();

        jQuery("#ajaxsearchlite1 form").submit(function(){
		  alert("Submitted");
		});
    });



</script>
<script>
function myFunction() {
  var x = document.getElementById("myDIV");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
</script>
<style>

.pum-theme-9030 .pum-content, .pum-theme-default-theme .pum-content {
    color: #8c8c8c;
    font-family: inherit;
    font-weight: 400;
    font-style: inherit;
    background: transparent;
    text-align: center;
}

.pum-theme-9031 .pum-content + .pum-close, .pum-theme-lightbox .pum-content + .pum-close {
    position: absolute;
    height: 26px;
    width: 26px;
    left: -13px!important;
    right: auto!important;
    bottom: auto;
    top: -13px;
    padding: 0px;
    color: #ffffff;
    font-family: Arial;
    font-weight: 100;
    font-size: 19px!important;
    line-height: 10px!important;
    border: 2px solid #ffffff;
    border-radius: 26px;
    box-shadow: 0px 0px 15px 1px rgba( 2, 2, 2, 0.75 );
    text-shadow: 0px 0px 0px rgba( 0, 0, 0, 0.23 );
    background-color: rgba( 0, 0, 0, 1.00 );
}

.pum-theme-9031 .pum-container, .pum-theme-lightbox .pum-container {
    padding: 18px;
    border-radius: 3px;
    border: 0px solid #000000!important;
    box-shadow: 0px 0px 30px 0px rgba( 2, 2, 2, 1.00 );
    background-color: rgba( 255, 255, 255, 1.00 );
}


.for-pc{
	display: block;
}

.for-mobile{
	display: none;
}


@media only screen and (max-width: 600px) {

	.for-pc{
		display: none;
	}

	.for-mobile{
		display: block;
	}

}
</style>
<?php wp_footer(); ?>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src=""https://www.googletagmanager.com/ns.html?id=GTM-TXJB76N""
height=""0"" width=""0"" style=""display:none;visibility:hidden""></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
</body>

</html>
