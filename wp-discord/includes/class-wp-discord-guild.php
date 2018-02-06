<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

require_once plugin_dir_path(__FILE__) . '../includes/class-wp-discord-webhook.php';

/**
 * Wrapper for Discord Guilds.
 *
 * @link       http://wpdiscord.com
 * @since      0.3.0
 *
 * @package    WP_Discord
 * @subpackage WP_Discord/includes
 * @author     Raymond Perez <ray@rayperez.com>
 */
class WP_Discord_Guild
{
    public $server_id;
    public $token;

    public function __construct($server_id, $token)
    {
        $this->id = $server_id;
        $this->token = $token;
    }

    /**
     * Add a webhook to an existing channel.
     * @param string $channel_id
     * @param string $name
     *
     * @since      0.3.0
     * @return array|mixed|object
     */
    public function add_webhook($channel_id, $name = null)
    {
        $avatar_url = null;
        $bot = $this->get_bot();
        $url = 'https://discordapp.com/api/channels/' . $channel_id . '/webhooks';

        if (empty($name)) {
            $name = $bot->name;
        }

        $response = DiscordApiWrapper::postRequest($url, $this->token, array('name' => $name));

        return json_decode($response);
    }

    /**
     * Get bot info
     *
     * @return array|mixed|object
     * @since 0.4.0
     */
    public function get_bot()
    {
        return json_decode(DiscordApiWrapper::getRequest('https://discordapp.com/api/oauth2/applications/@me', $this->token));
    }

    /**
     * Get an individual channel.
     * @param string $channel_id
     *
     * @since      0.3.0
     * @return array|mixed|object
     */
    public function get_channel($channel_id)
    {
        $url = 'https://discordapp.com/api/channels/' . $channel_id;
        $response = DiscordApiWrapper::getRequest($url, $this->token);

        return json_decode($response);
    }

    /**
     * Get list of channels.
     * @param string $type text, voice, etc.
     *
     * @since      0.3.0
     * @return array|mixed|object
     */
    public function get_channels($type = null)
    {
        $url = 'https://discordapp.com/api/guilds/' . $this->id . '/channels';

        $response = DiscordApiWrapper::getRequest($url, $this->token);

        if (self::validate_response($response) == false) {
            return false;
        }

        $channels = json_decode($response);

        if (!is_null($type)) {
            foreach ($channels as $key => $channel) {
                if ($channel->type !== $type) {
                    unset($channels[$key]);
                }
            }
        }

        return $channels;
    }

    /**
     * Grabs a webhook based on post type.
     * @param $post_type_name
     *
     * @since      0.3.0
     * @return WP_Discord_Webhook
     */
    public function get_post_type_webhook($post_type_name)
    {
        $option_name = WPD_PREFIX . 'channel_' . $post_type_name;
        $channel_id = get_option($option_name, 0);

        if (empty($channel_id)) {
            return null;
        }

        $webhooks = $this->get_webhooks($channel_id);

        if (!is_array($webhooks)) {
            return false;
        }

        // Grab first webhook we get back; create a new one if we get back empty set
        if (empty($webhooks)) {
            $channel = $this->get_channel($channel_id);
            $webhook_id = $this->add_webhook($channel_id)->id;
        } else {
            $webhook_id = $webhooks[0]->id;
        }

        return $this->get_webhook($webhook_id);
    }

    /**
     * Grabs list of webhooks for guild.
     * @param string $channel_id Pass a channel id to get webhooks for a specific channel.
     *
     * @since      0.3.0
     * @return array|mixed|object
     */
    public function get_webhooks($channel_id = null)
    {
        if (!empty($channel_id)) {
            $url = 'https://discordapp.com/api/channels/' . $channel_id . '/webhooks';
        } else {
            $url = 'https://discordapp.com/api/guilds/' . $this->id . '/webhooks';
        }

        $response = DiscordApiWrapper::getRequest($url, $this->token);

        return json_decode($response);
    }

    /**
     * Setup and return an existing webhook.
     * @param $webhook_id
     *
     * @since      0.3.0
     * @return WP_Discord_Webhook
     */
    public function get_webhook($webhook_id)
    {
        $webhook = new WP_Discord_Webhook($webhook_id, $this);

        return $webhook;
    }

    /**
     * Checks to make sure we got the response we want from discord.
     * @param $response
     *
     * @since      0.3.0
     */
    public static function validate_response($response)
    {
        if (strpos($response, 'guild_id') === false) {
            return false;
        }

        $response = json_decode($response);

        if (!is_array($response)) {
            return false;
        }

        return true;
    }
}
