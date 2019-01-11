<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Produit extends CI_Controller {

    public function show_list() {
        if ($this->input->post()) {
            $id = $this->input->post('pro_id');
            $this->produit_model->delete_list($id);
            $data['list'] = $this->produit_model->read_list();

            $title['title'] = 'Liste des produits';
            $this->load->view('header', $title);
            $this->load->view('list', $data);
            $this->load->view('footer');
        } else {
            $data['list'] = $this->produit_model->read_list();
            $title['title'] = 'Liste des produits';
            $this->load->view('header', $title);
            $this->load->view('list', $data);
            $this->load->view('footer');
        }
    }

    public function load_view() {
        $data['data_cat'] = $this->produit_model->read_cat();
        $title['title'] = 'Ajouter un produit';
        $this->load->view('header', $title);
        $this->load->view('add_list', $data);
        $this->load->view('footer');
    }

    public function add_list() {
        // Si il récupère au moins une valeur
        if ($this->input->post()) {

            // Délaration des règles de validation pour les champs du formulaire
            $this->form_validation->set_rules('pro_cat_id', 'Libellé', 'required|min_length[1]|max_length[2]|integer|xss_clean');
            $this->form_validation->set_rules('pro_ref', 'Référence', 'required|min_length[2]|max_length[10]|is_unique[produits.pro_ref]|alpha_numeric_spaces|xss_clean');
            $this->form_validation->set_rules('pro_libelle', 'Libellé', 'required|min_length[2]|max_length[200]|alpha_numeric_spaces|xss_clean');
            $this->form_validation->set_rules('pro_description', 'Description', 'required|min_length[2]|max_length[1000]|alpha_numeric_spaces|xss_clean');
            $this->form_validation->set_rules('pro_prix', 'Prix', 'required|min_length[2]|max_length[200]|numeric|xss_clean');
            $this->form_validation->set_rules('pro_stock', 'Stock', 'required|min_length[2]|max_length[200]|integer|xss_clean');
            $this->form_validation->set_rules('pro_couleur', 'Couleur', 'required|min_length[2]|max_length[30]|alpha|xss_clean');
            $this->form_validation->set_rules('pro_bloque', 'Oui_Non', 'required|xss_clean');
            $this->form_validation->set_rules('pro_photo', 'Image', 'min_length[1]|xss_clean');

            // Si les vérifications des champs est correct
            if ($this->form_validation->run()) {
                // Je récupère les données
                $data = $this->input->post();


                $extension = substr(strrchr($_FILES['pro_photo']['name'], '.'), 1);
                // Je rajoute le nom de la photo (car pas un post mais un files)
                $data["pro_photo"] = $extension;
                // J'appelle ma méthode qui provient du model
                $this->produit_model->insert_list($data);
                $this->session->set_flashdata('success', 'Bravo, le produit a été ajouté');

                $max_id = $this->db->insert_id();
                $config['upload_path'] = FCPATH . 'assets/image/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = 3000;
                $config['max_width'] = 3000;
                $config['max_height'] = 3000;
                $config['file_name'] = $max_id . '.jpg';
                $this->upload->initialize($config);
                $this->upload->do_upload('pro_photo');







                // et je recharge la vue
                $this->load_view();
            } else {
                $this->load_view();
            }
        } else {
            $this->load_view();
        }
    }

    /**
     * Chargement des vues pour la page update
     * @param type $id
     */
    public function load_view_update($id) {
        $data['this_product'] = $this->produit_model->read_one_product($id);
        $data['this_cat'] = $this->produit_model->read_cat();
        $title['title'] = 'Modifier un produit';
        $this->load->view('header', $title);
        $this->load->view('update_list', $data);
        $this->load->view('footer');
    }

    public function update_list($id) {
        if ($this->input->post()) {
            // Délaration des règles de validation pour les champs du formulaire
            $this->form_validation->set_rules('pro_cat_id', 'Libellé', 'required|min_length[1]|max_length[2]|integer|xss_clean');
            $this->form_validation->set_rules('pro_ref', 'Référence', 'required|min_length[2]|max_length[10]|alpha_numeric_spaces|xss_clean');
            $this->form_validation->set_rules('pro_libelle', 'Libellé', 'required|min_length[2]|max_length[200]|alpha_numeric_spaces|xss_clean');
            $this->form_validation->set_rules('pro_description', 'Description', 'required|min_length[2]|max_length[1000]|xss_clean');
            $this->form_validation->set_rules('pro_prix', 'Prix', 'required|min_length[2]|max_length[200]|numeric|xss_clean');
            $this->form_validation->set_rules('pro_stock', 'Stock', 'required|min_length[1]|max_length[200]|integer|xss_clean');
            $this->form_validation->set_rules('pro_couleur', 'Couleur', 'required|min_length[2]|max_length[30]|alpha|xss_clean');
            $this->form_validation->set_rules('pro_bloque', 'Oui_Non', 'required|xss_clean');

            // Si les vérifications des champs est correct
            if ($this->form_validation->run()) {
                // Je récupère les données
                $data = $this->input->post();


                if (!empty($_FILES['pro_photo']['name'])) {
                    $extension = substr(strrchr($_FILES['pro_photo']['name'], '.'), 1);
                    // Je rajoute le nom de la photo (car pas un post mais un files)
                    $data["pro_photo"] = $extension;
                    $this->form_validation->set_rules('pro_photo', 'Image', 'min_length[1]|xss_clean');
                    if ($this->form_validation->run()) {
                        unlink(FCPATH . 'assets/image/' . $id . '.' . 'jpg');
                        $config['upload_path'] = FCPATH . 'assets/image/';
                        $config['allowed_types'] = 'gif|jpg|png|jpeg';
                        $config['max_size'] = 3000;
                        $config['max_width'] = 3000;
                        $config['max_height'] = 3000;
                        $config['file_name'] = $id . '.jpg';
                        $this->upload->initialize($config);
                        $this->upload->do_upload('pro_photo');
                    }
                }
                $data['pro_d_modif'] = date('Y-m-d H:i:s');
                // J'appelle ma méthode qui provient du model
                $this->produit_model->update_list($id, $data);
                $this->session->set_flashdata('success', 'Bravo, le produit a été modifié');
            }
            $this->load_view_update($id);
        } else {
            $this->load_view_update($id);
        }
    }

}
