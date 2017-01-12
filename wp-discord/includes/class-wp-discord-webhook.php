<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

class WP_Discord_Webhook
{
    public function __construct($id, $guild)
    {
        $this->id = $id;
        $this->guild = $guild;

        // Grab info via API
        $response = json_decode(DiscordApiWrapper::getRequest('https://discordapp.com/api/webhooks/' . $this->id, $this->guild->bot_token));
        $attr = get_object_vars($response);

        foreach ($attr as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * Post content to a discord channel.
     * @param array|string $content
     * @return mixed
     */
    public function post_content($content)
    {
        $url = 'https://discordapp.com/api/webhooks/' . $this->id . '/' . $this->token;

        if (!is_array($content)) {
            $content = [
                'content' => $content
            ];
        }

        $response = DiscordApiWrapper::postRequest($url, $this->guild->bot_token, $content);

        return $response;
    }
}
