<?php
namespace App;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


/**
 * Block class
 *
 * @since 1.0.0
 */
class ACF_Block {
        
    
    /**
	 * Block data.
	 *
	 * Holds all the default block attributes
	 *
	 * @access private
	 *
	 * @var array
	 */
    private $_block = [];
    
    
    private $html_tag = 'section';    
    
    /**
	 * Feilds.
	 *
	 * Holds all the fields for the element
	 *
	 * @access private
	 *
	 * @var null|array
	 */
	private $_fields;
    
    /**
	 * Element render attributes.
	 *
	 * Holds all the render attributes of the element. Used to store data like
	 * the HTML class name and the class value, or HTML element ID name and value.
	 *
	 * @access private
	 *
	 * @var array
	 */
	private $_render_attributes = [];
    
    
    private $_inline_scripts = [];
    
    
    private $_inline_styles = [];
    
        
    public function __construct( array $data = [] ) {
                        
        if ( ! empty( $data['block'] ) ) {
			$this->_block = $data['block'];   
		}
                
        $this->_add_render_attributes();  
        
	}
    
    /**
	 * Get block name.
	 *
	 * Retrieve the block name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Block name.
	 */
	public function get_name() {
        
        if( empty( $this->_block['name'] ) ) {
            return false;
        }
        
        return sanitize_title_with_dashes( str_replace( 'acf/', '', $this->_block['name'] ) ); 
	}
    
    
    /**
	 * Get readable block name.
	 *
	 * Retrieve the block name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Block name.
	 */
	public function get_readable_name() {
        return ucwords( str_replace( '-', ' ', $this->get_name() ) );
	}
    
    
    
    
    /**
	 * Get block title.
	 *
	 * Retrieve the block title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Block title.
	 */
	public function get_title() {
        return $this->_block['title']; 
	}

	/**
	 * Is Block Preview
	 *
	 * Retrieve the preview status
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return boolean Block Is Preview.
	 */
	public function is_preview() {
        return $this->_block['is_preview']; 
	}


	/**
	 * Is Block Empty
	 *
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return boolean Block Is Empty.
	 */
	public function is_empty() {
        return $this->_block['is_empty']; 
	}
    
    
    /**
	 * Get block Description.
	 *
	 * Retrieve the block title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Block title.
	 */
	public function get_description() {
        return $this->_block['description']; 
	}
    
    
    /**
	 * Get block ID.
	 *
	 * Retrieve the block generic ID.
	 *
	 * @since 1.4.0
	 * @access public
	 *
	 * @return string The ID.
	 */
	public function get_id() {
       return $this->_block['id']; 
	}
    
