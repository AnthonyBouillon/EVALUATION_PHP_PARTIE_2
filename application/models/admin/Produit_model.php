<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Insert un produits
 * Lis les produits (pagination)
 * Lis un produit
 * Lis les catégories
 * Lis les sous-catégories
 * Modifie un produit
 * Supprime un produit
 * 
 */
class Produit_model extends CI_Model {

    /**
     * Enregistre un produit dans la base de données
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
     * Lis un produit correspondant à son identifiant
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
     * Lis les catégories parent
     * @return type
     */
    public function read_categorie() {
        $this->db->select('*')
                ->from('categories')
                ->where('cat_parent', NULL);
        $result = $this->db->get()->result();
        return $result;
    }
    /**
     * Lis les sous-catégories (enfants des catégories parents)
     * @return type
     */
    public function read_sub_categorie($id_parent) {
        $this->db->select('*')
                ->from('categories')
                ->where('cat_parent', $id_parent);
        $result = $this->db->get()->result();
        return $result;
    }

    /**
     * Modifie un produit correspondant à son identifiant
     * @param type $id
     * @param type $data
     */
    public function update_product($id, $data) {
        $this->db->where('pro_id', $id);
        $this->db->update('produits', $data);
    }

    /**
     * Supprime un produit correspondant à sont identifiant
     * Supprime l'image lié au produit
     * @param type $id
     */
    public function delete_product($id) {
        $this->db->where('pro_id', $id);
        $this->db->delete('produits');
        // Supprime image portant le nom de l'identifiant du produit
        $filename = FCPATH . 'assets/image/' . $id . '.' . 'jpg';
        if (file_exists($filename)) {
            unlink(FCPATH . 'assets/image/' . $id . '.' . 'jpg');
        }
    }

}
