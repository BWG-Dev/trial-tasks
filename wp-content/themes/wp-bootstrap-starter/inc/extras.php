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
        'supports' => array ('title', 'editor', 'thumbnail', 'categories'),
        'taxonomies' => array ('category')
    );
    register_post_type ('recipe', $args);
}
add_action ('init', 'register_recipes_post_type');

function showMyRecipes()
{
    set_post_thumbnail_size( 250, 250 );
	$s = "<div class='container'><div class='row'>";
	$args = array('posts_per_page'=>'3','post_type'=>'recipe');
	$results = new WP_Query($args);
	while($results->have_posts()):
	   $results->the_post();
	   $s .=  "<div class='col-lg-4'>" . the_post_thumbnail() . "<h5>" . the_category() . "</h5><h2>" . the_title() . "</h2></div>";
	endwhile;
    $s .= "</div></div>";
	wp_reset_postdata();
	return $s;
}

add_shortcode('show_recipes', 'showMyRecipes');