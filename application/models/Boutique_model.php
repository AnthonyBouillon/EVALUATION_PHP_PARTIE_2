<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Boutique_model extends CI_Model {

    /**
     * Retourne la liste des produits
     * @return type
     */
    public function read_list() {
        $result = $this->db->get('produits')->result();
        return $result;
    }

    /**
     * Retourne la liste des produits dans le panier
     * @return type
     */
    public function read_cart() {
        $this->db->select('sum(quantity) as quantity, sum(pro_prix * quantity) as price, id_tmp, id_product, pro_libelle, sum(pro_prix) as prix, id')
                ->from('produits')
                ->join('carts', 'carts.id_product = produits.pro_id')
                ->where('id_tmp', $this->session->id_tmp)
                ->group_by('id_product');
        $result = $this->db->get()->result();
        return $result;
    }


    /**
     * Retourne le prix total des produits dans le panier
     * @return type
     */
    public function read_ttc() {
        $this->db->select('sum(quantity) as quantity, sum(pro_prix * quantity) as ttc, id_tmp, id_product, pro_libelle, sum(pro_prix) as prix, id')
                ->from('produits')
                ->join('carts', 'carts.id_product = produits.pro_id')
                ->where('id_tmp', $_SESSION['id_tmp']);
        $result = $this->db->get()->result();
        return $result;
    }

    /**
     * Insert un produit dans le panier
     * @param type $data
     */
    public function create_cart($data) {
        $this->db->insert('carts', $data);
    }

    /**
     * Modifie la quantité d'un produit dans le panier
     * @param type $data
     * @param type $id
     */
    public function update_cart($data, $id) {
        $this->db->set('quantity', $data);
        $this->db->where('id', $id);
        $this->db->update('carts');
    }

    /**
     * Supprime les produits dans le panier
     * @param type $id_tmp
     */
    public function delete_cart($id_tmp) {
        $this->db->where('id_tmp', $id_tmp);
        $this->db->delete('carts');
    }

    /**
     * Supprime un produit
     * @param type $id_tmp
     * @param type $id_product
     */
    public function delete_by_product($id_product) {
        $this->db->where('id_product', $id_product);
        $this->db->delete('carts');
    }

}
