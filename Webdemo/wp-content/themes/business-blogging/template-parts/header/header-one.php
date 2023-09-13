<?php
/**
* Template Name: Header Two
*
*/
?>
<header id="masthead" class="site-header header-one" style="background-image: url(<?php echo esc_url( get_header_image() ); ?>);">
	<?php
	$gettopbar  = get_theme_mod( 'top_header_on_off', true );
	$getAddressValue  = get_theme_mod( 'top_header_address', '3486 Oakway Lane Pomona, CA 91766' );
	$getPhoneValue  = get_theme_mod( 'top_header_phone', '+1 763-227-5032' );
	$social_facebook  = get_theme_mod( 'social_facebook', 'https://facebook.com/' );
	$social_instagram  = get_theme_mod( 'social_instagram', 'https://instagram.com/' );
	$social_linkedin  = get_theme_mod( 'social_linkedin', 'https://linkedin.com/' );
	$social_twitter  = get_theme_mod( 'social_twitter', 'https://twitter.com/' );
	if ( true == $gettopbar ) :
	?>
	<div class="top-header">
		<div class="container">
			<div class="row top-header__wrapper">
				<div class="top-details">
					<div class="site-branding header-info">
						<ul class="address-contact-info">
							<li><i class="fa fa-map-marker"></i><span class="address"><?php echo $getAddressValue; ?></span></li>
							<li><i class="fa fa-phone"></i><span class="phone"><?php echo $getPhoneValue; ?></span></li>
						</ul>
					</div><!-- .site-branding -->
				</div>
				<div class="top-social">
					<div class="cssmenu text-right" id="cssmenu_social">
						<ul class="social-links">
							<li><a href="<?php echo $social_facebook;?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
							<li><a href="<?php echo $social_instagram;?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
							<li><a href="<?php echo $social_linkedin;?>" target="_blank"><i class="fa fa-linkedin"></i></a></li>
							<li><a href="<?php echo $social_twitter;?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
	endif;
	?>
	<div class="main-header">
		<div class="container">
			<div class="row">
				<div class="col-md-3 align-self-center">
					<div class="site-branding header-logo">
						<?php
						if ( has_custom_logo() ) :
							the_custom_logo();
						endif;
						?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
							<?php
							$business_blogging_description = get_bloginfo( 'description', 'display' );
							if ( $business_blogging_description || is_customize_preview() ) :
								?>
							<p class="site-description"><?php echo esc_html( $business_blogging_description ); /* WPCS: xss ok. */ ?></p>
								<?php
						endif;
						?>
					</div><!-- .site-branding -->
				</div>
				<div class="col-md-9 m-auto align-self-center text-right">
					<div class="cssmenu text-right" id="cssmenu">
						<?php
						wp_nav_menu(
							array(
								'theme_location'    => 'main-menu',
								'container'         => 'ul',
							)
						);
						?>
						<a href="#" class="menu-search"><i class="fa fa-search"></i></a>
						<div class="search-menu__wrapper">
							<form class="search-form" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
								<input type="text" class="form-control" id="search" placeholder="<?php esc_attr_e( 'Search Here.....', 'business-blogging' ); ?>" value="<?php echo esc_attr( the_search_query() ); ?>" name="s">
								<button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</header><!-- #masthead -->
