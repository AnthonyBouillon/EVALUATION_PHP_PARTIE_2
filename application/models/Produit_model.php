<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Produit_model extends CI_Model{
    public function get_list(){
        $data = $this->db->query('SELECT * FROM produits')->result();
        // Contient toutes les données de la table produits
        return $data; 
    }
    public function get_cat_name(){
        $data = $this->db->query('SELECT * FROM categories')->result();
        return $data;
    }
    public function insert_list($data){
        $this->db->insert('produits', $data);
    }
}
