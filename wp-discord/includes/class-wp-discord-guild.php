<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

require_once plugin_dir_path(__FILE__) . '../includes/class-wp-discord-webhook.php';

class WP_Discord_Guild
{
    public $server_id;
    public $bot_token;

    public function __construct($server_id, $bot_token)
    {
        $this->id = $server_id;
        $this->bot_token = $bot_token;
    }

    public function add_webhook($channel_id)
    {
        $url = 'https://discordapp.com/api/channels/' . $channel_id . '/webhooks';

        $response = DiscordApiWrapper::postRequest($url, $this->bot_token, ['name' => 'Wordpress 2']);

        return json_decode($response);
    }

    public function get_channels()
    {
        $url = 'https://discordapp.com/api/guilds/' . $this->id . '/channels';

        $response = DiscordApiWrapper::getRequest($url, $this->bot_token);

        return json_decode($response);
    }

    public function get_webhooks()
    {
        $url = 'https://discordapp.com/api/guilds/' . $this->id . '/webhooks';

        $response = DiscordApiWrapper::getRequest($url, $this->bot_token);

        return json_decode($response);
    }

    public function get_webhook($webhook_id)
    {
        $webhook = new WP_Discord_Webhook($webhook_id, $this);

        return $webhook;
    }
}
