
<h1 class="text-center">Votre panier</h1>
<hr>
<!-- Suppression de tous les produits -->
<form method="POST" action="<?php echo current_url(); ?>" class="delete_all_cart">
    <input type="submit" value="Supprimer mon panier" class="btn btn-danger" name="delete_submit" id="delete_all_submit" onclick="return confirm('Voulez vous supprimer votre panier ?')">
</form>
<hr>
<table class="table table-responsive table-hover table_cart">
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
        if (!empty($cart_user)) {
            foreach ($cart_user as $row) :
?>
                <tr>
                    <td>  
                        <?= $row->pro_libelle ?>
                    </td>
                    <td>
                        <img class="img-fluid" src="<?= base_url('assets/image/' . $row->id_product . '.jpg') ?>" alt="Card image cap" width="150">
                    </td>
                    <td>
                        <?= $row->quantity ?>
                        <!-- Modification de la quantité d'un produit -->
                        <form method="POST" action="<?php echo current_url(); ?>" class="form_update_quantity">
                            <input type="hidden" name="id" id="id" value="<?= $row->id ?>">
                            <input type="hidden" name="id_tmp" id="id_tmp" value="<?= $this->session->id_tmp ?>">
                            <input type="hidden" name="id_product" id="id_product" value="<?= $row->id_product ?>">
                            <input type="number" name="quantity" id="quantity" class="form-control" value="<?= $row->quantity ?>">
                            <input type="submit" name="update_submit" class="btn btn-block btn-primary update_submit" id="update_submit" value="Modifier">
                        </form>
                    </td>
                    <td>
                        <?= $row->price ?>
                    </td>
                    <td>
                        <!-- Suppression d'un produit -->
                        <form method="POST" action="<?php echo current_url(); ?>" class="form_delete_by_product">
                            <input type="hidden" name="id_product" value="<?= $row->id_product ?>" id="id_product">
                            <input type="submit" name="delete_by_product" value="Supprimer" class="btn btn-danger delete_by_product" id="delete_by_product" onclick="return confirm('Voulez vous supprimer le produit ?')">
                        </form>
                    </td>

                <tr>
<?php
                endforeach;
            }else if (!empty($cart_user_l)) {
                foreach ($cart_user_l as $row) :
?>
                <tr>
                    <td>
                        <?= $row->pro_libelle ?>
                    </td>
                    <td>
                        <img class="img-fluid" src="<?= base_url('assets/image/' . $row->id_product . '.jpg') ?>" alt="Card image cap" width="150">
                    </td>
                    <td>
                        <?= $row->quantity ?>
                        <form method="POST" action="<?php echo current_url(); ?>" class="form_update_quantity">
                            <input type="hidden" name="id" id="id" value="<?= $row->id ?>">
                            <input type="hidden" name="id_tmp" id="id_tmp" value="<?= $this->session->id_tmp ?>">
                            <input type="hidden" name="id_product" id="id_product" value="<?= $row->id_product ?>">
                            <input type="number" name="quantity" id="quantity" class="form-control" value="<?= $row->quantity ?>">
                            <input type="submit" name="update_submit" class="btn btn-block btn-primary update_submit" id="update_submit" value="Modifier">
                        </form>
                    </td>
                    <td>
                        <?= $row->price ?>
                    </td>
                    <td>
                        <form method="POST" action="<?php echo current_url(); ?>" class="form_delete_by_product">
                            <input type="hidden" name="id_product" value="<?= $row->id_product ?>" id="id_product">
                            <input type="submit" name="delete_by_product" value="Supprimer" class="btn btn-danger delete_by_product" id="delete_by_product" onclick="return confirm('Voulez vous supprimer le produit ?')">
                        </form>
                    </td>
                <tr>
<?php
                endforeach;
            }
?>
    </tbody>
    <caption><b>Prix final, toutes taxes comprises</b>      
<?php
        if (!empty($cart_user) || !empty($cart_user_l)) {
            foreach ($ttc as $row) :
?>
                <?= $row->ttc ?>
<?php
            endforeach;
        }
?>
    </caption>
</table>
<!-- Formulaire non fonctionnel de l'achat d'un/des produit(s) -->
<form method="POST">
    <input type="submit" name="buy_submit" value="Acheter" class="btn btn-success">
<?php
    if (isset($_POST['buy_submit']) && !isset($this->session->username)) {
        echo 'Vous devez être connecté';
    } else if (isset($_POST['buy_submit']) && !empty($this->session->username)) {
        echo 'Donne moi ta carte bancaire et c\'est réglé';
    }
?>
</form>


