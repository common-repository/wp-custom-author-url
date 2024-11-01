<?php
/**
 * WP Custom Author URL Core class
 *
 * Provides core methods for the WP Custom Author URL plugin.
 *
 * @package Wp_Custom_Author_Url
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Wp_Custom_Author_Url_Utils class
 */
class Wp_Custom_Author_Url_Core {

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;


	/**
     * Constructor
     *
     * Sets up the necessary actions for registering the plugin settings
     * and adding the settings page to the WordPress admin menu.
     */
    public function __construct() {
		
		$this->version = '2.0.2';

		add_action( 'template_redirect', array( $this, 'author_page_redirect' ) );
		add_action( 'author_link', array( $this, 'modify_author_link' ), 10, 3 );
    }

    /**
	 * This function modifies the author link, if necessary.
	 *
	 */
	public function modify_author_link( $link, $author_id, $author_nicename ) {

		// Get global custom author URL settings
		$options = get_option( 'wp_custom_author_url_global_options' );

		// Is the overide all authors set?
		if ( isset( $options['redirect_all_authors'] ) && '1' === $options['redirect_all_authors'] && strlen( $options['redirect_url'] ) ) {
			$link = esc_url( $options['redirect_url'] );

			if ( isset( $options['override_individual_authors'] ) && '1' === $options['override_individual_authors'] ) {
				return $link;
			}
		}

		// Get author options from author_id
		$author_options = get_user_meta( $author_id );
		// Check if the author has a custom url set
		if ( isset( $author_options['use_custom_author_url'] ) && 'on' === $author_options['use_custom_author_url'][0] && strlen( $author_options['custom_author_url'][0] ) ) {
			$link = esc_url( $author_options['custom_author_url'][0] );
			return $link;
		}

		return $link;

	}

	/**
	 * This function performs the redirect if the author page is directly accessed.
	 *
	 */
	public function author_page_redirect() {
		if ( is_author() ) {

			// Get author from slug
			$author         = get_user_by( 'slug', get_query_var( 'author_name' ) );
			// If using no permalinks, fall back to user id ( ?author=1 )
			if ( ! $author ) {
				$author = get_user_by( 'id', get_query_var( 'author' ) );
			}
			$author_options = get_user_meta( $author->ID );
			// Check if the author has a custom url set
			if ( isset( $author_options['use_custom_author_url'] ) && 'on' === $author_options['use_custom_author_url'][0] && strlen( $author_options['custom_author_url'][0] ) ) {
				$link = esc_url( $author_options['custom_author_url'][0] );
				wp_redirect( $link );
				exit;
			}
		}
	}

}
