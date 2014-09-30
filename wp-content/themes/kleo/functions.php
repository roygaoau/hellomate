<?php
/**
 * @package WordPress
 * @subpackage Kleo
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since Kleo 1.0
 */

/***************************************************
:: Load Kleo framework
***************************************************/

require_once( trailingslashit( get_template_directory() ) . 'kleo-framework/kleo.php' );


if ( ! isset( $content_width ) )
{
	$content_width = 1200;
}



/***************************************************
:: Load Theme specific functions
***************************************************/

require_once( trailingslashit( get_template_directory() ) . 'lib/theme-functions.php' );



/**
 * Sets up theme defaults and registers the various WordPress features
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add a Visual Editor stylesheet.
 * @uses add_theme_support() To add support for post thumbnails, automatic feed links,
 * 	custom background, and post formats.
 * @uses register_nav_menu() To add support for navigation menus.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Kleo Framework 1.0
 */
function kleo_setup() {

	/*
	 * Makes theme available for translation.
	 * Translations can be added to the /languages/ directory.
	 */
	load_theme_textdomain( 'kleo_framework', get_template_directory() . '/languages' );

	/* This theme styles the visual editor with editor-style.css to match the theme style. */
	add_editor_style();

	/* Adds RSS feed links to <head> for posts and comments. */
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery',
	) );
    
	/* This theme uses wp_nav_menu() in two locations. */
	register_nav_menu( 'primary', __( 'Primary Menu', 'kleo_framework' ) );
	register_nav_menu( 'top', __( 'Top Menu', 'kleo_framework' ) );

	/* This theme uses a custom image size for featured images, displayed on "standard" posts. */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 672, 9999 ); // Unlimited height, soft crop 
	add_image_size( 'kleo-full-width', 1038, 583 );
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list',
	) );	
	
	// Add support for featured content.
	add_theme_support( 'featured-content', array(
		'featured_content_filter' => 'kleo_get_featured_posts',
		'max_posts' => 6,
	) );
	
	/* Specific framework functionality */
	add_theme_support( 'kleo-sidebar-generator' );
	add_theme_support( 'kleo-facebook-login' );
  add_theme_support( 'kleo-mega-menu' );
  add_theme_support( 'kleo-menu-items' );
    
	/* Third-party plugins */
	add_theme_support( 'bbpress' );
	add_theme_support( 'woocommerce' );
	
}
add_action( 'after_setup_theme', 'kleo_setup' );




if (!function_exists('kleo_wp_title')):
	/**
	 * Creates a nicely formatted and more specific title element text
	 * for output in head of document, based on current view.
	 *
	 * @since Kleo Framework 1.0
	 *
	 * @param string $title Default title text for current view.
	 * @param string $sep Optional separator.
	 * @return string Filtered title.
	 */
	function kleo_wp_title( $title, $sep ) 
	{
			global $paged, $page;

			if ( is_feed() ) {
					return $title;
			}
			// Add the site name.
			$title .= get_bloginfo( 'name' );

			// Add the site description for the home/front page.
			$site_description = get_bloginfo( 'description', 'display' );
			if ( $site_description && ( is_home() || is_front_page() ) ) {
					$title = "$title $sep $site_description";
			}
			// Add a page number if necessary.
			if ( $paged >= 2 || $page >= 2 ) {
					$title = "$title $sep " . sprintf( __( 'Page %s', 'kleo_framework' ), max( $paged, $page ) );
			}
			
			return $title;
	}
	add_filter( 'wp_title', 'kleo_wp_title', 10, 2 );
endif;



/***************************************************
:: Main menu Navigation
***************************************************/

/**
 * Modify some elements for the menu
 */
