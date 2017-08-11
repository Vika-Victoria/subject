<?php
require get_template_directory() . '/inc/class-wptoots-recent-post-widget.php';
require get_template_directory() . '/inc/class-wptoots-subscribe-form-widget.php';

// регистрация wptoots_Widget в WordPress
function wptoots_register_widget() {
    register_widget( 'Wptoots_Widget_Recent_Posts' );//register my class
    register_widget( 'Wptoots_Widget_Subscribe' );
}
add_action( 'widgets_init', 'wptoots_register_widget' );

//регистрируем картинку для виджета
add_image_size('wptoots-recent-post', 80,80, true );



function wptoots_setup() {
    //для превода темы
    load_theme_textdomain('wptoots');
//дает возможность плагинам изменять метатег title
    add_theme_support('title-tag');
    //поддержка загрузки кастомного лога через customiser wordpress(logo в настройках для загрузкии картинок)
    add_theme_support('custom-logo', array('height' => 31 , 'widht' => 134, 'flex-height' => true));
//поддержка для всех страниц. второй параметр - для каких страниц
//для добавления метабокса справа в админ на странице
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(730, 446);

    //поддержка html-5 разметки для форм и т.д.
    add_theme_support('html50', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption'
    ));

    //поддержка разных форматов постов
    add_theme_support('post-formats', array(
       'aside',
        'image',
        'video',
        'gallery'
    ));

    //регистрация меню темы
    //add_theme_support('menus');

    //ф-я для регистрации локации меню в теме(регистрирует место)
    //превый параметр - это айди, название; второй - текст в админке
    //ф-я навязыввается на событие 'after_setup_theme'
    register_nav_menu('primary', 'Primary menu');

}
add_action('after_setup_theme', 'wptoots_setup');

function wptoots_scripts() {
    wp_enqueue_style('style-css', get_stylesheet_uri());//ф-я для подключения стилей
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css');//возвращает url к текущей теме
    wp_enqueue_style('animate', get_template_directory_uri() . '/css/animate.min.css');
    wp_enqueue_style('font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css');
    wp_enqueue_script('bootstrap', get_template_directory() . '/js/bootstrap.min.js');
    wp_enqueue_script('css3-animate-it', get_template_directory() . '/js/css3-animate-it.js');
    wp_enqueue_script('agency', get_template_directory() . '/js/agency.js');
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-easing', get_template_directory() . '/js/jquery.easing.min.js');
}
add_action('wp_enqueue_scripts', 'wptoots_scripts');

add_filter('excerpt_more', function ($more){
  return '';
});
/**
 * хлебные крошки
 */
function wptuts_the_breadcrumb(){
    global $post;
    if(!is_home()){
        echo '<li><a href="'.site_url().'"><i class="fa fa-home" aria-hidden="true"></i>Home</a></li> <li> / </li> ';
        if(is_single()){ // posts
            the_category(', ');
            echo " <li> / </li> ";
            echo '<li>';
            the_title();
            echo '</li>';
        }
        elseif (is_page()) { // pages
            if ($post->post_parent ) {
                $parent_id  = $post->post_parent;
                $breadcrumbs = array();
                while ($parent_id) {
                    $page = get_post($parent_id);
                    $breadcrumbs[] = '<li><a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a></li>';
                    $parent_id  = $page->post_parent;
                }
                $breadcrumbs = array_reverse($breadcrumbs);
                foreach ($breadcrumbs as $crumb) echo $crumb . '<li> / </li> ';
            }
            echo the_title();
        }
        elseif (is_category()) { // category
            global $wp_query;
            $obj_cat = $wp_query->get_queried_object();
            $current_cat = $obj_cat->term_id;
            $current_cat = get_category($current_cat);
            $parent_cat = get_category($current_cat->parent);
            if ($current_cat->parent != 0)
                echo(get_category_parents($parent_cat, TRUE, ' <li> / </li> '));
            single_cat_title();
        }
        elseif (is_search()) { // search pages
            echo 'Search results "' . get_search_query() . '"';
        }
        elseif (is_tag()) { // tags
            echo single_tag_title('', false);
        }
        elseif (is_day()) { // archive (days)
            echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li> <li> / </li> ';
            echo '<li><a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a></li> <li> / </li> ';
            echo get_the_time('d');
        }
        elseif (is_month()) { // archive (months)
            echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li> <li> / </li>';
            echo get_the_time('F');
        }
        elseif (is_year()) { // archive (years)
            echo get_the_time('Y');
        }
        elseif (is_author()) { // authors
            global $author;
            $userdata = get_userdata($author);
            echo '<li>Posted ' . $userdata->display_name . '</li>';
        } elseif (is_404()) { // if page not found
            echo '<li>Error 404</li>';
        }

        if (get_query_var('paged')) // number of page
            echo ' (' . get_query_var('paged').'- page)';

    } else { // home
        $pageNum=(get_query_var('paged')) ? get_query_var('paged') : 1;
        if($pageNum>1)
            echo '<li><a href="'.site_url().'"><i class="fa fa-home" aria-hidden="true"></i>Home</a></li> <li> / </li><li> '.$pageNum.'- page</li>';
        else
            echo '<li><i class="fa fa-home" aria-hidden="true"></i>Home</li>';
    }
}

