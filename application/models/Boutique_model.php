<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Boutique_model extends CI_Model {

    public function read_list() {
        $result = $this->db->get('produits')->result();
        return $result;
    }

    public function read_cart() {
        $this->db->select('sum(quantity) as quantity, id_user, id_product, pro_libelle, sum(pro_prix) as prix')
                ->from('produits')
                ->join('carts', 'carts.id_product = produits.pro_id')
                ->where('id_user', uniqid())
                ->group_by('id_product');
        $result = $this->db->get()->result();
        return $result;
    }

    public function create_cart($data) {
        $this->db->insert('carts', $data);
    }

    public function cart($id) {
        
    }

}