if (!class_exists('kleo_walker_nav_menu')): 

	class kleo_walker_nav_menu extends Walker_Nav_Menu {

		/**
		 * @see Walker::start_lvl()
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param int $depth Depth of page. Used for padding.
		 */
		public function start_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat( "\t", $depth );
			$output .= "\n$indent<ul role=\"menu\" class=\"dropdown-menu".($depth ===0?" pull-left":"")."\">\n";
		}

		/**
		 * @see Walker::start_el()
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param object $item Menu item data object.
		 * @param int $depth Depth of menu item. Used for padding.
		 * @param int $current_page Menu item ID.
		 * @param object $args
		 */
		public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

			/**
			 * Dividers, Headers or Disabled
			 * =============================
			 * Determine whether the item is a Divider, Header, Disabled or regular
			 * menu item. To prevent errors we use the strcasecmp() function to so a
			 * comparison that is not case sensitive. The strcasecmp() function returns
			 * a 0 if the strings are equal.
			 */
			if ( strcasecmp( $item->attr_title, 'divider' ) == 0 && $depth === 1 ) {
				$output .= $indent . '<li role="presentation" class="divider">';
			} else if ( strcasecmp( $item->title, 'divider') == 0 && $depth === 1 ) {
				$output .= $indent . '<li role="presentation" class="divider">';
			} else if ( strcasecmp( $item->attr_title, 'dropdown-header') == 0 && $depth === 1 ) {
				$output .= $indent . '<li role="presentation" class="dropdown-header">' . esc_attr( $item->title );
			} else if ( strcasecmp($item->attr_title, 'disabled' ) == 0 ) {
				$output .= $indent . '<li role="presentation" class="disabled"><a href="#">' . esc_attr( $item->title ) . '</a>';
			} else {

				$class_names = $value = '';

				$classes = empty( $item->classes ) ? array() : (array) $item->classes;
				$classes[] = 'menu-item-' . $item->ID;

				$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );

				if ( $args->has_children && $depth === 1 ) {
					$class_names .= ' dropdown-submenu';
				}
				elseif($args->has_children) {
					$class_names .= ' dropdown';
					if ($item->mega == 'yes') {
						$class_names .= ' kleo-megamenu';
					}
					$submenus = $depth == 0 ? get_posts( array( 'post_type' => 'nav_menu_item', 'numberposts' => -1, 'orderby' => 'menu_order', 'order' => 'ASC', 'meta_query' => array( array( 'key' => '_menu_item_menu_item_parent', 'value' => $item->ID ) ) ) ) : false;
					$count = $submenus ? count( $submenus ) : 'no';
					
					$class_names .= ' mega-' . $count . '-cols';
				}

				if ( in_array( 'current-menu-item', $classes ) )
					$class_names .= ' active';

				$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

				$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
				$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

                $data_li = $indent . '<li' . $id . $value . $class_names .'>';

				$atts = array();
				if (strpos($item->attr_title,'class=') !== false) {
					$atts['class'] = (isset($atts['class']) ? $atts['class']." " : '') . str_replace('class=', '', $item->attr_title);
				}else {
					$atts['title'] = ! empty( $item->attr_title ) ? $item->attr_title : ( ! empty( $item->title ) ? esc_attr($item->title) : '' );
				}
				$atts['target'] = ! empty( $item->target )        ? $item->target        : '';
				$atts['rel'] = ! empty( $item->xfn )                ? $item->xfn        : '';

				// If item has_children add atts to a.
				if ( $args->has_children && $depth === 0 ) {
					//$atts['href']				= '#';
					$atts['href']					= ! empty( $item->url ) ? $item->url : '';
					//$atts['data-toggle']	= 'dropdown';
					$atts['class']				= 'js-activated';
				} else {
					$atts['href'] = ! empty( $item->url ) ? $item->url : '';
				}
				
	

				$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

				$attributes = '';
				foreach ( $atts as $attr => $value ) {
					if ( ! empty( $value ) ) {
						$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
						$attributes .= ' ' . $attr . '="' . $value . '"';
					}
				}

				$item_output = $args->before;
				$item_output .= '<a'. $attributes .'>';

                /* Menu icons */
                if (isset( $item->icon ) && $item->icon != '') {
                    $title_icon = '<i class="icon-' . $item->icon . '"></i>';

                    if ( $item->iconpos == 'after' ) {
                        $title = $item->title . ' ' . $title_icon;
                    }
                    elseif ( $item->iconpos == 'icon' ) {
                        $title = $title_icon;
                    }
                    else {
                        $title = $title_icon . ' ' . $item->title;
                    }
                }
                else {
                    $title = $item->title;
                }

				$item_output .= $args->link_before . apply_filters( 'the_title', $title, $item->ID ) . $args->link_after;

				$item_output .= ( $args->has_children && in_array($depth, array(0,1))) ? ' <span class="caret"></span></a>' : '</a>';
				$item_output .= $args->after;
        
                //custom filters
                $css_target = preg_match( '/\skleo-(.*)-nav/', implode( ' ', $item->classes), $matches );
                // If this isn't a KLEO menu item, we can stop here
                if ( ! empty( $matches[1] ) ) {
                    $item_output = apply_filters( 'walker_nav_menu_start_el_' . $matches[1], $item_output, $item, $depth, $args );
                    $data_li = apply_filters( 'walker_nav_menu_start_el_li_' . $matches[1], $data_li, $item, $depth, $args);
                }

                $output .= $data_li;

				$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
			}
		}

		/**
		 * Traverse elements to create list from elements.
		 *
		 * Display one element if the element doesn't have any children otherwise,
		 * display the element and its children. Will only traverse up to the max
		 * depth and no ignore elements under that depth.
		 *
		 * This method shouldn't be called directly, use the walk() method instead.
		 *
		 * @see Walker::start_el()
		 * @since 2.5.0
		 *
		 * @param object $element Data object
		 * @param array $children_elements List of elements to continue traversing.
		 * @param int $max_depth Max depth to traverse.
		 * @param int $depth Depth of current element.
		 * @param array $args
		 * @param string $output Passed by reference. Used to append additional content.
		 * @return null Null on failure with no changes to parameters.
		 */
		public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
		if ( ! $element )
				return;

		$id_field = $this->db_fields['id'];

		// Display this element.
		if ( is_object( $args[0] ) )
			 $args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );

		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
		}

		/**
		 * Menu Fallback
		 * =============
		 * If this function is assigned to the wp_nav_menu's fallback_cb variable
		 * and a manu has not been assigned to the theme location in the WordPress
		 * menu manager the function with display nothing to a non-logged in user,
		 * and will add a link to the WordPress menu manager if logged in as an admin.
		 *
		 * @param array $args passed from the wp_nav_menu function.
		 *
		 */
		public static function fallback( $args ) {
			if ( current_user_can( 'manage_options' ) ) {

				extract( $args );

				$fb_output = null;

				if ( $container ) {
					$fb_output = '<' . $container;

					if ( $container_id )
						$fb_output .= ' id="' . $container_id . '"';

					if ( $container_class )
						$fb_output .= ' class="' . $container_class . '"';

					$fb_output .= '>';
				}

				$fb_output .= '<ul';

				if ( $menu_id )
					$fb_output .= ' id="' . $menu_id . '"';

				if ( $menu_class )
					$fb_output .= ' class="' . $menu_class . '"';

				$fb_output .= '>';
				$fb_output .= '<li><a href="' . admin_url( 'nav-menus.php' ) . '">Add a menu</a></li>';
				$fb_output .= '</ul>';

				if ( $container )
					$fb_output .= '</' . $container . '>';

				echo $fb_output;
			}
		}
	}
	
endif;
//------------------------------------------------------------------------------



/***************************************************
:: Featured content 
***************************************************/

/**
 * Getter function for Featured Content Plugin.
 *
 * @since Kleo 1.0
 *
 * @return array An array of WP_Post objects.
 */
function kleo_get_featured_posts() {
	/**
	 * Filter the featured posts to return in Kleo.
	 *
	 * @since Kleo 1.0
	 *
	 * @param array|bool $posts Array of featured posts, otherwise false.
	 */
	return apply_filters( 'kleo_get_featured_posts', array() );
}

/**
 * A helper conditional function that returns a boolean value.
 *
 * @since Kleo 1.0
 *
 * @return bool Whether there are featured posts.
 */
function kleo_has_featured_posts() {
	return ! is_paged() && (bool) kleo_get_featured_posts();
}


/*
 * Add Featured Content functionality.
 *
 * To overwrite in a plugin, define your own Featured_Content class on or
 * before the 'setup_theme' hook.
 */
