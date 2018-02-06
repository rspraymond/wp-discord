<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Wrapper for Discord Webhooks.
 *
 * @link       http://wpdiscord.com
 * @since      0.3.0
 *
 * @package    WP_Discord
 * @subpackage WP_Discord/includes
 * @author     Raymond Perez <ray@rayperez.com>
 */
class WP_Discord_Webhook
{
    public function __construct($id, $guild)
    {
        $this->id = $id;
        $this->guild = $guild;

        // Grab info via API
        $response = json_decode(DiscordApiWrapper::getRequest('https://discordapp.com/api/webhooks/' . $this->id, $this->guild->token));
        $attr = get_object_vars($response);

        foreach ($attr as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * Post content to a discord channel.
     * @param array|string $content
     *
     * @since      0.3.0
     * @return mixed
     */
    public function post_content($content)
    {
        $url = 'https://discordapp.com/api/webhooks/' . $this->id . '/' . $this->token;
        $bot = $this->guild->get_bot();

        if (!is_array($content)) {
            $content = array(
                'content' => $content,
            );
        }

        $content['username'] = $bot->name;

        if (!empty($bot->icon)) {
            $content['avatar_url'] = DiscordApiWrapper::getAvatarUrl($bot->id, $bot->icon);
        }

        $response = DiscordApiWrapper::postRequest($url, $this->guild->token, $content);

        return $response;
    }
}
