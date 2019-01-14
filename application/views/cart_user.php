<?php

foreach($cart_user as $row){
    echo $row->quantity;
    echo $row->pro_libelle;
    echo $row->prix ?>
    <img src="<?= base_url('assets/image/' . $row->id_product . '.jpg') ?>" class="img-fluid">
<?php } ?>