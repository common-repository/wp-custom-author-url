<?php
/**
 * Plugin Name:     WP Custom Author URL
 * Plugin URI:      https://poodleplugins.com/
 * Description:     Choose a custom URL for your author links, instead of the standard WordPress author page.
 * Version:         2.0.2
 * Author:          Poodle Plugins
 * Author URI:      https://poodleplugins.com
 * License:         GPL-3.0+
 * License URI:     https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:     wp-custom-author-url
 * Domain Path:     /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Load plugin translations
 */
function wp_custom_author_url_load_textdomain() {
    load_plugin_textdomain(
        'wp-custom-author-url',
        false,
        dirname( plugin_basename( __FILE__ ) ) . '/languages/'
    );
}
add_action( 'plugins_loaded', 'wp_custom_author_url_load_textdomain' );

// Include the necessary files
require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-custom-author-url.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-custom-author-url-core.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-custom-author-url-settings.php';

// Create an instance of the main plugin class
$wp_custom_author_url = new Wp_Custom_Author_Url();