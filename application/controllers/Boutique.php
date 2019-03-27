<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlleur utilisateur
 * Gestion de la liste et du panier
 * Pour les connectés et les non connectés
 */
class Boutique extends CI_Controller {

    /**
     * $id_url = !null : récupère le paramètre dans l'url si il existe
     * @param int $id_url
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

        // Configuration de la pagination
        $config['base_url'] = base_url('boutique/read_list');
        $config['total_rows'] = $this->boutique_model->count_display_product();
        $config['per_page'] = 5;
        $config['next_link'] = ' >> ';
        $config['prev_link'] = ' << ';
        $config['last_link'] = ' last ';
        $config['first_link'] = ' first ';
        $config['use_page_numbers'] = TRUE;
        $this->pagination->initialize($config);

        $data['title'] = 'Liste des produits';
        $data['page'] = 'list_user';
        // Assigne l'id de l'url à 1 pour la première page
        if (!isset($id_url)) {
            $id_url = 1;
        }
        $data['list'] = $this->boutique_model->read_list(5, $id_url);
        $this->load->view('templates/template', $data);
    }

    /**
     * Gestion du panier pour les connectés et les non connectés
     */
    public function read_cart() {

        // Supprime tous les produits du panier pour les connectés et les non connectés
        if ($this->input->post('delete_submit')) {
            if (!empty($this->session->username)) {
                $this->boutique_model->delete_cart_l($this->session->id_user);
            } else {
                $this->boutique_model->delete_cart($this->session->id_tmp);
            }
        }
        // Modifie la quantité d'un produit du panier pour les connectés ou les non connectés
        if ($this->input->post('update_submit')) {
            if ($this->input->post('quantity') > 0) {
                $this->boutique_model->update_cart($this->input->post('quantity'), $this->input->post('id'));
            }
        }
        // Supprime un produit dans le panier pour les connectés et les non connectés
        if ($this->input->post('delete_by_product')) {
            /* if (!isset($this->session->id_user)) {
              $this->session->id_user = 0;
              } */
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
        // Affiche le prix total de tous les produits dans le panier
        if (!empty($this->session->username)) {
            $data['ttc'] = $this->boutique_model->read_ttc_l();
        } else {
            $data['ttc'] = $this->boutique_model->read_ttc();
        }

        $data['title'] = 'Panier';
        $data['page'] = 'cart_user';
        $this->load->view('templates/template', $data);
    }

    /**
     * Ajoute un produit
     * APPEL AJAX
     */
    public function add_product() {

        if ($this->input->is_ajax_request()) {
            $data = array(
                'quantity' => $this->input->post('quantity'),
                'id_product' => $this->input->post('id_product'),
                'id_tmp' => $this->session->id_tmp
            );
            $this->output->set_content_type('application/json');
            $this->output->set_header('Access-Control-Allow-Origin: *');
            $this->output->set_output(json_encode($this->boutique_model->create_cart($data, $this->input->post('id_product'))));
        }
    }

    /**
     * Supprime tous les produits du panier pour les connectés et les non connectés
     * APPEL AJAX
     */
    public function delete_product() {
        if ($this->input->is_ajax_request()) {
            if (!empty($this->session->username)) {
                $this->output->set_content_type('application/json');
                $this->output->set_header('Access-Control-Allow-Origin: *');
                $this->output->set_output(json_encode($this->boutique_model->delete_cart_l($this->session->id_user)));
            } else {
                $this->output->set_content_type('application/json');
                $this->output->set_header('Access-Control-Allow-Origin: *');
                $this->output->set_output(json_encode($this->boutique_model->delete_cart($this->session->id_tmp)));
            }
        }
    }

    /**
     * Supprime un produit dans le panier pour les connectés et les non connectés
     * APPEL AJAX
     */
    public function delete_by_product() {
        if ($this->input->is_ajax_request()) {
            $this->output->set_content_type('application/json');
            $this->output->set_header('Access-Control-Allow-Origin: *');
            $this->output->set_output(json_encode($this->boutique_model->delete_by_product($this->input->post('id_product'), $this->session->id_tmp, $this->session->id_user)));
        }
    }

    /**
     *  Modifie la quantité d'un produit du panier pour les connectés ou les non connectés
     *  APPEL AJAX
     */
    public function update_product() {
        if ($this->input->is_ajax_request()) {
            $this->output->set_content_type('application/json');
            $this->output->set_header('Access-Control-Allow-Origin: *');
            if ($this->input->post('quantity') > 0) {
                $this->output->set_output(json_encode($this->boutique_model->update_cart($this->input->post('quantity'), $this->input->post('id'))));
            }
        }
    }

}
