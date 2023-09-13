<?php
/**
 *   The template for displaying archive pages
 *
 *   @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 *   @package Business Blogging
 */
get_header();
?>
<div id="primary" class="content-area">
	<main id="main" class="site-main">
		<?php
		do_action( 'business_blogging_before_default_page' );
		if ( have_posts() ) :
			?>
			<header class="archive-page-header">
			<?php
			the_archive_title( '<h1 class="page-title">', '</h1>' );
			the_archive_description( '<div class="archive-description">', '</div>' );
			?>
			</header><!-- .page-header -->
			<?php
			echo '<div class="row masonaryactive">';
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content/content', get_post_type() );
				endwhile;
			echo '</div>';
			business_blogging_navigation();
			else :
				get_template_part( 'template-parts/content/content', 'none' );
			endif;
			do_action( 'business_blogging_after_default_page' );
			?>
		</main><!-- #main -->
	</div><!-- #primary -->
<?php get_footer(); ?>