if ( ! class_exists( 'Featured_Content' ) && 'plugins.php' !== $GLOBALS['pagenow'] ) {
	require get_template_directory() . '/lib/featured-content/featured-content.php';
}
//------------------------------------------------------------------------------



if (!function_exists('kleo_widgets_init')):
	/**
	 * Registers our main widget area and the front page widget areas.
	 *
	 * @since Kleo 1.0
	 */
	function kleo_widgets_init() {
		register_sidebar( array(
			'name' => __( 'Main Sidebar', 'kleo_framework' ),
			'id' => 'sidebar-1',
			'description' => __( 'Default sidebar', 'kleo_framework' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>',
		) );
		register_sidebar(array(
			'name' => 'Footer column 1',
			'id' => 'footer-1',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>',
		));

		register_sidebar(array(
			'name' => 'Footer column 2',
				'id' => 'footer-2',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>',
		));

		register_sidebar(array(
			'name' => 'Footer column 3',
			'id' => 'footer-3',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>',
		));

		register_sidebar(array(
			'name' => 'Footer column 4',
			'id' => 'footer-4',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>',
		));
    register_sidebar(array(
			'name' => 'Extra - for 3 columns pages',
			'id' => 'extra',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>',
     ));
    register_sidebar(array(
			'name' => 'Shop sidebar',
			'id' => 'shop-1',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>',
     ));

	}
endif;
add_action( 'widgets_init', 'kleo_widgets_init' );



if ( ! function_exists( 'kleo_entry_meta' ) ) :
	/**
	 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
	 * Create your own kleo_entry_meta() to override in a child theme.
	 * @since 1.0
	 */
	function kleo_entry_meta($echo=true, $att=array()) {
	
		$meta_list = array();
		
		// Translators: used between list items, there is a space after the comma.
		$categories_list = get_the_category_list( __( ', ', 'kleo_framework' ) );

		// Translators: used between list items, there is a space after the comma.
		$tag_list = get_the_tag_list( '', __( ', ', 'kleo_framework' ) );

		$date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark" class="post-time"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);

		$author = sprintf( '<a href="%1$s" title="%2$s" rel="author">%3$s</a>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'kleo_framework' ), get_the_author() ) ),
			get_the_author()
		);

		$meta_list[] = '<small class="meta-author">'.$author.'</small>';
		$meta_list[] = '<small>'.$date.'</small>';
		
		$cat_tag = array();
		
		if ( $categories_list ) {
			$cat_tag[] = $categories_list;
		}
		
		if ($tag_list) {
			$cat_tag[] = $tag_list;
		}
		if (!empty($cat_tag)) {
			$meta_list[] = '<small class="meta-category">'.implode(", ",$cat_tag).'</small>';
		}
		
		//comments
		if (!isset($att['comments']) || (isset($att['comments']) && $att['comments'] !== false)) {
		$meta_list[] = '<small class="meta-comment-count"><a href="'. get_permalink().'#comments">'.get_comments_number().' <i class="icon-chat-1 hover-tip" 
			data-original-title="'.sprintf( _n( 'This article has one comment', 'This article has %1$s comments', get_comments_number(), 'kleo_framework' ),number_format_i18n( get_comments_number() ) ).'" 
			data-toggle="tooltip" 
			data-placement="top"></i></a></small>';
		}
		
		if ($echo) {
			echo implode(", ", $meta_list);
		}
		else {
			return implode(", ", $meta_list);
		}
		
	}
endif;



/***************************************************
:: Comments functions
***************************************************/


if (!function_exists('kleo_custom_comments')) {
	/**
	 * Display customized comments
	 * @param object $comment
	 * @param array $args
	 * @param integer $depth
	 */
	function kleo_custom_comments($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment;
		$GLOBALS['comment_depth'] = $depth;
		?>
		<li id="comment-<?php comment_ID() ?>" <?php comment_class('clearfix') ?>>
			<div class="comment-wrap clearfix">
				<div class="comment-avatar kleo-rounded">
					<?php if(function_exists('get_avatar')) { echo get_avatar($comment, '100'); } ?>
					<?php if ($comment->comment_author_email == get_the_author_meta('email')) { ?>
					<span class="tooltip"><?php _e("Author", "kleo_framework"); ?><span class="arrow"></span></span>
					<?php } ?>
				</div>
				<div class="comment-content">
					<div class="comment-meta">
						<?php
							printf('<span class="comment-author">%1$s</span> <span class="comment-date">%2$s</span>',
								get_comment_author_link(),
								human_time_diff( get_comment_time('U'), current_time('timestamp') ) . ' ' . __("ago", "kleo_framework")
							);
						?>
					</div>
					<?php if ($comment->comment_approved == '0') _e("<span class='unapproved'>Your comment is awaiting moderation.</span>\n", 'kleo_framework') ?>
					<div class="comment-body">
							<?php comment_text() ?>
					</div>
					<div class="comment-meta-actions">
						<?php
						edit_comment_link(__('Edit', 'kleo_framework'), '<span class="edit-link">', '</span><span class="meta-sep"> |</span>');
						?>
						<?php if($args['type'] == 'all' || get_comment_type() == 'comment') :
							comment_reply_link(array_merge($args, array(
									'reply_text' => __('Reply','kleo_framework'),
									'login_text' => __('Log in to reply.','kleo_framework'),
									'depth' => $depth,
									'before' => '<span class="comment-reply">',
									'after' => '</span>'
							)));
						endif; ?>
					</div>
				</div>
			</div>
<?php }
} // end kleo_custom_comments



if (!function_exists('kleo_comment_form')) :
	/**
	 * Outputs a complete commenting form for use within a template.
	 * Most strings and form fields may be controlled through the $args array passed
	 * into the function, while you may also choose to use the comment_form_default_fields
	 * filter to modify the array of default fields if you'd just like to add a new
	 * one or remove a single field. All fields are also individually passed through
	 * a filter of the form comment_form_field_$name where $name is the key used
	 * in the array of fields.
	 *
	 * @param array $args Options for strings, fields etc in the form
	 * @param mixed $post_id Post ID to generate the form for, uses the current post if null
	 * @return void
	 */
	function kleo_comment_form( $args = array(), $post_id = null ) {
		global $id;

		$user = wp_get_current_user();
		$user_identity = $user->exists() ? $user->display_name : '';

		if ( null === $post_id ) {
			$post_id = $id;
		}
		else {
			$id = $post_id;
		}

		if ( comments_open( $post_id ) ) :
		?>
		<div id="respond-wrap">
			<?php 
				$commenter = wp_get_current_commenter();
				$req = get_option( 'require_name_email' );
				$aria_req = ( $req ? " aria-required='true'" : '' );
				$fields =  array(
					'author' => '<div class="row"><p class="comment-form-author col-sm-4"><label for="author">' . __( 'Name', 'kleo_framework' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) . '<input id="author" name="author" type="text" class="form-control" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
					'email' => '<p class="comment-form-email col-sm-4"><label for="email">' . __( 'Email', 'kleo_framework' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) . '<input id="email" name="email" type="text" class="form-control" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
					'url' => '<p class="comment-form-url col-sm-4"><label for="url">' . __( 'Website', 'kleo_framework' ) . '</label><input id="url" name="url" type="text" class="form-control" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p></div>'
				);
        
        if (function_exists('bp_is_active')) {
          $profile_link = bp_get_loggedin_user_link();
        }
        else {
          $profile_link = admin_url( 'profile.php' );
        }
        
				$comments_args = array(
						'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
						'logged_in_as'		   => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'kleo_framework' ), $profile_link, $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
						'title_reply'          => __( 'Leave a reply', 'kleo_framework' ),
						'title_reply_to'       => __( 'Leave a reply to %s', 'kleo_framework' ),
						'cancel_reply_link'    => __( 'Click here to cancel the reply', 'kleo_framework' ),
						'label_submit'         => __( 'Post comment', 'kleo_framework' ),
						'comment_field'		   => '<p class="comment-form-comment"><label for="comment">' . __( 'Comment', 'kleo_framework' ) . '</label><textarea class="form-control" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
						'must_log_in'		   => '<p class="must-log-in">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'kleo_framework' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
				);

			comment_form($comments_args); 
			?>
		</div>

		<?php
		endif;

	}
