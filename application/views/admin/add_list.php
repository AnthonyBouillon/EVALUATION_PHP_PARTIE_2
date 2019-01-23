<h1 class="text-center">Ajouter un produit</h1>
<hr>
<!-- Affiche les erreurs lié aux règles des champs du formulaire -->
<?php if (!empty(validation_errors())) { ?>
    <div class="alert alert-danger"><?= validation_errors(); ?></div>
<?php } else if ($this->session->flashdata('success_add')) { ?>
    <div class="alert alert-success"><?= $this->session->flashdata('success_add') ?></div>
<?php } ?>
<form method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="pro_cat_id">Catégorie</label>
        <!-- Noms des catégories -->
        <select class="form-control" id="pro_cat_id">
            <?php foreach ($data_cat as $row) : ?>
                <option value="<?= $row->cat_id ?>"><?= $row->cat_nom ?></option>
            <?php endforeach; ?>
        </select>
        <label for="pro_sub_cat">Sous-catégorie</label>
        <select class="form-control" id="pro_sub_cat" name="pro_cat_id">
      
        </select>
    </div>
    <div class="form-group">
        <label for="pro_ref">Référence</label>
        <input type="text" name="pro_ref" class="form-control" id="pro_ref" placeholder="Entrer référence" value="<?= set_value('pro_ref') ?>">
    </div>
    <div class="form-group">
        <label for="pro_libelle">Libellé</label>
        <input type="text" name="pro_libelle" class="form-control" id="pro_libelle" placeholder="Entrer libellé" value="<?= set_value('pro_libelle') ?>">
    </div>
    <div class="form-group">
        <label for="pro_description">Description</label>
        <input type="text" name="pro_description" class="form-control" id="pro_description" placeholder="Entrer description" value="<?= set_value('pro_description') ?>">
    </div>
    <div class="form-group">
        <label for="pro_prix">Prix</label>
        <input type="text" name="pro_prix" class="form-control" id="pro_prix" placeholder="Entrer prix" value="<?= set_value('pro_prix') ?>">
    </div>
    <div class="form-group">
        <label for="pro_stock">Stock</label>
        <input type="text" name="pro_stock" class="form-control" id="pro_stock" placeholder="Entrer stock" value="<?= set_value('pro_stock') ?>">
    </div>
    <div class="form-group">
        <label for="pro_couleur">Couleur</label>
        <input type="text" name="pro_couleur" class="form-control" id="pro_couleur"  placeholder="Entrer couleur" value="<?= set_value('pro_couleur') ?>">
    </div>
    <div class="custom-file">
        <input type="file" class="custom-file-input" id="pro_photo" name="pro_photo">
        <label class="custom-file-label" for="pro_photo">Parcourir image...</label>
    </div>
    <hr>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="pro_bloque" id="pro_bloque" value="0" checked>
        <label class="form-check-label" for="pro_bloque">
            Bloquer produit
        </label><br>
        <input class="form-check-input" type="radio" name="pro_bloque" id="pro_bloque2" value="1">
        <label class="form-check-label" for="pro_bloque2">
            Afficher produit
        </label>
    </div>
    <hr>
    <button type="submit" class="btn btn-primary">Ajouter</button>
</form>

