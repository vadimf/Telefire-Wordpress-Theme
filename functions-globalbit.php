<?php

wp_enqueue_style ('globalbit', get_template_directory_uri().'/assets/css/globalbit.css');

function custom_shortcode_atts_wpcf7_filter( $out, $pairs, $atts ) {
    $additionalFields = [
        'page-name',
        'event-name',
        'event-date'
    ];

    foreach ($additionalFields as $my_attr) {
        if (isset($atts[$my_attr])) {
            $out[$my_attr] = $atts[$my_attr];
        }
    }

    return $out;
}
add_filter( 'shortcode_atts_wpcf7', 'custom_shortcode_atts_wpcf7_filter', 10, 3 );

function get_post_query_by_slug( $slug, $post_type = "post" ) {
    return new WP_Query(
        array(
            'name'   => $slug,
            'post_type'   => $post_type,
            'numberposts' => 1,
        ) );
}

add_filter('upload_mimes', 'my_myme_types', 1, 1);
function my_myme_types($mime_types) {
    $revitFileExtensions = [
        'rvt',
        'rfa',
        'rte',
        'rft'
    ];

    foreach ($revitFileExtensions as $fileExtension) {
        $mime_types[$fileExtension] = 'application/octet-stream';
    }

    return $mime_types;
}

add_action('admin_head', 'my_custom_fonts');
function my_custom_fonts() {
    echo <<<EOF
<style type="text/css">
    .ui-datepicker-rtl,
    .ui-timepicker-rtl {
        direction: ltr !important;
    }
</style>
EOF;
}
