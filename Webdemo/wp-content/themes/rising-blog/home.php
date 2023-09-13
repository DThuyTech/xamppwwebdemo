<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Shadow Themes
 */

get_header(); 

	
	$img = '';
	if( rising_blog_is_frontpage_blog() ) {
        $page_for_posts = get_option( 'page_for_posts' );
		$img = get_the_post_thumbnail_url( $page_for_posts, 'large' );
	}
	$archive_column = get_theme_mod( 'rising_blog_blog_archive_column',4); 
	?>
  <?php $header_image = get_header_image();
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
	                <h2 class="page-title">
		                <?php 
		            	if ( rising_blog_is_latest_posts() ) {
		            		echo esc_html( get_theme_mod( 'rising_blog_your_latest_posts_title', esc_html__( 'Blogs', 'rising-blog' ) ) ); 
		            	} elseif( rising_blog_is_frontpage_blog() ) {
		            		single_post_title();
		            	} 
		            	?>
	                </h2>
	            </header><!-- .page-header -->

	            <?php  
		        $breadcrumb_enable = get_theme_mod( 'rising_blog_breadcrumb_enable', true );
		        if ( $breadcrumb_enable ) : 
		            ?>
		            <div id="breadcrumb-list" >
		                <div class="wrapper">
		                    <?php echo rising_blog_breadcrumb( array( 'show_on_front'   => false, 'show_browse' => false ) ); ?>
		                </div><!-- .wrapper -->
		            </div><!-- #breadcrumb-list -->
		        <?php endif; ?>
	        </div><!-- .wrapper -->
	    </div><!-- #page-site-header -->
	</div><!-- #banner-image -->

    <div id="inner-content-wrapper" class=" <?php if ($archive_column > 3) { ?>wide-wrapper <?php } ?> wrapper page-section">
			<div id="primary" class="content-area">
                <main id="main" class="site-main" role="main">
		        	<?php 
		        	$sticky_posts = get_option( 'sticky_posts' );  
		        	if ( ! empty( $sticky_posts ) ) :
		        	?>
                        <div class="sticky-post-wrapper posts-wrapper grid column-<?php echo esc_attr( $archive_column );?>">
        	        		<?php  
        						$sticky_query = new WP_Query( array(
        							'post__in'  => $sticky_posts,
        						) );

        						if ( $sticky_query->have_posts() ) :
        							/* Start the Loop */
        							while ( $sticky_query->have_posts() ) : $sticky_query->the_post(); ?>
        								<article id="post-<?php the_ID(); ?>" <?php post_class('grid-item'); ?>>
        									<?php 
        									$archive_img_enable = get_theme_mod( 'rising_blog_enable_archive_featured_img', true );

        									$img_url = '';
        									if ( has_post_thumbnail() && $archive_img_enable ) : 
        										$img_url = get_the_post_thumbnail_url( get_the_ID(), 'full');
        									endif;
        									?>
        									<div class="featured-image">
        										<?php 
        										if ( ! empty( $img_url ) ) : ?>
        									    	<a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url( $img_url ); ?>"></a>
        										<?php endif; ?>
        									</div><!-- .featured-image -->

        									<div class="shadow-entry-container">
        										<?php
        										$enable_archive_author = get_theme_mod( 'rising_blog_enable_archive_author', true );
        										$archive_date_enable = get_theme_mod( 'rising_blog_enable_archive_date', true );

        										if ( $enable_archive_author || $archive_date_enable ) : ?>
        										    <div class="entry-meta">
        										        <?php
        									    		rising_blog_cats(); 
        										        
        										        if ( $enable_archive_author ) {
        													rising_blog_post_author(); 
        												}

        												if ( $archive_date_enable ) {
        													rising_blog_posted_on(); 
        												}
        												?>

        										    </div><!-- .entry-meta -->
        										<?php endif; ?>

        									    <header class="shadow-entry-header">
        									        <?php
        											if ( is_singular() ) :
        												the_title( '<h1 class="shadow-entry-title">', '</h1>' );
        											else :
        												the_title( '<h2 class="shadow-entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
        											endif; ?>
        									    </header>

        									    <div class="shadow-entry-content">
        									        <?php
        												$archive_content_type = get_theme_mod( 'rising_blog_enable_archive_content_type', 'excerpt' );
        												if ( 'excerpt' === $archive_content_type ) {
        													the_excerpt();
        													?>
        											        <div class="read-more-link">
        													    <a href="<?php the_permalink(); ?>"><?php echo esc_html( get_theme_mod( 'rising_blog_archive_excerpt', esc_html__( 'See More', 'rising-blog' ) ) ); ?></a>
        													</div><!-- .read-more -->
        												<?php
        												} else {
        													the_content( sprintf(
        														wp_kses(
        															/* translators: %s: Name of current post. Only visible to screen readers */
        															__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'rising-blog' ),
        															array(
        																'span' => array(
        																	'class' => array(),
        																),
        															)
        														),
        														get_the_title()
        													) );

        													wp_link_pages( array(
        														'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'rising-blog' ),
        														'after'  => '</div>',
        													) );
        												}
        											?>
        									    	
        									    	<?php rising_blog_tags(); ?>

        									    </div><!-- .shadow-entry-content -->
        								    </div><!-- .shadow-entry-container -->
        								</article><!-- #post-<?php the_ID(); ?> -->
        							<?php
        							endwhile;
        							wp_reset_postdata();
        						endif;
        	        		?>
                        </div><!-- .blog-posts-wrapper/.sticky-post-wrapper -->
		        	<?php endif; 

	        		$page_id = get_option( 'page_for_posts' );
	        		
	        	    $rising_blog_page_sidebar_meta = get_post_meta( $page_id, 'rising-blog-select-sidebar', true );
	        		$global_page_sidebar = get_theme_mod( 'rising_blog_global_page_layout', 'right' ); 
                    $blog_sidebar = get_theme_mod( 'rising_blog_blog_sidebar', 'right' ); 
                    $archive_column = get_theme_mod( 'rising_blog_blog_archive_column',4); 
	        		if ( ! empty( $rising_blog_page_sidebar_meta ) && ( 'no' === $rising_blog_page_sidebar_meta ) ) {
	        			$col = 3;
	        		} elseif ( empty( $rising_blog_page_sidebar_meta ) && 'no' === $global_page_sidebar ) {
	        			$col = 3;
	        		} elseif( ( is_front_page() ) && ( 'no' === $blog_sidebar ) ) {
	        			$col = 3;
	        		} else{
                        $col = 2;
                    }
		        	?>
                    <div  id="rising-blog-infinite-scroll" class="archive-blog-wrapper posts-wrapper grid clear column-<?php echo esc_attr( $archive_column );?>">
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
					</div><!-- .blog-posts-wrapper -->
					<?php rising_blog_posts_pagination();?>
				</main><!-- #main -->
			</div><!-- #primary -->

			<?php get_sidebar();?>
	</div>
<?php get_footer();
