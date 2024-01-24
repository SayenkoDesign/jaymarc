<?php

/**
 * GeneratePress child theme functions and definitions.
 *
 * Add your custom PHP in this file.
 * Only edit this file if you have direct access to it on your server (to fix errors if they happen).
 */

function sd_child_theme_setup()
{

	//* Child theme (do not remove)
	define('CHILD_THEME_VERSION', filemtime(get_stylesheet_directory() . '/style.css'));

	define('THEME_DIR', get_stylesheet_directory());
	define('THEME_URL', get_stylesheet_directory_uri());
	define('THEME_DIST', THEME_URL . '/dist');
	define('THEME_BLOCKS', THEME_URL . '/blocks');
	define('THEME_LANG', THEME_URL . '/languages');
	define('THEME_LIB', THEME_URL . '/lib');
	define('THEME_STYLES', THEME_DIST . '/styles');
	define('THEME_IMG', THEME_DIST . '/images');
	define('THEME_SCRIPTS', THEME_DIST . '/scripts');
	define('THEME_ICONS', THEME_URL . '/assets/icons');

	// -- Responsive embeds
	add_theme_support('responsive-embeds');

	add_theme_support( 'editor-styles' );
    add_editor_style( 'dist/styles/editor-style.css' );
}
add_action('after_setup_theme', 'sd_child_theme_setup', 15);

function my_login_logo() { 

	$custom_logo_id = get_theme_mod( 'custom_logo' );
	$image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
	?>
		<style type="text/css">
		#login h1 a, .login h1 a {
			background-image: url(<?php echo $image[0];?>); 
			width: 220px;
			height: 46px;
			background-size: contain;
			background-repeat: no-repeat;
			padding-bottom: 30px;
		}
		</style>
	<?php 
	}
	add_action( 'login_enqueue_scripts', 'my_login_logo' );
	

/**
 * Explicitly load theme files
 */
array_map(function ($file) {
	if (!$filepath = locate_template("${file}")) {
		trigger_error(sprintf(__('Error locating %s for inclusion', ''), $file), E_USER_ERROR);
	}

	require_once $filepath;
}, [
	'lib/functions/attributes.php',
	'lib/functions/markup.php',
	'lib/functions/format.php',
	'lib/functions/scripts.php',
	'lib/functions/assets.php',
	'lib/functions/icon.php',
	'lib/functions/theme.php',
	'lib/functions/blog.php',
	'lib/functions/generatepress.php',
	'lib/classes/class-acf-blocks.php',
	'lib/classes/class-acf-block.php',
	'lib/functions/blocks.php',
	'lib/functions/acf.php',
	'lib/functions/homes.php',
	'lib/functions/redirects.php',
	'lib/functions/facetwp.php',
	'lib/functions/plans.php',
	'lib/functions/template-tags.php',
	'lib/functions/gravity-forms.php',
	'lib/functions/team.php',
	'lib/functions/post.php',
	'lib/functions/videos.php'
]);