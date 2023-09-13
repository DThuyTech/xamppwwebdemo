<?php
/**
 * Business Blogging Hero Home two
 */

 $banner_title = get_theme_mod('banner_title', __('Welcome to the Business blogging!', 'business-blogging'));
 $banner_description = get_theme_mod('banner_descriptions', __('Simply dummy text of the printing and typesetting industry.
 has been theindustry\'s standard dummy text ever since the
 1500s, when an unknownprinter', 'business-blogging'));
 $button_text = get_theme_mod('banner_button_text', __( 'Discover', 'business-blogging' ));
 $button_link = get_theme_mod('banner_button_link', '#');

 $banner_title2 = get_theme_mod('banner_title2', __('Share your Business Blogging!', 'business-blogging'));
 $banner_description2 = get_theme_mod('banner_descriptions2', __('Simply dummy text of the printing and typesetting industry.
 has been theindustry\'s standard dummy text ever since the
 1500s, when an unknownprinter', 'business-blogging'));
 $button_text2 = get_theme_mod('banner_button_text2', __( 'Discover', 'business-blogging' ));
 $button_link2 = get_theme_mod('banner_button_link2', '#');

 $banners = array(
    [
        'title' => $banner_title,
        'description' => $banner_description,
        'btn-link' => $button_link,
        'btn-text' => $button_text
    ],
    [
        'title' => $banner_title2,
        'description' => $banner_description2,
        'btn-link' => $button_link2,
        'btn-text' => $button_text2
    ]
 );
 ?>
 <section id="hero-section" class="banner-section">
     <div class="container">
         <div class="row banner-row-slider">
            <?php 
            $col_class = 'col-md-8 ';
            foreach($banners as $banner){
            ?>
                <div class="<?php echo $col_class; ?>align-self-center banner__col">
                    <div class="hero-content mb-4 mb-md-0">
                        <?php
                        if(!empty($banner["title"])) :
                        ?>
                        <h2 class="banner-title mt-0"><?php echo wp_kses_post($banner["title"]); ?></h2>
                    <?php endif;
                    if (!empty($banner["description"])) :
                    ?>
                        <p class="banner-descriptions"><?php echo wp_kses_post($banner["description"]); ?></p>
                    <?php endif;
                    if (!empty($banner["btn-text"])):
                    ?>
                        <div class="discover-me-button">
                            <a href="<?php echo esc_url($banner["btn-link"]);?>"><?php echo esc_html( $banner["btn-text"] );?></a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php
            }
            ?>
         </div>
     </div>
 </section>
