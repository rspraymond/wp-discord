<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

class WP_Discord_Webhook
{
    public function __construct($id)
    {
        $this->id = $id;

        //Grab token via API
    }

    public function post_message($message)
    {
        $url = 'https://discordapp.com/api/webhooks/' . $this->id . '/' . $this->token;

        $ch = curl_init();
        $post_data = json_encode(array(
            "content" => $message,
        ));

        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => array(
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

        die(var_export($response, true));
    }
}