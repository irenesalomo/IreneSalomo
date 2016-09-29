<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<?php $theme_uri = get_template_directory_uri(); ?>

    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link rel="stylesheet" type="text/css" media="all" href="<?php _e($theme_uri); ?>/assets/css/build/main.min.css?v=<?php _e(THEME_VERSION) ?>" />
        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>
        <div id="wrapper" class="hfeed">
            <header id="header" role="banner">
                <section class="navbar">
                    <div class="navbar-container">
                        <div class="site-title">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_html( get_bloginfo( 'name' ) ); ?>" rel="home">
                                <span><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span> &ndash;
                                <?php bloginfo( 'description' ); ?>
                            </a>
                        </div>

                        <div class="site-navigation" role="navigation">
                            <div class="navigation-container">
                                <div class="navigation navigation-aboutme">
                                    About Me
                                    <!--<?php wp_nav_menu( array( 'theme_location' => 'main-menu', 
                                            'menu_class' => 'header-menu-list' ) ); ?>-->
                                </div>
                                <div class="navigation navigation-contact">
                                    Contact
                                </div>
                                <div class="navigation navigation-categories">
                                    Categories
                                </div>
                                <div class="navigation navigation-search">
                                    <i class="fa fa-search"></i>

                                </div>
                                <div class="navigation navigation-subscribe">
                                    <i class="fa fa-envelope"></i>
                                </div>
                            </div>
                            <div class="display-md mobile-navigation" role="navigation">
                                <div class="fa fa-lg fa-bars"></div>
                            </div>
                        </div>
                            
                       
                    </div>
                </section>
                
                <section class="header-intro container container-content">
                    <picture>
                        <source media="(min-width: 1200px)" srcset="<?php _e($theme_uri); ?>/assets/images/header.jpg">
                        <source media="(max-width: 1199px)" srcset="<?php _e($theme_uri); ?>/assets/images/header2.jpg">
                        <img src="/assets/images/header.jpg" alt="mountain background">
                    </picture>
                    
                </section>
            </header>
            <div class="main-content-wrapper clearfix">
                <div class="main-content">
                    <div class="container container--content">