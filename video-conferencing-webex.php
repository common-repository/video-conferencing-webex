<?php
/**
 * Plugin Name:       Video Conferencing with Webex
 * Plugin URI:        https://wordpress.org/plugins/video-conferencing-webex
 * Description:       Enables you to visually collaborate, create, edit, delete and align your Webex meeting schedules directly from your WordPress dashboard.
 * Version:           1.1.6
 * Author:            codemanas
 * Author URI:        https://codemanas.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       video-conferencing-webex
 * Domain Path:       /languages
 * Requires at least: 6.0
 * Requires PHP:      7.4
 */

defined( 'VCW_ABS_NAME' ) || define( 'VCW_ABS_NAME', plugin_basename( __FILE__ ) );
defined( 'VCW_SLUG' ) || define( 'VCW_SLUG', 'video-conferencing-webex' );
defined( 'VCW_DIR_PATH' ) || define( 'VCW_DIR_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
defined( 'VCW_DIR_URI' ) || define( 'VCW_DIR_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );
defined( 'VCW_DIR_CORE' ) || define( 'VCW_DIR_CORE', VCW_DIR_PATH . 'core/' );
defined( 'VCW_DIR_INCLUDES' ) || define( 'VCW_DIR_INCLUDES', VCW_DIR_PATH . 'includes/' );
defined( 'VCW_DIR_ASSETS_URI' ) || define( 'VCW_DIR_ASSETS_URI', VCW_DIR_URI . 'assets/' );
defined( 'VCW_DIR_DIST_URI' ) || define( 'VCW_DIR_DIST_URI', VCW_DIR_URI . 'public/' );
defined( 'VCW_DIR_DIST_VENDORS_URI' ) || define( 'VCW_DIR_DIST_VENDORS_URI', VCW_DIR_URI . 'public/vendors/' );
defined( 'VCW_VERSION' ) || define( 'VCW_VERSION', '1.1.6' );

include VCW_DIR_PATH . '/vendor/autoload.php';
require VCW_DIR_INCLUDES . 'dependencies.php';
require VCW_DIR_CORE . 'Kernel.php';

register_activation_hook( __FILE__, 'Codemanas\Webex\Core\Kernel::activate' );
register_deactivation_hook( __FILE__, 'Codemanas\Webex\Core\Kernel::deactivate' );