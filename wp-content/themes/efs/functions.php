<?php
// Minimal enqueue for child theme styles
add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style(
        'efs-style',
        get_stylesheet_uri(),
        array(), // parent styles not required for block themes, keep array empty or add parent handle if needed
        wp_get_theme( get_stylesheet() )->get( 'Version' )
    );
}, 20 );