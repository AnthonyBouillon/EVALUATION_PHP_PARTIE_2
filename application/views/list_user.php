
<div class="container content pt-4 pb-4">
    <h1 class="text-center">Liste des produits (partie utilisateur)</h1>
    <hr>
    <table class="table">
        <thead>
            <tr>
                <th>Référence</th>
                <th>Description</th>
                <th>Photo</th>
                <th>Prix</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($list as $row) { ?>
                <tr>
                    <td>
                        <?= $row->pro_ref ?>
                    </td>
                    <td>
                        <?= $row->pro_description; ?>
                    </td>
                    <td>
                        <img class="card-img-top img-fluid" src="<?= base_url('assets/image/' . $row->pro_id . '.' . $row->pro_photo) ?>" alt="Card image cap">

                    </td>
                    <td>
                        <?= $row->pro_prix; ?>
                    </td>
                    <td>
                        <form method="POST">
                            <input type="number" class="form-control" name="quantity" value="1">
                            <input type="hidden" name="pro_id" value="<?= $row->pro_id ?>">
                            <button type="submit" class="btn btn-primary btn_list" >Ajouter</button>  
                        </form>  
                    </td>
                <tr>
                <?php } ?>
        </tbody>
    </table>

</div>

