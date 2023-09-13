<?php
    /**
 * Template part for displaying front page popular.
 *
 * @package Shadow Themes
 */

/// Get default  mods value.
$popular_enable = get_theme_mod( 'rising_blog_popular_section_enable', true );

if ( false == $popular_enable ) {
    return;
}

$header_font_size = get_theme_mod( 'rising_blog_popular_header_font_size');
$title_font_size = get_theme_mod( 'rising_blog_popular_post_font_size');
$popular = get_theme_mod( 'rising_blog_popular_content_type', 'post' );
$popular_section_title = get_theme_mod( 'rising_blog_popular_title');
$popular_section_subtitle = get_theme_mod( 'rising_blog_popular_subtitle');


$default = rising_blog_get_default_mods();
$popular_num = get_theme_mod( 'rising_blog_popular_num', 6 );
$excerpt_length = get_theme_mod( 'rising_blog_popular_secion_excerpt',20); ?>

<div id="popular" class="page-section">
    <div class="wrapper">
        <?php if(!empty($popular_section_title)):?>
            <div class="shadow-section-header">
                <h2 class="shadow-section-title" style="font-size: <?php echo esc_attr($header_font_size); ?>px; " ><?php echo esc_html($popular_section_title);?></h2>
                <div class="seperator"></div>
                <?php if(!empty($popular_section_subtitle)):?>
                    <p class="shadow-section-subtitle"><?php echo esc_html($popular_section_subtitle);?></p>
                <?php endif;?>
            </div><!-- .shadow-section-header -->
        <?php endif; ?>
        <div class="shadow-section-content column-2">
            <?php
            $popular_cat_id = get_theme_mod( 'rising_blog_popular_cat' );
            $args = array(
                'cat' => $popular_cat_id,   
                'posts_per_page' => $popular_num,
                'ignore_sticky_posts' => true,
            );
                   

                $query = new WP_Query( $args );

                $i = 1;
                if ( $query->have_posts() ) :
                    while ( $query->have_posts() ) :
                        $query->the_post();
                        ?>
                        <article>
                            <div class="featured-image" style="background-image: url('<?php the_post_thumbnail_url( 'full' ); ?>');">
                                <a href="<?php echo the_permalink();?>" class="post-thumbnail-link"></a>
                            </div><!-- .featured-image -->

                            <div class="shadow-entry-container">

                                <header class="shadow-entry-header">
                                    <h2 class="shadow-entry-title"><a href="<?php echo the_permalink();?> " style="font-size: <?php echo esc_attr($title_font_size); ?>px; "><?php the_title();?></a></h2>
                                </header>

                                <div class="shadow-entry-content">
                                    <?php
                                        $excerpt = rising_blog_the_excerpt( $excerpt_length );
                                        echo wp_kses_post( wpautop( $excerpt ) );
                                    ?>
                                    <div class="entry-meta shadow-posted">
                                        <div class="entry-meta-left">
                                            <?php rising_blog_comment(); ?>
                                        </div>
                                        <div class="post-date">
                                            <?php rising_blog_posted_on(); ?>
                                        </div>
                                    </div>
                                </div><!-- .shadow-entry-content -->
                                <?php $readmore_text = get_theme_mod( "rising_blog_popular_custom_btn_" . $i );?>
                                <?php if (!empty($readmore_text)) {?>
                                    <div class="read-more">
                                        <a href="<?php the_permalink();?>" class="btn"><?php echo esc_html($readmore_text);?></a>
                                    </div><!-- .read-more -->
                                <?php } ?>
                            </div><!-- .shadow-entry-container -->
                        </article>
                <?php 
                    $i++;
                    endwhile;
                endif;
            wp_reset_postdata(); ?>
        </div>
    </div>
</div>