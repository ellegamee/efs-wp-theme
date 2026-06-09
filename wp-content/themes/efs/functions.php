<?php
/**
 * EFS Tema – functions and definitions.
 *
 * @package EFS_Tema
 */

// ─── Inkludera delar ─────────────────────────────────────────────────────────

$efs_includes = array(
	'setup.php',
	'patterns.php',
	'enable-linked-groups/enable-linked-groups.php'
);

foreach ( $efs_includes as $file ) {
	require_once get_stylesheet_directory() . '/include/' . $file;
}