
<h1 class="text-center">Modifier un produit</h1>
<hr>
<!-- Message d'erreur lié au formulaire -->
<?php if (!empty(validation_errors())) { ?>
    <div class="alert alert-danger"><?= validation_errors(); ?></div>
    <!-- Message de succès après la modification d'un produit -->
    <?php } if ($this->session->flashdata('success')) { ?>
    <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
<?php } ?>
<form method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="pro_cat_id">Catégorie</label>
        <select class="form-control" id="pro_cat_id">
            <!-- la catégorie du produit -->
           
            <!-- Liste des catégories -->
            <?php foreach ($this_cat as $row) { ?>
                <option value="<?= $row->cat_id ?>"><?= $row->cat_nom ?></option>
            <?php } ?>
        </select>
        <!-- Sous-catégorie du produit affiché en ajax -->
        <label for="pro_sub_cat">Sous-catégorie</label>
        <select class="form-control" id="pro_sub_cat" name="pro_cat_id">
       <option value="<?= $this_product->pro_cat_id ?>"><?= $this_product->cat_nom ?></option>
        </select>
    </div>
    <div class="form-group">
        <label for="pro_ref">Référence</label>
        <input type="text" name="pro_ref" class="form-control" id="pro_ref" placeholder="Entrer référence" value="<?= $this_product->pro_ref ?>" required>
    </div>
    <div class="form-group">
        <label for="pro_libelle">Libellé</label>
        <input type="text" name="pro_libelle" class="form-control" id="pro_libelle" placeholder="Entrer libellé" value="<?= $this_product->pro_libelle ?>" required>
    </div>
    <div class="form-group">
        <label for="pro_description">Description</label>
        <textarea class="form-control" id="pro_description" rows="3" name="pro_description" required><?= $this_product->pro_description ?></textarea>
    </div>
    <div class="form-group">
        <label for="pro_prix">Prix</label>
        <input type="text" name="pro_prix" class="form-control" id="pro_prix" placeholder="Entrer prix" value="<?= $this_product->pro_prix ?>" required>
    </div>
    <div class="form-group">
        <label for="pro_stock">Stock</label>
        <input type="text" name="pro_stock" class="form-control" id="pro_stock" placeholder="Entrer stock" value="<?= $this_product->pro_stock ?>" required>
    </div>
    <div class="form-group">
        <label for="pro_couleur">Couleur</label>
        <input type="text" name="pro_couleur" class="form-control" id="pro_couleur"  placeholder="Entrer couleur" value="<?= $this_product->pro_couleur ?>" required>
    </div>
    <!-- Image actuel affiché -->
    <div class="card" style="max-width: 25em">
        <img class="card-img-top img-fluid" src="<?= base_url('assets/image/' . $this_product->pro_id . '.' . $this_product->pro_photo) ?>" alt="Card image cap">
        <div class="card-body">
            <p class="card-text">Si vous voulez remplacer l'image, choisissez-en une nouvelle !</p>
        </div>
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="pro_photo" name="pro_photo">
            <label class="custom-file-label" for="pro_photo">Parcourir image...</label>
        </div>
    </div>
    <hr>
    <?php if($this_product->pro_bloque == 1){ ?>
    <!-- Bouton radio -->
    <div class="form-check">
        <input class="form-check-input" type="radio" name="pro_bloque" id="pro_bloque" value="0" >
        <label class="form-check-label" for="pro_bloque">
            Bloquer produit
        </label><br>
        <input class="form-check-input" type="radio" name="pro_bloque" id="pro_bloque2" value="1" checked>
        <label class="form-check-label" for="pro_bloque2">
            Afficher produit
        </label>
    </div>
    <?php } else { ?>
       <!-- Bouton radio -->
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
    <?php } ?>
    <hr>
    <button type="submit" class="btn btn-primary">Modifier</button>
</form>

