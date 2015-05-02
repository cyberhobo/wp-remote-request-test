<?php
/*
 * Plugin Name: WordPress Remote Request Test
 * Plugin URI:  https://github.com/cyberhobo/wp-remote-request-test
 * Description: A simple tool for examining the results of a WordPress wp_remote_get() call.
 * Version:     0.1.0
 * Author:      Dylan Kuhn
 * Author URI:  http://cyberhobo.net/
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * GitHub Plugin URI: cyberhobo/wp-remote-request-test
 */

DKK_Remote_Request_Test::load();

class DKK_Remote_Request_Test {

	protected static $menu_slug = 'remote-request-test';
	protected static $get_url_name = 'get_url';

	public static function load() {

		add_action( 'admin_menu', array( __CLASS__, 'action_admin_menu' ) );

	}

	public static function action_admin_menu() {

		add_submenu_page(
			'tools.php',
			'Remote Request Test',
			'Remote Request Test',
			'manage_options',
			self::$menu_slug,
			array( __CLASS__, 'page_content' )
		);

	}

	public static function page_content() {

		$get_url = '';
		if ( isset( $_POST[self::$get_url_name] ) ) {
			$get_url = esc_url_raw( $_POST[self::$get_url_name] );
			self::display_get_results( $get_url );
		}

		printf( '<h2>GET</h2>' );
		printf( '<form method="POST">' );
		printf( '<label for="%s">URL:</label>', self::$get_url_name );
		printf( '<input name="%1$s" id="%1$s" type="text" value="%2$s" />', self::$get_url_name, esc_attr( $get_url ) );
		printf( '<input type="submit" class="button" />' );
		printf( '</form>' );

	}

	public static function display_get_results( $url ) {
		printf( '<h2>GET results for %s</h2>', esc_url( $url ) );

		$results = wp_remote_get( $url );

		printf( '<textarea>%s</textarea>', json_encode( $results ) );
	}

}
