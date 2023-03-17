<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package WP_Bootstrap_Starter
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function wp_bootstrap_starter_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

    if ( get_theme_mod( 'theme_option_setting' ) && get_theme_mod( 'theme_option_setting' ) !== 'default' ) {
        $classes[] = 'theme-preset-active';
    }

	return $classes;
}
add_filter( 'body_class', 'wp_bootstrap_starter_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function wp_bootstrap_starter_pingback_header() {
	echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
}
add_action( 'wp_head', 'wp_bootstrap_starter_pingback_header' );


/**
 * Return the header class
 */
function wp_bootstrap_starter_bg_class() {
    switch (get_theme_mod( 'theme_option_setting' )) {
        case "cerulean":
            return 'navbar-dark bg-primary';
            break;
        case "cosmo":
            return 'navbar-dark bg-primary';
            break;
        case "cyborg":
            return 'navbar-dark bg-dark';
            break;
        case "darkly":
            return 'navbar-dark bg-primary';
            break;
        case "flatly":
            return 'navbar-dark bg-primary';
            break;
        case "journal":
            return 'navbar-light bg-light';
            break;
        case "litera":
            return 'navbar-light bg-light';
            break;
        case "lumen":
            return 'navbar-light bg-light';
            break;
        case "lux":
            return 'navbar-light bg-light';
            break;
        case "materia":
            return 'navbar-dark bg-primary';
            break;
        case "minty":
            return 'navbar-dark bg-primary';
            break;
        case "pulse":
            return 'navbar-dark bg-primary';
            break;
        case "sandstone":
            return 'navbar-dark bg-primary';
            break;
        case "simplex":
            return 'navbar-light bg-light';
            break;
        case "sketchy":
            return 'navbar-light bg-light';
            break;
        case "slate":
            return 'navbar-dark bg-primary';
            break;
        case "solar":
            return 'navbar-dark bg-dark';
            break;
        case "spacelab":
            return 'navbar-light bg-light';
            break;
        case "superhero":
            return 'navbar-dark bg-dark';
            break;
        case "united":
            return 'navbar-dark bg-primary';
            break;
        case "yeti":
            return 'navbar-dark bg-primary';
            break;
        default:
            return 'navbar-light';
    }
}

function is_theme_preset_active() {
    if(get_theme_mod( 'theme_option_setting' ) && get_theme_mod( 'theme_option_setting' ) !== 'default'){
        return true;
    }
}

function register_recipes_post_type () {
    $args = array (
        'public' => true,
        'label' => 'Recipes',
        'supports' => array ('title', 'editor', 'thumbnail', 'categories')
    );
    register_post_type ('recipe', $args);
}
add_action ('init', 'register_recipes_post_type');

/**
 * Add Custom Taxonomy Into Recipe
 */

 function register_recipe_category()
 {
    $labels = [
        'name'                       => _x('Recipe Categories', 'Recipe Category General Name', 'wp-bootstrap-starter'),
        'singular_name'              => _x('Recipe Category', 'Recipe Category Singular Name', 'wp-bootstrap-starter'),
        'menu_name'                  => __('Recipe Category', 'wp-bootstrap-starter'),
        'all_items'                  => __('All Items', 'wp-bootstrap-starter'),
        'parent_item'                => __('Parent Item', 'wp-bootstrap-starter'),
        'parent_item_colon'          => __('Parent Item:', 'wp-bootstrap-starter'),
        'new_item_name'              => __('New Item Name', 'wp-bootstrap-starter'),
        'add_new_item'               => __('Add New Item', 'wp-bootstrap-starter'),
        'edit_item'                  => __('Edit Item', 'wp-bootstrap-starter'),
        'update_item'                => __('Update Item', 'wp-bootstrap-starter'),
        'view_item'                  => __('View Item', 'wp-bootstrap-starter'),
        'separate_items_with_commas' => __('Separate items with commas', 'wp-bootstrap-starter'),
        'add_or_remove_items'        => __('Add or remove items', 'wp-bootstrap-starter'),
        'choose_from_most_used'      => __('Choose from the most used', 'wp-bootstrap-starter'),
        'popular_items'              => __('Popular Items', 'wp-bootstrap-starter'),
        'search_items'               => __('Search Items', 'wp-bootstrap-starter'),
        'not_found'                  => __('Not Found', 'wp-bootstrap-starter'),
        'no_terms'                   => __('No items', 'wp-bootstrap-starter'),
        'items_list'                 => __('Items list', 'wp-bootstrap-starter'),
        'items_list_navigation'      => __('Items list navigation', 'flynt'),
    ];
    $args = [
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
    ];

    register_taxonomy('recipe-category', ['recipe'], $args);
 }
 
 add_action('init', 'register_recipe_category');

 /**
  * Add Shortcode for 3 recipes block
  */

function register_three_recipes_block_shortcode($atts){
    global $post;

    $default = array(
        'title' => 'Microwave Power-Up!',
    );
    $a = shortcode_atts($default, $atts);
    $output = '<div>';
        $output .= '<h3 class="text-center">' . $a['title'] . '</h3>';
        

        $args = array(
            'post_type' => 'recipe',
            'posts_per_page' => '3',
            'order' => 'DESC',
            'orderby' => 'date'
        );

        $the_query = new WP_Query( $args );

        $output .= '<div class="row">';
            if ( $the_query->have_posts() ) {
                while ( $the_query->have_posts() ) {
                    $the_query->the_post();

                    $recipe_categories = get_the_terms($post->ID, 'recipe-category');

                    $post_thumbnail_id = get_post_thumbnail_id( $post );
                    $thumb_url = wp_get_attachment_image_url($post_thumbnail_id, 'full');
                    $thumb_alt = get_post_meta ( $post_thumbnail_id, '_wp_attachment_image_alt', true );

                    $output .= '<div class="col-lg-4 mt-5 mt-lg-0">';
                        $output .= '<div class="card">';
                            if( !empty($post_thumbnail_id) ){
                                $output .= '<a href="' . get_permalink($post->ID) . '">';
                                    $output .= '<img class="card-img-top" src="' . $thumb_url . '" alt="' . esc_html ( $thumb_alt ) . '">';
                                $output .= '</a>';
                            }
                            $output .= '<div class="card-body">';
                                if( !empty($recipe_categories) ){
                                    $output .= '<p class="card-text">';
                                    
                                    foreach($recipe_categories as $index => $item){
                                        if( $index > 0 ) $output .= ', ';
                                        $output .= '<a href="' . get_term_link($item->term_id) . '">' . $item->name . '</a>';
                                    }

                                    $output .= '</p>';
                                }

                                $output .= '<h5 class="card-title"><a href="' . get_permalink($post->ID) . '">' . $post->post_title . '</a></h5>';
                            $output .= '</div>';
                        $output .= '</div>';
                    $output .= '</div>';
                }
            } else {
                // no posts found
            }
        $output .= '</div>';

        wp_reset_postdata();
    $output .= '</div>';

    return $output;
}
add_shortcode('three_recipes_block', 'register_three_recipes_block_shortcode');
