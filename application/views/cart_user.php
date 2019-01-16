
    <h1 class="text-center">Votre panier (partie utilisateur)</h1>
    <?php 
    echo $this->session->id_tmp;
    echo $this->session->username;
    ?>
    <hr>
    <form method="POST">
        <input type="submit" value="Supprimer mon panier" class="btn btn-danger" name="delete_submit" onclick="return confirm('Voulez vous supprimer votre panier ?')">
    </form>
    <hr>
    <table class="table table-responsive table-hover">
        <thead>
            <tr>
                <th>Référence</th>
                <th>Photo</th>
                <th>Quantité</th>
                <th>Prix</th>
                <th>Supprimer</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if(!empty($cart_user)){
            foreach ($cart_user as $row) : ?>
                <tr>
                    <td>
                        <?= $row->pro_libelle ?>
                    </td>
                    <td>
                        <img class="img-fluid" src="<?= base_url('assets/image/' . $row->id_product . '.jpg') ?>" alt="Card image cap" width="150">
                    </td>
                    <td>
                        <?= $row->quantity ?>
                        <form method="POST">
                            <input type="hidden" name="id" value="<?= $row->id ?>">
                            <input type="hidden" name="id_tmp" value="<?= $_SESSION['id_tmp'] ?>">
                            <input type="hidden" name="id_product" value="<?= $row->id_product ?>">
                            <input type="number" name="quantity" class="form-control" value="<?= $row->quantity ?>">
                            <input type="submit" name="update_submit" value="Modifier">
                        </form>
                    </td>
                    <td>
                        <?= $row->price ?>
                    </td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="id_product" value="<?= $row->id_product ?>">
                            <input type="submit" name="delete_product" value="Supprimer" class="btn btn-danger" onclick="return confirm('Voulez vous supprimer le produit ?')">
                        </form>
                    </td>

                <tr>
            <?php endforeach; }else if (!empty($cart_user_l)) { 
                  foreach ($cart_user_l as $row) : ?>
                <tr>
                    <td>
                        <?= $row->pro_libelle ?>
                    </td>
                    <td>
                        <img class="img-fluid" src="<?= base_url('assets/image/' . $row->id_product . '.jpg') ?>" alt="Card image cap" width="150">
                    </td>
                    <td>
                        <?= $row->quantity ?>
                        <form method="POST">
                            <input type="hidden" name="id" value="<?= $row->id ?>">
                            <input type="hidden" name="id_tmp" value="<?= $_SESSION['id_tmp'] ?>">
                            <input type="hidden" name="id_product" value="<?= $row->id_product ?>">
                            <input type="number" name="quantity" class="form-control" value="<?= $row->quantity ?>">
                            <input type="submit" name="update_submit" value="Modifier">
                        </form>
                    </td>
                    <td>
                        <?= $row->price ?>
                    </td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="id_product" value="<?= $row->id_product ?>">
                            <input type="submit" name="delete_product" value="Supprimer" class="btn btn-danger" onclick="return confirm('Voulez vous supprimer le produit ?')">
                        </form>
                    </td>

                <tr>
            <?php endforeach;
            }  ?>
        </tbody>
    </table>
    <p><b>Prix final, toutes taxes comprises</b></p>
    <p>
         <?php 
         if(!empty($cart_user)){
         foreach ($ttc as $row) : ?>
        <?= $row->ttc ?>
            <?php endforeach; }  ?>
    </p>
    <form method="POST">
        <input type="submit" name="buy_submit" value="Acheter" class="btn btn-success">
        <?php
        if (isset($_POST['buy_submit']) && !isset($_SESSION['username'])) {
            echo 'Vous devez être connecté';
        }else if(isset($_POST['buy_submit']) && !empty($_SESSION['username'])){
            echo 'Donne moi ta carte bancaire et c\'est réglé';
            } 
        ?>
    </form>
            

