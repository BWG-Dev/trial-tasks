<?php
/**
 * Recipes Showcase block
 *
 * Displays three recipes
 *
 * @author Matt Bonacini
 * @since 1.0
 */

$block_id = $block['id'];
$block_name = str_replace('acf/', '', $block['name']);

$section_title = get_field('tb_section_title');
?>
<section id="<?php echo esc_attr($block_id); ?>" class="tb-blocks <?php echo $block_name; ?>">

<h1><?php echo $section_title;?></h1>

<div class="tb-recipes-loop">
	<?php
		if (have_rows('tb_recipes')) :
			while (have_rows('tb_recipes')) : the_row();
			$recipe_post = get_sub_field('tb_recipe_post');
			// Get the title of the recipe post
			$recipe_title = get_the_title($recipe_post);

			// Get URL to post
			$recipe_url = get_permalink($recipe_post);

			// Get the image of the recipe post
			$recipe_image = get_the_post_thumbnail($recipe_post);

			// Get the first category of the recipe post
			$recipe_category = get_the_category($recipe_post);
			$recipe_cat_name = $recipe_category[0]->name;
			$recipe_cat_url = get_category_link($recipe_category[0]->term_id); 
			?>
			<article class="tb-single-recipe">
				<a href="<?php echo $recipe_url; ?>"><?php echo $recipe_image; ?></a>
				<div class="tb-recipt-text">
					<div class="tb-recipe-cat"><a href="<?php echo $recipe_cat_url; ?>"><?php echo $recipe_cat_name; ?></a></div>
					<h2 class="tb-recipe-title"><?php echo $recipe_title;?></h2>
				</div>
			</article>
			<?php
			endwhile;
		endif;
		?>
</div>
</section>
 