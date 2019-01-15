<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Boutique_model extends CI_Model {

    public function read_list() {
        $result = $this->db->get('produits')->result();
        return $result;
    }

    public function read_cart() {

        $this->db->select('sum(quantity) as quantity, sum(pro_prix * quantity) as total, id_tmp, id_product, pro_libelle, sum(pro_prix) as prix, id')
                ->from('produits')
                ->join('carts', 'carts.id_product = produits.pro_id')
                ->where('id_tmp', $_SESSION['id_tmp'])
                ->group_by('id_product');
        $result = $this->db->get()->result();
        return $result;
    }

    public function read_ttc() {

        $this->db->select('sum(quantity) as quantity, sum(pro_prix * quantity) as ttc, id_tmp, id_product, pro_libelle, sum(pro_prix) as prix, id')
                ->from('produits')
                ->join('carts', 'carts.id_product = produits.pro_id')
                ->where('id_tmp', $_SESSION['id_tmp']);
        $result = $this->db->get()->result();
        return $result;
    }

    public function create_cart($data) {
        $this->db->insert('carts', $data);
    }

    public function update_cart($data, $id) {
        $this->db->set('quantity', $data);
        $this->db->where('id', $id);
        $this->db->update('carts');
    }

    public function delete_cart($id_tmp) {
        $this->db->where('id_tmp', $id_tmp);
        $this->db->delete('carts');
    }

    public function delete_by_product($id_tmp, $id_product) {
        $this->db->where('id_tmp', $id_tmp AND 'id_product', $id_product);
        $this->db->delete('carts');
    }

}
