<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Insert un utilisateur
 * Lis les informations de l'utilisateur
 */
class User_model extends CI_Model {

    /**
     * Enregistre un utilisateur
     * @param type $data
     */
    public function create_user($data) {
        $this->db->insert('users', $data);
    }

    /**
     * Lis les informations de l'utilisateur correspondant à son nom d'utilisateur
     * @param type $login
     * @return type
     */
    public function read_login($login) {
        $this->db->select('u_password, u_id, u_id, admin')
                ->from('users')
                ->where('u_login', $login);
        $result = $this->db->get()->row();
        return $result;
    }

}