endif;


if ( ! function_exists( 'kleo_the_attached_image' ) ) :
/**
 * Print the attached image with a link to the next attached image.
 *
 * @since Kleo 1.0
 *
 * @return void
 */
function kleo_the_attached_image() {
	$post = get_post();
	/**
	 * Filter the default attachment size.
	 *
	 * @since Kleo 1.0
	 *
	 * @param array $dimensions {
	 *     An array of height and width dimensions.
	 *
	 *     @type int $height Height of the image in pixels. Default 810.
	 *     @type int $width  Width of the image in pixels. Default 810.
	 * }
	 */
	$attachment_size     = apply_filters( 'kleo_attachment_size', array( 810, 810 ) );
	$next_attachment_url = wp_get_attachment_url();

	/*
	 * Grab the IDs of all the image attachments in a gallery so we can get the URL
	 * of the next adjacent image in a gallery, or the first image (if we're
	 * looking at the last image in a gallery), or, in a gallery of one, just the
	 * link to that image file.
	 */
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID',
	) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id ) {
			$next_attachment_url = get_attachment_link( $next_id );
		}

		// or get the URL of the first image attachment.
		else {
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
		}
	}

	printf( '<a href="%1$s" rel="attachment">%2$s</a>',
		esc_url( $next_attachment_url ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;



/***************************************************
:: Sidebar logic
***************************************************/
if (!function_exists('kleo_switch_layout')) {
	/**
	 * Change site layout
	 * @param string $layout
	 */
	function kleo_switch_layout($layout=false)
	{
		if($layout == false) {
			$layout = sq_option('global_sidebar', 'right');
		}
		
		$main_width_2cols = (int)sq_option('main_width_2cols', 9) == 0 ? 9 : (int)sq_option('main_width_2cols', 9);
		$main_width_3cols = (int)sq_option('main_width_3cols', 6) == 0 ? 6 : (int)sq_option('main_width_3cols', 6);
		
		$sidebar_width_2cols = 12 - $main_width_2cols;
		$sidebar_width_3cols = ( 12 - $main_width_3cols ) / 2;

		switch ($layout) {

			case 'left':
				add_action('kleo_after_content', 'kleo_sidebar');
				remove_action('kleo_after_content', 'kleo_extra_sidebar');
				add_filter('kleo_main_template_classes', create_function('$cols', '$cols = "col-sm-' . $main_width_2cols . ' col-sm-push-' . $sidebar_width_2cols . ' tpl-left"; return $cols;'));
				add_filter('kleo_sidebar_classes', create_function('$cols', '$cols = "col-sm-' . $sidebar_width_2cols . ' sidebar-left col-sm-pull-' . $main_width_2cols . '"; return $cols;'));			
				break;

			case 'no':		//full width
				remove_action('kleo_after_content', 'kleo_sidebar');
				remove_action('kleo_after_content', 'kleo_extra_sidebar');
				add_filter('kleo_main_template_classes', create_function('$cols', '$cols = "col-sm-12 tpl-no"; return $cols;'));
				//enable full-width elements
				if (is_singular() && kleo_has_shortcode('vc_row')) {
					add_filter( 'kleo_main_container_class', 'kleo_ret_full_container' );
				}
				
				break;

			case '3ll':
				add_action('kleo_after_content', 'kleo_sidebar');
				add_action('kleo_after_content', 'kleo_extra_sidebar');
				add_filter('kleo_main_template_classes', create_function('$cols', '$cols = "col-sm-' . $main_width_3cols . ' col-sm-push-' . ( $sidebar_width_3cols * 2 ) . ' tpl-3ll"; return $cols;'));
				add_filter('kleo_sidebar_classes', create_function('$cols', '$cols = "col-sm-' . $sidebar_width_3cols . ' col-sm-pull-' . $main_width_3cols . ' sidebar-3ll"; return $cols;'));
				add_filter('kleo_extra_sidebar_classes', create_function('$cols', '$cols = "col-sm-' . $sidebar_width_3cols . ' col-sm-pull-' . $main_width_3cols . ' sidebar-3ll"; return $cols;'));
				break;

			case '3lr':
				add_action('kleo_after_content', 'kleo_sidebar');
				add_action('kleo_after_content', 'kleo_extra_sidebar');
				add_filter('kleo_main_template_classes', create_function('$cols', '$cols = "col-sm-' . $main_width_3cols . ' col-sm-push-' . $sidebar_width_3cols . ' tpl-3lr"; return $cols;'));
				add_filter('kleo_sidebar_classes', create_function('$cols', '$cols = "col-sm-' . $sidebar_width_3cols . ' col-sm-pull-' . $main_width_3cols . ' sidebar-3lr"; return $cols;'));
				add_filter('kleo_extra_sidebar_classes', create_function('$cols', '$cols = "col-sm-' . $sidebar_width_3cols .  ' sidebar-3lr"; return $cols;'));
				break;

			case '3rr':
				add_action('kleo_after_content', 'kleo_sidebar');
				add_action('kleo_after_content', 'kleo_extra_sidebar');
				add_filter('kleo_main_template_classes', create_function('$cols', '$cols = "col-sm-' . $main_width_3cols . ' tpl-3rr"; return $cols;'));
				add_filter('kleo_sidebar_classes', create_function('$cols', '$cols = "col-sm-' . $sidebar_width_3cols . ' sidebar-3rr"; return $cols;'));
				add_filter('kleo_extra_sidebar_classes', create_function('$cols', '$cols = "col-sm-' . $sidebar_width_3cols . ' sidebar-3rr"; return $cols;'));
				break;

			case 'right':
			default:
				add_action('kleo_after_content', 'kleo_sidebar');
				remove_action('kleo_after_content', 'kleo_extra_sidebar');
				add_filter('kleo_main_template_classes', create_function('$cols', '$cols = "col-sm-' . $main_width_2cols . ' tpl-right"; return $cols;'));
				add_filter('kleo_sidebar_classes', create_function('$cols', '$cols = "col-sm-' . $sidebar_width_2cols . ' sidebar-right"; return $cols;'));
				break;
		}
	}
}

if ( !function_exists( 'kleo_prepare_layout' ) ) {
	/**
	 * Prepare site layout with different customizations
	 * @global string $kleo_custom_logo
	 */
	function kleo_prepare_layout() {

		//Change the template
		$layout = sq_option('global_sidebar', 'right');

		if (is_home()) {
			$layout = sq_option('blog_layout', 'right');
		}	
		elseif (is_archive()) {
			$layout = sq_option('cat_layout', 'right');
		}
		elseif( is_singular( 'post' ) 
						&& get_cfield('post_layout') && get_cfield('post_layout') != 'default' ) {
			$layout = get_cfield('post_layout');
		}

		$layout = apply_filters('kleo_page_layout', $layout);
		kleo_switch_layout($layout);

		/* Single post of any post type */
		if( is_singular() )
		{
			$topbar_status = get_cfield('topbar_status');
			//Top bar
			if ( isset($topbar_status) ) {
				if ( $topbar_status === '1' ) {
					add_filter('kleo_show_top_bar', create_function('', 'return 1;'));
				} elseif ( $topbar_status === '0' ) {
					add_filter('kleo_show_top_bar', create_function('', 'return 0;'));
				}
			}

			//Header and Footer settings
			if (get_cfield('hide_header') && get_cfield('hide_header') == 1 ) {
				remove_action('kleo_header', 'kleo_show_header');
			}
			if (get_cfield('hide_footer') && get_cfield('hide_footer') == 1 ) {
				add_filter('kleo_footer_hidden', create_function('$status','return true;'));
			}
			if (get_cfield('hide_socket') && get_cfield('hide_socket') == 1 ) {
				remove_action('kleo_after_footer', 'kleo_show_socket');
			}

			//Custom logo
			if( get_cfield('logo') ) {
				global $kleo_custom_logo;
				$kleo_custom_logo = get_cfield('logo');
				add_filter('kleo_logo', create_function("",'global $kleo_custom_logo; return $kleo_custom_logo;'));
			}
		}
		
		//Show title in main content - if set from Theme options
		add_action('kleo_before_main_content', 'kleo_title_main_content');
	}
}

add_action('wp_head','kleo_prepare_layout');


//get the global sidebar
if (!function_exists('kleo_sidebar')):
	function kleo_sidebar()
	{
		get_sidebar();
	}
endif;

//get the extra sidebar
if (!function_exists('kleo_extra_sidebar')):
	function kleo_extra_sidebar()
	{
		$classes = apply_filters('kleo_extra_sidebar_classes', '');
		
		echo '<div class="sidebar sidebar-extra '.$classes.'">'
			. '<div class="inner-content">';
		
		generated_dynamic_sidebar('extra');
		
		echo '</div>'
		.'</div> <!--end sidebar columns-->';
	}
endif;

function kleo_ret_full_container(){
	return 'container-full';
}

if ( ! function_exists( 'kleo_title_main_content' ) ) {
	/**
	 * Echo the title if it was set to show in main content area
	 */
	function kleo_title_main_content() {
		if (sq_option('title_location', 'breadcrumb') == 'main') {
			
			$title_status = true;
			if( is_singular() && get_cfield( 'title_checkbox' ) == 1 ) {
				$title_status = false;
			}

			if ( $title_status ) {
				echo '<div class="container">';
				echo '<h1 class="page-title">' . kleo_title() . '</h1>';
				echo '</div>';
			}
			
		}
	}
}


/***************************************************
:: Render the header section with the menus
***************************************************/

function kleo_show_header() 
{
	get_template_part('page-parts/general-header-section');
}

add_action('kleo_header', 'kleo_show_header');



/***************************************************
:: Extra body classes
***************************************************/

add_filter('body_class','kleo_body_classes');

/**
 * Adds specific classes to body element
 * @param array $classes
 * @return array
 * @since 1.0
 */
function kleo_body_classes($classes = '') {

	if(is_admin_bar_showing() && sq_option('admin_bar',1 ) == 1) {
		$classes[] = 'adminbar-enable';
	}
	
	if (sq_option('responsive_design',1) == 0) {
		$classes[] = 'not-responsive';
	}
	
	if (sq_option('sticky_menu',1) == 1) {
		$classes[] = 'kleo-navbar-fixed';

		if (sq_option('resize_logo',1) == 1) {
			$classes[] = 'navbar-resize';
		}		
	}
	
	if (sq_option('transparent_logo',1) == 1
					|| ((is_single() || is_page()) && get_cfield('transparent_menu'))
					) {
		$classes[] = 'navbar-transparent';
	}

	return $classes;
}

// -----------------------------------------------------------------------------



/***************************************************
:: Theme options link in Admin bar
***************************************************/

add_action('admin_bar_menu', 'kleo_add_adminbar_options', 100);

function kleo_add_adminbar_options($admin_bar){
	if ( is_super_admin() && ! is_admin() ) {
		$admin_bar->add_menu( array(
				'id'    => 'theme-options',
				'title' => __('Theme options','kleo_framework'),
				'href'  => get_admin_url().'admin.php?page=kleo_options',
				'meta'  => array(
					'title' => __('Theme options','kleo_framework'),
					'target' => '_blank'
				),
		));
	}
	
}

/***************************************************
:: Add mp4, webm and ogv mimes for uploads
***************************************************/

add_filter('upload_mimes','kleo_add_upload_mimes');
if(!function_exists('kleo_add_upload_mimes'))
{
	function kleo_add_upload_mimes($mimes){ return array_merge($mimes, array ('mp4' => 'video/mp4', 'ogv' => 'video/ogg', 'webm' => 'video/webm')); }
}



/***************************************************
:: Scripts/Styles load
***************************************************/

add_action( 'wp_enqueue_scripts', 'kleo_frontend_files' );
if (!function_exists('kleo_frontend_files')):
	// Register some javascript files
	function kleo_frontend_files() 
	{
		//head scripts
		wp_register_script( 'kleo-init', get_template_directory_uri() . '/assets/js/init.js', array(),KLEO_THEME_VERSION, false );
		wp_register_script( 'modernizr', get_template_directory_uri() . '/assets/js/modernizr.custom.46504.js', array(),KLEO_THEME_VERSION, false );

		/* Footer scripts */
		wp_register_script( 'bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'),KLEO_THEME_VERSION, true );
		wp_register_script( 'waypoints', get_template_directory_uri() . '/assets/js/plugins/waypoints.min.js', array('jquery'),KLEO_THEME_VERSION, true );
		wp_register_script( 'magnific-popup', get_template_directory_uri() . '/assets/js/plugins/magnific-popup/magnific.min.js', array('jquery'),KLEO_THEME_VERSION, true );
		wp_register_script( 'caroufredsel', get_template_directory_uri() . '/assets/js/plugins/carouFredSel/jquery.carouFredSel-6.2.0-packed.js', array('jquery'),KLEO_THEME_VERSION, true );
		wp_register_script( 'jquery-mousewheel', get_template_directory_uri() . '/assets/js/plugins/carouFredSel/helper-plugins/jquery.mousewheel.min.js', array('jquery', 'caroufredsel'),KLEO_THEME_VERSION, true );
		wp_register_script( 'jquery-touchswipe', get_template_directory_uri() . '/assets/js/plugins/carouFredSel/helper-plugins/jquery.touchSwipe.min.js', array('jquery', 'caroufredsel'),KLEO_THEME_VERSION, true );
		//wp_register_script( 'jquery-transit', get_template_directory_uri() . '/assets/js/plugins/carouFredSel/helper-plugins/jquery.transit.min.js', array('jquery', 'caroufredsel'),KLEO_THEME_VERSION, true );
		//wp_register_script( 'jquery-ba-throttle-debounce', get_template_directory_uri() . '/assets/js/plugins/carouFredSel/helper-plugins/jquery.ba-throttle-debounce.min.js', array('jquery', 'caroufredsel'),KLEO_THEME_VERSION, true );
		wp_register_script( 'isotope', get_template_directory_uri() . '/assets/js/plugins/jquery.isotope.min.js', array('jquery'),KLEO_THEME_VERSION, true );
		wp_register_script( 'kleo-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery'),KLEO_THEME_VERSION, true );
		wp_register_script( 'kleo-shortcodes', get_template_directory_uri() . '/assets/js/shortcodes.js', array('jquery'),KLEO_THEME_VERSION, true );
		wp_register_script( 'app', get_template_directory_uri() . '/assets/js/app.js', array('jquery'),KLEO_THEME_VERSION, true );

		//enque them
		wp_enqueue_script('kleo-init');
		wp_enqueue_script('modernizr');
		wp_enqueue_script('bootstrap');
		wp_enqueue_script('waypoints');
		wp_enqueue_script('magnific-popup');
		wp_enqueue_script('caroufredsel');
		wp_enqueue_script('jquery-touchswipe');
		//wp_enqueue_script('jquery-transit');
		//wp_enqueue_script('jquery-ba-throttle-debounce');
		wp_enqueue_script('mediaelement');
		wp_enqueue_script('isotope');	
		wp_enqueue_script('kleo-scripts');
		wp_enqueue_script('kleo-shortcodes');
		wp_enqueue_script('app');

		$retina_logo = sq_option_url('logo_retina') != '' ? sq_option_url('logo_retina') : "";
		if (is_singular() && get_cfield('logo_retina') ) {
			$retina_logo = get_cfield('logo_retina');
		}
		$obj_array = array(
				'ajaxurl' =>  home_url().'/wp-admin/admin-ajax.php',
				'goTop' => sq_option('go_top', 1),
				'ajaxSearch' => sq_option('ajax_search', 1),
				'alreadyLiked' => sq_option('likes_already', 'You already like this'),
				'retinaLogo' => $retina_logo,
        'loadingmessage' => '<i class="icon icon-spin5 animate-spin"></i> '.__('Sending info, please wait...', 'kleo_framework')
		);
    $obj_array = apply_filters( 'kleo_localize_app', $obj_array );
    
		wp_localize_script( 'app', 'kleoFramework', $obj_array );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
		
		
		// Register the styles
		wp_register_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), KLEO_THEME_VERSION, 'all' );  
		wp_register_style( 'kleo-app', get_template_directory_uri() . '/assets/css/app.css', array(), KLEO_THEME_VERSION, 'all' ); 
		wp_register_style( 'kleo-shortcodes', get_template_directory_uri() . '/assets/css/shortcodes.css', array(), KLEO_THEME_VERSION, 'all' );  
		//wp_register_style( 'pretty-photo', get_template_directory_uri() . '/assets/js/plugins/prettyPhoto/prettyPhoto.css', array(), KLEO_THEME_VERSION, 'all' );
		wp_register_style( 'magnific-popup', get_template_directory_uri() . '/assets/js/plugins/magnific-popup/magnific.css', array(), KLEO_THEME_VERSION, 'all' ); 
		wp_register_style( 'mediaelement-skin', get_template_directory_uri() . '/assets/js/plugins/mediaelement/mejs-kleo-skin.css', array(), KLEO_THEME_VERSION, 'all' );  
		wp_register_style( 'kleo-fonts', get_template_directory_uri() . '/assets/css/embed-fonts.css', array(), KLEO_THEME_VERSION, 'all' );
		wp_register_style( 'kleo-style', CHILD_THEME_URI . '/style.css', array(), KLEO_THEME_VERSION, 'all' );

		//enque required styles
		wp_enqueue_style( 'bootstrap' );
		wp_enqueue_style( 'kleo-app' );
		wp_enqueue_style( 'kleo-shortcodes' );   
		//wp_enqueue_style( 'pretty-photo' );
		wp_enqueue_style( 'magnific-popup' );
		wp_enqueue_style( 'kleo-fonts' );
		wp_enqueue_style( 'mediaelement' );

	} // end kleo_frontend_files()
