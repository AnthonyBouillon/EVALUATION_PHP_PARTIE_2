<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Produit_model extends CI_Model {

    public function create_product($data) {
        // Insert un produit in bdd      
        $this->db->insert('produits', $data);
    }

    public function read_products() {
        // Lis toutes les lignes de la table produits
        $result = $this->db->get('produits')->result();
        return $result;
    }

    public function read_by_product($id) {
        // Lis les informations d'un produit
        $this->db->select('*')
                ->from('produits')
                ->join('categories', 'categories.cat_id = produits.pro_cat_id')
                ->where('pro_id', $id);
        $result = $this->db->get()->row();
        return $result;
    }

    public function read_categorie() {
        // Lis toutes les lignes de la table categories
        $result = $this->db->get('categories')->result();
        return $result;
    }

    public function update_product($id, $data) {
        // Modifie le produit sélectionnée
        $this->db->where('pro_id', $id);
        $this->db->update('produits', $data);
    }

    public function delete_product($id) {
        // Supprime produit in bdd
        $this->db->where('pro_id', $id);
        $this->db->delete('produits');
        // Supprime image in dossier
        $filename = FCPATH . 'assets/image/' . $id . '.' . 'jpg';
        if (file_exists($filename)) {
            unlink(FCPATH . 'assets/image/' . $id . '.' . 'jpg');
        }
    }

}
