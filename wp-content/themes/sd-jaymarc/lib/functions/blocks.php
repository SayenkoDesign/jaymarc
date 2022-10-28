<?php

function xml_attribute($object, $attribute)
{
    if(isset($object[$attribute]))
        return (string) $object[$attribute];
}

// Blocks

/* add_action( 'wp_enqueue_scripts', function() {
	
	wp_register_script( 'plyr', get_url( 'scripts/plyr.js' ), ['jquery'], '', false );
    
    wp_register_style( 'plyr', get_url( 'styles/plyr.css' ) );
    
    if( has_block('acf/home-hero' ) ){
        wp_enqueue_script( 'plyr' );
        wp_enqueue_style( 'plyr' );
    }
}, 10 );
 */

add_filter( 'render_block', function( $block_content, $block ) {
    if ( 'generateblocks/button' === $block['blockName'] ) {

        $xml = simplexml_load_string($block_content);
        
        $href = xml_attribute( $xml, 'href' );

        if( $href ) {
            $parts = wp_parse_url( $href );
    
            if( is_array( $parts ) && ! empty( $parts['path'] ) ) {
                
                $path = $parts['path'];
        
                if ( $_post = get_page_by_path( basename( untrailingslashit( $path ) ), OBJECT, 'modal' ) ) {
                    
                    if( 'modal' == $_post->post_type ) {
                        $post_id = $_post->ID;
                        $slug = sanitize_title_with_dashes( get_the_title( $post_id ) );
    
                        $replace = sprintf( '<a data-fancybox="modal-%s" data-src="#%s" data-touch="false" data-auto-focus="false" data-thumbs="false"', wp_unique_id('-'), $slug );
        
                        $block_content = str_replace( '<a ', $replace, $block_content );
            
                        $block_content = str_replace( $href, '',  $block_content );
                    }
                    
                } 
            }
        }        
    }

    return $block_content;
}, 10, 2 );


/* add_filter( 'render_block', function( $block_content, $block ) {	

	if ( isset( $block['attrs']['className'] ) && ! empty( $block['attrs']['className'] ) && 'news-date' === $block['attrs']['className']  ) {
        $block_content = sprintf(
            '<time class="entry-date published" datetime="%1$s"><span>%2$s</span><span>%3$s</span></time>',
            esc_attr( get_the_date( 'c' ) ),
            esc_html( get_the_date( 'M' ) ),
            esc_html( get_the_date( 'Y' ) )
            );
    }

	return $block_content;
}, 10, 2 ); */