endif;



add_action( 'wp_enqueue_scripts', 'kleo_load_files_plugin_compat', 1000 );  

function kleo_load_files_plugin_compat()
{
	wp_register_style( 'kleo-plugins', get_template_directory_uri() . '/assets/css/plugins.css', array(), KLEO_THEME_VERSION, 'all' ); 
	wp_enqueue_style( 'kleo-plugins' );
	wp_enqueue_style( 'mediaelement-skin' );
	
	//enque child theme style only if activated
	if (is_child_theme()) {
		wp_enqueue_style( 'kleo-style' );
	}

    //Visual composer file
    wp_dequeue_style( 'js_composer_front' );
	
	
} // kleo_load_css_files_plugin_compat()



if ( !function_exists( 'remove_wp_open_sans' ) ) {
	/**
	 * Remove duplicate Open Sans from Wordpress
	 */
	function kleo_remove_wp_open_sans() {
		$font_link = get_transient(KLEO_DOMAIN.'_google_link');
		if ( strpos( $font_link, 'Open+Sans' ) !== false ) {
			wp_deregister_style( 'open-sans' );
			wp_register_style( 'open-sans', false );
		}
	}
	add_action('wp_enqueue_scripts', 'kleo_remove_wp_open_sans');
}


/***************************************************
:: ADMIN CSS
***************************************************/
function kleo_admin_styles() {
		wp_register_style("kleo-admin", KLEO_LIB_URI . "/assets/admin-custom.css", false, "1.0", "all");
		wp_enqueue_style( 'kleo-admin' );
}
add_action( 'admin_enqueue_scripts', 'kleo_admin_styles' );



