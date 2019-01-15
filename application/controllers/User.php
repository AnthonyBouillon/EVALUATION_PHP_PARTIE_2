<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    /**
     * Inscription
     */
    public function register() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('u_name', 'nom', 'required|min_length[2]|max_length[255]|alpha_numeric_spaces|xss_clean');
            $this->form_validation->set_rules('u_firstname', 'prénom', 'required|min_length[2]|max_length[255]|alpha_numeric_spaces|xss_clean');
            $this->form_validation->set_rules('u_email', 'mail', 'required|max_length[255]|valid_email|xss_clean|is_unique[users.u_email]');
            $this->form_validation->set_rules('u_login', 'nom d\'utilisateur', 'required|min_length[2]|max_length[255]|alpha_numeric_spaces|xss_clean|is_unique[users.u_login]');
            $this->form_validation->set_rules('u_password', 'mot de passe', 'required|matches[confirm_password]|xss_clean');
            $this->form_validation->set_rules('confirm_password', 'confirmation du mot de passe', 'required|matches[u_password]|xss_clean');
            // Si le formulaire est rempli correctement
            if ($this->form_validation->run()) {
                // Mot de passe chiffré
                $password_hash = password_hash($this->input->post('u_password'), PASSWORD_DEFAULT);
                $data = array(
                    'u_name' => $this->input->post('u_name'),
                    'u_firstname' => $this->input->post('u_firstname'),
                    'u_email' => $this->input->post('u_email'),
                    'u_login' => $this->input->post('u_login'),
                    'u_password' => $password_hash
                );
                // Si l'utilisateur possède un identifiant unique temporaire
                if (!empty($this->session->id_tmp)) {
                    // On l'insère dans la base de données
                    $data['id_tmp'] = $this->session->id_tmp;
                }
                // Enregistre un nouvel utilisateur
                $this->user_model->create_user($data);
            }
        }
        // Vues
        $title['title'] = 'Inscription';
        $this->load->view('header', $title);
        $this->load->view('register');
        $this->load->view('footer');
    }

    /**
     * Connexion
     */
    public function login() {
        // Vérifie qu'il y a bien des valeurs à récupèrer
        if ($this->input->post()) {
            // Vérification des champs
            $this->form_validation->set_rules('u_login', 'nom d\'utilisateur', 'required|xss_clean');
            $this->form_validation->set_rules('u_password', 'mot de passe', 'required|xss_clean');
            // Si aucune erreur
            if ($this->form_validation->run()) {
                // Récupère les identifiants de l'utilisateur grâce au login
                $result = $this->user_model->read_login($this->input->post('u_login'));
                if ($result) {
                    // Si le mot de passe est correct
                    if (password_verify($this->input->post('u_password'), $result->u_password)) {
                        $this->session->set_flashdata('success', 'Vous êtes connectez !');
                        $this->session->username = $this->input->post('u_login');
                        $this->session->id_user = $result->u_id;
                    } else {
                        $this->session->set_flashdata('fail', 'Mauvais identifiant');
                    }
                } else {
                    $this->session->set_flashdata('fail', 'Mauvais identifiant');
                }
            }
        }
        // Vues
        $title['title'] = 'Connexion';
        $this->load->view('header', $title);
        $this->load->view('login');
        $this->load->view('footer');
    }

    /**
     * Déconnexion
     */
    public function logout() {
        $title['title'] = 'Déconnexion';
        $this->load->view('header', $title);
        $this->load->view('logout');
        $this->load->view('footer');
    }

}