/**
 * Pagination
 */
function wptoots_pagination( $args = array() ) {

    $defaults = array(
        'range'           => 4,
        'custom_query'    => FALSE,
        'previous_string' => esc_html__( 'Previous', 'wptuts' ),
        'next_string'     => esc_html__( 'Next', 'wptuts' ),
        'before_output'   => '<div class="next_page"><ul class="page-numbers">',
        'after_output'    => '</ul></div>'
    );

    $args = wp_parse_args(
        $args,
        apply_filters( 'wp_bootstrap_pagination_defaults', $defaults )
    );

    $args['range'] = (int) $args['range'] - 1;
    if ( !$args['custom_query'] )
        $args['custom_query'] = @$GLOBALS['wp_query'];
    $count = (int) $args['custom_query']->max_num_pages;
    $page  = intval( get_query_var( 'paged' ) );
    $ceil  = ceil( $args['range'] / 2 );

    if ( $count <= 1 )
        return FALSE;

    if ( !$page )
        $page = 1;

    if ( $count > $args['range'] ) {
        if ( $page <= $args['range'] ) {
            $min = 1;
            $max = $args['range'] + 1;
        } elseif ( $page >= ($count - $ceil) ) {
            $min = $count - $args['range'];
            $max = $count;
        } elseif ( $page >= $args['range'] && $page < ($count - $ceil) ) {
            $min = $page - $ceil;
            $max = $page + $ceil;
        }
    } else {
        $min = 1;
        $max = $count;
    }

    $echo = '';
    $previous = intval($page) - 1;
    $previous = esc_attr( get_pagenum_link($previous) );

    if ( $previous && (1 != $page) )
        $echo .= '<li><a href="' . $previous . '" class="page-numbers" title="' . esc_html__( 'previous', 'wptuts') . '">' . $args['previous_string'] . '</a></li>';

    if ( !empty($min) && !empty($max) ) {
        for( $i = $min; $i <= $max; $i++ ) {
            if ($page == $i) {
                $echo .= '<li class="active"><span class="page-numbers current">' . str_pad( (int)$i, 1, '0', STR_PAD_LEFT ) . '</span></li>';
            } else {
                $echo .= sprintf( '<li><a href="%s" class="page-numbers">%2d</a></li>', esc_attr( get_pagenum_link($i) ), $i );
            }
        }
    }

    $next = intval($page) + 1;
    $next = esc_attr( get_pagenum_link($next) );
    if ($next && ($count != $page) )
        $echo .= '<li><a href="' . $next . '" class="page-numbers" title="' . esc_html__( 'next', 'wptuts') . '">' . $args['next_string'] . '</a></li>';
    if ( isset($echo) )
        echo $args['before_output'] . $echo . $args['after_output'];
}

/**
 *  кастомайзер
 */
