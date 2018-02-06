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
        $args = array(
            'label' => __('Discord Widget', 'wp-discord'),
            'description' => __('Show who is online for your server.', 'wp-discord'),
            'fields' => array(
                // ID Field
                array(
                    'name' => __('Server ID', 'wp-discord'),
                    'desc' => __('Go to Server Settings -> Widget to get your Server ID.', 'wp-discord'),
                    'id' => 'wp-discord-server-id',
                    'type' => 'text',
                    'class' => 'widefat',
                    'std' => __('Discord Server', 'wp-discord'),
                    'validate' => 'numeric',
                    'filter' => 'strip_tags|esc_attr'
                ),
                // Theme Field
                array(
                    'name' => __('Color Theme', 'wp-discord'),
                    'desc' => __('Select Color Theme', 'wp-discord'),
                    'id' => 'wp-discord-theme',
                    'type' => 'select',
                    'class' => 'widefat',
                    'fields' => array(
                        array(
                            'name' => __('White', 'wp-discord'),
                            'value' => 'wpd-white'
                        ),
                        array(
                            'name' => __('Dark', 'wp-discord'),
                            'value' => 'wpd-dark'
                        ),
                        array(
                            'name' => __('Gray', 'wp-discord'),
                            'value' => 'wpd-gray'
                        ),
                    ),
                    'filter' => 'strip_tags|esc_attr'
                ),
                // Member Count Field
                array(
                    'name' => __('Member Count', 'wp-discord'),
                    'desc' => __('How Many Online Members would you like widget to display?', 'wp-discord'),
                    'id' => 'wp-discord-member-count',
                    'type' => 'select',
                    'class' => 'widefat',
                    'fields' => array(
                        array(
                            'name' => __('None', 'wp-discord'),
                            'value' => '0'
                        ),
                        array(
                            'name' => __('3', 'wp-discord'),
                            'value' => '3'
                        ),
                        array(
                            'name' => __('6', 'wp-discord'),
                            'value' => '6'
                        ),
                        array(
                            'name' => __('9', 'wp-discord'),
                            'value' => '9'
                        ),
                        array(
                            'name' => __('12', 'wp-discord'),
                            'value' => '12'
                        ),
                        array(
                            'name' => __('All', 'wp-discord'),
                            'value' => '-1'
                        ),
                    ),
                    'filter' => 'strip_tags|esc_attr'
                )
            )
        );

        $this->create_widget($args);
    }

    public static function filter_bots($members)
    {
        $real_users = array();

        foreach ($members as $member) {
            //Not Bots!
            if ((isset($member->bot) && $member->bot == true) == false) {
                $real_users[] = $member;
            }
        }

        return $real_users;
    }

    public static function member_shuffle($members)
    {
        $shuffled_members = array();

        $keys = array_keys($members);
        shuffle($keys);

        foreach ($keys as $key) {
            $shuffled_members[$key] = $members[$key];
        }

        return $shuffled_members;
    }

    public static function render_widget($widget_object, $theme_class = 'wpd-white', $member_count = 3)
    {
        if (self::validate_response($widget_object, __LINE__) == false) {
            return false;
        }

        $server_title = $widget_object->name;
        $users_online = self::filter_bots($widget_object->members);
        $invite_url = $widget_object->instant_invite;
        $img_path = plugin_dir_url(__FILE__) . '../public/img';

        $output = '<div id="wp-discord" class="' . $theme_class . '">' . PHP_EOL;
        $output .= '<div class="wpd-head">' . PHP_EOL;
        $output .= '<img src="' . $img_path . '/icon.png" class="wpd-icon">' . PHP_EOL;
        $output .= '<img src="' . $img_path . '/discord.png" class="wpd-name">' . PHP_EOL;
        $output .= '<h3>' . $server_title . '</h3>' . PHP_EOL;
        $output .= '</div>' . PHP_EOL;
        $output .= '<div class="wpd-info">' . PHP_EOL;
        $output .= '<span><strong>' . count($users_online) . '</strong> ' . __('User(s) Online', 'wp-discord') . '</span>' . PHP_EOL;

        if (!empty($invite_url)) {
            $output .= '<a href="' . $invite_url . '" target="_blank">' . __('Join Server', 'wp-discord') . '</a>' . PHP_EOL;
        }

        if ($member_count != 0 && count($users_online) > 0) {
            $users_online = self::member_shuffle($users_online);
            $user_counter = 0;
            $output .= '<ul class="wpd-users">';

            foreach ($users_online as $user) {
                $user_counter++;
                $output .= '<li><img src="' . str_replace('https://', '//', $user->avatar_url) . '"><strong>' . $user->username . '</strong><span class="wpd-status ' . $user->status . '"></span></li>';

                if ($member_count != -1 && $user_counter >= $member_count) {
                    break;
                }
            }

            $output .= '</ul>';
        }

        $output .= '</div>' . PHP_EOL;
        $output .= '</div>' . PHP_EOL;

        return $output;
    }

    // Output function
    public function widget($args, $instance)
    {
        $server_id = $instance['wp-discord-server-id'];
        $theme_class = $instance['wp-discord-theme'];
        $widget_object = self::widget_feed($server_id);
        $member_count = 0;

        if (isset($instance['wp-discord-member-count'])) {
            $member_count = $instance['wp-discord-member-count'];
        } elseif (isset($instance['wp-discord-show-members']) && $instance['wp-discord-show-members'] == true) {
            //legacy
            $member_count = 3;
        }

        if (is_object($widget_object) && !empty($widget_object)) {
            $output = self::render_widget($widget_object, $theme_class, $member_count);
            echo $output;
        }
    }

    public static function widget_feed($server_id)
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

    /**
     * Validate the response from discord.
     * @param object $widget_response
     *
     * @since 0.3.1
     * @return bool
     */
    public static function validate_response($widget_response, $line_number = null)
    {
        // If message is set. We assume it is an error.
        if (!isset($widget_response->channels)) {
            if (current_user_can('edit_theme_options')) {
                $output = '<span class="' . WPD_PREFIX . 'alert">' . __('Error Response from Discord: ', 'wp-discord')  . json_encode($widget_response);

                if ($line_number > 0) {
                    $output .= '<br>Line Number: ' . $line_number . ' in ' . __FILE__;
                }

                $output .= '</span>';

                echo $output;
            }
            return false;
        }

        return true;
    }
}
