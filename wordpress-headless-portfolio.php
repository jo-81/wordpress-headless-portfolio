<?php
/**
 * Plugin Name:       Portfolio Headless
 * Plugin URI:        https://github.com/jo-81/wordpress-headless-portfolio
 * Description:       API REST WordPress headless pour le portfolio Astro.js.
 *                    Expose les articles, projets, commentaires et options.
 * Version:           1.0.0
 * Requires at least: 6.4
 * Requires PHP:      8.1
 * Author:            Geoffroy Colpart
 * License:           MIT
 * Text Domain:       portfolio-headless
 * Domain Path:       /languages
 *
 * @package           Portfolio_Headless
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PORTFOLIO_VERSION', '1.0.0' );
define( 'PORTFOLIO_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'PORTFOLIO_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once PORTFOLIO_PLUGIN_DIR . 'vendor/autoload.php';

// Démarrage du plugin
add_action('plugins_loaded', static function (): void {
    \PortfolioHeadless\Plugin::get_instance()->run();
});