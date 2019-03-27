
<h1 class="text-center"><?= !isset($this->session->username) ? 'Connexion' : 'Bienvenue ' . $this->session->username ?></h1>
<br>
<!-- Affiche les erreurs lié aux règles des champs du formulaire -->
<?php if (!empty(validation_errors())) { ?>
    <?= '<div class="alert alert-danger">' . validation_errors() . '</div>' ?>
<?php } ?>
<!-- Affiche un message si oui ou non il as réussi à se connecter -->
<p class="text-success text-center"><b><?= $this->session->flashdata('success') ?></b></p>
<small class="text-danger"><b><?= $this->session->flashdata('fail') ?></b></small>
<hr>
<?php if(!isset($this->session->username)){ ?>
<!-- Formulaire qui permet à un utilisateur de se connecter -->
<form acion="" method="POST">
    <div class="">
        <div class="form-group">
            <label for="u_login">Nom d'utilisateur</label>
            <input type="text" name="u_login" class="form-control" id="u_login" placeholder="Nom d'utilisateur" required value="<?= !empty($_POST['u_login']) ? $_POST['u_login'] : '' ?>">
        </div>
        <div class="form-group">
            <label for="u_password">Mot de passe</label>
            <input type="password" name="u_password" class="form-control" id="u_password" placeholder="Mot de passe" required value="<?= !empty($_POST['u_password']) ? $_POST['u_password'] : '' ?>">
        </div>
    </div>
    <button type="submit" name="submit_login" class="btn btn-primary" id="submit"> M'enregistrer</button>
</form>
<?php } ?>
