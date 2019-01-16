<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Produit extends CI_Controller {

    /**
     * Si le formulaire est soumis,
     * récupère l'id du produit
     * appelle la méthode qui supprime un produit
     * et retourne les vues
     */
    public function read_list($test =! null) {
        if($this->session->admin != 1){
            header('location: ../boutique/read_list');
        }
        if ($this->input->post()) {
            $id = $this->input->post('pro_id');
            $this->produit_model->delete_product($id);
        }
                // Pagination test
        $this->load->library('pagination');
        $config['base_url'] = 'http://localhost/Jarditou/index.php/produit/read_list';
        $config['total_rows'] = $this->db->get('produits')->num_rows();
        $config['per_page'] = 5;
     
           $config['next_link'] = ' Page suivante';
           $config['first_link'] = '';
  $config['prev_link'] = 'Page précédente ';
  $config['last_link'] = '';
         $config['use_page_numbers'] = TRUE;
        $this->pagination->initialize($config);
        $data['title'] = 'Liste des produits';
         // Affiche tous les produits
        if(empty($test)){
            $test = 1;
        }
        // Nom de la page
        $data['page'] = 'list';
        $data['list'] = $this->produit_model->read_products(5, $test);
        $this->load->view('templates/template', $data);
    }

    /**
     * Si le formulaire est soumis,
     * vérification des champs
     * récupèration des données
     * insertion d'une nouvelle image dans un dossier 
     */
    public function insert_list() {
        if($this->session->admin != 1){
            header('location: ../boutique/read_list');
        }
        if ($this->input->post()) {
            // Vérification de chaques champs
            $this->form_validation->set_rules('pro_cat_id', 'Libellé', 'required|min_length[1]|max_length[2]|integer|xss_clean');
            $this->form_validation->set_rules('pro_ref', 'Référence', 'required|min_length[2]|max_length[10]|is_unique[produits.pro_ref]|alpha_numeric_spaces|xss_clean');
            $this->form_validation->set_rules('pro_libelle', 'Libellé', 'required|min_length[2]|max_length[200]|alpha_numeric_spaces|xss_clean');
            $this->form_validation->set_rules('pro_description', 'Description', 'required|min_length[2]|max_length[1000]|alpha_numeric_spaces|xss_clean');
            $this->form_validation->set_rules('pro_prix', 'Prix', 'required|min_length[2]|max_length[200]|numeric|xss_clean');
            $this->form_validation->set_rules('pro_stock', 'Stock', 'required|min_length[2]|max_length[200]|integer|xss_clean');
            $this->form_validation->set_rules('pro_couleur', 'Couleur', 'required|min_length[2]|max_length[30]|alpha|xss_clean');
            $this->form_validation->set_rules('pro_bloque', 'Oui_Non', 'required|xss_clean');
            $this->form_validation->set_rules('pro_photo', 'Image', 'min_length[1]|xss_clean');
            // Si les règles des champs sont correct
            if ($this->form_validation->run()) {
                // Je récupère les données
                $data = $this->input->post();
                // Récupère l'extension de l'image 
                $extension = substr(strrchr($_FILES['pro_photo']['name'], '.'), 1);
                // Je rajoute le nom de la photo (car pas un post mais un files)
                $data["pro_photo"] = $extension;
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
        // Nom de la page
        $data['page'] = 'add_list';
        $data['data_cat'] = $this->produit_model->read_categorie();
        $this->load->view('templates/template', $data);
    }

    /**
     * Modifie les valeurs d'un produit
     * @param type $id
     */
    public function update_list($id) {
        if($this->session->admin != 1){
            header('location: ../boutique/read_list');
        }
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
            // Si les vérifications des champs sont correct
            if ($this->form_validation->run()) {
                // Je récupère les données
                $data = $this->input->post();
                if (!empty($_FILES['pro_photo']['name'])) {
                    $extension = substr(strrchr($_FILES['pro_photo']['name'], '.'), 1);
                    $data["pro_photo"] = $extension;
                    // Date d'aujourd'hui
                    $data['pro_d_modif'] = date('Y-m-d H:i:s');
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
                $this->produit_model->update_product($id, $data);
                $this->session->set_flashdata('success', 'Bravo, le produit a été modifié');
            }
        }    
        $data['title'] = 'Modifier un produit';
        // Nom de la page
        $data['page'] = 'update_list';
        $data['this_cat'] = $this->produit_model->read_categorie();
        $data['this_product'] = $this->produit_model->read_by_product($id);
        $this->load->view('templates/template', $data);
    }

}
