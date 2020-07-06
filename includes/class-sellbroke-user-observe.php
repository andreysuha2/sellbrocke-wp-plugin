<?php

class Sellbroke_User_Observe {
    private $api;
    private $user_observe_group;

    public function __construct($group = "test") {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sellbroke-api.php';
        $this->user_observe_group = $group;
        $this->api = new Sellbroke_Api();
    }

    public function on_user_insert_meta($meta, $user, $update) {
        if($update) $this->on_user_update($meta, $user);
        return $meta;
    }

    public function on_user_delete($id) {
        $this->api->deleteCustomer($id);
    }

    private function on_user_update($meta, $user) {
        $this->api->storeCustomer([
            "merchant_customer_id" => (int) $user->data->ID,
            "email" => $user->data->user_email,
            "login" => $user->data->user_login,
            "first_name" => $meta["first_name"],
            "last_name" => $meta["last_name"],
            "data" => json_encode($user->data)
        ]);
    }
}