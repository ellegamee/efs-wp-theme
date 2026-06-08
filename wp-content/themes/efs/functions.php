<?php
/**
 * EFS Tema – functions and definitions.
 *
 * @package EFS_Tema
 */

// ─── Post formats ────────────────────────────────────────────────────────────

if ( ! function_exists( 'efs_post_format_setup' ) ) {
	function efs_post_format_setup() {
		add_theme_support( 'post-formats', array(
			'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video',
		) );
	}
}
add_action( 'after_setup_theme', 'efs_post_format_setup' );

// ─── Editor style ────────────────────────────────────────────────────────────

if ( ! function_exists( 'efs_editor_style' ) ) {
	function efs_editor_style() {
		add_editor_style( 'style.css' );
	}
}
add_action( 'after_setup_theme', 'efs_editor_style' );

// ─── Enqueue frontend styles ─────────────────────────────────────────────────

if ( ! function_exists( 'efs_enqueue_styles' ) ) {
	function efs_enqueue_styles() {
		wp_enqueue_style(
			'efs-style',
			get_stylesheet_uri(),
			array(),
			wp_get_theme()->get( 'Version' )
		);
	}
}
add_action( 'wp_enqueue_scripts', 'efs_enqueue_styles' );

// ─── Block styles ────────────────────────────────────────────────────────────

if ( ! function_exists( 'efs_block_styles' ) ) {
	function efs_block_styles() {
		register_block_style(
			'core/list',
			array(
				'name'         => 'checkmark-list',
				'label'        => __( 'Checkmark', 'efs-tema' ),
				'inline_style' => '
				ul.is-style-checkmark-list {
					list-style-type: "\2713";
				}
				ul.is-style-checkmark-list li {
					padding-inline-start: 1ch;
				}',
			)
		);
	}
}
add_action( 'init', 'efs_block_styles' );

// ─── Pattern categories ──────────────────────────────────────────────────────

if ( ! function_exists( 'efs_pattern_categories' ) ) {
	function efs_pattern_categories() {
		register_block_pattern_category(
			'efs',
			array( 'label' => __( 'EFS', 'efs-tema' ) )
		);
	}
}
add_action( 'init', 'efs_pattern_categories' );

// ─── Block bindings (post format) ────────────────────────────────────────────

if ( ! function_exists( 'efs_register_block_bindings' ) ) {
	function efs_register_block_bindings() {
		register_block_bindings_source(
			'efs/format',
			array(
				'label'              => _x( 'Post format name', 'Label for the block binding placeholder in the editor', 'efs-tema' ),
				'get_value_callback' => 'efs_format_binding',
			)
		);
	}
}
add_action( 'init', 'efs_register_block_bindings' );

if ( ! function_exists( 'efs_format_binding' ) ) {
	function efs_format_binding() {
		$post_format_slug = get_post_format();
		if ( $post_format_slug && 'standard' !== $post_format_slug ) {
			return get_post_format_string( $post_format_slug );
		}
	}
}

// ─── Include pattern registration ────────────────────────────────────────────

include_once get_stylesheet_directory() . '/include/patterns.php';