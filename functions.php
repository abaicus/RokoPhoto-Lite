<?php
/**
 * RokoPhoto Lite functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage RokoPhoto-Lite
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function rokophotolite_setup() {

	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 750;
	}

	// text domain
	load_theme_textdomain( 'rokophotolite', get_template_directory() . '/languages' );

	// Takes care of the <title> tag.
	add_theme_support( 'title-tag' );

	// Add automatic feed links support. http://codex.wordpress.org/Automatic_Feed_Links
	add_theme_support( 'automatic-feed-links' );

	// Add post thumbnails support. http://codex.wordpress.org/Post_Thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add custom background support. http://codex.wordpress.org/Custom_Backgrounds
	add_theme_support( 'custom-background', array(
		// Default color
		'default-color' => 'F6F9FA',
	) );

	// Add custom header support. http://codex.wordpress.org/Custom_Headers
	add_theme_support( 'custom-header', array(
		// Defualt image
		'default-image' => get_template_directory_uri() . '/img/01_services.jpg',
		// Header text
		'header-text'   => false,
		'width'         => 1360,
		'height'        => 582,
	) );

	// This theme uses wp_nav_menu().
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'rokophotolite' ),
	) );

	add_image_size( 'blog_post_thumbnail', 750, 650, true );
	add_image_size( 'blog_post_thumbnail_mobile', 400, 400, true );

	// woocommerce support
	add_theme_support( 'woocommerce' );

	require_once( get_template_directory() . '/inc/customizer-info/class/class-singleton-customizer-info-section.php' );
}

add_action( 'after_setup_theme', 'rokophotolite_setup' );

/**
 * Registering and enqueuing scripts/stylesheets to header/footer.
 */
