<?php
// Blog


function _s_get_term_filters( $tax = 'portfolio_filters' ) {
    
    $terms = get_terms( array(
        'taxonomy' => $tax, // set your taxonomy here
    ) );
    
    if ( empty( $terms ) || is_wp_error( $terms ) ) {
        return false;
    }

    $out = '';
        
    foreach( $terms as $term ) {
        $current = get_queried_object() == $term ? ' class="current-menu-item"' : '';
        $out .= sprintf(
            '<li%s><a href="%s">%s</a></li>',
            $current,
            esc_url( get_term_link( $term ) ),
            esc_attr( $term->name )
        );
    }

    return $out;
}

/**
 * Get the primary term of a post, by taxonomy.
 * If Yoast Primary Term is used, return it,
 * otherwise fallback to the first term.
 *
 * @version  1.1.0
 *
 * @link     https://gist.github.com/JiveDig/5d1518f370b1605ae9c753f564b20b7f
 * @link     https://gist.github.com/jawinn/1b44bf4e62e114dc341cd7d7cd8dce4c
 * @author   Mike Hemberger @JiveDig.
 *
 * @param    string  $taxonomy  The taxonomy to get the primary term from.
 * @param    int     $post_id   The post ID to check.
 *
 * @return   WP_Term|bool  The term object or false if no terms.
 */
function _s_get_primary_term( $taxonomy = 'category', $post_id = false ) {
	// Bail if no taxonomy.
	if ( ! $taxonomy ) {
		return false;
	}
	// If no post ID, set it.
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}
	// If checking for WPSEO.
	if ( class_exists( 'WPSEO_Primary_Term' ) ) {
		// Get the primary term.
		$wpseo_primary_term = new WPSEO_Primary_Term( $taxonomy, $post_id );
		$wpseo_primary_term = $wpseo_primary_term->get_primary_term();
		// If we have one, return it.
		if ( $wpseo_primary_term ) {
			return get_term( $wpseo_primary_term );
		}
	}
	// We don't have a primary, so let's get all the terms.
	$terms = get_the_terms( $post_id, $taxonomy );
    
	// Bail if no terms.
	if ( ! $terms || is_wp_error( $terms ) ) {
		return false;
	}
    
	// Return the first term.
	return $terms[0];
}

add_action( 'generate_before_content', function() {
	if (! is_singular() ) {
		echo '<div class="post-content">';
	}
}, 12 );

add_action( 'generate_after_content', function() {
	if ( ! is_singular()) {
		echo '</div>';
	}
});

//add_filter( 'wp_trim_excerpt', 'tu_excerpt_metabox_more' );
function tu_excerpt_metabox_more( $excerpt ) {
    $output = $excerpt;

    if ( is_home() && has_excerpt() ) {
        $output = sprintf( '%1$s <p class="read-more-button-container"><a class="read-more" href="%2$s">%3$s</a></p>',
            $excerpt,
            get_permalink(),
            __( 'Read more', 'generatepress' )
        );
    }
	
    return $output;
}


// Temporarily remove author index
 // $byline = '<span class="byline">%1$s<span class="author%8$s" %5$s><a class="url fn n" href="%2$s" title="%3$s" rel="author"%6$s><span class="author-name"%7$s>%4$s</span></a></span> /</span> ';
/* add_filter( 'generate_post_author_output', function() {
    
    $schema_type = generate_get_schema_type();
		
	$byline = '<span class="byline">%1$s<span class="author%8$s" %5$s><span class="author-name"%7$s>%4$s</span></span> /</span> ';
    return
        sprintf(
            $byline,
            apply_filters( 'generate_inside_post_meta_item_output', '', 'author' ),
            esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
            esc_attr( sprintf( __( 'View all posts by %s', 'generatepress' ), get_the_author() ) ),
            esc_html( get_the_author() ),
            generate_get_microdata( 'post-author' ),
            'microdata' === $schema_type ? ' itemprop="url"' : '',
            'microdata' === $schema_type ? ' itemprop="name"' : '',
            generate_is_using_hatom() ? ' vcard' : ''
        );
} ); */


add_filter( 'option_generate_blog_settings', 'lh_disable_featured_column' );
function lh_disable_featured_column( $options ) {
    if ( ! is_home() ) {
	    $options['featured_column'] = false;
    }
  
    return $options;
}


add_filter( 'next_post_link', function( $output, $format, $link, $post ) {
    if ( ! $post ) {
    return '';
  }

  return sprintf(
      '<div class="nav-next"><span class="next"><a href="%1$s" title="%2$s">Next %3$s</a></span></div>',
        get_permalink( $post ),
        $post->post_title,
        generate_get_svg_icon( 'arrow-right' )
  );
}, 10, 4 );

