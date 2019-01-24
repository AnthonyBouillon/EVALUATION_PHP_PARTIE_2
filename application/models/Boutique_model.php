<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Insert un produit dans la table panier
 * Lis tous les produits
 * Lis la liste des produits dans le panier (non connecté)
 * Lis la liste des produits dans le panier (connecté)
 * Lis le prix total des produits dans le panier (non connecté)
 * Lis le prix total des produits dans le panier (connecté)
 * Modifie la quantité d'un produit dans le panier (non connecté)
 * Modifie la quantité d'un produit dans le panier (connecté)
 * Ajoute l'identifiant de l'utiliseur (si connecté)
 * Supprime tous les produits dans le panier (non connecté)
 * Supprime tous les produits dans le panier (connecté)
 * Supprime un produit dans le panier (non connecté)
 * Supprime un produit dans le panier (connecté)
 * 
 */
class Boutique_model extends CI_Model {

    /**
     * Insert un produit dans le panier
     * à condition que l'utilisateur ne l'as pas déjà ajouté
     * @param type 
     */
    public function create_cart($data, $id_product) {
        $sql = 'SELECT COUNT(id_product) as num_pro FROM carts WHERE (id_user= ? OR id_tmp = ?) AND id_product = ?';
        $result = $this->db->query($sql, array($this->session->id_user, $this->session->id_tmp, $id_product))->row();
        if ($result->num_pro == "0") {
            $this->db->insert('carts', $data);
        }
    }

    /**
     * Lis la liste des produits (pagination) 
     * à condition qu'elle ne soit pas bloqué
     * @return type 
     */
    public function read_list($per_page, $page) {
        $this->db->select('*')
                ->from('produits')
                ->limit(intval($per_page), (intval($page) - 1) * $per_page)
                ->where('pro_bloque', 1);
        $result = $this->db->get()->result();
        return $result;
    }

    /**
     * Lis la liste de ses produits dans le panier correspondant à son identifiant temporaire
     * à condition qu'il en es un
     * @return type
     */
    public function read_cart() {
        if (isset($this->session->id_tmp)) {
            $this->db->select('sum(quantity) as quantity, sum(pro_prix * quantity) as price, id_tmp, id_product, pro_libelle, sum(pro_prix) as prix, id')
                    ->from('produits')
                    ->join('carts', 'carts.id_product = produits.pro_id')
                    ->where('id_tmp', $this->session->id_tmp)
                    ->group_by('id_product');
            $result = $this->db->get()->result();
            return $result;
        }
        return NULL;
    }

    /**
     * Lis la liste de ses produits dans le panier correspondant à son identifiant d'utilisateur
     * à condition qu'il en es un
     * @return type
     */
    public function read_cart_l() {
        if (isset($this->session->username)) {
            $this->db->select('sum(quantity) as quantity, sum(pro_prix * quantity) as price, id_tmp, id_product, pro_libelle, sum(pro_prix) as prix, id')
                    ->from('produits')
                    ->join('carts', 'carts.id_product = produits.pro_id')
                    ->where('id_user', $this->session->id_user)
                    ->group_by('id_product');
            $result = $this->db->get()->result();
            return $result;
        }
        return NULL;
    }

    /**
     * Lis le prix total de ses produits dans le panier
     * à condition que l'utilisateur es un identifiant temporaire
     * @return type
     */
    public function read_ttc() {
        $this->db->select('sum(quantity) as quantity, sum(pro_prix * quantity) as ttc, id_tmp, id_product, pro_libelle, sum(pro_prix) as prix, id')
                ->from('produits')
                ->join('carts', 'carts.id_product = produits.pro_id')
                ->where('id_tmp', $this->session->id_tmp);
        $result = $this->db->get()->result();
        return $result;
    }

    /**
     * Lis le prix total de ses produits dans le panier
     * à condition que l'utilisateur es un identifiant d'utilisateur
     * @return type
     */
    public function read_ttc_l() {
        $this->db->select('sum(quantity) as quantity, sum(pro_prix * quantity) as ttc, id_tmp, id_product, pro_libelle, sum(pro_prix) as prix, id')
                ->from('produits')
                ->join('carts', 'carts.id_product = produits.pro_id')
                ->where('id_user', $this->session->id_user);
        $result = $this->db->get()->result();
        return $result;
    }

    /**
     * Modifie la quantité d'un produit dans le panier correspondant à l'identifiant du produit et de 
     * l'identifiant de l'utilisateur ou de l'identifiant temporaire
     * @param type $data
     * @param type $id
     */
    public function update_cart($data, $id) {
        if (!isset($this->session->username)) {
            $this->db->set('quantity', $data);
            $this->db->where(array('id' => $id, 'id_tmp'=> $this->session->id_tmp));
            $this->db->update('carts');
        } 
        if (isset($this->session->username)) {
            $this->db->set('quantity', $data);
            $this->db->where(array('id' => $id, 'id_user'=> $this->session->id_user));
            $this->db->update('carts');
        }
    }

    /**
     * Ajoute l'identifiant de l'utiliseur correspondant à sont identifiant temporaire
     * à condition qu'il soit connecté
     * à condition qu'il a un identifiant temporaire
     * @param type $id_user
     * @param type $id_tmp
     */
    public function update_id_user($id_user, $id_tmp) {
        $this->db->set('id_user', $id_user);
        $this->db->where('id_tmp', $id_tmp);
        $this->db->update('carts');
    }

    /**
     * Supprime les produits dans le panier via l'identifiant temporaire
     * @param type $id_tmp
     */
    public function delete_cart($id_tmp) {
        $this->db->where('id_tmp', $id_tmp);
        $this->db->delete('carts');
    }

    /**
     * Supprime les produits dans le panier via l'identifiant de l'utilisateur
     * @param type $id_user
     */
    public function delete_cart_l($id_user) {
        $this->db->where('id_user', $id_user);
        $this->db->delete('carts');
    }

    /**
     * Supprime un produit dans le panier via
     * l'identifiant du produit + identifiant temporaire ou identifiant de l'utilisateur
     * @param type $id_tmp
     * @param type $id_product
     * @param type $id_user
     */
    public function delete_by_product($id_product, $id_tmp, $id_user) {
        $sql = 'DELETE FROM carts WHERE id_product = ? AND (id_tmp = ? OR id_user = ?)';
        $this->db->query($sql, array($id_product, $id_tmp, $id_user));
    }

}
