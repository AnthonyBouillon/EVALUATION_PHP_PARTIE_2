<div class="container content pt-4 pb-4">
    <h1 class="text-center">Connexion</h1>
    <br>
    <?php if (!empty(validation_errors())) { ?>
        <?= '<div class="alert alert-danger">' . validation_errors() . '</div>' ?>
    <?php } ?>
    <small class="text-success"><?= !empty($success) ? $success : '' ?></small>
    <small class="text-danger"><?= !empty($fail) ? $fail : '' ?></small>
    <hr>
    <form acion="script_register.php" method="POST">
        <div class="">
            <div class="form-group">
                <label for="u_login">Nom d'utilisateur</label>
                <input type="text" name="u_login" class="form-control" id="u_login" placeholder="Nom d'utilisateur" pattern="[A-Za-z-àáâäçèéêëìíîïñòóôöùúûü -]{1,255}" required value="<?= !empty($_POST['u_login']) ? $_POST['u_login'] : '' ?>">
            </div>
            <div class="form-group">
                <label for="u_password">Mot de passe</label>
                <input type="password" name="u_password" class="form-control" id="u_password" placeholder="Mot de passe" pattern="[A-Za-z-àáâäçèéêëìíîïñòóôöùúûü -]{1,255}" required value="<?= !empty($_POST['u_password']) ? $_POST['u_password'] : '' ?>">
            </div>
        </div>
        <button type="submit" name="submit_register" class="btn btn-primary" id="submit">M'enregistrer</button>
    </form>
</div>
