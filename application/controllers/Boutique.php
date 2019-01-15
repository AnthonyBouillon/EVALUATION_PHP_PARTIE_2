<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Boutique extends CI_Controller {

    public function read_list() {
        if (!isset($_SESSION['id_tmp'])) {
            $_SESSION['id_tmp'] = uniqid();
        }
        if ($this->input->post()) {

            $data = array(
                'quantity' => $_POST['quantity'],
                'id_product' => $_POST['pro_id'],
                'id_tmp' => $_SESSION['id_tmp']
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
        if ($this->input->post('delete_submit')) {
            $this->boutique_model->delete_cart($_SESSION['id_tmp']);
        }
        if ($this->input->post('update_submit')) {
            $this->boutique_model->update_cart($_POST['quantity'], $_POST['id']);
        }

        $data['cart_user'] = $this->boutique_model->read_cart();
        $data['ttc'] = $this->boutique_model->read_ttc();
        $title['title'] = 'Panier';
        $this->load->view('header', $title);
        $this->load->view('cart_user', $data);
        $this->load->view('footer');
    }

}
