<?php

/**

 * The template for displaying single Blog page

 */



get_header(); 

the_post();



$fields = get_fields();

$terms = get_the_terms( $post->ID, 'products_category' );
$term_obj = (!empty( $terms ) ) ? array_shift( $terms ) : '';
$term_id = (!empty($term_obj)) ? $term_obj->term_id : '';
$term_title = (!empty($term_obj)) ? $term_obj->name : '';

?>

<?php get_template_part( 'template-parts/page', 'header-banner-product' ); ?>


<div class="custom-container breadcrumbs_blog">

	<span property="itemListElement" typeof="ListItem">
		<a property="item" typeof="WebPage" title="Go to Telefire." href="<?php echo home_url(); ?>" class="home">
			<span property="name"><span class="enshow">Home</span><span class="heshow">עמוד הבית</span></span>
		</a>
		<meta property="position" content="1">
	</span>
	<span property="itemListElement" typeof="ListItem">
		<a property="item" typeof="WebPage" title="" href="<?php echo home_url() . '/products/?cat=category-' . $term_id ; ?>" class="taxonomy products_category">
			<span property="name"><?php echo $term_title; ?></span>
		</a>
		<meta property="position" content="2">
	</span>
	<span property="itemListElement" typeof="ListItem">
		<span property="name"><?php the_title(); ?></span>
		<meta property="position" content="3">
	</span>

</div><!-- .breadcrumbs -->

<main class="custom-container blog_wrap product-main">


	<div class="row">
		<div class="col-md-4">
			

			<div class="product-thumbnail-image"><?php the_post_thumbnail('products-lobby'); ?></div>



			<?php if(get_field('standarts_icon')): ?>				

			<ul class="standarts_icon">

			<?php 

			$posts = get_field('standarts_icon');

			if( $posts ): ?>
			  	
			    <?php foreach( $posts as $post): // variable must be called $post (IMPORTANT) ?>
			        <?php setup_postdata($post); ?>
			        

			        	<li><img src="<?php echo get_the_post_thumbnail_url(); ?>" title="<?php the_title(); ?>" alt="<?php the_title(); ?>"></li>
			            
			        
			    <?php endforeach; ?>
			    
			    <?php wp_reset_postdata(); ?>
			<?php endif; ?>				
				<div class="clearfix"></div>
			</ul>
			<?php endif; ?>

		</div>
		<div class="col-md-8 product-main-content">
			<?php the_content(); ?>
		</div>
	</div>




</main><!-- .blog_wrap -->

<?php get_template_part( 'template-parts/page', 'functions-product' ); ?>

<?php get_template_part( 'template-parts/page', 'features-product' ); ?>

<?php get_template_part( 'template-parts/page', 'related-products' ); ?>



<?php get_footer(); ?>