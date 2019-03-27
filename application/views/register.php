
<h1 class="text-center">Inscription</h1>
<hr>
<!-- Message d'erreur correspondant aux règles des champs du formulaire -->
<?php if (!empty(validation_errors())) { ?>
    <?= '<div class="alert alert-danger">' . validation_errors() . '</div>' ?>
<?php } ?>
<!-- Message d'erreur en javascript -->
<small class="c_red empty_field"></small><br>

<form acion="script_register.php" method="POST">
    <div class="row">
        <div class="form-group col-6 pl-2 pr-1">
            <label for="name">Nom</label>
            <input type="text" name="u_name" class="form-control" id="name" placeholder="Nom" value="<?= !empty($_POST['u_name']) ? $_POST['u_name'] : '' ?>" required>
            <small class="c_red name"></small>
        </div>
        <div class="form-group col-6 pl-2 pr-1">
            <label for="firstname">Prénom</label>
            <input type="text" name="u_firstname" class="form-control" id="firstname" placeholder="Prénom" value="<?= !empty($_POST['u_firstname']) ? $_POST['u_firstname'] : '' ?>" required>
            <small class="c_red firstname"></small>
        </div>
    </div>
    <div class="row">
    <div class="form-group col-12 pl-2 pr-1">
        <label for="email">Adresse e-mail</label>
        <input type="email" name="u_email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Adresse e-mail"  value="<?= !empty($_POST['u_email']) ? $_POST['u_email'] : '' ?>" required>
        <small class="c_red email"></small>
    </div>
    <div class="form-group col-12 pl-2 pr-1">
        <label for="login">Nom d'utilisateur</label>
        <input type="text" name="u_login" class="form-control" id="login" placeholder="Nom d'utilisateur"  value="<?= !empty($_POST['u_login']) ? $_POST['u_login'] : '' ?>" required>
        <small class="c_red login"></small>
    </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6 pl-2 pr-1">
            <label for="password">Mot de passe</label>
            <input type="password" name="u_password" class="form-control" id="password" placeholder="Mot de passe"  value="<?= !empty($_POST['u_password']) ? $_POST['u_password'] : '' ?>" required>
            <small class="c_red password_c"></small>
        </div>
        <div class="form-group col-md-6 pl-2 pr-1">
            <label for="confirm_password">Confirmation mot de passe</label>
            <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Confirmation mot de passe"  value="<?= !empty($_POST['confirm_password']) ? $_POST['confirm_password'] : '' ?>" required>
        </div>
    </div>
    <div class="row pl-2 pr-1">
    <button type="submit" class="btn btn-primary btn-block" id="submit_register">M'enregistrer</button>
    </div>
</form>
