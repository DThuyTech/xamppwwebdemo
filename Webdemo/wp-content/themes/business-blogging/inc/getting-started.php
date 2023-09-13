<?php
/**
 * Getting Started Help Notic
 **/
function business_blogging_general_admin_notice(){
       global $pagenow;
       $theme_args      = wp_get_theme();
       $meta            = get_option( 'author_blog_admin_notice' );
       $name            = $theme_args->__get( 'Name' );
       $current_screen  = get_current_screen();
       if( 'themes.php' == $pagenow && !$meta ){
           if( $current_screen->id !== 'dashboard' && $current_screen->id !== 'themes' ){
               return;
           }
           if( is_network_admin() ){
               return;
           }
           if( ! current_user_can( 'manage_options' ) ){
               return;
           } ?>
           <div class="smarterthemes welcome-message notice notice-info">
                <div class="notice-wrapper">
                    <div class="notice-text">
                        <h3><?php printf( __( 'Thank you for installing %1$s Theme.', 'business-blogging' ), esc_html( $name ) ); ?></h3>
                        <p><?php esc_html_e( 'Use the button below to turn on advanced blogging and AI auto posting features.', 'business-blogging'  ) ; ?></p>
                        <p>
                            <a href="<?php echo esc_url( 'https://www.quickwrite.ai/blog-special/' );?>" class="button button-primary" style="text-decoration: none;" target="_blank">
                                <?php esc_html_e( 'Get started with AutoPosting', 'business-blogging' ); ?>
                            </a>
                        </p>
                        <p class="dismiss-link"><strong><a href="?business-blogging-update-notice=1"><?php esc_html_e( 'Dismiss','business-blogging' ); ?></a></strong></p>
                    </div>
                </div>
            </div>
       <?php }
}

if ( isset( $_GET['business_blogging_notice_dismissed'] ) ){
    //set notice value false
    update_option('business_blogging_help_notice', 'notice_business_blogging_dismissed');
}

$business_blogging_help_notice = get_option('business_blogging_help_notice', '');

if (($business_blogging_help_notice != 'notice_business_blogging_dismissed' || $business_blogging_help_notice === '') ){
    add_action('admin_notices', 'business_blogging_general_admin_notice');
}