function rokophotolite_scripts() {
	wp_enqueue_style( 'rokophoto_font', '//fonts.googleapis.com/css?family=Open+Sans:400,600' );
	wp_enqueue_style( 'rokophotolite_style', get_stylesheet_uri(), array(
		'rokophotolite_bootstrap',
		'rokophotolite_animate',
		'rokophotolite_font_awesome',
	) );
	wp_enqueue_style( 'rokophotolite_bootstrap', get_template_directory_uri() . '/css/bootstrap.css' );
	wp_enqueue_style( 'rokophotolite_animate', get_template_directory_uri() . '/css/animate.css' );
	wp_enqueue_style( 'rokophotolite_font_awesome', get_template_directory_uri() . '/css/font-awesome.css' );
	wp_enqueue_style( 'rokophotolite_responsiveness', get_template_directory_uri() . '/css/responsiveness.css' );

	if ( is_singular() ) {
		wp_enqueue_script( 'comment-reply' );
	}
	wp_enqueue_script( 'rokophotolite_modernizr', get_template_directory_uri() . '/js/modernizr.custom.js' );

	wp_enqueue_script( 'rokophotolite_navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );
	wp_enqueue_script( 'rokophotolite_bootstrap', get_template_directory_uri() . '/js/bootstrap.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'rokophotolite_wow', get_template_directory_uri() . '/js/wow.min.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'rokophotolite_smooth_scroll', get_template_directory_uri() . '/js/SmoothScroll.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'rokophotolite_easing', get_template_directory_uri() . '/js/jquery.easing.min.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'rokophotolite_animate_header', get_template_directory_uri() . '/js/cbpAnimatedHeader.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'rokophotolite_classie', get_template_directory_uri() . '/js/classie.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'rokophotolite_main', get_template_directory_uri() . '/js/main.js', array( 'jquery' ), '', true );
}

add_action( 'wp_enqueue_scripts', 'rokophotolite_scripts' );

/**
 * Adding IE-only scripts to header.
 */
function rokophotolite_ie() {
	echo '<!--[if lt IE 9]>' . "\n";
	echo '<script src="' . get_template_directory_uri() . '/js/html5shiv.min.js"></script>' . "\n";
	echo '<script src="' . get_template_directory_uri() . '/js/respond.min.js"></script>' . "\n";
	echo '<![endif]-->' . "\n";
}

add_action( 'wp_head', 'rokophotolite_ie' );


/**
 * Menu fallback. Link to the menu editor if that is useful.
 *
 * @param  array $args wp_nav_menu arguments.
 *
 * @return string
 */
function rokophotolite_new_setup( $args ) {
	// see wp-includes/nav-menu-template.php for available arguments
	$link = $args['link_before'] .
	        '<a href="' . esc_url( home_url( '/' ) ) . '">' .
	        $args['before'] . __( 'Home', 'rokophotolite' ) . $args['after'] .
	        '</a>' .
	        $args['link_after'];

	// We have a list
	if ( false !== stripos( $args['items_wrap'], '<ul' ) or false !== stripos( $args['items_wrap'], '<ol' ) ) {
		$link = "<li class='menu-item'>" . $link . '</li>';
	}

	$output = sprintf( $args['items_wrap'], $args['menu_id'], $args['menu_class'], $link );
	if ( ! empty( $args['container'] ) ) {
		$output = '<' . esc_attr( $args['container'] ) . ' class="' . esc_attr( $args['container_class'] ) . '" id="' . esc_attr( $args['container_id'] ) . '">' . esc_textarea( $output ) . '</' . esc_attr( $args['container'] ) . '>';
	}

	if ( $args['echo'] ) {
		echo $output;
	}

	return $output;
}

/**
 * Custom function to use to open and display each comment.
 *
 * @param integer /string/object $comment Author’s User ID (an integer or string), an E-mail Address (a string) or the comment object from the comment loop.
 * @param array                  $args Comments args.
 * @param int                    $depth Depth of comments.
 */
function rokophotolite_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	?>
	<li <?php comment_class( 'comment even thread-even' ); ?> id="comment-<?php comment_ID() ?>">
	<table class="comment-container wow fadeIn">
		<tr>
			<td class="comment-avatar">
				<?php echo get_avatar( $comment, 70 ); ?>
			</td>
			<td class="comment-data">
				<div class="comment-header">
					<span
						class="comment-author"><?php printf( '%s', get_comment_author_link() ) ?></span>
					<span
						class="comment-date"><?php echo get_comment_date(); ?><?php _e( 'on', 'rokophotolite' ); ?><?php echo get_comment_time(); ?></span>
					<?php comment_reply_link( array_merge( $args, array(
						'depth'     => $depth,
						'max_depth' => $args['max_depth'],
					) ) ) ?>
				</div>
				<div class="comment-body">
					<?php if ( $comment->comment_approved == '0' ) : ?>
						<em><?php _e( 'Your comment is awaiting moderation.', 'rokophotolite' ) ?></em><br/>
					<?php endif; ?>
					<?php comment_text(); ?>
				</div>
			</td>
		</tr>
	</table>
	<?php
}

/**
 * Theme inline style.
 */
function rokophotolite_css() {
	if ( is_user_logged_in() ) {
		?>
		<style>
			.comment-login {
				width: 100% !important;
			}
		</style>
		<?php
	}
}

add_action( 'wp_head', 'rokophotolite_css' );

/**
 * Define all the controls for the Theme Customizer.
 */
