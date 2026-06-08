<?php
/**
 * Tema-inställningar och assets.
 *
 * @package EFS_Tema
 */

add_action( 'after_setup_theme', function() {
	add_editor_style( 'style.css' );
} );

add_action( 'wp_enqueue_scripts', function() {
	wp_enqueue_style( 'efs-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );
} );