/***************************************************
:: Customize wp-login.php
***************************************************/
function custom_login_css() {
	global $kleo_theme;
	echo "\n<style>";

	echo $kleo_theme->get_bg_css('header_background', 'body.login');

	echo '.login h1 a { background-image: url("'.sq_option_url('logo','none').'");background-size: contain;min-height: 88px;width:auto;}';
	echo '#login {padding: 20px 0 0;}';
	echo '.login #nav a, .login #backtoblog a {color:'.sq_option('header_primary_color').'!important;text-shadow:none;}';

	echo "</style>\n";
}
add_action('login_enqueue_scripts', 'custom_login_css');

function kleo_new_wp_login_url() { return home_url(); }
add_filter('login_headerurl', 'kleo_new_wp_login_url');

function kleo_new_wp_login_title() { return get_option('blogname'); }
add_filter('login_headertitle', 'kleo_new_wp_login_title');


/***************************************************
:: Load Fonts and Quick CSS
***************************************************/
$kleo_theme->add_google_fonts_link();
add_action('wp_head',array($kleo_theme, 'render_css'));



/***************************************************
:: Render custom css resulted from theme options
***************************************************/
if (!is_admin())
{
	global $kleo_config;

	if (is_writable(trailingslashit($kleo_config['custom_style_path'])))
	{
		//write the file if isn't there
		if (!file_exists(trailingslashit($kleo_config['custom_style_path']) . 'dynamic.css'))
		{
			add_filter('kleo_add_dynamic_style', array($kleo_theme,'add_font_css'));
			kleo_generate_dynamic_css();
		}

		add_action( 'wp_enqueue_scripts', 'kleo_load_dynamic_css' );  
	}
	else 
	{
		add_action('wp_head', 'kleo_custom_head_css');
	}
}



