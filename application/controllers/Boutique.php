<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Boutique extends CI_Controller {

    public function read_list() {
        if ($this->input->post()) {
            $_SESSION['id_user'] = uniqid();
            $data = array(
                'quantity' => $_POST['quantity'],
                'id_product' => $_POST['pro_id'],
                'id_user' => $_SESSION['id_user']
            );
            $this->boutique_model->create_cart($data);
        }
        $data['list'] = $this->boutique_model->read_list();
        $title['title'] = 'Liste des produits';
        $this->load->view('header', $title);
        $this->load->view('list_user', $data);
        $this->load->view('footer');
    }

    public function read_cart() {
        
        $data['cart_user'] = $this->boutique_model->read_cart();
        $title['title'] = 'Panier';
        $this->load->view('header', $title);
        $this->load->view('cart_user', $data);
        $this->load->view('footer');
    }

}
