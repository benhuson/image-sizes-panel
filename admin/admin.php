<?php

/**
 * Image Sizes Panel Admin Class
 * 
 * @package Image Sizes Panel
 * @since 0.1
 */

// Actions
add_action( 'add_meta_boxes', array( 'Image_Sizes_Panel_Admin', 'add_image_sizes_meta_box' ) );

class Image_Sizes_Panel_Admin {

	/**
	 * Add Image Sizes Meta Box
	 */
	public static function add_image_sizes_meta_box() {

		add_meta_box(
			'image_sizes_panel',
			__( 'Image Sizes', IMAGE_SIZES_PANEL_TEXTDOMAIN ),
			array( 'Image_Sizes_Panel_Admin', 'image_sizes_meta_box' ),
			'attachment',
			'side'
		);

	}

	/**
	 * Image Sizes Meta Box
	 *
	 * @param  object  $post  Post.
	 */
	public static function image_sizes_meta_box( $post ) {

		$metadata = wp_get_attachment_metadata( $post->ID );

		if ( isset( $metadata['sizes'] ) && count( $metadata['sizes'] ) > 0 ) {

			echo '<table style="width: 100%;">';
			foreach ( $metadata['sizes'] as $size => $data ) {
				$src = wp_get_attachment_image_src( $post->ID, $size );
				echo '<tr><th style="text-align: left;"><a href="' . $src[0] . '" target="images_sizes_panel">' . $size . '</a></th><td>' . $data['width'] . ' &times ' . $data['height'] . '</td></tr>';
			}
			echo '</table>';

		} else {

			echo '<p>No image sizes</p>';

		}

	}

}
