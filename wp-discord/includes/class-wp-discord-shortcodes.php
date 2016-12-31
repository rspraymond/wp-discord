<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

include_once(plugin_dir_path(__FILE__) . 'helpers/class-wp-doin-shortcodes-generator.php');
include_once(plugin_dir_path(__FILE__) . 'class-wp-discord-widget.php');

class WP_Discord_Shortcodes
{
    protected $generator;

    public function __construct()
    {
        $this->generator = new WP_Doin_Shortcodes_Generator();
    }

    public function generate()
    {
        $widget_shortcode_tag = 'wp-discord';
        $follow_widget = $this->generator->add_shortcode($widget_shortcode_tag, 'Follow Widget', '');
        $follow_widget->add_field('text', 'server_id', __('Server ID', 'server_id'));
        $follow_widget->add_field('select', 'theme_class', __('Theme Class', 'theme_class'), '', ['wpd-white' => 'White', 'wpd-gray' => 'Gray', 'wpd-dark' => 'Dark']);
        $follow_widget->add_field('select', 'member_count', __('How many online members would you like to display?', 'member_count'), '', ['0' => 'none', '3' => '3', '6' => '6', '9' => '9', '12' => '12', '-1' => 'All']);

        $this->generator->generate();

        //register code
        add_shortcode($widget_shortcode_tag, [$this, 'widget_render']);
    }

    public function widget_render($args)
    {
        $params = shortcode_atts([
            'server_id' => null,
            'theme_class' => 'wpd-white',
            'show_members' => false,
            'member_count' => 0,
        ], $args);

        $feed = WP_Discord_Follow_Widget::widget_feed($params['server_id']);

        if ($params['show_members'] == true) {
            //legacy
            $member_count = 3;
        } else {
            $member_count = $params['member_count'];
        }

        return WP_Discord_Follow_Widget::render_widget($feed, $params['theme_class'], $member_count);
    }
}
