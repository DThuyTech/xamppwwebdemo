<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Shadow Themes
 */

get_header(); ?>
	<?php $header_image = get_header_image(); 
	$archive_column = get_theme_mod( 'rising_blog_blog_archive_column',4); 
	$archive_header_image='';
	$default_header_image = ! empty( $header_image ) ?  $header_image : get_template_directory_uri() . '/assets/img/header-image.jpg';
	if (!empty($header_image)) {
		$archive_header_image= $header_image;
	} else{
		$archive_header_image= $default_header_image;
	} ?>
	<div id="banner-image" style="background-image: url('<?php echo esc_url( $archive_header_image ) ?>')">
	    <div class="overlay"></div>
	    <div class="page-site-header">
	        <div class="wrapper">
	            <header class="page-header">
	                <?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="archive-description">', '</div>' );
					?>
	            </header><!-- .page-header -->

	            <?php  
		        $breadcrumb_enable = get_theme_mod( 'rising_blog_breadcrumb_enable', true );
		        if ( $breadcrumb_enable ) : 
		            ?>
		            <div id="breadcrumb-list">
		                <div class="wrapper">
		                    <?php echo rising_blog_breadcrumb( array( 'show_on_front'   => false, 'show_browse' => false ) ); ?>
		                </div><!-- .wrapper -->
		            </div><!-- #breadcrumb-list -->
		        <?php endif; ?>
	        </div><!-- .wrapper -->
	    </div><!-- #page-site-header -->
	</div><!-- #banner-image -->

    <div id="inner-content-wrapper" class="<?php if ($archive_column > 3) { ?>wide-wrapper <?php } ?> wrapper page-section">
        <div class="">
			<div id="primary" class="content-area">
                <main id="main" class="site-main" role="main">
                	<?php 
                	$col='';
            		
            		$archive_sidebar = get_theme_mod( 'rising_blog_archive_sidebar', 'right' ); 
    	    		if ( 'no' === $archive_sidebar ){
    	    			$col = '3';
    	    		} else {
    	    			$col = '2';
    	    		}
                	?>
                    <div id="rising-blog-infinite-scroll" class="blog-posts-wrapper grid column-4">

						<?php
						if ( have_posts() ) :

							/* Start the Loop */
							while ( have_posts() ) : the_post();

								/*
								 * Include the Post-Format-specific template for the content.
								 * If you want to override this in a child theme, then include a file
								 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
								 */
								get_template_part( 'template-parts/content', get_post_format() );

							endwhile;

							wp_reset_postdata();

						else :

							get_template_part( 'template-parts/content', 'none' );

						endif; ?>
					</div><!-- .posts-wrapper -->
					<?php rising_blog_posts_pagination(); ?>
				</main><!-- #main -->
			</div><!-- #primary -->
			
			<?php get_sidebar(); ?>

		</div>
	</div>

<?php
get_footer();