function wptoots_customize_register($wp_customize) {
    $wp_customize->add_setting('header_social', array(
        'default' => __('Share Your Favorite Mobile Apps With Your Friends', 'wptoots'),
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('facebook_social', array(
        'default' => __('Url facebook', 'wptoots'),
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('twitter_social', array(
        'default' => __('Url twitter', 'wptoots'),
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('linkedin_social', array(
        'default' => __('Url linkedin', 'wptoots'),
        'transport' => 'refresh'
    ));

    $wp_customize->add_setting('footer_copy', array(
        'default' => __('Copyright text', 'wptoots'),
        'transport' => 'refresh'
    ));

    $wp_customize->add_section('social_section', array(
        'title' => __('Social settings', 'wptoots'),
        'priority' => 30
    ));

    $wp_customize->add_section('footer_setting', array(
        'title' => __('Footer settings', 'wptoots'),
        'priority' => 31
    ));

    $wp_customize->add_control(
      'header_social',
        array(
            'label' => __('Social header in footer', 'wptoots'),
            'section' => 'social_section',
            'settings' => 'header_social',
            'type' => 'text'
        )
    );

    $wp_customize->add_control(
        'facebook_social',
        array(
            'label' => __('Facebook profile url', 'wptoots'),
            'section' => 'social_section',
            'settings' => 'facebook_social',
            'type' => 'text'
        )
    );

    $wp_customize->add_control(
        'twitter_social',
        array(
            'label' => __('Twitter profile url', 'wptoots'),
            'section' => 'social_section',
            'settings' => 'twitter_social',
            'type' => 'text'
        )
    );

    $wp_customize->add_control(
        'linkedin_social',
        array(
            'label' => __('Linkedin profile url', 'wptoots'),
            'section' => 'social_section',
            'settings' => 'linkedin_social',
            'type' => 'text'
        )
    );

    $wp_customize->add_control(
        'footer_copy',
        array(
            'label' => __('Footer settings', 'wptoots'),
            'section' => 'footer_setting',
            'settings' => 'footer_copy',
            'type' => 'textarea'
        )
    );
}
add_action('customize_register', 'wptoots_customize_register');

/**
 * Add a sidebar.
 */
function wptoots_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Main Sidebar', ' wptoots' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Widgets in this area will be shown on all posts and pages.', ' wptoots' ),
        'before_widget' => '<div id="%1$s" class="sidebar_wrap %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<div class="side_bar_heading"><h6>',
        'after_title'   => '</h6></div>',
    ) );
}
add_action( 'widgets_init', 'wptoots_widgets_init' );


//add vidget
function wptoots_widget_categories($args) {
    $walker = new Walker_Categories_Wptoots();
    $args = array_merge($args, array('walker' => $walker));
    return $args;
}
add_filter('widget_categories_args', 'wptoots_widget_categories');

//create class
class Walker_Categories_Wptoots extends Walker_Category {
    /**
     * What the class handles.
     *
     * @since 2.1.0
     * @access public
     * @var string
     *
     * @see Walker::$tree_type
     */
    public $tree_type = 'category';

    /**
     * Database fields to use.
     *
     * @since 2.1.0
     * @access public
     * @var array
     *
     * @see Walker::$db_fields
     * @todo Decouple this
     */
    public $db_fields = array ('parent' => 'parent', 'id' => 'term_id');

    /**
     * Starts the list before the elements are added.
     *
     * @since 2.1.0
     * @access public
     *
     * @see Walker::start_lvl()
     *
     * @param string $output Used to append additional content. Passed by reference.
     * @param int    $depth  Optional. Depth of category. Used for tab indentation. Default 0.
     * @param array  $args   Optional. An array of arguments. Will only append content if style argument
     *                       value is 'list'. See wp_list_categories(). Default empty array.
     */
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        parent::start_lvl( $output, $depth, $args );
    }

    /**
     * Ends the list of after the elements are added.
     *
     * @since 2.1.0
     * @access public
     *
     * @see Walker::end_lvl()
     *
     * @param string $output Used to append additional content. Passed by reference.
     * @param int    $depth  Optional. Depth of category. Used for tab indentation. Default 0.
     * @param array  $args   Optional. An array of arguments. Will only append content if style argument
     *                       value is 'list'. See wp_list_categories(). Default empty array.
     */
    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        parent::end_lvl( $output, $depth = 0, $args = array());
    }

    /**
     * Starts the element output.
     *
     * @since 2.1.0
     * @access public
     *
     * @see Walker::start_el()
     *
     * @param string $output   Passed by reference. Used to append additional content.
     * @param object $category Category data object.
     * @param int    $depth    Optional. Depth of category in reference to parents. Default 0.
     * @param array  $args     Optional. An array of arguments. See wp_list_categories(). Default empty array.
     * @param int    $id       Optional. ID of the current category. Default 0.
     */
    public function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
        /** This filter is documented in wp-includes/category-template.php */
        $cat_name = apply_filters(
            'list_cats',
            esc_attr( $category->name ),
            $category
        );

        // Don't generate an element if the category name is empty.
        if ( ! $cat_name ) {
            return;
        }

        $link = '<a href="' . esc_url( get_term_link( $category ) ) . '" ';
        if ( $args['use_desc_for_title'] && ! empty( $category->description ) ) {
            /**
             * Filters the category description for display.
             *
             * @since 1.2.0
             *
             * @param string $description Category description.
             * @param object $category    Category object.
             */
            $link .= 'title="' . esc_attr( strip_tags( apply_filters( 'category_description', $category->description, $category ) ) ) . '"';
        }

        $link .= '><i class="fa fa-folder-open-o" aria-hidden="true"></i>';
        $link .= $cat_name;

        if ( ! empty( $args['show_count'] ) ) {
            $link .= '<span>' . number_format_i18n( $category->count ) . '</span>';
        }
        $link .=  '</a>';

        if ( ! empty( $args['feed_image'] ) || ! empty( $args['feed'] ) ) {
            $link .= ' ';

            if ( empty( $args['feed_image'] ) ) {
                $link .= '(';
            }

            $link .= '<a href="' . esc_url( get_term_feed_link( $category->term_id, $category->taxonomy, $args['feed_type'] ) ) . '"';

            if ( empty( $args['feed'] ) ) {
                $alt = ' alt="' . sprintf(__( 'Feed for all posts filed under %s' ), $cat_name ) . '"';
            } else {
                $alt = ' alt="' . $args['feed'] . '"';
                $name = $args['feed'];
                $link .= empty( $args['title'] ) ? '' : $args['title'];
            }

            $link .= '>';

            if ( empty( $args['feed_image'] ) ) {
                $link .= $name;
            } else {
                $link .= "<img src='" . $args['feed_image'] . "'$alt" . ' />';
            }
            $link .= '</a>';

            if ( empty( $args['feed_image'] ) ) {
                $link .= ')';
            }
        }


        if ( 'list' == $args['style'] ) {
            $output .= "\t<li";
            $css_classes = array(
                'cat-item',
                'cat-item-' . $category->term_id,
            );

            if ( ! empty( $args['current_category'] ) ) {
                // 'current_category' can be an array, so we use `get_terms()`.
                $_current_terms = get_terms( $category->taxonomy, array(
                    'include' => $args['current_category'],
                    'hide_empty' => false,
                ) );

                foreach ( $_current_terms as $_current_term ) {
                    if ( $category->term_id == $_current_term->term_id ) {
                        $css_classes[] = 'current-cat';
                    } elseif ( $category->term_id == $_current_term->parent ) {
                        $css_classes[] = 'current-cat-parent';
                    }
                    while ( $_current_term->parent ) {
                        if ( $category->term_id == $_current_term->parent ) {
                            $css_classes[] =  'current-cat-ancestor';
                            break;
                        }
                        $_current_term = get_term( $_current_term->parent, $category->taxonomy );
                    }
                }
            }

            /**
             * Filters the list of CSS classes to include with each category in the list.
             *
             * @since 4.2.0
             *
             * @see wp_list_categories()
             *
             * @param array  $css_classes An array of CSS classes to be applied to each list item.
             * @param object $category    Category data object.
             * @param int    $depth       Depth of page, used for padding.
             * @param array  $args        An array of wp_list_categories() arguments.
             */
            $css_classes = implode( ' ', apply_filters( 'category_css_class', $css_classes, $category, $depth, $args ) );

            $output .=  ' class="' . $css_classes . '"';
            $output .= ">$link\n";
        } elseif ( isset( $args['separator'] ) ) {
            $output .= "\t$link" . $args['separator'] . "\n";
        } else {
            $output .= "\t$link<br />\n";
        }
    }

    /**
     * Ends the element output, if needed.
     *
     * @since 2.1.0
     * @access public
     *
     * @see Walker::end_el()
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $page   Not used.
     * @param int    $depth  Optional. Depth of category. Not used.
     * @param array  $args   Optional. An array of arguments. Only uses 'list' for whether should append
     *                       to output. See wp_list_categories(). Default empty array.
     */
    public function end_el( &$output, $page, $depth = 0, $args = array() ) {
        parent::end_el( $output, $page, $depth, $args );
    }

}

//ф-я для облака ьегов(для добавления своего стиля)

function wptoots_tag_cloud($args) {
    $args['format'] = 'list';
    $args['smallest'] = 14;
    $args['unit'] = 'px';
    return $args;
}

add_filter('widget_tag_cloud_args', 'wptoots_tag_cloud');