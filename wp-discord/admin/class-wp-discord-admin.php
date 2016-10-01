<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://wpdiscord.com
 * @since      0.1.0
 *
 * @package    WP_Discord
 * @subpackage WP_Discord/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * @package    WP_Discord
 * @subpackage WP_Discord/admin
 * @author     Raymond Perez <ray@rayperez.com>
 */

include_once(plugin_dir_path(__FILE__) . 'class-settings-tab.php');
include_once(plugin_dir_path(__FILE__) . '../includes/class-wp-discord-widget.php');
include_once(plugin_dir_path(__FILE__) . '../includes/class-wp-discord-shortcodes.php');

class WP_Discord_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    0.1.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    0.1.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    public $tabs = ['discord', 'settings'];

    /**
     * Initialize the class and set its properties.
     *
     * @since    0.1.0
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Add Admin Menu Items
     */
    public function admin_menu()
    {
        $display_name = 'WP Discord';
        add_menu_page($display_name, $display_name, 'manage_options', $this->plugin_name, array($this, 'admin_options'), 'dashicons-admin-generic');
    }

    /**
     * Display Options Page
     *
     * @since 0.1.0
     */
    public function admin_options()
    {
        if (isset($_GET['tab'])) {
            $active_tab = $_GET['tab'];
        } else {
            $active_tab = 'discord';
        }

        $title = 'WP Discord Options';

        $tabs = $this->get_tabs();

        include 'partials/wp-discord-admin-display.php';
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    0.1.0
     */
    public function enqueue_styles()
    {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wp-discord-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    0.1.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wp-discord-admin.js', array('jquery'), $this->version, false);
    }

    public function get_tabs()
    {

        $tabs = [];

        foreach ($this->tabs as $tab_name) {
            $settings_tab = new SettingsTab($tab_name);
            $tabs[$tab_name] = $settings_tab;
        }

        return $tabs;
    }

    public function register_shortcodes()
    {
        $shortcodes = New WP_Discord_Shortcodes();
        $shortcodes->generate();
    }

    public function register_widgets()
    {
        register_widget('WP_Discord_Follow_Widget');
    }

}