/**
 * Load generated CSS file containing theme customizations
 * @global array $kleo_config
 */
function kleo_load_dynamic_css() 
{
	global $kleo_config;
	wp_register_style( 'kleo-colors', trailingslashit($kleo_config['custom_style_url']) . 'dynamic.css', array(), KLEO_THEME_VERSION, 'all' );
	wp_enqueue_style( 'kleo-colors' );
}



/**
 * Generate CSS styles in head section
 * @global Kleo $kleo_theme
 */
function kleo_custom_head_css()
{
	global $kleo_theme;
	$dynamic_css = get_template_directory() . '/assets/css/dynamic.php';
	
	echo "\n<style>";
	ob_start(); // Capture all output (output buffering)
	//add fonts styles
	add_filter('kleo_add_dynamic_style', array($kleo_theme,'add_font_css'));
	
	require($dynamic_css); // Generate CSS
	$css = ob_get_clean(); // Get generated CSS
	echo kleo_compress($css);
	echo '</style>';
}



/***************************************************
:: Modal Ajax login && Modal Lost Password
***************************************************/

add_action( 'wp_footer', 'kleo_load_popups', 12 );

function kleo_load_popups() {
  get_template_part( 'page-parts/general-popups' );
}

add_action( 'wp_ajax_nopriv_kleoajaxlogin', 'kleo_ajax_login' );

