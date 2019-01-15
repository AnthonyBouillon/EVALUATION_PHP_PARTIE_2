<?php
//session_start();
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
        <title><?= $title ?></title>
    </head>
    <body>
        <div class="container-fluid">
            <header class="row block-header">
                    <div class="col-2">
                        <img src="<?= base_url('assets/image/logo.png') ?>" alt="Logo du site" class="img-fluid logo">
                    </div>
                    <div class="col-10">
                        <img src="<?= base_url('assets/image/banner_1.jpg') ?>" alt="Logo du site" class="img-fluid banner">
                    </div>
            </header>
            <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand" href="#">Jarditou</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="container">
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item active">
                                <a class="nav-link" href="<?= site_url('produit/read_list') ?>">Liste des produits (Administrateur)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url('produit/insert_list') ?>">Ajouter un produit (Administrateur)</a>
                            </li>
                            <li class="nav-item active">
                                <a class="nav-link" href="<?= site_url('boutique/read_list') ?>">Liste des produits (Utilisateur)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url('boutique/read_cart') ?>">Panier (Utilisateur)</a>
                            </li>
                            <?php if(!isset($_SESSION['username'])){ ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url('user/register') ?>">Inscription</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url('user/login') ?>">Connexion</a>
                            </li>
                            <?php }else{  ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url('boutique/read_list') ?>"><?= $_SESSION['username'] ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url('user/logout') ?>">Déconnexion</a>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
