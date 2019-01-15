<?php

class User_model extends CI_Model {

    public function create_user($data) {
        $this->db->insert('users', $data);
    }

    public function read_login($login) {
        $this->db->select('u_password, u_id, u_id')
                ->from('users')
                ->where('u_login', $login);
        $result = $this->db->get()->row();
        return $result;
    }

}