function rokophotolite_customize_register( $wp_customize ) {

	require_once( 'inc/class/class-rokophoto-info.php' );
	require_once( 'inc/class/class-rokophoto-text-control.php' );

	$wp_customize->add_setting( 'rokophotolite_slider_upsale', array(
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( new RokoPhoto_Text( $wp_customize, 'rokophotolite_slider_upsale',
		array(
			'section'           => 'rokophotolite_subhead_section',
			'priority'          => 10,
			'rokophoto_message' => __( 'Check out the <a href="https://themeisle.com/themes/rokophoto/">PRO version</a> add a Slider on frontpage!', 'rokophotolite' ),
		)
	) );

	$wp_customize->add_setting( 'rokophotolite_portfolio_upsale', array(
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( new RokoPhoto_Text( $wp_customize, 'rokophotolite_portfolio_upsale',
		array(
			'section'           => 'rokophotolite_subhead_section',
			'priority'          => 12,
			'rokophoto_message' => __( 'Check out the <a href="https://themeisle.com/themes/rokophoto/">PRO version</a> add a Portfolio section on frontpage!', 'rokophotolite' ),
		)
	) );

	$wp_customize->add_setting( 'rokophotolite_sanitize_pro_version', array(
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( new RokoPhoto_Text( $wp_customize, 'rokophotolite_sanitize_pro_version',
		array(
			'section'           => 'rokophotolite_subhead_section',
			'priority'          => 15,
			'rokophoto_message' => __( 'Check out the <a href="https://themeisle.com/themes/rokophoto/">PRO version</a> add a Contact section on frontpage!', 'rokophotolite' ),
		)
	) );

	$wp_customize->add_section( 'rockophoto_theme_info', array(
			'title'    => __( 'Theme info', 'rokophotolite' ),
			'priority' => 0,
		)
	);
	$wp_customize->add_setting( 'rockophoto_theme_info', array(
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control( new RokoPhoto_Info( $wp_customize, 'rockophoto_theme_info', array(
			'section'  => 'rockophoto_theme_info',
			'priority' => 10,
	) ) );

	$wp_customize->add_section( 'rokophotolite_logo_section', array(
		'priority' => 25,
		'title'    => __( 'Site Logo', 'rokophotolite' ),
	) );

	$wp_customize->add_section( 'rokophotolite_subhead_section', array(
		'priority' => 50,
		'title'    => __( 'Sub-Header', 'rokophotolite' ),
	) );

	$wp_customize->add_section( 'rokophotolite_footer_section', array(
		'priority' => 60,
		'title'    => __( 'Footer', 'rokophotolite' ),
	) );

	$wp_customize->add_setting( 'rokophotolite_logo_image', array(
		'default'           => get_template_directory_uri() . '/img/logo.png',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'esc_url_raw',
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'rokophotolite_logo_image', array(
		'label'    => __( 'Site Logo Image', 'rokophotolite' ),
		'section'  => 'rokophotolite_logo_section',
		'priority' => 5,
		'settings' => 'rokophotolite_logo_image',
	) ) );

	$wp_customize->add_setting( 'rokophotolite_subhead_title', array(
		'default'           => 'Welcome to',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'rokophotolite_subhead_title', array(
		'label'    => __( 'Sub-Header Title', 'rokophotolite' ),
		'section'  => 'rokophotolite_subhead_section',
		'priority' => 5,
		'settings' => 'rokophotolite_subhead_title',
	) );

	$wp_customize->add_setting( 'rokophotolite_social_label', array(
		'default'           => 'To get the latest update of me and my works',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'rokophotolite_social_label', array(
		'label'    => __( 'Social Box Label', 'rokophotolite' ),
		'section'  => 'rokophotolite_footer_section',
		'priority' => 5,
		'settings' => 'rokophotolite_social_label',
	) );

	$wp_customize->add_setting( 'rokophotolite_social_text', array(
		'default'           => 'Follow Me',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'rokophotolite_social_text', array(
		'label'    => __( 'Social Box Text', 'rokophotolite' ),
		'section'  => 'rokophotolite_footer_section',
		'priority' => 10,
		'settings' => 'rokophotolite_social_text',
	) );

	$wp_customize->add_setting( 'rokophotolite_facebook_link', array(
		'default'           => '#',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'esc_url_raw',
	) );

	$wp_customize->add_control( 'rokophotolite_facebook_link', array(
		'label'    => __( 'Facebook URL', 'rokophotolite' ),
		'section'  => 'rokophotolite_footer_section',
		'priority' => 15,
		'settings' => 'rokophotolite_facebook_link',
	) );

	$wp_customize->add_setting( 'rokophotolite_twitter_link', array(
		'default'           => '#',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'esc_url_raw',
	) );

	$wp_customize->add_control( 'rokophotolite_twitter_link', array(
		'label'    => __( 'Twitter URL', 'rokophotolite' ),
		'section'  => 'rokophotolite_footer_section',
		'priority' => 20,
		'settings' => 'rokophotolite_twitter_link',
	) );

	$wp_customize->add_setting( 'rokophotolite_behance_link', array(
		'default'           => '#',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'esc_url_raw',
	) );

	$wp_customize->add_control( 'rokophotolite_behance_link', array(
		'label'    => __( 'Behance URL', 'rokophotolite' ),
		'section'  => 'rokophotolite_footer_section',
		'priority' => 25,
		'settings' => 'rokophotolite_behance_link',
	) );

	$wp_customize->add_setting( 'rokophotolite_dribbble_link', array(
		'default'           => '#',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'esc_url_raw',
	) );

	$wp_customize->add_control( 'rokophotolite_dribbble_link', array(
		'label'    => __( 'Dribbble URL', 'rokophotolite' ),
		'section'  => 'rokophotolite_footer_section',
		'priority' => 30,
		'settings' => 'rokophotolite_dribbble_link',
	) );

	$wp_customize->add_setting( 'rokophotolite_flickr_link', array(
		'default'           => '#',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'esc_url_raw',
	) );

	$wp_customize->add_control( 'rokophotolite_flickr_link', array(
		'label'    => __( 'Flickr URL', 'rokophotolite' ),
		'section'  => 'rokophotolite_footer_section',
		'priority' => 35,
		'settings' => 'rokophotolite_flickr_link',
	) );

	$wp_customize->add_setting( 'rokophotolite_googleplus_link', array(
		'default'           => '#',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'esc_url_raw',
	) );

	$wp_customize->add_control( 'rokophotolite_googleplus_link', array(
		'label'    => __( 'Google + URL', 'rokophotolite' ),
		'section'  => 'rokophotolite_footer_section',
		'priority' => 40,
		'settings' => 'rokophotolite_googleplus_link',
	) );

	$wp_customize->add_setting( 'rokophotolite_instagram_link', array(
		'default'           => '#',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'esc_url_raw',
	) );

	$wp_customize->add_control( 'rokophotolite_instagram_link', array(
		'label'    => __( 'Instagram URL', 'rokophotolite' ),
		'section'  => 'rokophotolite_footer_section',
		'priority' => 45,
		'settings' => 'rokophotolite_instagram_link',
	) );

	$wp_customize->add_setting( 'rokophotolite_mail_link', array(
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_email',
	) );

	$wp_customize->add_control( 'rokophotolite_mail_link', array(
		'label'    => __( 'Email address', 'rokophotolite' ),
		'section'  => 'rokophotolite_footer_section',
		'priority' => 50,
		'settings' => 'rokophotolite_mail_link',
	) );

	$wp_customize->add_setting( 'rokophotolite_linkedin_link', array(
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'esc_url_raw',
	) );

	$wp_customize->add_control( 'rokophotolite_linkedin_link', array(
		'label'    => __( 'LinkedIn URL', 'rokophotolite' ),
		'section'  => 'rokophotolite_footer_section',
		'priority' => 55,
		'settings' => 'rokophotolite_linkedin_link',
	) );

	$wp_customize->add_setting( 'rokophotolite_footer_copyrights', array(
		'default'           => 'RokoPhoto Lite. All Rights Reserved',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'rokophotolite_footer_copyrights', array(
		'label'    => __( 'Footer Copyrights', 'rokophotolite' ),
		'section'  => 'rokophotolite_footer_section',
		'priority' => 60,
		'settings' => 'rokophotolite_footer_copyrights',
	) );
}

add_action( 'customize_register', 'rokophotolite_customize_register' );

/**
 * Widget initialization.
 */
function rokophoto_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar top', 'rokophotolite' ),
		'id'            => 'rokophoto-sidebar-top',
		'description'   => __( 'Widgets in this area will be shown on all posts and pages.', 'rokophotolite' ),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'Sidebar bottom', 'rokophotolite' ),
		'id'            => 'rokophoto-sidebar-bottom',
		'description'   => __( 'Widgets in this area will be shown on all posts and pages.', 'rokophotolite' ),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'rokophoto_widgets_init' );
