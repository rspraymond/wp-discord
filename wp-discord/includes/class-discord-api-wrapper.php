<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

class DiscordApiWrapper
{
    public static function getRequest($url, $bot_token)
    {
        $ch = curl_init();

        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bot ' . $bot_token,
            ),
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_VERBOSE => 1,
            CURLOPT_SSL_VERIFYPEER => 0,
        ));


        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    public static function postRequest($url, $bot_token, array $params)
    {
        $ch = curl_init();
        $post_data = json_encode($params);

        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bot ' . $bot_token,
                'Content-Type: application/json',
                'Content-Length: ' . strlen($post_data)
            ),
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_VERBOSE => 1,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $post_data,
            CURLOPT_SSL_VERIFYPEER => 0,
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}
