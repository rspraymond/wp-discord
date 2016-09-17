<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
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
class WP_Discord_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
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
     * @since 1.0.0
     */
    public function admin_options()
    {
        $file_path = plugin_dir_url(__FILE__) . '/partials/wp-discord-admin-display.php';
        $page_builder = New AdminPageBuilder($file_path);
        $page_builder->title = 'WP Discord Options';
        $page_builder->form_action = '';

        $page_builder->render();
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wp-discord-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wp-discord-admin.js', array('jquery'), $this->version, false);
    }

}
