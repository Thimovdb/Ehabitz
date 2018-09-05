<?php
if ( ! defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

/**
 * Moove_Functions File Doc Comment
 *
 * @category Moove_Functions
 * @package   moove-gdpr-tracking
 * @author    Gaspar Nemes
 */
function moove_gdpr_get_plugin_directory_url() {
	return plugin_dir_url( __FILE__ );
}

add_filter( 'plugin_action_links', 'moove_gdpr_plugin_settings_link', 10, 2 );

function moove_gdpr_plugin_settings_link( $links, $file ) {
	if ( plugin_basename( dirname( __FILE__ ) . '/moove-gdpr.php' ) === $file ) {
		/*
         * Insert the settings page link at the beginning
         */
		$in = '<a href="options-general.php?page=moove-gdpr">' . __( 'Settings','moove-gdpr' ) . '</a>';
		array_unshift( $links, $in );

	}
	return $links;
}

/**
 * Get an attachment ID given a URL.
 * 
 * @param string $url
 *
 * @return int Attachment ID on success, 0 on failure
 */
function gdpr_get_attachment_id( $url ) {

    $attachment_id = 0;

    $dir = wp_upload_dir();

    if ( false !== strpos( $url, $dir['baseurl'] . '/' ) ) { // Is URL in uploads directory?

        $file = basename( $url );

        $query_args = array(
            'post_type'   => 'attachment',
            'post_status' => 'inherit',
            'fields'      => 'ids',
            'meta_query'  => array(
                array(
                    'value'   => $file,
                    'compare' => 'LIKE',
                    'key'     => '_wp_attachment_metadata',
                ),
            )
        );

        $query = new WP_Query( $query_args );

        if ( $query->have_posts() ) {

            foreach ( $query->posts as $post_id ) {

                $meta = wp_get_attachment_metadata( $post_id );

                $original_file       = basename( $meta['file'] );
                $cropped_image_files = wp_list_pluck( $meta['sizes'], 'file' );

                if ( $original_file === $file || in_array( $file, $cropped_image_files ) ) {
                    $attachment_id = $post_id;
                    break;
                }

            }

        }

    }

    return $attachment_id;
}

/**
 * Get image alt text by image URL
 *
 * @param String $image_url
 *
 * @return Bool | String
 */
function gdpr_get_logo_alt( $image_url ) {

    global $wpdb;

    if ( empty( $image_url ) ) {
        return get_bloginfo('name');
    }
    $image_id   = gdpr_get_attachment_id( $image_url );
    if ( $image_id ) :
    	$image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
    	return $image_alt;
    else :
    	return get_bloginfo('name');
    endif;

}