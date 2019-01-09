<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Produit extends CI_Controller {

    public function show_list() {
        // Appelle la méthode qui retourne les données des produits faite dans le model
        $data['list'] = $this->produit_model->get_list();
        $title['title'] = 'Liste des produits';
        $this->load->view('header', $title);
        $this->load->view('list', $data);
        $this->load->view('footer');
    }

    public function load_view() {
        $data['data_cat'] = $this->produit_model->get_cat_name();
        $title['title'] = 'Ajouter un produit';
        $this->load->view('header', $title);
        $this->load->view('add_list', $data);
        $this->load->view('footer');
    }

    public function add_list() {
        // Si il récupère au moins une valeur
        if ($this->input->post()) {
            
            // Délaration des règles de validation pour les champs du formulaire
            $this->form_validation->set_rules('pro_cat_id', 'Libellé', 'required|min_length[2]|max_length[200]|integer');
            $this->form_validation->set_rules('pro_ref', 'Référence', 'required|min_length[2]|max_length[10]|is_unique[produits.pro_ref]|regex_match[/^[A-Za-z@-_]+$/]');
            $this->form_validation->set_rules('pro_libelle', 'Libellé', 'required|min_length[2]|max_length[200]|alpha_numeric_spaces');
            $this->form_validation->set_rules('pro_description', 'Description', 'required|min_length[2]|max_length[1000]|alpha_numeric_spaces');
            $this->form_validation->set_rules('pro_prix', 'Prix', 'required|min_length[2]|max_length[200]|decimal');
            $this->form_validation->set_rules('pro_stock', 'Stock', 'required|min_length[2]|max_length[200]|decimal');
            $this->form_validation->set_rules('pro_couleur', 'Couleur', 'required|min_length[2]|max_length[30]|alpha');
            $this->form_validation->set_rules('pro_bloque', 'Oui_Non', 'required');
            // Si les vérifications des champs est correct
            if ($this->form_validation->run()) {
                // Je récupère les données
                $data = $this->input->post();
                // Je rajoute le nom de la photo (car pas un post mais un files)
                $data["pro_photo"] = $_FILES['pro_photo']['name'];
                // J'appelle ma méthode qui provient du model
                $this->produit_model->insert_list($data);
                // et je recharge la vue
                $this->load_view();
            } else {
                $this->load_view();
            }
            
        } else {
            $this->load_view();
        }
    }

}
