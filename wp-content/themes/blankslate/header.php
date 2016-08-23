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
                                <?php echo esc_html( get_bloginfo( 'name' ) ); ?> &ndash;
                                    <?php bloginfo( 'description' ); ?>
                            </a>
                        </div>

                        <div class="site-navigation" role="navigation">
                            <div class="site-search">
                                <?php get_search_form(); ?>
                            </div>
                            <div class="site-menu">
                                <?php wp_nav_menu( array( 'theme_location' => 'main-menu', 
                                        'menu_class' => 'header-menu-list' ) ); ?>
                            </div>

                        </div>




                    </div>

                </section>

                <section class="header-background">
                    <img src="<?php header_image(); ?>" alt="<?php echo esc_attr( get_bloginfo('name')); ?>" />

                </section>
            </header>
            <div class="main-content-wrapper clearfix">
                <div class="main-content">
                    <div class="container container--content">