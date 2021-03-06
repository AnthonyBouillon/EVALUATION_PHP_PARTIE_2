<h1 class="text-center">Liste des produits (partie administrateur)</h1>
<hr>
<!-- Message de succès quand un produit est supprimé -->
<?php
if($this->session->flashdata('succes_delete')){
    echo '<div class="alert alert-success">' . $this->session->flashdata('succes_delete') . '</div>';
}
?>
<table class="table table-responsive">
    <thead>
        <tr>
            <th>ID</th>
            <th>Référence</th>
            <th>Libellé</th>
            <th>Description</th>
            <th>Afficher</th>
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
                    <?php
                    if($row->pro_bloque == 1){
                        echo 'Oui';
                    }else{
                        echo 'Non';
                    }
                    
                    ?>
                </td>
                <td>
                    <!-- Lien vers le formulaire de modification -->
                    <a href="<?= site_url('admin/produit/update_list/' . $row->pro_id) ?>" title="Modifier" class="btn btn-primary btn_list">Modifier</a><br>
                    <!-- Formulaire de suppression d'un produit -->
                    <form method="POST">
                        <!-- Facultatif à présent -->
                        <input type="hidden" name="pro_id" value="<?= $row->pro_id ?>">
                        <button type="submit" class="btn btn-danger btn_list" onclick="return confirm('Voulez vous vraiment supprimer ce produit ?')">Supprimer</button>
                    </form>  
                </td>
            <tr>
        <?php endforeach; } ?>
    </tbody>
</table>
<!-- Lien vers les différentes pages (pagination) -->
<?php echo $this->pagination->create_links(); ?>