<h1 class="text-center">Liste des produits (partie utilisateur)</h1>
<hr>
<table class="table table-responsive">
    <thead>
        <tr>
            <th><?= lang('reference') ?></th>
            <th><?= lang('description') ?></th>
            <th><?= lang('picture') ?></th>
            <th><?= lang('price') ?></th>
            <th><?= lang('gestion') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if(!empty($list)){
        foreach ($list as $row) : ?>
            <tr>
                <td>
                    <?= $row->pro_ref ?>
                </td>
                <td>
                    <?= $row->pro_description; ?>
                </td>
                <td>
                    <img class="card-img-top img-fluid" src="<?= base_url('assets/image/' . $row->pro_id . '.' . $row->pro_photo) ?>" alt="Image">
                </td>
                <td>
                    <?= $row->pro_prix; ?>
                </td>
                <td>
                    <!-- Ajoute un produit avec sa quantité -->
                    <form method="POST">
                        <input type="number" class="form-control" name="quantity" value="1">
                        <input type="hidden" name="id_product" value="<?= $row->pro_id ?>">
                        <button type="submit" class="btn btn-primary btn_list">Ajouter</button>  
                    </form>  
                </td>
            <tr>
        <?php endforeach; } ?>
    </tbody>
</table>
<!-- Lien de la pagination -->
<?php echo $this->pagination->create_links(); ?>


