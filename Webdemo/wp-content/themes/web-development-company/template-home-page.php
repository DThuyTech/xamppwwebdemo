<?php
/**
 * The Template Name: Home Page
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Web Development Company
 */

get_header(); ?>

<div id="content">
  <?php
    $hidcatslide = get_theme_mod('web_developer_hide_categorysec', true);
    if( $hidcatslide != ''){
  ?>
    <section id="catsliderarea">
      <div class="catwrapslider">
        <div class="owl-carousel">
          <?php if( get_theme_mod('web_developer_slidersection',false) ) { ?>
            <?php $queryvar = new WP_Query(
              array( 
                'cat' => esc_attr(get_theme_mod('web_developer_slidersection',true)),
                'posts_per_page' => esc_attr(get_theme_mod('web_developer_slider_count',true))
              )
            );
            while( $queryvar->have_posts() ) : $queryvar->the_post(); ?>
              <div class="slidesection"> 
                <?php the_post_thumbnail( 'full' ); ?>
                <div class="bg-opacity"></div>
                <div class="slider-box">
                  <h1><?php the_title(); ?></h1>
                  <?php
                    $trimexcerpt = get_the_excerpt();
                    $shortexcerpt = wp_trim_words( $trimexcerpt, $num_words = 15 );
                    echo '<p class="mt-4">' . esc_html( $shortexcerpt ) . '</p>'; 
                  ?>
                  <?php if ( get_theme_mod('web_developer_button_text','Start Now') != "") { ?>
                    <div class="slide-btn mt-3">
                      <a href="<?php the_permalink(); ?>"><?php echo esc_html(get_theme_mod('web_developer_button_text',__('Start Now','web-development-company'))); ?></a>
                    </div>
                  <?php }?>
                </div>
              </div>
            <?php endwhile; wp_reset_postdata(); ?>
          <?php } ?>
        </div>
      </div>
      <div class="clear"></div>
    </section>
  <?php } ?>

  <?php
    $web_developer_hidepageboxes = get_theme_mod('web_developer_disabled_pgboxes',true);
    if( $web_developer_hidepageboxes != ''){
  ?>
  <section id="serives_box" class="py-4">
    <div class="container">
      <div class="my-5">
        <div class="row">
          <?php if( get_theme_mod('web_developer_services_cat',false) ) { ?>
            <?php $queryvar = new WP_Query('cat='.esc_attr(get_theme_mod('web_developer_services_cat',true)));
              while( $queryvar->have_posts() ) : $queryvar->the_post(); ?>
                <div class="col-lg-4 col-md-6 col-sm-6">
                  <?php if( get_post_meta(get_the_ID(), 'web_development_company_custom_icon', true) ) {?>
                    <div class="meta-feilds">
                      <?php if( get_post_meta($post->ID, 'web_development_company_custom_icon', true) ) {?>
                        <i class="<?php echo esc_html(get_post_meta($post->ID, 'web_development_company_custom_icon', true)); ?>"></i>
                      <?php }?>
                    </div>
                  <?php }?>
                  <div class="services_inner_box text-center pt-3">
                    <h3 class="mb-3 mt-5"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <?php
                      $trimexcerpt = get_the_excerpt();
                      $shortexcerpt = wp_trim_words( $trimexcerpt, $num_words = 15 );
                      echo '<p class="mb-3">' . esc_html( $shortexcerpt ) . '</p>'; 
                    ?>
                    <div class="service-btn mt-3">
                    <a class="text-decoration-none" href="<?php the_permalink(); ?>"><?php esc_html_e('Read More','web-development-company'); ?></a>
                  </div>
                  </div>
                </div>
              <?php endwhile; wp_reset_postdata(); ?>
            <?php } ?>
          <?php }?>
        </div>
      </div>
    </div>
  </section>
</div>

<?php get_footer(); ?>