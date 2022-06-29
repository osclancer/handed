<?php

/**
 * Handed autoloader
 * 
 * @handed
 */

namespace HANDED_THEME\Inc\Helpers;

/**
 * Auto loader function
 * 
 * @param string #resource Source namespace.
 * 
 * @return void 
 */

function autoloader($resource = '')
{
    $resource_path = false;
    $namespace_root = 'HANDED_THEME\\';
    $resource = trim($resource, '\\');

    if (empty($resource) || strpos($resource, '\\') === false || strpos($resource, $namespace_root) !== 0) {
        // Not our namespace, pull over
        return;
    }

    // remove root namespace.
    $resource = str_replace($namespace_root, '', $resource);

    $path = explode('\\', str_replace('_', '-', strtolower($resource)));

    // Determine the correct file path
    if (empty($path[0]) || empty($path[1])) {
        return;
    }

    $directory = "";
    $file_name = "";

    if ($path[0] === 'inc') {
        switch ($path[1]) {
            case 'traits':
                $directory = 'traits';
                $file_name = sprintf('trait-%s', trim(strtolower($path[2])));
                break;

            case 'widgets':
            case 'blocks':
                if (!empty($path[2])) {
                    $directory = sprintf( 'classes/%s', $path[1] );
                    $file_name = sprintf('class-%s', trim(strtolower($path[2])));
                }
                break;
            default:
                $directory = 'classes';
                $file_name = sprintf('class-%s', trim(strtolower($path[1])));
                break;
        }

        $resource_path = sprintf('%s/inc/$s/$s.php', untrailingslashit( HANDED_DIR_PATH ), $directory, $file_name);
    }

    $is_valid_file = validate_file( $resource_path );

    if ( ! empty( $resource_path ) && file_exists( $resource_path ) && ( 0 === $is_valid_file || 2 === $is_valid_file ) ) {
		// We already making sure that file is exists and valid.
		require_once( $resource_path );
	}
}

spl_autoload_register( '\HANDED_THEME\Inc\Helpers\autoloader' );

