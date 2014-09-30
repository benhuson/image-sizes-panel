<?php

/**
 * Image Sizes Panel Admin Class
 * 
 * @package Image Sizes Panel
 * @since 0.1
 */

// Actions
add_action( 'admin_head', array( 'Image_Sizes_Panel_Admin', 'admin_enqueue_scripts' ) );
add_action( 'add_meta_boxes', array( 'Image_Sizes_Panel_Admin', 'add_image_sizes_meta_box' ) );

class Image_Sizes_Panel_Admin {

	/**
	 * Admin Styles
	 */
	public static function admin_enqueue_scripts() {

		$screen = get_current_screen();

		if ( 'post' == $screen->base && 'attachment' == $screen->id ) {

			?>

			<style>

			#image_sizes_panel table {
				width: 100%;
			}

			#image_sizes_panel table th,
			#image_sizes_panel table td {
				font-weight: normal;
				text-align: left;
				vertical-align: top;
			}

			#image_sizes_panel table td {
				text-align: right;
			}

			</style>

			<?php

		}

	}

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

			echo '<table>';
			foreach ( $metadata['sizes'] as $size => $data ) {
				$src = wp_get_attachment_image_src( $post->ID, $size );
				echo '<tr><th><a href="' . $src[0] . '" target="images_sizes_panel">' . $size . '</a></th><td>' . $data['width'] . ' &times ' . $data['height'] . '</td></tr>';
			}
			echo '</table>';

		} else {

			echo '<p>No image sizes</p>';

		}

	}

}
