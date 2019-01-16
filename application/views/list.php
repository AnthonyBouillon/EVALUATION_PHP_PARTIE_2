<h1 class="text-center">Liste des produits (partie administrateur)</h1>
<hr>
<table class="table table-responsive">
    <thead>
        <tr>
            <th>ID</th>
            <th>Référence</th>
            <th>Libellé</th>
            <th>Description</th>
            <th>Gestion</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if(!empty($list)){
        foreach ($list as $row) : 
        ?>
            <tr>
                <td>
                    <?= $row->pro_id ?>
                </td>
                <td>
                    <?= $row->pro_ref; ?>
                </td>
                <td>
                    <?= $row->pro_libelle; ?>
                </td>
                <td>
                    <?= $row->pro_description; ?>
                </td>
                <td>
                    <a href="<?= site_url('produit/update_list/' . $row->pro_id) ?>" title="Modifier" class="btn btn-primary btn_list">Modifier</a><br>
                    <form method="POST">
                        <input type="hidden" name="pro_id" value="<?= $row->pro_id ?>">
                        <button type="submit" class="btn btn-danger btn_list" onclick="return confirm('Voulez vous vraiment supprimer ce produit ?')">Supprimer</button>
                    </form>  
                </td>
            <tr>
        <?php endforeach; } ?>
    </tbody>
</table>
<?php echo $this->pagination->create_links(); ?>