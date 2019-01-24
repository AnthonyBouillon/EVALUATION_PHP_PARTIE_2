
<?php
// Assigne un id unique pour la première visite
if (!isset($this->session->id_tmp)) {
    $this->session->id_tmp = uniqid();
    // ???????????????????????????????????? PROBLEME DE LOGIQUE
} /*else if (isset($this->session->username) && !isset($this->session->id_tmp)) {
    $this->session->id_tmp = 0;
}*/
// Récupère en tete du langage du navigateur
$language = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
// Récupère les deux premières lettres
$language = $language{0} . $language{1};
if ($language == "fr") {
    $this->lang->load('fr', 'french');
} else {
    $this->lang->load('en', 'english');
}
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
        <link rel="stylesheet" media="screen and (max-width: 640px)" href="<?= base_url('assets/css/mobile.css') ?>">
        <title><?= !empty($title) ? $title : 'Titre indéfini' ?></title>
    </head>
    <body>
        <div class="container-fluid mb-4">
            <!-- Header contenant le logo et la bannière -->
            <header class="row block-header">
                <div class="col-2">
                    <img src="<?= base_url('assets/image/logo.png') ?>" alt="Logo du site" class="img-fluid logo">
                </div>
                <div class="col-10">
                    <img src="<?= base_url('assets/image/banner_1.jpg') ?>" alt="Logo du site" class="img-fluid banner">
                </div>
            </header>
            <!-- Navigation contenant les liens des différentes pages -->
            <nav class="row navbar navbar-expand-lg">
                <a class="navbar-brand" href="#">Jarditou</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="container">
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <?php if ($this->session->admin == 1): ?>
                                <!-- Faire un accès administrateur -->
                                <li class="nav-item active">
                                    <a class="nav-link" href="<?= site_url('admin/produit/read_list') ?>">Liste des produits (Administrateur)</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= site_url('admin/produit/insert_list') ?>">Ajouter un produit (Administrateur)</a>
                                </li>
                            <?php endif; ?>
                            <!-- Public -->
                            <li class="nav-item active">
                                <a class="nav-link" href="<?= site_url('boutique/read_list') ?>">Liste des produits</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url('boutique/read_cart') ?>">Panier</a>
                            </li>
                            <!-- Si l'utilisateur n'est pas connecté -->
                            <?php if (!isset($this->session->username)) { ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= site_url('user/register') ?>">Inscription</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= site_url('user/login') ?>">Connexion</a>
                                </li>
                                <!-- Si l'utilisateur est connecté -->
                            <?php } else { ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= site_url('boutique/read_list') ?>"><?= $this->session->username ?></a>
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
        <div class="container content pt-4 mb-4 pb-4">
            <?php $this->load->view($page); ?>
        </div>
        <div class="container-fluid">
            <footer>
                <img src="<?= base_url('assets/image/img_footer.png') ?>" class="img-fluid" alt="Image">
            </footer>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="<?= base_url('assets/js/script.js') ?>"></script>
    </body>
</html>