    /**
	 * Get block IDs.
	 *
	 * Retrieve the block generic IDs.
	 *
	 * @since 1.4.0
	 * @access public
	 *
	 * @return array The IDs.
	 */
    public function get_block_ids() {
        
        if( ! is_singular() ) {
            return false;
        }
        
        
        global $post;
        
        // get all blocks
        $parse_blocks = parse_blocks( $post->post_content );
        
        // Remove empty blocks
        $parse_blocks = array_filter($parse_blocks);
        
        if( empty( $parse_blocks ) ) {
            return NULL;
        }
                
        $ids = [];
        foreach( $parse_blocks as $block ) {
            if( ! empty( $block['attrs']['id'] ) ) {
                $ids[] = $block['attrs']['id'];
            }
        }
        
        return $ids;   
    }
    
    
    /**
	 * Get block anchor.
	 *
	 * Retrieve the block anchor.
	 *
	 * @since 1.4.0
	 * @access public
	 *
	 * @return string The ID.
	 */
	public function get_anchor() {
        if( ! empty( $this->_block['anchor'] ) ) {
            return $this->_block['anchor']; 
        }
	}
    
    
    /**
	 * Get block index
	 *
	 * Retrieve the block index.
	 *
	 *
	 * @return integer
	 */
    public function get_block_index() {
               
        $ids = $this->get_block_ids();
        
        if( empty( $ids ) ) {
            return false;
        }
        
        // Find the id by key
        $key = array_search( $this->get_id(), $ids ) ;
        
        if( false !== $key ) {
            return $key + 1;
        }
        
        return false;
    }
    
    
    /**
	 * Is First Block
	 *
	 * Find the first block
	 *
	 *
	 * @return boolean
	 */
    public function is_first_block() {
       
        $ids = $this->get_block_ids();
        
        if( empty( $ids ) ) {
            return false;
        }
        
        $key = NULL;

        if ( is_array( $ids ) ) {
            
            if( reset( $ids ) == $this->get_id() ) {
                return true;
            }
        }
        
        return false;
    }
    
    
    /**
	 * Is Last Block
	 *
	 * Find the last block
	 *
	 *
	 * @return boolean
	 */
    public function is_last_block() {
       
        $ids = $this->get_block_ids();
        
        if( empty( $ids ) ) {
            return false;
        }
        
        $key = NULL;

        if ( is_array( $ids ) ) {
            
            if( end( $ids ) == $this->get_id() ) {
                return true;
            }
        }
        
        return false;
    }
    
            
    /**
	 * Before block rendering.
	 *
	 * Used to add stuff before the block block.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function before_render() {            
                                        
        // $this->add_render_attribute( 'wrap', 'class', 'wrap' );
        
        // $this->add_render_attribute( 'container', 'class', 'container' );
        
        return sprintf( '<%s %s>', 
                        esc_html( $this->get_html_tag() ), 
                        $this->get_render_attribute_string( 'block' ),
                        // $this->get_render_attribute_string( 'wrap' ),
                        // $this->get_render_attribute_string( 'container' )
                        );
    }
    

	/**
	 * After block rendering.
	 *
	 * Used to add stuff after the block block.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function after_render() {
        
        $scripts = $this->get_inline_scripts();
        $styles = $this->get_inline_styles();
        return sprintf( '%s%s</%s>', $scripts, $styles, esc_html( $this->get_html_tag() ) );
	}
    
    
    public function add_inline_script( $data = '' ) {
        if( ! empty( $data ) ) {
            $this->_inline_scripts[] = $data;  
        }
    }
    
    
    private function get_inline_scripts() {
        $data = $this->_inline_scripts;
        if( ! is_admin() && ! empty( $data ) ) {
            return sprintf( "\n<script>\n%s\n</script>\n", join( "\n\n", $data ) );
        }
    }
    
    
    public function add_inline_style( $data = '' ) {
        if( ! empty( $data ) ) {
            $this->_inline_styles[] = $data;  
        }
    }
    
    
    private function get_inline_styles() {
        $data = $this->_inline_styles;
        if( ! empty( $data ) ) {
            return sprintf( "\n<style>\n%s\n</style>\n", join( "\n\n", $data ) );
        }
    }
    

	/**
	 * Add block render attributes.
	 *
	 * Used to add render attributes to the block block.
	 *
	 * @since 1.3.0
	 * @access protected
	 */
	protected function _add_render_attributes() {
                        
        $this->add_render_attribute(
            'block', 'class', [
                'acf-block'
             ]
        );
        
        if( $this->get_name() ) {
            $this->add_render_attribute(
                'block', 'class', [
                    'acf-block-' .$this->get_name()
                 ]
            );
        }
        
        if( is_admin() ) {

			if( $this->is_empty() ) {
				$this->add_render_attribute(
					'block', 'class', [
						'acf-block-placeholder'
					 ]
				);
			}

            return;
        }
        
        if( ! empty( $this->_block['className'] ) ) {       
            $this->add_render_attribute(
                'block', 'class', [
                    $this->_block['className']
                 ]
            );
        }
                
        if( $this->get_block_index() ) {
            $this->add_render_attribute(
            'block', 'class', [
                'acf-block-' . $this->get_block_index()
             ]
            );
                        
            $even_odd = $this->get_block_index() % 2 ? 'odd' : 'even';
            
            $this->add_render_attribute(
            'block', 'class', [
                'acf-block-' . $even_odd
             ]
            );
        }
        
        if( $this->is_first_block() ) {
            $this->add_render_attribute(
            'block', 'class', [
                'acf-block-first'
             ]
            );
        }
        
        if( $this->is_last_block() ) {
            $this->add_render_attribute(
            'block', 'class', [
                'acf-block-last'
             ]
            );
        }
        
        if( ! empty( $this->_block['align'] ) ) {  
			
			$align = ltrim( $this->_block['align'], 'align' );

            $this->add_render_attribute(
                'block', 'class', [
                    'align' . $this->_block['align']
                 ]
            );
        }
        
        if( $this->get_anchor() ) {
            $this->add_render_attribute(
                'block', 'id', [
                    $this->get_anchor()
                ]
            );
        } else {
            $this->add_render_attribute(
                'block', 'id', [
                    $this->get_id()
                ]
            );
        }
        
		
	}
    
    
    /**
	 * Get default arguments.
	 *
	 * Retrieve the element default arguments. Used to return all the default
	 * arguments or a specific default argument, if one is set.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $item Optional. Default is null.
	 *
	 * @return array Default argument(s).
	 */
	public function get_default_args( $item = null ) {
		return self::_get_items( $this->_default_args, $item );
	}

