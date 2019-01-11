<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Produit_model extends CI_Model {

    public function insert_list($data) {
        // On spécifie les valeurs à inserer dans la table        
        $this->db->insert('produits', $data);
    }

    public function read_list() {
        $this->db->select('*')
                ->from('produits')
                ->join('categories', 'categories.cat_id = produits.pro_cat_id');
        $result = $this->db->get()->result();
        return $result;
    }

    public function read_cat() {
        // On sécifie qu'on veut toutes les données dans la table
        $result = $this->db->get('categories')->result();
        // ensuite, on envoi le résultat
        return $result;
    }

    public function read_one_product($id) {
        //$result = $this->db->get_where('produits', array('pro_id' => $id))->row();
        $this->db->select('*')
                ->from('produits')
                ->join('categories', 'categories.cat_id = produits.pro_cat_id')
                ->where('pro_id', $id);
        $result = $this->db->get()->row();
        return $result;
    }
    

    public function update_list($id, $data) {
        // On doit spécifier en premier lieu l'identifiant de la ligne à modifier
        $this->db->where('pro_id', $id);
        // ensuite les valeur à changer dans la table
        $this->db->update('produits', $data);
    }

    /**
     * 
     * @param type $id
     */
    public function delete_list($id) {
        $this->db->where('pro_id', $id);
        $this->db->delete('produits');
        unlink(FCPATH . 'assets/image/' . $id . '.' . 'jpg');
    }

}
