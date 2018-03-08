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

    public $tabs = array('discord', 'settings');
    public $guild = null;
    public $errors = array();

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
        $this->set_guild();
    }

    /**
     * Add Admin Menu Items
     */
    public function admin_menu()
    {
        $display_name = 'WP Discord';
        add_menu_page($display_name, $display_name, 'manage_options', $this->plugin_name, array($this, 'admin_options'), plugin_dir_url(__FILE__) . '../assets/icon-16x16.png');
    }

    /**
     * Display Options Page
     *
     * @since 0.1.0
     */
    public function admin_options()
    {
        $notices = array();

        if (isset($_GET['tab'])) {
            $active_tab = $_GET['tab'];
        } else {
            $active_tab = 'discord';
        }

        if (isset($_GET['success'])) {
            $notices[] = array(
                'class' => 'notice-success',
                'message' => ucfirst(str_replace('_', ' ', $_GET['success']))
            );
        }

        if (isset($_GET['errors'])) {
            $errors = explode('&', $_GET['errors']);

            foreach ($errors as $error) {
                $notices[] = array(
                    'class' => 'notice-error',
                    'message' => ucfirst(str_replace('_', ' ', $error))
                );
            }
        }

        $title = 'WP Discord Options';

        $tabs = $this->get_tabs();

        include 'partials/wp-discord-admin-display.php';
    }

    /**
     * Check that guild is configured.
     *
     * @since    0.4.1
     */
    public function config_check()
    {
        if (current_user_can('manage_options') && $this->guild->get_channels() == false) {
            ?>
            <div class="notice notice-warning">
                <p><?php
                    _e('WP Discord is not configured Properly.', 'wp-discord');
            echo ' <a href="' . menu_page_url('wp-discord', false) . '">';
            _e('Configure', 'wp-discord');
            echo '</a>'; ?></p>
            </div>
            <?php
        }
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

    /**
     * Grab admin setting stabs.
     *
     * @since 0.3.0
     * @return array
     */
    public function get_tabs()
    {
        $tabs = array();
        $args = array(
            'public' => true,
        );

        $post_types = get_post_types($args, 'objects');
        $banned_types = array('attachment', 'nav_menu_item', 'revision');

        //cleanup
        foreach ($post_types as $key => $type) {
            if (in_array($type->name, $banned_types)) {
                unset($post_types[$key]);
            }
        }

        foreach ($this->tabs as $tab_name) {
            $settings_tab = new SettingsTab($tab_name, array('post_types' => $post_types));
            switch ($tab_name) {
                case 'discord':
                    $settings_tab->guild_id = get_option(WPD_PREFIX . 'guild_id');
                    $settings_tab->client_id = get_option(WPD_PREFIX . 'client_id');
                    $settings_tab->auth_token = get_option(WPD_PREFIX . 'auth_token');
                    $settings_tab->auth_link = 'https://discordapp.com/oauth2/authorize?client_id=' . $settings_tab->client_id . '&scope=bot&permissions=0x20000000';
                    break;
                case 'settings':
                    $settings_tab->channels = $this->guild->get_channels(0);
                    break;
            }

            $tabs[$tab_name] = $settings_tab;
        }

        return $tabs;
    }

    /**
     * Register events for when a post has been published
     * @param $new_status
     * @param $old_status
     * @param $post
     *
     * @since    0.3.0
     */
    public function post_published_event($new_status, $old_status, $post)
    {

        // Only post to discord when a post switches from unpublished to published.
        $alreadyposted = get_post_meta($post->ID, 'wpdiscord_posted', true);

        if ($old_status == 'publish' || $new_status != 'publish' || $alreadyposted) {
            return true;
        }

        $webhook = $this->guild->get_post_type_webhook($post->post_type);

        // If we do not get a webhook back. No need to try and post to Discord.
        if (empty($webhook)) {
            return true;
        }

        if (empty($post->post_excerpt)) {
            $description = strip_tags(substr($post->post_content, 0, 150)) . '...';
        } else {
            $description = $post->post_excerpt;
        }

        $content = array(
            'embeds' => array(
                array(
                    'title' => $post->post_title,
                    'url' => get_permalink($post),
                    'type' => 'rich',
                    //'timestamp' => date(DATE_ATOM, strtotime($post->post_modified_gmt)),
                    'description' => $description,
                    /*'author' => [
                        'name' => '',
                        'url' => '',
                        'icon_url' => ''
                    ]*/
                )
            )
        );

        $webhook->post_content($content);
        update_post_meta($post->ID, 'wpdiscord_posted', 'true');
    }

    public function register_shortcodes()
    {
        $shortcodes = new WP_Discord_Shortcodes();
        $shortcodes->generate();
    }

    public function register_widgets()
    {
        register_widget('WP_Discord_Follow_Widget');
    }

    /**
     * Save admin settings.
     *
     * @since    0.3.0
     */
    public function save_settings()
    {
        // Handle request then generate response using echo or leaving PHP and using HTML
        check_admin_referer(WPD_PREFIX . 'save_settings');

        $settings = $_POST;
        $url = parse_url($settings['_wp_http_referer']);
        $redirect_url = $url['path'];
        $query = array();
        parse_str($url['query'], $query);

        $redirect_url .= '?page=' . $query['page'];

        $this->validate_settings($settings);

        if (!empty($this->errors)) {
            $redirect_url .= '&errors=';

            foreach ($this->errors as $error) {
                $redirect_url .= urlencode($error) . '&';
            }

            wp_redirect(rtrim($redirect_url, '&'));
            exit;
        }

        foreach ($settings as $key => $value) {
            // Handle settings
            update_option($key, trim($value));
        }

        $redirect_url .= '&success=settings_updated';

        wp_redirect($redirect_url);
        exit;
    }

    /**
     * Setup Discord Guild.
     *
     * @since    0.3.0
     */
    private function set_guild()
    {
        $server_id = get_option(WPD_PREFIX . 'guild_id');
        $auth_token = get_option(WPD_PREFIX . 'auth_token');
        $this->guild = new WP_Discord_Guild($server_id, $auth_token);
    }

    /**
     * Validate settings
     * @param array $options
     *
     * @since 0.3.7
     */
    public function validate_settings(array $options)
    {
        $validation = array(
            'snowflake' => array('wpd_guild_id' => 'Server ID', 'wpd_client_id' => 'Client ID'),
            'string' => array('wpd_auth_token' => 'Bot Token')
        );

        foreach ($options as $key => $value) {
            if (in_array($key, array_keys($validation['snowflake'])) && !$this->validate_snowflake($value)) {
                $this->errors[] = 'Invalid Setting: ' . $validation['snowflake'][$key];
            }

            if (in_array($key, array_keys($validation['string'])) && !is_string($value)) {
                $this->errors[] = 'Invalid Setting: ' . $validation['string'][$key];
            }
        }
    }

    /**
     * Validate snowflake.
     * @param int $value
     *
     * @since 0.3.7
     */
    public function validate_snowflake($value)
    {
        if ((is_numeric($value)) == false || $value >= 9223372036854775807) {
            return false;
        }

        return true;
    }
}
