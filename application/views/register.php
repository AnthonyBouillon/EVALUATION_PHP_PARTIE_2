 <div class="container content pt-4 pb-4">
        <h1 class="text-center">Inscription</h1>
        <br>
        <?php if(!empty(validation_errors())){ ?>
        <?= '<div class="alert alert-danger">' . validation_errors() . '</div>' ?>
        <?php } ?>
        <hr>
        <form acion="script_register.php" method="POST">
            <div class="row">
                <div class="form-group col 6">
                    <label for="name">Nom</label>
                    <input type="text" name="u_name" class="form-control" id="name" placeholder="Nom" pattern="[A-Za-z-àáâäçèéêëìíîïñòóôöùúûü -]{1,255}" required value="<?= !empty($_POST['u_name']) ? $_POST['u_name'] : '' ?>">
                </div>
                <div class="form-group col 6">
                    <label for="firstname">Prénom</label>
                    <input type="text" name="u_firstname" class="form-control" id="firstname" placeholder="Prénom" pattern="[A-Za-z-àáâäçèéêëìíîïñòóôöùúûü -]{1,255}" required value="<?= !empty($_POST['u_firstname']) ? $_POST['u_firstname'] : '' ?>">
                </div>
            </div>


            <div class="form-group">
                <label for="email">Adresse e-mail</label>
                <input type="email" name="u_email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Adresse e-mail" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$" required value="<?= !empty($_POST['u_email']) ? $_POST['u_email'] : '' ?>">
            </div>
            <div class="form-group">
                <label for="login">Nom d'utilisateur</label>
                <input type="text" name="u_login" class="form-control" id="login" placeholder="Nom d'utilisateur" pattern="[A-Za-z-àáâäçèéêëìíîïñòóôöùúûü@*/_0-9 -]{1,255}" required value="<?= !empty($_POST['u_login']) ? $_POST['u_login'] : '' ?>">
            </div>
            <div class="row">
                <div class="form-group col 6">
                    <label for="password">Mot de passe</label>
                    <input type="password" name="u_password" class="form-control" id="password" placeholder="Mot de passe" required value="<?= !empty($_POST['u_password']) ? $_POST['u_password'] : '' ?>">
                </div>
                <div class="form-group col 6">
                    <label for="confirm_password">Confirmation mot de passe</label>
                    <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Confirmation mot de passe" required value="<?= !empty($_POST['confirm_password']) ? $_POST['confirm_password'] : '' ?>">
                </div>
            </div>
            <button type="submit" class="btn btn-primary" id="submit">M'enregistrer</button>
        </form>
    </div>