if (!function_exists('kleo_ajax_login')){
	function kleo_ajax_login()
	{
		// Check the nonce, if it fails the function will break
		check_ajax_referer( 'kleo-ajax-login-nonce', 'security' );

		// Nonce is checked, get the POST data and sign in user
		$info = array();
		$info['user_login'] = $_POST['log'];
		$info['user_password'] = $_POST['pwd'];
		$info['remember'] = (isset( $_POST['remember'] ) && $_POST['remember'] === true) ? true : false ;

		$info = apply_filters('kleo_ajaxlogin_atts', $info);
		
		$user_signon = wp_signon( $info, false );
		if ( is_wp_error($user_signon) ){
			echo json_encode(array( 'loggedin' => false, 'message' => '<span class="wrong-response"><i class="icon icon-attention"></i> ' . __( 'Wrong username or password. Please try again.', 'kleo_framework' ) . '</span>' ));
		} else {
            if ( sq_option( 'login_redirect' , 'default' ) == 'reload' ) {
                $redirecturl = NULL;
            }
            else {
                $redirecturl = apply_filters( 'login_redirect', '', '', $user_signon );
            }

			echo json_encode(array('loggedin'=>true, 'redirecturl' => $redirecturl, 'message'=> '<span class="good-response"><i class="icon icon-ok-circled"></i> ' . __( 'Login successful, redirecting...','kleo_framework' ) . '</span>' ));
		}

		die();
	}
}

add_action( 'wp_ajax_kleoajaxlogin', 'kleo_ajax_login_priv' );

if (!function_exists('kleo_ajax_login_priv')) {
	function kleo_ajax_login_priv() {
	$link = "javascript:window.location.reload();return false;";
		echo json_encode(array('loggedin'=>false, 'message'=> '<i class="icon icon-info-circled"></i> ' . sprintf(__('You are already logged in. Please <a href="#" onclick="%s">refresh</a> page','kleo_framework'),$link)));
		die();
	}
}


if (!function_exists('kleo_lost_password_ajax')) {
function kleo_lost_password_ajax()
{
    global $wpdb;
    $errors = array();
    if ( isset($_POST) ) {

      if ( empty( $_POST['email'] ) )
      {
         _e( '<strong>ERROR</strong>: The e-mail field is empty.', 'kleo_framework' );
         die();
      }
      else {
          do_action('lostpassword_post');
          // redefining user_login ensures we return the right case in the email
          $user_data = get_user_by( 'email', trim( $_POST['email'] ) );

          if ( ! isset( $user_data->user_email ) || strtolower( $user_data->user_email ) != strtolower( $_POST['email'] ) ) {
            echo '<span class="wrong-response">' . __('<strong>ERROR</strong>: Invalid  e-mail.', 'kleo_framework') . '</span>';
            die();
          } else {
              $user_login = $user_data->user_login;
              $user_email = $user_data->user_email;

              do_action('retrieve_password', $user_login);

              $allow = apply_filters( 'allow_password_reset', true, $user_data->ID );

              if ( ! $allow )
                echo new WP_Error('no_password_reset', __('Password reset is not allowed for this user'));
              else if ( is_wp_error($allow) )
                echo $allow;

              // Generate something random for a password reset key.
              $key = wp_generate_password( 20, false );

              do_action( 'retrieve_password_key', $user_login, $key );

              // Now insert the key, hashed, into the DB.
              if ( empty( $wp_hasher ) ) {
                require_once ABSPATH . 'wp-includes/class-phpass.php';
                $wp_hasher = new PasswordHash( 8, true );
              }
              $hashed = $wp_hasher->HashPassword( $key );
              $wpdb->update( $wpdb->users, array( 'user_activation_key' => $hashed ), array( 'user_login' => $user_login ) );

              $message = __('Someone requested that the password be reset for the following account:') . "\r\n\r\n";
              $message .= network_home_url( '/' ) . "\r\n\r\n";
              $message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
              $message .= __('If this was a mistake, just ignore this email and nothing will happen.') . "\r\n\r\n";
              $message .= __('To reset your password, visit the following address:') . "\r\n\r\n";
              $message .= '<' . network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . ">\r\n";

              if ( is_multisite() )
                $blogname = $GLOBALS['current_site']->site_name;
              else
                // The blogname option is escaped with esc_html on the way into the database in sanitize_option
                // we want to reverse this for the plain text arena of emails.
                $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

              $title = sprintf( __('[%s] Password Reset'), $blogname );

              /**
               * Filter the subject of the password reset email.
               *
               * @since 2.8.0
               *
               * @param string $title Default email title.
               */
              $title = apply_filters( 'retrieve_password_title', $title );
              /**
               * Filter the message body of the password reset mail.
               *
               * @since 2.8.0
               *
               * @param string $message Default mail message.
               * @param string $key     The activation key.
               */
              $message = apply_filters( 'retrieve_password_message', $message, $key, $user_login );

              if ( $message && !wp_mail($user_email, $title, $message) ) {
                echo '<span class="wrong-response">' . __("Failure!", 'kleo_framework');
                echo __("The e-mail could not be sent.", 'kleo_framework');
                echo "</span>";
                die();
              } else {
                echo '<span class="good-response">' . __("Email successfully sent!", 'kleo_framework')."</span>";
                die();
              }
          }
      }
    }
    die();
}
}
add_action("wp_ajax_kleo_lost_password","kleo_lost_password_ajax");
add_action('wp_ajax_nopriv_kleo_lost_password', 'kleo_lost_password_ajax');
// -----------------------------------------------------------------------------
