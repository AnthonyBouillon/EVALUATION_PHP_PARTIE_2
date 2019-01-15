<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function register() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('u_name', 'nom', 'required|min_length[2]|max_length[255]|alpha_numeric_spaces|xss_clean');
            $this->form_validation->set_rules('u_firstname', 'prénom', 'required|min_length[2]|max_length[255]|alpha_numeric_spaces|xss_clean');
            $this->form_validation->set_rules('u_email', 'mail', 'required|max_length[255]|valid_email|xss_clean|is_unique[users.u_email]');
            $this->form_validation->set_rules('u_login', 'nom d\'utilisateur', 'required|min_length[2]|max_length[255]|alpha_numeric_spaces|xss_clean|is_unique[users.u_login]');
            $this->form_validation->set_rules('u_password', 'mot de passe', 'required|matches[confirm_password]|xss_clean');
            $this->form_validation->set_rules('confirm_password', 'confirmation du mot de passe', 'required|matches[u_password]|xss_clean');

            $password_hash = password_hash($_POST['u_password'], PASSWORD_DEFAULT);
            $data = array(
                'u_name' => $_POST['u_name'],
                'u_firstname' => $_POST['u_firstname'],
                'u_email' => $_POST['u_email'],
                'u_login' => $_POST['u_login'],
                'u_password' => $password_hash
            );
            if ($this->form_validation->run()) {
                if (!empty($_SESSION['username'])) {
                    $data['id_tmp'] = $_SESSION['id_tmp'];
                }
                $this->user_model->create_user($data);
            }
        }
        $title['title'] = 'Inscription';
        $this->load->view('header', $title);
        $this->load->view('register');
        $this->load->view('footer');
    }

    public function login() {
        $msg['fail'] = '';
        if ($this->input->post()) {
            $this->form_validation->set_rules('u_login', 'nom d\'utilisateur', 'required|xss_clean');
            $this->form_validation->set_rules('u_password', 'mot de passe', 'required|xss_clean');
            $result = $this->user_model->read_login($_POST['u_login']);
            if ($this->form_validation->run()) {
                if ($result == true) {
                    if (password_verify($_POST['u_password'], $result->u_password)) {
                        $msg['success'] = 'Bravo';
                        $_SESSION['username'] = $_POST['u_login'];
                        $_SESSION['id_user'] = $result->u_id;
                        
                    } else {
                        $msg['fail'] = 'Mauvais mot de passe';
                    }
                } else {
                    $msg['fail'] = 'Mauvais login';
                }
            }
        }
        $title['title'] = 'Connexion';
        $this->load->view('header', $title);
        $this->load->view('login', $msg);
        $this->load->view('footer');
    }

    public function logout() {
        $title['title'] = 'Déconnexion';
        $this->load->view('header', $title);
        $this->load->view('logout');
        $this->load->view('footer');
    }

}
