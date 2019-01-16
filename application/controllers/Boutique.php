<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Boutique extends CI_Controller {

    /**
     * Page liste
     */
    public function read_list($test =!null) {
        // Assigne un id unique pour les non connectés
        if ($this->session->id_tmp == 0 && !isset($this->session->username)) {
            $this->session->id_tmp = uniqid();
        } else if (!isset($this->session->id_tmp) && isset($this->session->username)) {
            $this->session->id_tmp = 0;
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
        if (empty($test)) {
            $test = 1;
        }
        $data['list'] = $this->boutique_model->read_list(5, $test);
        // Vues
        $this->load->view('templates/template', $data);
    }

    /**
     * Page panier
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
        if ($this->input->post('delete_product')) {
            $this->boutique_model->delete_by_product($this->input->post('id_product'));
        }
          if($this->session->id_tmp != 0 && !empty($this->session->username)){
            $data['cart_user'] = $this->boutique_model->read_cart();
            $this->boutique_model->update_id_user($this->session->id_user, $this->session->id_tmp);
        }
        if($this->session->id_tmp != 0 && !isset($this->session->username)){
             $data['cart_user'] = $this->boutique_model->read_cart();
        }
        if (!empty($this->session->username)) {
            $data['cart_user_l'] = $this->boutique_model->read_cart_l();
        } 
      
            
        

        $data['title'] = 'Panier';
        // Nom de la page
        $data['page'] = 'cart_user';

        $data['ttc'] = $this->boutique_model->read_ttc();
        $this->load->view('templates/template', $data);
    }

}
