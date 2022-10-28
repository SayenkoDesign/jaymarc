<?php
// FacetWP

add_filter('facetwp_preload_url_vars', function ($url_vars) {
    if ('about' == FWP()->helper->get_uri()) {
        if (empty($url_vars['department'])) {
            $url_vars['department'] = array('leadership');
        }
    }
    return $url_vars;
});



function fwp_add_facet_labels()
{
?>
    <script>
        (function($) {
            $(document).on('facetwp-loaded', function() {
                $('.facetwp-facet').each(function() {
                    var facet_name = $(this).attr('data-name');
                    var facet_label = FWP.settings.labels[facet_name];
                    if ($('.facet-label[data-for="' + facet_name + '"]').length < 1) {
                        $(this).before('<div class="facet-label" data-for="' + facet_name + '">' + facet_label + '</div>');
                    }
                });
            });
        })(jQuery);
    </script>
<?php
}
add_action('wp_head', 'fwp_add_facet_labels', 100);



add_filter('facetwp_index_row', function ($params, $class) {
    if ( in_array( $params['facet_name'], [ 'beds', 'baths' ] ) ) {
        $params['facet_value'] = floor($params['facet_value']);
        $params['facet_display_value'] = sprintf( '%d %s', floor($params['facet_display_value'] ), ucwords( $params['facet_name'] ) );
    }
    return $params;
}, 10, 2);
