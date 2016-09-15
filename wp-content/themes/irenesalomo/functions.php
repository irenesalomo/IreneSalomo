<?php
    define('THEME_VERSION','23123432123');

    add_action( 'after_setup_theme', 'irenesalomo_setup' );
    function irenesalomo_setup()
    {
        load_theme_textdomain( 'irenesalomo', get_template_directory() . '/languages' );
        add_theme_support( 'title-tag' );
        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'post-thumbnails' );
        global $content_width;
        if ( ! isset( $content_width ) ) $content_width = 640;
        register_nav_menus(
        array( 'main-menu' => __( 'Main Menu', 'irenesalomo' ) )
        );
    }

    add_action( 'wp_enqueue_scripts', 'irenesalomo_load_scripts' );
    function irenesalomo_load_scripts()
    {
        //wp_enqueue_script( 'jquery' );
    }

    add_action( 'comment_form_before', 'irenesalomo_enqueue_comment_reply_script' );
    function irenesalomo_enqueue_comment_reply_script()
    {
        if ( get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }
    }

    add_filter( 'the_title', 'irenesalomo_title' );
    function irenesalomo_title( $title ) {
        if ( $title == '' ) {
        return '&rarr;';
        } else {
        return $title;
        }
    }

    add_filter( 'wp_title', 'irenesalomo_filter_wp_title' );
    function irenesalomo_filter_wp_title( $title )
    {
        return $title . esc_attr( get_bloginfo( 'name' ) );
    }

    add_action( 'widgets_init', 'irenesalomo_widgets_init' );
    function irenesalomo_widgets_init()
    {
        register_sidebar( array (
        'name' => __( 'Sidebar Widget Area', 'irenesalomo' ),
        'id' => 'primary-widget-area',
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => "</li>",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
        ) );
    }

    function irenesalomo_custom_pings( $comment )
    {
    $GLOBALS['comment'] = $comment;
    ?>
    <li <?php comment_class(); ?> id="li-comment-
        <?php comment_ID(); ?>">
            <?php echo comment_author_link(); ?>
    </li>
    <?php
    }

    add_filter( 'get_comments_number', 'irenesalomo_comments_number' );
    function irenesalomo_comments_number( $count )
    {
        if ( !is_admin() ) {
        global $id;
        $comments_by_type = separate_comments( get_comments( 'status=approve&post_id=' . $id ) );
        return count( $comments_by_type['comment'] );
        } else {
        return $count;
        }
    }

    // Add support for custom headers.
    $custom_header_support = array(
        'default-image' => get_template_directory_uri() . '/assets/images/header.jpg',
        'flex-height'   => true,
        'flex-weight'   => true, 
        'uploads'       => true,
    );
    add_theme_support('custom-header',$custom_header_support);