add_filter( 'previous_post_link', function( $output, $format, $link, $post ) {
    if ( ! $post ) {
    return '';
  }

  return sprintf(
      '<div class="nav-previous"><span class="prev"><a href="%1$s" title="%2$s">%3$s Previous</a></span></div>',
        get_permalink( $post ),
        $post->post_title,
        generate_get_svg_icon( 'arrow-left' )
  );
}, 10, 4 );

/* add_filter('generate_category_list_output', function( $output ) {
   
    $social = 'social icons here';
   
    return $social . $output;
}); */


function _s_posts_order_dropdown() {
    
    $order = get_query_var( 'order' );
    
    $onchange = ' onchange="document.location.search=this.options[this.selectedIndex].value;"';
    
    //$options = '<option value="">Select one</option>';
    $options = '';
    $options .= sprintf( '<option value="DESC"%s>Date (Newest)</option>', ( 'DESC' == $order ) ? ' selected' : '' );
    $options .= sprintf( '<option value="ASC"%s>Date (Oldest)</option>', ( 'ASC' == $order ) ? ' selected' : '' );
    
    return sprintf( '<select class="sort-select" name="order"%s>%s</select>', '', $options );

}


add_action( 'generate_before_loop', function() {
	if ( is_home() ) {
		echo '<div class="categories-list post generate-columns tablet-grid-50 mobile-grid-100 grid-parent grid-50 no-featured-image-padding"><div class="categories-list__wrap">';
        echo '<h2 class="border-bottom">Categories</h2><ul>';
        wp_list_categories(['title_li' => '']);
        echo '</ul></div></div>';
	}
}, 12 );

add_action( 'generate_before_main_content', function() {
    
    if ( ! is_home() && ! is_category() ) {
        return;
    }
    
    ?>
    <div class="archive-header">
    <div class="archive-heading"><h1>Resource Hub</h1></div>
    <?php
    $args = array(
        'show_option_none' => __( 'Select one', '_s' ),
        'show_count'       => 1,
        'orderby'          => 'name',
        'hierarchical'     => 1,
        'hide_if_empty'    => false,
        'class'            => '',
        'echo'             => 0,
    );
    
    if( is_category() ) {
        
        // is this a parent?
        $category = get_category( get_query_var( 'cat' ) );
        $args['selected'] =  $category->cat_ID;                            
    } 
    
    $reset = get_post_type_archive_link( 'post' );
 
    
    $url = home_url( '/' );
    
    
    $categories = wp_dropdown_categories( $args );

    $filters = sprintf( '<form id="category-select" class="category-select" action="%s" method="get">
            <ul class="menu facetwp-filters">
                <li><div class="facet-wrap"><div class="facet-label">Categories</div>%s</div></li>
                <li><div class="facet-wrap"><div class="facet-label">Order</div>%s</div></li>
                <li>%s</li>
                <li>%s</li>
            </ul>
         </form>',  
        esc_url( $url ),
        $categories,
        _s_posts_order_dropdown(),
        '<button class="button" value="Search">Search</button>',
        sprintf( '<a href="%s" class="button reset">%s</a>', $reset, __( 'Reset', '_s' ) )
      );
    
    $children = get_categories( array(
                'child_of' => get_queried_object_id(),
                'hide_empty' => false
    ) );
    
    echo $filters;

    ?>
    </div>
    <?php
}, 0);






/* add_filter ( 'generate_post_navigation_args', function( $args ) {
    $args['previous_format'] = '<div class="nav-previous">' . $previous . '<span class="prev" title="' . esc_attr__( 'Previous', 'generatepress' ) . '">%link</span></div>';
    $args['next_format'] = '<div class="nav-next">' . $next . '<span class="next" title="' . esc_attr__( 'Next', 'generatepress' ) . '">%link</span></div>'; 

    return $args;
} ); */


add_filter( 'generate_next_link_text', function() {
    $next = _s_get_icon(
        [
            'icon'	=> 'next',
            'group'	=> 'theme',
            'class'	=> 'next',
            'width' => 66,
            'height'=> 66,
            'label'	=> false,
        ]
    );
    return sprintf( '<span class="screen-reader-text" title="%1$s">%1$s</span>%2$s', esc_attr__( 'Next', 'generatepress' ), $next );
} );
add_filter( 'generate_previous_link_text', function() {
    $previous = _s_get_icon(
        [
            'icon'	=> 'previous',
            'group'	=> 'theme',
            'class'	=> 'previous',
            'width' => 66,
            'height'=> 66,
            'label'	=> false,
        ]
    );
    return sprintf( '<span class="screen-reader-text" title="%1$s">%1$s</span>%2$s', esc_attr__( 'Previous', 'generatepress' ), $previous );
} );