<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

class WP_Discord_Guild
{
    public $server_id, $bot_token;
    public function __construct($server_id, $bot_token)
    {
        $this->id = $server_id;
        $this->bot_token = $server_id;
    }

    public function get_channels()
    {
        $url = 'https://discordapp.com/api/guilds/' . $this->id . '/channels';

        $ch = curl_init();

        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bot ' . $this->bot_token,
            ),
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_VERBOSE => 1,
            CURLOPT_SSL_VERIFYPEER => 0,
        ));


        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response);
    }
}