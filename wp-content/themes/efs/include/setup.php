<?php
/**
 * Tema-inställningar och assets.
 *
 * @package EFS_Tema
 */

add_action( 'after_setup_theme', function() {
	// Enable support for editor styles.
	add_theme_support( 'editor-styles' );

	// Enqueue editor styles.
	add_editor_style( 'style.css' );
} );

/**
 * Enqueue assets for both front-end and editor.
 */
add_action( 'enqueue_block_assets', function() {
	wp_enqueue_style( 'efs-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );
} );
