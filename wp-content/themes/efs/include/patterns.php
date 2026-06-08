<?php
/**
 * Mönsterkategorier och manuell registrering.
 *
 * @package EFS_Tema
 */

// ─── Pattern categories ──────────────────────────────────────────────────────

add_action( 'init', function() {
	register_block_pattern_category( 'efs', array( 'label' => __( 'EFS', 'efs-tema' ) ) );
} );

// ─── Pattern registration ────────────────────────────────────────────────────

add_action( 'init', function() {
	$pattern_file = get_stylesheet_directory() . '/patterns/full-width-section.php';
	
	if ( file_exists( $pattern_file ) ) {
		$content = file_get_contents( $pattern_file );
		$content = preg_replace( '/<\?php.*?\?>/s', '', $content ); // Ta bort PHP-header
		$content = trim( $content );

		register_block_pattern(
			'efs/full-width-section',
			array(
				'title'       => __( 'Fullbreddssektion', 'efs-tema' ),
				'categories'  => array( 'efs', 'featured' ),
				'content'     => $content,
			)
		);
	}
}, 20 );

add_action( 'init', function() {
	$pattern_file = get_stylesheet_directory() . '/patterns/contact-card.php';
	
	if ( file_exists( $pattern_file ) ) {
		$content = file_get_contents( $pattern_file );
		$content = preg_replace( '/<\?php.*?\?>/s', '', $content ); // Ta bort PHP-header
		$content = trim( $content );

		register_block_pattern(
			'efs/contact-card',
			array(
				'title'       => __( 'Kontaktkort', 'efs-tema' ),
				'categories'  => array( 'efs', 'featured', 'kontakt' ),
				'content'     => $content,
			)
		);
	}
}, 20 );

add_action( 'init', function() {
	$pattern_file = get_stylesheet_directory() . '/patterns/contact-card-no-image.php';
	
	if ( file_exists( $pattern_file ) ) {
		$content = file_get_contents( $pattern_file );
		$content = preg_replace( '/<\?php.*?\?>/s', '', $content ); // Ta bort PHP-header
		$content = trim( $content );

		register_block_pattern(
			'efs/contact-card-no-image',
			array(
				'title'       => __( 'Kontaktkort (Utan bild)', 'efs-tema' ),
				'categories'  => array( 'efs', 'featured', 'kontakt' ),
				'content'     => $content,
			)
		);
	}
}, 20 );