<?php
// Denna fil behövs inte längre för mönster i /patterns/ mappen.
// WordPress sköter registreringen automatiskt via fil-headern.

// Registrera mönsterkategori för EFS
add_action( 'init', function() {
    register_block_pattern_category(
        'efs',
        array( 'label' => __( 'EFS', 'efs' ) )
    );
});