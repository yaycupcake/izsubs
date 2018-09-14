<?php

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
} 

global $top_nav, $social_icons; ?>

<!-- Top Navigation Wrapper -->
<div class="top-nav-wrapper">
    <div class="top-nav-sub-wrapper">
        
        <?php if( $top_nav ): ?>
        <!-- Top Navigation -->
        <nav id="vision-top-nav" class="top-navigation pull-left" role="navigation">
            <?php echo Agama::menu( 'top', 'top-nav-menu' ); ?>
        </nav><!-- Top Navigation End -->
        <?php endif; ?>
        
        <?php if( $social_icons ): ?>
        <!-- Social Icons -->
        <div id="top-social" class="pull-right">
            <?php if( get_theme_mod( 'agama_top_nav_social', true ) ): ?>
                <?php Agama::sociali( false, 'animated' ); ?>
            <?php endif; ?>
        </div><!-- Social Icons End -->
        <?php endif; ?>

    </div>
</div><!-- Top Navigation Wrapper End -->

<!-- Logo -->
<hgroup>

    <?php if( is_customize_preview() ) { echo '<div class="customize_preview_logo" style="display:block;">'; } ?>

    <?php if( get_theme_mod( 'agama_logo' ) ): ?>
    <a href="<?php echo esc_url( home_url('/') ); ?>" 
       title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
        <img src="<?php echo esc_url( get_theme_mod( 'agama_logo', '' ) ); ?>" 
             alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" class="logo">
    </a>
    <?php else: ?>
    <h1 class="site-title">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" 
           title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" 
           rel="home"><?php bloginfo( 'name' ); ?></a>
    </h1>
    <h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
    <?php endif; ?>

    <?php if( is_customize_preview() ) { echo '</div>'; } ?>

    <?php Agama_Helper::get_mobile_menu_toggle_icon(); ?>

</hgroup><!-- Logo End -->

<!-- Primary Navigation -->
<nav id="vision-primary-nav" class="main-navigation" role="navigation">
    <?php echo Agama::menu( 'primary', 'nav-menu' ); ?>
</nav><!-- Primary Navigation End -->

<!-- Mobile Navigation -->
<nav id="vision-mobile-nav" class="mobile-menu collapse" role="navigation">
    <?php echo Agama::menu( 'primary', 'menu' ); ?>
</nav><!-- Mobile Navigation End -->
