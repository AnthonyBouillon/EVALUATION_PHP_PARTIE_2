<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Boutique extends CI_Controller {

    /**
     * Page liste
     */
    public function read_list() {
        // Assigne un id unique pour les non connectés
        if (!isset($this->session->id_tmp) && !isset($this->session->username)) {
            $this->session->id_tmp = uniqid();
        }
        // Vérification des valeurs récupèrer
        $this->form_validation->set_rules('quantity', 'Quantité', 'required|integer|xss_clean');
        $this->form_validation->set_rules('id_product', 'Id du produit', 'required|integer|xss_clean');
        // Si c'est correct
        if ($this->form_validation->run()) {
            if ($this->input->post()) {
                $data = array(
                    'quantity' => $this->input->post('quantity'),
                    'id_product' => $this->input->post('id_product'),
                    'id_tmp' => $this->session->id_tmp
                );
                // Si l'utilisateur est connecté
                if (!empty($this->session->username)) {
                    // Insert son identifiant
                    $data['id_user'] = $this->session->id_user;
                }
                // L'utilisateur est insérer
                $this->boutique_model->create_cart($data);
            }
        }
        // Affiche tous les produits
        $data['list'] = $this->boutique_model->read_list();
        // Vues
        $title['title'] = 'Liste des produits';
        $this->load->view('header', $title);
        $this->load->view('list_user', $data);
        $this->load->view('footer');
    }

    /**
     * Page panier
     */
    public function read_cart() {
        // Supprime tous les produits
        if ($this->input->post('delete_submit')) {
            $this->boutique_model->delete_cart($this->session->id_tmp);
        }
        // Modifie la quantité d'un produit
        if ($this->input->post('update_submit')) {
            $this->boutique_model->update_cart($this->input->post('quantity'), $this->input->post('id'));
        }
        // Supprime un produit
        if ($this->input->post('delete_product')) {
            $this->boutique_model->delete_by_product($this->input->post('id_product'));
        }

            // Affiche les produits du panier
            $data['cart_user'] = $this->boutique_model->read_cart();
        



        // Prix total
        $data['ttc'] = $this->boutique_model->read_ttc();
        // Vues
        $title['title'] = 'Panier';
        $this->load->view('header', $title);
        $this->load->view('cart_user', $data);
        $this->load->view('footer');
    }

}
