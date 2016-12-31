<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://wpdiscord.com
 * @since      0.1.0
 *
 * @package    WP_Discord
 * @subpackage WP_Discord/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      0.1.0
 * @package    WP_Discord
 * @subpackage WP_Discord/includes
 * @author     Raymond Perez <ray@rayperez.com>
 */
class WP_Discord_i18n
{


    /**
     * Load the plugin text domain for translation.
     *
     * @since    0.1.0
     */
    public function load_plugin_textdomain()
    {
        load_plugin_textdomain(
            'wp-discord',
            false,
            dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        );
    }
}
