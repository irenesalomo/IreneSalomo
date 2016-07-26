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
                <section id="branding">
                    <div class="container">
                        <div id="site-title">
                            <h1>
                                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_html( get_bloginfo( 'name' ) ); ?>" rel="home">
                                    <?php echo esc_html( get_bloginfo( 'name' ) ); ?>
                                </a>
                            </h1>
                        </div>
                        <div id="site-description">
                            <?php bloginfo( 'description' ); ?>
                        </div>
                    </div>

                </section>
                <nav id="menu" role="navigation">
                    <div id="search">
                        <?php get_search_form(); ?>
                    </div>
                    <?php wp_nav_menu( array( 'theme_location' => 'main-menu' ) ); ?>
                </nav>
            </header>
            <div class="container">