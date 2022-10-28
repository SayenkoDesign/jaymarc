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


function _s_gf_populate_dropdown( $form, $class ) {
     
    
    
    foreach ( $form['fields'] as &$field ) {
         
        if ( strpos( $field->cssClass, $class ) === false ) {
            continue;
        }
                
        $post_type = str_replace( 'populate_', '', $class );
        
        $rows = _s_get_dropdown_posts( $post_type );
         
        $choices = array();
 
        foreach ( $rows as $row ) {
            $choices[] = array( 'text' => $row, 'value' => $row );
        }
 
        // update 'Select a Post' to whatever you'd like the instructive option to be
        // $field->placeholder = 'Select a Location';
        $field->choices = $choices;
 
    }
 
    return $form;
}

// $('#fund option:contains(' + splitGift + ')').attr("selected", true);

function _s_gf_populate_jobs( $form ) {
    return _s_gf_populate_dropdown( $form, 'populate_job' );
}

add_filter( 'gform_pre_render', '_s_gf_populate_jobs' );
add_filter( 'gform_pre_validation', '_s_gf_populate_jobs' );
add_filter( 'gform_pre_submission_filter', '_s_gf_populate_jobs' );
add_filter( 'gform_admin_pre_render', '_s_gf_populate_jobs' );


function _s_gf_populate_homes( $form ) {
    return _s_gf_populate_dropdown( $form, 'populate_home' );
}

add_filter( 'gform_pre_render', '_s_gf_populate_homes' );
add_filter( 'gform_pre_validation', '_s_gf_populate_homes' );
add_filter( 'gform_pre_submission_filter', '_s_gf_populate_homes' );
add_filter( 'gform_admin_pre_render', '_s_gf_populate_homes' );


function _s_gf_populate_plans( $form ) {
    return _s_gf_populate_dropdown( $form, 'populate_plan' );
}

add_filter( 'gform_pre_render', '_s_gf_populate_plans' );
add_filter( 'gform_pre_validation', '_s_gf_populate_plans' );
add_filter( 'gform_pre_submission_filter', '_s_gf_populate_plans' );
add_filter( 'gform_admin_pre_render', '_s_gf_populate_plans' );