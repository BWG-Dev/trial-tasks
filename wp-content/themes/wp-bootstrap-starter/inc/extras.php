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
        'supports' => array ( 'title', 'editor', 'thumbnail', 'categories' )
    );
    register_post_type ('recipe', $args);
}
add_action ('init', 'register_recipes_post_type');

function bwg_create_recipe_taxonomy() {
    register_taxonomy(
        'recipe_category',
        'recipe',
        array(
            'label' => __( 'Recipe Categories' ),
            'rewrite' => array( 'slug' => 'recipe_category' ),
            'hierarchical' => true,
        )
    );
}
add_action( 'init', 'bwg_create_recipe_taxonomy' );

function bwg_display_recipes_shortcode() {
    $args = array(
        'post_type' => 'recipe',
        'posts_per_page' => 3,
        'orderby' => 'date',
        'order' => 'DESC'
    );

    $recipes = new WP_Query( $args );
    $output = '';

    if ( $recipes->have_posts() ) {
        $output .= '<div class="recipe-wrapper">';
        while ( $recipes->have_posts() ) {
            $recipes->the_post();
            $output .= '<div class="recipe">';
            $output .= '<a href="' . get_the_permalink() . '">';
            $output .= '<div class="recipe-image">' . get_the_post_thumbnail() . '</div>';
            $output .= '<div class="recipe-category">' . get_the_term_list( get_the_ID(), 'recipe_category', '', ', ', '' ) . '</div>';
            $output .= '<h3 class="recipe-title">' . get_the_title() . '</h3>';
            $output .= '</a>';
            $output .= '</div>';
        }
        $output .= '</div>';
        wp_reset_postdata();
    }

    return $output;
}
add_shortcode( 'bwg_display_recipes', 'bwg_display_recipes_shortcode' );


function bwg_enqueue_styles() {
    wp_enqueue_style( 'bwg_style', get_template_directory_uri() . '/inc/assets/css/style.css' );
}
add_action( 'wp_enqueue_scripts', 'bwg_enqueue_styles' );