<?php

namespace App;


// Check whether WordPress and ACF are available; bail if not.
if (! function_exists('acf_register_block_type')) {
    return;
}
if (! function_exists('add_filter')) {
    return;
}
if (! function_exists('add_action')) {
    return;
}

// Add the default blocks location, 'blocks', via filter
add_filter('acf-gutenberg-blocks-templates', function () {
    return ['blocks'];
});

/**
 * Create blocks based on templates found in theme "blocks" directory
 */
add_action('acf/init', function () {

    // Get an array of directories containing blocks
    $directories = apply_filters('acf-gutenberg-blocks-templates', [] );    

    // Check whether ACF exists before continuing
    foreach ($directories as $directory) {

        $dir = \locate_template($directory);

        

        // Sanity check whether the directory we're iterating over exists first
        if ( !file_exists( $dir ) ) {
            continue;
        }

        $files = list_files( $dir );

        //error_log( print_r( $files, 1 ) );

        if( empty( $files ) ) {
            continue;
        }

        foreach ($files as $file ) {
            
            $file_headers = get_file_data($file, [
                'title' => 'Title',
                'description' => 'Description',
                'category' => 'Category',
                'icon' => 'Icon',
                'keywords' => 'Keywords',
                'mode' => 'Mode',
                'align' => 'Align',
                'post_types' => 'PostTypes',
                'supports_align' => 'SupportsAlign',
                'supports_anchor' => 'SupportsAnchor',
                'supports_mode' => 'SupportsMode',
                'supports_jsx' => 'SupportsInnerBlocks',
                'supports_align_text' => 'SupportsAlignText',
                'supports_align_content' => 'SupportsAlignContent',
                'supports_multiple' => 'SupportsMultiple',
                'enqueue_style'     => 'EnqueueStyle',
                'enqueue_script'    => 'EnqueueScript',
                'enqueue_assets'    => 'EnqueueAssets',
            ]);

            if (empty($file_headers['title'])) {
                // error_log(__('This block needs a title: ' . $directory . '/' . $file, 'sage'), __('Block title missing', 'sage'));
                continue;
            }

            if (empty($file_headers['category'])) {
                // error_log(__('This block needs a category: ' . $directory . '/' . $file, 'sage'), __('Block category missing', 'sage'));
                continue;
            }

            // Make sure we have a slug
            $slug = str_replace( $dir, '', dirname( $file ) );
            $slug = ltrim( $slug, '\/' );

            if( ! $slug ) {
                continue;
            }

            // Checks if dist contains this asset, then enqueues the dist version.
            if (!empty($file_headers['enqueue_style'])) {
                checkAssetPath($file_headers['enqueue_style'], $directory, $slug );
            }

            if (!empty($file_headers['enqueue_script'])) {
                checkAssetPath($file_headers['enqueue_script'], $directory, $slug);
            }

            

            // Set up block data for registration
            $data = [
                'name' => $slug,
                'title' => $file_headers['title'],
                'description' => $file_headers['description'],
                'category' => $file_headers['category'],
                'icon' => $file_headers['icon'],
                'keywords' => explode(' ', $file_headers['keywords']),
                'mode' => $file_headers['mode'],
                'align' => $file_headers['align'],
                'render_callback'  => __NAMESPACE__.'\\acf_blocks_callback',
                'enqueue_style'   => $file_headers['enqueue_style'],
                'enqueue_script'  => $file_headers['enqueue_script'],
                'enqueue_assets'  => $file_headers['enqueue_assets'],
                'example'  => array(
                    'attributes' => array(
                        'mode' => 'preview',
                    )
                )
            ];

            // If the PostTypes header is set in the template, restrict this block to those types
            if (!empty($file_headers['post_types'])) {
                $data['post_types'] = explode(' ', $file_headers['post_types']);
            }

            // If the SupportsAlign header is set in the template, restrict this block to those aligns
            if (!empty($file_headers['supports_align'])) {
                $data['supports']['align'] = in_array($file_headers['supports_align'], array('true', 'false'), true) ? filter_var($file_headers['supports_align'], FILTER_VALIDATE_BOOLEAN) : explode(' ', $file_headers['supports_align']);
            }

            // If the SupportsMode header is set in the template, restrict this block mode feature
            if (!empty($file_headers['supports_anchor'])) {
                $data['supports']['anchor'] = $file_headers['supports_anchor'] === 'true' ? true : false;
            }

            // If the SupportsMode header is set in the template, restrict this block mode feature
            if (!empty($file_headers['supports_mode'])) {
                $data['supports']['mode'] = $file_headers['supports_mode'] === 'true' ? true : false;
            }

            // If the SupportsInnerBlocks header is set in the template, restrict this block mode feature
            if (!empty($file_headers['supports_jsx'])) {
                $data['supports']['jsx'] = $file_headers['supports_jsx'] === 'true' ? true : false;
            }

            // If the SupportsAlignText header is set in the template, restrict this block mode feature
            if (!empty($file_headers['supports_align_text'])) {
                $data['supports']['align_text'] = $file_headers['supports_align_text'] === 'true' ? true : false;
            }

            // If the SupportsAlignContent header is set in the template, restrict this block mode feature
            if (!empty($file_headers['supports_align_text'])) {
                $data['supports']['align_content'] = $file_headers['supports_align_content'] === 'true' ? true : false;
            }

            // If the SupportsMultiple header is set in the template, restrict this block multiple feature
            if (!empty($file_headers['supports_multiple'])) {
                $data['supports']['multiple'] = $file_headers['supports_multiple'] === 'true' ? true : false;
            }

            // Register the block with ACF
            \acf_register_block_type(apply_filters("theme/blocks/$slug/register-data", $data));
        }
        
    }
});

