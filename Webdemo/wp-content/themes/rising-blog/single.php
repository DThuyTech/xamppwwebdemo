<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Shadow Themes
 */

get_header(); ?>
	<?php 
	$rising_blog_enable_single_featured_img = get_theme_mod( 'rising_blog_enable_single_featured_img', true );
	$img = '';
	$header_image = get_header_image();
	$default_header_image = ! empty( $header_image ) ?  $header_image : get_template_directory_uri() . '/assets/img/header-image.jpg';
	if ( has_post_thumbnail() && $rising_blog_enable_single_featured_img ){
		$img = get_the_post_thumbnail_url( get_the_ID(), 'full', array( 'alt' => the_title_attribute( 'echo=0' ) ) );
	} elseif (!empty($header_image)) {
		$img= $header_image;
	} else{
		$img= $default_header_image;
	} ?>

	<div id="banner-image" style="background-image: url('<?php echo esc_url( $img ); ?>');">
	    <div class="overlay"></div>
	    <div class="page-site-header">
	        <div class="wrapper">
	            <header class="page-header">
	                <?php
					if ( is_singular() ) :
						the_title( '<h1 class="page-title">', '</h1>' );
					else :
						the_title( '<h2 class="page-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
					endif; ?>
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

	<div id="inner-content-wrapper" class="wrapper page-section">
        <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main">
					<?php while ( have_posts() ) : the_post(); ?>
                        <div class="single-wrapper">
							<?php get_template_part( 'template-parts/content', 'single' ); ?>
						</div>
						
						<?php
						$post_pagination_enable = get_theme_mod( 'rising_blog_enable_single_pagination', true );
						if ( $post_pagination_enable ) {
							the_post_navigation( array(
									'prev_text'          => rising_blog_get_icon_svg( 'keyboard_arrow_right' ) . '<span>%title</span>',
									'next_text'          => '<span>%title</span>' . rising_blog_get_icon_svg( 'keyboard_arrow_right' ),
								) );
						}

						$single_comment_enable = get_theme_mod( 'rising_blog_enable_single_comment', true );
						if ( $single_comment_enable ) {
							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;
						}

					endwhile; // End of the loop.
					?>
			</main><!-- #main -->
		</div><!-- #primary -->

		<?php get_sidebar(); ?>

    </div><!-- #inner-content-wrapper-->
<?php
get_footer();
