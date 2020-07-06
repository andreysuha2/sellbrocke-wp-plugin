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
        write_log("DELETE USER $id");
        write_log("---------------");
        write_log("");
    }

    private function on_user_update($meta, $user) {
        write_log("UPDATE USER");
        write_log($meta);
        write_log($user);
        write_log("---------------");
        write_log("");
    }
}