/**
 * Callback to register blocks
 */
function acf_blocks_callback($block, $content = '', $is_preview = false, $post_id = 0)
{
    
    $data = get_fields() ?: [];
    // $data = array_filter_recursive( $data, 'strlen', true ); // check if no fields
    
    
    // Set up the slug to be useful
    $slug  = str_replace('acf/', '', $block['name']);
    $block = array_merge(['className' => ''], $block);

    // Set up the block data
    $block['post_id'] = $post_id;
    $block['is_preview'] = $is_preview;
    $block['is_empty'] = ! $content && empty( $data ) ? true : false;
    $block['content'] = $content;
    $block['slug'] = $slug;
    $block['anchor'] = isset($block['anchor']) ? $block['anchor'] : '';
    // Send classes as array to filter for easy manipulation.
    $block['classes'] = [
        $slug,
        $block['className'],
        $block['is_preview'] ? 'is-preview' : null,
        'align'.$block['align']
    ];

    // Join up the classes.
    // $block['classes'] = implode(' ', array_filter($block['classes']));

    // Get the template directories.
    $directories = apply_filters('acf-gutenberg-blocks-templates', []);

    foreach ($directories as $directory) {
        get_template_part("${directory}/${slug}/index", null, ['block' => $block]);
    }
}

/**
 * Function to strip the `.blade.php` from a blade filename
 */
function removeExtension($filename)
{
    // Filename must end with ".blade.php". Parenthetical captures the slug.
    $pattern = '/(.*)\.php$/';
    $matches = [];
    // If the filename matches the pattern, return the slug.
    if (preg_match($pattern, $filename, $matches)) {
        return $matches[1];
    }
    // Return FALSE if the filename doesn't match the pattern.
    return false;
}

/**
 * Checks asset path for specified asset.
 *
 * @param string &$path
 *
 * @return void
 */
function checkAssetPath(&$path, $directory, $slug )
{
    if (preg_match("/^(styles|scripts)/", $path)) {
        $path = \get_url($directory . '/' . $slug . '/' . $path);
    }
}


/** function array_filter_recursive
 *
 *      Exactly the same as array_filter except this function
 *      filters within multi-dimensional arrays
 *
 * @param array
 * @param string optional callback function name
 * @param bool optional flag removal of empty arrays after filtering
 * @return array merged array
 */
function array_filter_recursive($array, $callback = null, $remove_empty_arrays = false) {
    foreach ($array as $key => & $value) {
      if (is_array($value)) {
        $value = call_user_func_array(__FUNCTION__, array($value, $callback, $remove_empty_arrays));
        if ($remove_empty_arrays && ! (bool) $value) {
          unset($array[$key]);
        }
      }
      else {
        if ( ! is_null($callback) && ! $callback($value)) {
          unset($array[$key]);
        }
        elseif ( ! (bool) $value) {
          unset($array[$key]);
        }
      }
    }
    unset($value);
    return $array;
  }


if( ! function_exists( 'list_files' ) ) {
    function list_files( $folder = '', $levels = 5, $exclusions = array() ) {
        if ( empty( $folder ) ) {
            return false;
        }
    
        $folder = trailingslashit( $folder );
    
        if ( ! $levels ) {
            return false;
        }
    
        $files = array();
    
        $dir = @opendir( $folder );
    
        if ( $dir ) {
            while ( ( $file = readdir( $dir ) ) !== false ) {
                // Skip current and parent folder links.
                if ( in_array( $file, array( '.', '..' ), true ) ) {
                    continue;
                }
    
                // Skip hidden and excluded files.
                if ( '.' === $file[0] || in_array( $file, $exclusions, true ) ) {
                    continue;
                }
    
                if ( is_dir( $folder . $file ) ) {
                    $files2 = list_files( $folder . $file, $levels - 1 );
                    if ( $files2 ) {
                        $files = array_merge( $files, $files2 );
                    } else {
                        $files[] = $folder . $file . '/';
                    }
                } else {
                    $files[] = $folder . $file;
                }
            }
    
            closedir( $dir );
        }
    
        return $files;
    }
}