<?php

/**
 * WP Discord bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wordpress.org/plugins/wp-discord/
 * @since             0.1.0
 * @package           WP_Discord
 *
 * @wordpress-plugin
 * Plugin Name:       WP Discord
 * Plugin URI:        https://wordpress.org/plugins/wp-discord/
 * Description:       Wordpress plugin to integrate discord into your wordpress sites. Currently supports discord widget, and basic channel posting.
 * Version:           0.3.6
 * Author:            Raymond Perez
 * Author URI:        http://rayperez.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-discord
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

$php_version = floatval(phpversion());

if ($php_version < 5.4) {
    trigger_error(__('You are using an unsupported version of PHP. PHP version 5.4 or greater required to use this plugin.', 'wp-discord'), E_USER_ERROR);
}

if (!defined('WPD_PREFIX')) {
    define('WPD_PREFIX', 'wpd_');
}

if (!defined('WPD_URI')) {
    define('WPD_URI', plugin_dir_url(__FILE__));
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-discord-activator.php
 */
function activate_wp_discord()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-wp-discord-activator.php';
    WP_Discord_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-discord-deactivator.php
 */
function deactivate_wp_discord()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-wp-discord-deactivator.php';
    WP_Discord_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_wp_discord');
register_deactivation_hook(__FILE__, 'deactivate_wp_discord');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require_once plugin_dir_path(__FILE__) . 'includes/class-wp-discord.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-discord-api-wrapper.php';
require plugin_dir_path(__FILE__) . 'includes/class-wp-discord-guild.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.1.0
 */
function run_wp_discord()
{
    $plugin = new WP_Discord();
    $plugin->run();
}

run_wp_discord();
