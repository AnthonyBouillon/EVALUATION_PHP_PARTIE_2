<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlleur utilisateur
 * Gestion des inscription, connexions et déconnexion
 * 
 * Page 404
 */
class User extends CI_Controller {

    /**
     * Enregistrement d'un utilisateur dans la base de données
     * Mot de passe chiffré
     */
    public function register() {
        if ($this->input->post()) {
            // Vérification des champs du formulaire
            $this->form_validation->set_rules('u_name', 'nom', 'required|min_length[2]|max_length[255]|alpha_numeric_spaces|xss_clean');
            $this->form_validation->set_rules('u_firstname', 'prénom', 'required|min_length[2]|max_length[255]|alpha_numeric_spaces|xss_clean');
            $this->form_validation->set_rules('u_email', 'mail', 'required|max_length[255]|valid_email|xss_clean|is_unique[users.u_email]');
            $this->form_validation->set_rules('u_login', 'nom d\'utilisateur', 'required|min_length[2]|max_length[255]|alpha_numeric_spaces|xss_clean|is_unique[users.u_login]');
            $this->form_validation->set_rules('u_password', 'mot de passe', 'required|matches[confirm_password]|xss_clean');
            $this->form_validation->set_rules('confirm_password', 'confirmation du mot de passe', 'required|matches[u_password]|xss_clean');
            // Si les données sont correct
            if ($this->form_validation->run()) {
                // Mot de passe chiffré
                $password_hash = password_hash($this->input->post('u_password'), PASSWORD_DEFAULT);
                // Récupèration des données du formulaire
                $data = array(
                    'u_name' => $this->input->post('u_name'),
                    'u_firstname' => $this->input->post('u_firstname'),
                    'u_email' => $this->input->post('u_email'),
                    'u_login' => $this->input->post('u_login'),
                    'u_password' => $password_hash
                );
                // Si l'utilisateur possède un identifiant unique temporaire 
                // (???????????? ID TEMPORAIRE EXISTE FORCEMENT | A VERIFIER)
                //if (!empty($this->session->id_tmp)) {
                    // On l'insère dans la base de données
                    $data['id_tmp'] = $this->session->id_tmp;
                //}
                // Enregistre un nouvel utilisateur
                $this->user_model->create_user($data);
            }
        }
        
        $data['title'] = 'Inscription';
        $data['page'] = 'register';
        $this->load->view('templates/template', $data);
    }

    /**
     * Authentification de l'utilisateur
     */
    public function login() {
        
        if ($this->input->post()) {
            // Vérification des champs
            $this->form_validation->set_rules('u_login', 'nom d\'utilisateur', 'required|xss_clean');
            $this->form_validation->set_rules('u_password', 'mot de passe', 'required|xss_clean');
            // Si aucune erreur
            if ($this->form_validation->run()) {
                // Récupère le mot de passe de l'utilisateur correspondant à son login
                $result = $this->user_model->read_login($this->input->post('u_login'));
                // Si il y a un résultat (login et le mot de passe existe)
                if ($result) {
                    // Si la saisie du mot de passe (form) correspond au mot de passe (bdd)
                    if (password_verify($this->input->post('u_password'), $result->u_password)) {
                        $this->session->set_flashdata('success', 'Vous êtes connectez !');
                        // SESSION DONNEE UTILISATEUR
                        $this->session->username = $this->input->post('u_login');
                        $this->session->id_user = $result->u_id;
                        $this->session->admin = $result->admin;
                    } else {
                        $this->session->set_flashdata('fail', 'Mauvais identifiant');
                    }
                } else {
                    $this->session->set_flashdata('fail', 'Mauvais identifiant');
                }
            }
        }

        $data['title'] = 'Connexion';
        $data['page'] = 'login';
        $this->load->view('templates/template', $data);
    }

    /**
     * Page déconnexion
     */
    public function logout() {
        $data['title'] = 'Déconnexion';
        $data['page'] = 'logout';
        $this->load->view('templates/template', $data);
    }
    /**
     * Page 404
     */
    public function error_page(){
         $data['title'] = 'ERROR 404';
        $data['page'] = '404';
        $this->load->view('templates/template', $data);
    }

}
