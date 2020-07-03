<?php

class Sellbroke_Api {

    private $auth_url = SELLBROKE_API_URL . "oauth/token";
    private $base_url = SELLBROKE_API_URL . "api/merchants";

    public function auth($user_name, $password) {
        $tokens = wp_remote_post($this->auth_url, [
            "body" => [
                "grant_type" => "password",
                "client_id" => 2,
                "client_secret" => "ZNAPQMFFbWFyFYuxiAXJWS9doEnCxW5M61WzAvgi",
                "username" => $user_name,
                "password" => $password
            ]
        ]);
        print_r($tokens["body"]);
    }
}