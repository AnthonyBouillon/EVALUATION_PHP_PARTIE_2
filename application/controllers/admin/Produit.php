<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlleur de l'administrateur
 * CRUD FONCTIONNEL
 */
class Produit extends CI_Controller {

    /**
     * $id_url = !null : récupère le paramètre dans l'url si il existe
     * @param type $id_url
     */
    public function read_list($id_url = !null) {
        // Si non administrateur -> sort
        if ($this->session->admin != 1) {
            header('location: ../../boutique/read_list');
        }

        // Supprime un produit
        if ($this->input->post()) {
            $id = $this->input->post('pro_id');
            $this->produit_model->delete_product($id);
            $this->session->set_flashdata('succes_delete', 'Produit supprimer');
        }

        // Configuration du système de pagination
        $config['base_url'] = base_url('admin/produit/read_list');
        $config['total_rows'] = $this->db->get('produits')->num_rows();
        $config['per_page'] = 5;
        $config['prev_link'] = ' << ';
        $config['next_link'] = ' >> ';
        $config['first_link'] = ' first ';
        $config['last_link'] = ' last ';
        $config['use_page_numbers'] = TRUE;
        $this->pagination->initialize($config);
        
        // Vue
        $data['title'] = 'Liste des produits';
        $data['page'] = 'admin/list';
        // Liste des produits
        $data['list'] = $this->produit_model->read_products(5, $id_url);
        $this->load->view('templates/template', $data);
    }

    /**
     * 
     */
    public function insert_list() {
        // Si non administrateur -> sort
        if ($this->session->admin != 1) {
            header('location: ../../boutique/read_list');
        }
        
        //
        if ($this->input->post()) {
            // Vérification de chaques champs
            $this->form_validation->set_rules('pro_cat_id', 'Libellé', 'required|min_length[1]|max_length[2]|integer|xss_clean');
            $this->form_validation->set_rules('pro_ref', 'Référence', 'required|min_length[2]|max_length[10]|is_unique[produits.pro_ref]|xss_clean');
            $this->form_validation->set_rules('pro_libelle', 'Libellé', 'required|min_length[2]|max_length[200]|xss_clean');
            $this->form_validation->set_rules('pro_description', 'Description', 'required|min_length[2]|max_length[1000]|xss_clean');
            $this->form_validation->set_rules('pro_prix', 'Prix', 'required|min_length[2]|max_length[200]|numeric|xss_clean');
            $this->form_validation->set_rules('pro_stock', 'Stock', 'required|min_length[2]|max_length[200]|integer|xss_clean');
            $this->form_validation->set_rules('pro_couleur', 'Couleur', 'required|min_length[2]|max_length[30]|alpha|xss_clean');
            $this->form_validation->set_rules('pro_bloque', 'Oui_Non', 'required|xss_clean');
            $this->form_validation->set_rules('pro_photo', 'Image', 'min_length[1]|xss_clean');
            
            // Si les règles des champs sont correct
            if ($this->form_validation->run()) {
                // Je récupère les données du formulaire
                $data = $this->input->post();
                // Récupère l'extension de l'image 
                $extension = substr(strrchr($_FILES['pro_photo']['name'], '.'), 1);
                // Je rajoute l'extension de la photo (car pas un post mais un files)
                $data["pro_photo"] = 'jpg';
                // J'appelle ma méthode qui permet d'insérer une ligne dans la bdd
                $this->produit_model->create_product($data);
                // Message de succès
                $this->session->set_flashdata('success_add', 'Bravo, le produit a été ajouté');
                // Récupère l'id du produit qui vient d'être inséré
                $last_id = $this->db->insert_id();
                // Vérification du fichier à télécharger
                $config['upload_path'] = FCPATH . 'assets/image/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = 3000;
                $config['max_width'] = 3000;
                $config['max_height'] = 3000;
                $config['file_name'] = $last_id . '.jpg';
                $this->upload->initialize($config);
                $this->upload->do_upload('pro_photo');
            }
        }


        $data['title'] = 'Ajouter un produit';
        // Chemin/Nom de la page
        $data['page'] = 'admin/add_list';
        // Lis les catégories
        $data['data_cat'] = $this->produit_model->read_categorie();
        $this->load->view('templates/template', $data);
    }

    /**
     * Vérification du status de l'utilisateur
     * Vérification des champs du formulaire
     * Upload de l'image si elle existe
     * Modifie un produit
     * @param type $id
     */
    public function update_list($id) {
        // Si non administrateur -> sort
        if ($this->session->admin != 1) {
            header('location: ../../boutique/read_list');
        }
        // Si le formulaire contient des données après soumission
        if ($this->input->post()) {
            // Délaration des règles de validation pour les champs du formulaire
            $this->form_validation->set_rules('pro_cat_id', 'Sous-catégorie', 'required|min_length[1]|max_length[2]|integer|xss_clean');
            $this->form_validation->set_rules('pro_ref', 'Référence', 'required|min_length[2]|max_length[10]|xss_clean');
            $this->form_validation->set_rules('pro_libelle', 'Libellé', 'required|min_length[2]|max_length[200]|xss_clean');
            $this->form_validation->set_rules('pro_description', 'Description', 'required|min_length[2]|max_length[1000]|xss_clean');
            $this->form_validation->set_rules('pro_prix', 'Prix', 'required|min_length[2]|max_length[200]|numeric|xss_clean');
            $this->form_validation->set_rules('pro_stock', 'Stock', 'required|min_length[1]|max_length[200]|integer|xss_clean');
            $this->form_validation->set_rules('pro_couleur', 'Couleur', 'required|min_length[2]|max_length[30]|alpha|xss_clean');
            $this->form_validation->set_rules('pro_bloque', 'Oui_Non', 'required|xss_clean');
            // Si les vérifications des champs sont correct
            if ($this->form_validation->run()) {
                // Je récupère les données
                $data = $this->input->post();
                // Date d'aujourd'hui
                $data['pro_d_modif'] = date('Y-m-d H:i:s');
                // Upload image
                if (!empty($_FILES['pro_photo']['name'])) {
                    $data["pro_photo"] = 'jpg';
                    // Supprime l'ancienne image
                    unlink(FCPATH . 'assets/image/' . $id . '.' . 'jpg');
                    // Configuration d'upload d'image
                    $config['upload_path'] = FCPATH . 'assets/image/';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                    $config['max_size'] = 3000;
                    $config['max_width'] = 3000;
                    $config['max_height'] = 3000;
                    $config['file_name'] = $id . '.jpg';
                    $this->upload->initialize($config);
                    $this->upload->do_upload('pro_photo');
                }
                // Modifie le produit
                $this->produit_model->update_product($id, $data);
                $this->session->set_flashdata('success', 'Bravo, le produit a été modifié');
            }
        }

        $data['title'] = 'Modifier un produit';
        $data['page'] = 'admin/update_list';
        // Lis les catégories
        $data['this_cat'] = $this->produit_model->read_categorie();
        // Lis le produit correspondant à son identifiant
        $data['this_product'] = $this->produit_model->read_by_product($id);
        $this->load->view('templates/template', $data);
    }
    /**
     * Affiche les sous-catégories si la requête ajax à fonctionné
     * Pour la page ajouter un produit et modifier un produit
     */
    public function get_sub_category() {
        if ($this->input->is_ajax_request()) {
            $data = $this->produit_model->read_sub_categorie($this->input->post('pro_cat_id'));
            echo json_encode($data);
        }
    }

}
