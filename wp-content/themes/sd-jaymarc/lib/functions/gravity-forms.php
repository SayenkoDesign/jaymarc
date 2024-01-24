<?php
// Gravity Forms
function _s_get_dropdown_posts( $post_type = false ) {
    
    if( empty( $post_type ) || ! post_type_exists( $post_type ) ) {
        return false;
    }
    
    // arguments, adjust as needed
	$args = array(
		'post_type'      => $post_type,
		'posts_per_page' => 100,
		'post_status'    => 'publish',
        'order'          => 'ASC',
        'orderby'        => 'title'
	);

	// Use $loop, a custom variable we made up, so it doesn't overwrite anything
	$loop = new WP_Query( $args );
    
    $list = [];

	// have_posts() is a wrapper function for $wp_query->have_posts(). Since we
	// don't want to use $wp_query, use our custom variable instead.
	if ( $loop->have_posts() ) : 
		while ( $loop->have_posts() ) : $loop->the_post(); 

			$list[] = get_the_title();

		endwhile;
	endif;

	// We only need to reset the $post variable. If we overwrote $wp_query,
	// we'd need to use wp_reset_query() which does both.
	wp_reset_postdata();
    
    return $list;   
}


add_filter( 'gform_form_post_get_meta_3', 'populate_homes' );
function populate_homes( $form ) {

    if( is_admin() ) {
        return $form;
    }
 
    foreach ( $form['fields'] as &$field ) {
         
        $field_id = 6;
        if ( $field->id != $field_id ) {
            continue;
        }
                        
        $rows = _s_get_dropdown_posts( 'home' );
         
        $choices = array();
 
        foreach ( $rows as $id => $title ) {
            $choices[] = array( 'text' => $title, 'value' => $id );
        }
 
        $field->choices = $choices;
 
    }
 
    return $form;
}


add_filter( 'gform_form_post_get_meta_4', 'populate_plan' );
function populate_plan( $form ) {

    if( is_admin() ) {
        return $form;
    }
 
    foreach ( $form['fields'] as &$field ) {
         
        $field_id = 6;
        if ( $field->id != $field_id ) {
            continue;
        }
                        
        $rows = _s_get_dropdown_posts( 'plan' );
         
        $choices = array();
 
        foreach ( $rows as $id => $title ) {
            $choices[] = array( 'text' => $title, 'value' => $id );
        }
 
        $field->choices = $choices;
 
    }
 
    return $form;
}


add_filter( 'gform_form_post_get_meta_2', 'populate_job' );
function populate_job( $form ) {

    if( is_admin() ) {
        return $form;
    }
 
    foreach ( $form['fields'] as &$field ) {
         
        $field_id = 6;
        if ( $field->id != $field_id ) {
            continue;
        }
                        
        $rows = _s_get_dropdown_posts( 'job' );
         
        $choices = array();
 
        foreach ( $rows as $id => $title ) {
            $choices[] = array( 'text' => $title, 'value' => $id );
        }
 
        $field->choices = $choices;
 
    }
 
    return $form;
}