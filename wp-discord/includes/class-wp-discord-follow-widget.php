<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

include_once(plugin_dir_path(__FILE__) . 'helpers/class-whp-widget.php');

class WP_Discord_Follow_Widget extends WPH_Widget
{
    public function __construct()
    {
        $args = [
            'label' => __('Discord Widget', 'wp-discord-widget'),
            'description' => __('Show who is online for your server.', 'wp-discord-widget'),
            'fields' => [
                // ID Field
                [
                    'name' => __('Server ID', 'wp-discord-widget'),
                    'desc' => __('Go to Server Settings -> Widget to get your Server ID.', 'wp-discord-widget'),
                    'id' => 'wp-discord-server-id',
                    'type' => 'text',
                    'class' => 'widefat',
                    'std' => __('Discord Server', 'wp-discord-widgets'),
                    'validate' => 'numeric',
                    'filter' => 'strip_tags|esc_attr'
                ],
                // Theme Field
                [
                    'name' => __('Color Theme', 'wp-discord-widget'),
                    'desc' => __('Select Color Theme', 'wp-discord-widget'),
                    'id' => 'wp-discord-theme',
                    'type' => 'select',
                    'class' => 'widefat',
                    'fields' => [
                        [
                            'name' => __('White', 'wp-discord-widget'),
                            'value' => 'wpd-white'
                        ],
                        [
                            'name' => __('Dark', 'wp-discord-widget'),
                            'value' => 'wpd-dark'
                        ],
                        [
                            'name' => __('Gray', 'wp-discord-widget'),
                            'value' => 'wpd-gray'
                        ],
                    ],
                    'filter' => 'strip_tags|esc_attr'
                ],
                [
                    'name' => __('Show Members', 'wp-discord-widgets'),
                    'desc' => __('Displays online members inside widget.', 'wp-discord-widgets'),
                    'id' => 'wp-discord-show-members',
                    'type' => 'checkbox',
                    'std' => 1, // 0 or 1
                    'filter' => 'strip_tags|esc_attr',
                ],
            ]
        ];

        $this->create_widget($args);
    }

    public function filter_bots($members)
    {
        $real_users = [];

        foreach ($members as $member) {
            //Not Bots!
            if ((isset($member->bot) && $member->bot == true) == false) {
                $real_users[] = $member;
            }
        }

        return $real_users;
    }

    // Output function
    public function widget($args, $instance)
    {

        $server_id = $instance['wp-discord-server-id'];
        $theme_class = $instance['wp-discord-theme'];
        $show_members = $instance['wp-discord-show-members'];
        $widget_object = $this->widget_feed($server_id);

        if (is_object($widget_object) && !empty($widget_object)) {
            $server_title = $widget_object->name;
            $users_online = $this->filter_bots($widget_object->members);
            $invite_url = $widget_object->instant_invite;
            $img_path = plugin_dir_url(__FILE__) . '../public/img';

            $output = '<div id="wp-discord" class="' . $theme_class . '">' . PHP_EOL;
            $output .= '<div class="wpd-head">' . PHP_EOL;
            $output .= '<img src="' . $img_path . '/icon.png" class="wpd-icon">' . PHP_EOL;
            $output .= '<img src="' . $img_path . '/discord.png" class="wpd-name">' . PHP_EOL;
            $output .= '<h3>' . $server_title . '</h3>' . PHP_EOL;
            $output .= '</div>' . PHP_EOL;
            $output .= '<div class="wpd-info">' . PHP_EOL;
            $output .= '<span><strong>' . count($users_online) . '</strong> User(s) Online</span>' . PHP_EOL;
            $output .= '<a href="' . $invite_url . '" target="_blank">Join Server</a>' . PHP_EOL;

            if ($show_members == true && count($users_online) > 0) {
                $user_counter = 0;
                $output .= '<ul class="wpd-users">';

                foreach ($users_online as $user) {
                    $user_counter++;
                    $output .= '<li><img src="' . str_replace('https://', '//', $user->avatar_url) . '"><strong>' . $user->username . '</strong><span class="wpd-status ' . $user->status . '"></span></li>';

                    if ($user_counter >= 3) {
                        break;
                    }
                }

                $output .= '</ul>';
            }

            $output .= '</div>' . PHP_EOL;
            $output .= '</div>' . PHP_EOL;

            echo $output;
        }
    }

    public function widget_feed($server_id)
    {
        $url = 'https://discordapp.com/api/servers/' . trim($server_id) . '/widget.json';

        // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, $url);

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $output = curl_exec($ch);

        // close curl resource to free up system resources
        curl_close($ch);

        return json_decode($output);
    }
}