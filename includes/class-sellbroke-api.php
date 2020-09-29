<?php
class Sellbroke_Api {

    private $auth_url = SELLBROKE_API_URL . "oauth/token";
    private $base_url = SELLBROKE_API_URL . "api/merchants";
    private $nowDate;
    private $db;
    private $datetime_format = "Y-m-d H:i:s";
    private $client_id;
    private $client_secret;

    public function __construct() {
        global $wpdb;
        $this->client_secret = defined("SELLBROKE_DEV_CLIENT_SECRET") ? SELLBROKE_DEV_CLIENT_SECRET : "";
        $this->client_id = defined("SELLBROKE_DEV_CLIENT_ID") ? SELLBROKE_DEV_CLIENT_ID : "";
        $this->db = $wpdb;
        $this->nowDate = new DateTime();
    }

    public function auth($user_name, $password) {
        $tokens = wp_remote_post($this->auth_url, [
            "body" => [
                "grant_type" => "password",
                "client_id" => $this->client_id,
                "client_secret" => $this->client_secret,
                "username" => $user_name,
                "password" => $password
            ]
        ]);
        $tokenData = json_decode($tokens["body"], true);
        if(isset($tokenData["access_token"])) {
            $isInserted = $this->saveToken($tokenData);
            $merchant = $this->getAuthMerchant();
            return [
                "success" => $merchant["success"],
                "msg" => "Authorize success",
                "isInserted" => $isInserted,
                "merchant" => $merchant["merchant"]
            ];
        } else return [ "success" => false, "msg" => "Authorize failed", "hasAuthToken" => $this->hasActiveToken() ];
    }

    public function hasActiveToken() {
        $count = $this->db->get_var(
            "SELECT COUNT(*) FROM " . SELLBROKE_TOKENS_TABLE_NAME . "
                  WHERE `is_active` = '1'
                  AND DATE(`expired_at`) > '" . $this->nowDate->format($this->datetime_format) . "'"
        );
        return (int) $count;
    }

    public function request($slug, $method, $body = [], $args = []) {
        $url = $this->base_url . "/" . $slug;
        $response = wp_remote_request($url, array_merge($args, [
            "body" => $body,
            "method" => $method,
            "headers" => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '. $this->getToken()
            ]
        ]));

        if (isset($response->errors)) {
            return [
                "body" => "HTTP request error",
                "code" => 500,
                "message" => "HTTP request failed",
                "success" => false
            ];
        }

        $code = $response["response"]["code"];
        return [
            "body" => json_decode($response["body"], true),
            "code" => $code,
            "message" => $response["response"]["message"],
            "success" => $code === 200 || $code === 201
        ];
    }

    public function get($slug, $body = [], $args = []) {
        return $this->request($slug, "GET", $body, $args);
    }

    public function post($slug, $body = [], $args = []) {
        return $this->request($slug, "POST", $body, $args);
    }

    public function put($slug, $body = [], $args = []) {
        return $this->request($slug, "PUT", $body, $args);
    }

    public function delete($slug, $body = [], $args = []) {
        return $this->request($slug, "DELETE", $body, $args);
    }

    public function getAuthMerchant() {
        $merchant = $this->get("/");
        if($merchant["success"]) {
            return [ "merchant" => $merchant["body"]["merchant"], "success" => $merchant["success"] ];
        } else return $merchant;
    }

    public function storeCustomer($customer) {
        return $this->post("customer", $customer);
    }

    public function deleteCustomer($customer_id) {
        return $this->delete("customer", [ "id" => $customer_id ]);
    }

    public function search($query) {
        $response = $this->get("search/$query");

        if (isset($response['body']['redirectTo'])) {
            wp_redirect(get_page_link() . "/" . $response['body']['redirectTo']);
            exit;
        }

        return $response;
    }

    private function getToken() {
        $token = $this->db->get_row(
            "SELECT `access_token` FROM " . SELLBROKE_TOKENS_TABLE_NAME . "
                   WHERE `is_active` = '1'
                   AND DATE(`expired_at`) > '" . $this->nowDate->format($this->datetime_format) . "'");
        return $token ? $token->access_token : $this->refreshToken();
    }

    private function refreshToken() {
        $lastActiveToken = $this->db->get_row(
            "SELECT `refresh_token` FROM " . SELLBROKE_TOKENS_TABLE_NAME . "
                   WHERE `is_active` = '1'");
        if($lastActiveToken) {
            $tokens = wp_remote_post($this->auth_url, [
                "body" => [
                    "grant_type" => "refresh_token",
                    "refresh_token" => $lastActiveToken->refresh_token,
                    "client_id" => $this->client_id,
                    "client_secret" => $this->client_secret
                ]
            ]);
            $tokenData = json_decode($tokens["body"], true);
            if(isset($tokenData["access_token"])) {
                $this->saveToken($tokenData);
                return $tokenData["access_token"];
            } else return null;
        }
    }

    private function deactivateTokens() {
        // TODO get not expired tokens and logout with that tokens
        $this->db->update(SELLBROKE_TOKENS_TABLE_NAME,
            [ "is_active" => 0 ],
            [ "is_active" => 1 ]
        );
    }

    private function saveToken($tokenData) {
        $this->deactivateTokens();
        return $this->db->insert(SELLBROKE_TOKENS_TABLE_NAME, [
            "access_token" => $tokenData["access_token"],
            "refresh_token" => $tokenData["refresh_token"],
            "is_active" => 1,
            "created_at" => $this->nowDate->format($this->datetime_format),
            "expired_at" => $this->getTokenExpiresDate($tokenData["expires_in"])
        ], [ "%s", "%s", "%d", "%s", "%s" ]);
    }

    private function getTokenExpiresDate($expires_in) {
        $expires_in = $this->nowDate->getTimestamp() + $expires_in;
        return (new DateTime())->setTimestamp($expires_in)->format($this->datetime_format);
    }
}
