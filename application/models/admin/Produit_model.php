<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Produit_model extends CI_Model {

    /**
     * Enregistre un produit
     * @param type $data
     */
    public function create_product($data) {
        $this->db->insert('produits', $data);
    }

    /**
     * Lis les produits (pagination)
     * @param type $per_page
     * @param type $page
     * @return type
     */
    public function read_products($per_page, $page) {
        $result = $this->db->get('produits', intval($per_page), (intval($page) - 1) * $per_page)->result();
        return $result;
    }

    /**
     * Lis un produit
     * @param type $id
     * @return type
     */
    public function read_by_product($id) {
        $this->db->select('*')
                ->from('produits')
                ->join('categories', 'categories.cat_id = produits.pro_cat_id')
                ->where('pro_id', $id);
        $result = $this->db->get()->row();
        return $result;
    }

    /**
     * Lis les catégories
     * @return type
     */
    public function read_categorie() {
        $result = $this->db->get('categories')->result();
        return $result;
    }

    /**
     * Modifie un produit
     * @param type $id
     * @param type $data
     */
    public function update_product($id, $data) {
        $this->db->where('pro_id', $id);
        $this->db->update('produits', $data);
    }

    /**
     * Supprime un ou des produits
     * @param type $id
     */
    public function delete_product($id) {
        $this->db->where('pro_id', $id);
        $this->db->delete('produits');
        // Supprime image in dossier
        $filename = FCPATH . 'assets/image/' . $id . '.' . 'jpg';
        if (file_exists($filename)) {
            unlink(FCPATH . 'assets/image/' . $id . '.' . 'jpg');
        }
    }

}