	/**
	 * Add render attribute.
	 *
	 * Used to add render attribute to specific HTML elements.
	 *
	 * Example usage:
	 *
	 * `$this->add_render_attribute( 'block', 'class', 'custom-widget-block-class' );`
	 * `$this->add_render_attribute( 'widget', 'id', 'custom-widget-id' );
	 * `$this->add_render_attribute( 'button', [ 'class' => 'custom-button-class', 'id' => 'custom-button-id' ] );
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array|string $element   The HTML element.
	 * @param array|string $key       Optional. Attribute key. Default is null.
	 * @param array|string $value     Optional. Attribute value. Default is null.
	 * @param bool         $overwrite Optional. Whether to overwrite existing
	 *                                attribute. Default is false, not to overwrite.
	 *
	 * @return Element_Base Current instance of the element.
	 */
	public function add_render_attribute( $element, $key = null, $value = null, $overwrite = false ) {
		if ( is_array( $element ) ) {
			foreach ( $element as $element_key => $attributes ) {
				$this->add_render_attribute( $element_key, $attributes, null, $overwrite );
			}

			return $this;
		}

		if ( is_array( $key ) ) {
			foreach ( $key as $attribute_key => $attributes ) {
				$this->add_render_attribute( $element, $attribute_key, $attributes, $overwrite );
			}

			return $this;
		}

		if ( empty( $this->_render_attributes[ $element ][ $key ] ) ) {
			$this->_render_attributes[ $element ][ $key ] = [];
		}

		settype( $value, 'array' );

		if ( $overwrite ) {
			$this->_render_attributes[ $element ][ $key ] = $value;
		} else {
			$this->_render_attributes[ $element ][ $key ] = array_merge( $this->_render_attributes[ $element ][ $key ], $value );
		}

		return $this;
	}

	/**
	 * Set render attribute.
	 *
	 * Used to set the value of the HTML element render attribute or to update
	 * an existing render attribute.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array|string $element The HTML element.
	 * @param array|string $key     Optional. Attribute key. Default is null.
	 * @param array|string $value   Optional. Attribute value. Default is null.
	 *
	 * @return Element_Base Current instance of the element.
	 */
	public function set_render_attribute( $element, $key = null, $value = null ) {
		return $this->add_render_attribute( $element, $key, $value, true );
	}

	/**
	 * Get render attribute string.
	 *
	 * Used to retrieve the value of the render attribute.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array|string $element The element.
	 *
	 * @return string Render attribute string, or an empty string if the attribute
	 *                is empty or not exist.
	 */
	public function get_render_attribute_string( $element ) {
		if ( empty( $this->_render_attributes[ $element ] ) ) {
			return '';
		}

		$render_attributes = $this->_render_attributes[ $element ];

		$attributes = [];

		foreach ( $render_attributes as $attribute_key => $attribute_values ) {
			$attributes[] = sprintf( '%1$s="%2$s"', $attribute_key, esc_attr( implode( ' ', $attribute_values ) ) );
		}

		return implode( ' ', $attributes );
	}

	public function print_render_attribute_string( $element ) {
		echo $this->get_render_attribute_string( $element ); // XSS ok.
	}
    
    /**
	 * Get the element raw data.
	 *
	 * Retrieve the raw element data, including the id, type, settings, child
	 * elements and whether it is an inner element.
	 *
	 * The data with the HTML used always to display the data, but the
	 * editor uses the raw data without the HTML in order not to render the data
	 * again.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 *
	 * @return array Element raw data.
	 */
	public function get_raw_data() {
		$data = $this->get_data();

		return [
			'id' => $this->get_id(),
			'settings' => $data['settings'],
            'fields' => $data['fields'],
		];
	}

	/**
	 * Set HTML tag.
	 *
	 * Set block HTML tag.
	 *
	 * @since 1.5.3
	 * @access private
	 *
	 * @return string Block HTML tag.
	 */
	public function set_html_tag( $tag = 'section' ) {
	
		if( $tag ) {
            $this->html_tag = $tag;
        }

	}
    
    
    /**
	 * Get HTML tag.
	 *
	 * Retrieve the block HTML tag.
	 *
	 * @since 1.5.3
	 * @access private
	 *
	 * @return string Block HTML tag.
	 */
	public function get_html_tag() {
	
		return $this->html_tag;
	}
            
}
