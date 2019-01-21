<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Boutique extends CI_Controller {

    /**
     * Vérification des champs
     */
    public function read_list($id_url = !null) {
        if ($this->input->post()) {
// Vérification des valeurs récupèrer
            $this->form_validation->set_rules('quantity', 'Quantité', 'required|integer|xss_clean');
            $this->form_validation->set_rules('id_product', 'Id du produit', 'required|integer|xss_clean');
// Si c'est correct
            if ($this->form_validation->run()) {
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
// Le produit est inséré
                $this->boutique_model->create_cart($data, $this->input->post('id_product'));
            }
        }

// Pagination test
        $this->load->library('pagination');
        $config['base_url'] = 'http://localhost/Jarditou/index.php/boutique/read_list';
        $config['total_rows'] = $this->db->get('produits')->num_rows();
        $config['per_page'] = 5;
        $config['next_link'] = ' Page suivante';
        $config['prev_link'] = 'Page précédente ';
        $config['last_link'] = '';
        $config['first_link'] = '';
        $config['use_page_numbers'] = TRUE;
        $this->pagination->initialize($config);


        $data['title'] = 'Liste des produits';
// Nom de la page
        $data['page'] = 'list_user';
// Affiche tous les produits
        if (empty($id_url)) {
            $id_url = 1;
        }
        $data['list'] = $this->boutique_model->read_list(5, $id_url);

// Vues
        $this->load->view('templates/template', $data);
    }

    /**
     * Méthode concernant le panier, NON FONCTIONNEL 
     */
    public function read_cart() {

// Supprime tous les produits
        if ($this->input->post('delete_submit')) {
            $this->boutique_model->delete_cart_l($this->session->id_user);
            $this->boutique_model->delete_cart($this->session->id_tmp);
        }
// Modifie la quantité d'un produit
        if ($this->input->post('update_submit')) {
            $this->boutique_model->update_cart($this->input->post('quantity'), $this->input->post('id'));
        }
// Supprime un produit
        if ($this->input->post('delete_by_product')) {
            if (!isset($this->session->id_user)) {
                $this->session->id_user = 0;
            }
            $this->boutique_model->delete_by_product($this->input->post('id_product'), $this->session->id_tmp, $this->session->id_user);
        }
// Si il a un id temporaire et qu'il est connecté, je l'enregistre dans le panier de l'utilisateur connecté
        if ($this->session->id_tmp != 0 && !empty($this->session->username)) {
            $this->boutique_model->update_id_user($this->session->id_user, $this->session->id_tmp);
        }
// Si l'utilisateur est connecté, j'affiche le panier correspondant à l'id de l'utilisateur
        if (!empty($this->session->username)) {
            $data['cart_user_l'] = $this->boutique_model->read_cart_l();
        }
// Si il à un id temporaire et qu'il n'est pas connecté, j'affiche le panier lié à l'id temporaire
        if ($this->session->id_tmp != 0 && !isset($this->session->username)) {
            $data['cart_user'] = $this->boutique_model->read_cart();
        }
// Affiche le prix total
        if (!empty($this->session->username)) {
            $data['ttc'] = $this->boutique_model->read_ttc_l();
        } else {
            $data['ttc'] = $this->boutique_model->read_ttc();
        }
        $data['title'] = 'Panier';
// Nom de la page
        $data['page'] = 'cart_user';
        $this->load->view('templates/template', $data);
    }

    public function delete_product() {  
        if ($this->input->is_ajax_request()) {
            $this->boutique_model->delete_cart_l($this->session->id_user);
            $this->boutique_model->delete_cart($this->session->id_tmp);
        }
    }

    public function delete_by_product() {
        if ($this->input->is_ajax_request()) {
            if (!isset($this->session->id_user)) {
                $this->session->id_user = 0;
            }
            $this->boutique_model->delete_by_product($this->input->post('id_product'), $this->session->id_tmp, $this->session->id_user);
        }
    }

    public function update_product() {
        if ($this->input->is_ajax_request()) {
            $this->boutique_model->update_cart($this->input->post('quantity'), $this->input->post('id'));
        }
    }

}
