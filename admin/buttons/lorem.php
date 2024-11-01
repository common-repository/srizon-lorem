<?php
add_action( 'admin_head', 'srzfb_add_lorem_button' );

function srzfb_add_lorem_button() {
	global $typenow;
	// check user permissions
	if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
		return;
	}
	// verify the post type
	if ( ! in_array( $typenow, array( 'post', 'page' ) ) ) {
		return;
	}
	// check if WYSIWYG is enabled
	if ( get_user_option( 'rich_editing' ) == 'true' ) {
		add_filter( "mce_external_plugins", "srzfb_lorem_add_tinymce_plugin" );
		add_filter( 'mce_buttons', 'srzfb_lorem_register_button' );
	}
}

function srzfb_lorem_add_tinymce_plugin($plugin_array) {
	$plugin_array['srizon_lorem_button'] = WP_PLUGIN_URL . '/srizon-lorem/resources/js/button-lorem.js';

	return $plugin_array;
}

function srzfb_lorem_register_button( $buttons ) {
	array_push( $buttons, "srizon_lorem_button" );

	return $buttons;
}

function srizon_lorem_script() {
	wp_enqueue_style( 'srizonlorem', WP_PLUGIN_URL . '/srizon-lorem/resources/css/button-lorem.css', null, '1.0' );
}

add_action( 'admin_print_scripts-post-new.php', 'srizon_lorem_script', 11 );
add_action( 'admin_print_scripts-post.php', 'srizon_lorem_script', 11 );
