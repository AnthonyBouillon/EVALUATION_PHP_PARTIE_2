
$(document).ready(function () {
    /**
     * AJAX
     * AJOUT D'UN PRODUIT DANS LE PANIER
     */
    $('.form').submit(function (e) {
        // La classe form
        var form = $(this);
        // Destination des données, les données, fonction =>
        $.post(form.attr('action'), form.serialize(), function () {
            swal({
                title: "Produit ajouté",
                icon: "success",
            });
        });
        e.preventDefault();
    });

    function update_quantity(e) {
        var form_update_quantity = $(this);
        $.post('http://localhost/Jarditou/boutique/update_product', form_update_quantity.serialize(), function () {
            // Alert success
            swal({
                title: "Produit modifié",
                icon: "success",
            });
            // Actualise le tableau
            $('.table_cart').load('http://localhost/Jarditou/boutique/read_cart .table_cart', function () {
                $('.form_update_quantity').submit(update_quantity);
                $('.form_delete_by_product').submit(delete_by_product);
            });
        });
        //  / test
        e.preventDefault();
    }

    function delete_by_product(e) {
        var form_delete_by_product = $(this);
        $.post('http://localhost/Jarditou/boutique/delete_by_product', form_delete_by_product.serialize(), function () {
            swal({
                title: "Produit supprimé",
                icon: "success",
            });
            // Actualise le tableau
            $('.table_cart').load('http://localhost/Jarditou/boutique/read_cart .table_cart', function () {
                $('.form_delete_by_product').submit(delete_by_product);
                $('.form_update_quantity').submit(update_quantity);
            });
        });
        e.preventDefault();
    }

// Si je fait lun et l'autre ne fonctionne plus mais une seule fois

    // Page panier, modifie la quantité du produit
    $('.form_update_quantity').submit(update_quantity);
    // Page panier, supprime un produits
    $('.form_delete_by_product').submit(delete_by_product);

    // Page panier, supprime tous les produits
    $('.delete_all_cart').submit(function (e) {
        var delete_all_cart = $(this);
        $.post({
            // Fichier de destination
            url: 'http://localhost/Jarditou/boutique/delete_product',
            // Données à envoyer
            data: ({
                delete_submit: $('#delete_all_submit').val(),
            }),
            // Si la requête ajax est réussie
            success: function () {
                // Affiche succès
                swal({
                    title: "Panier supprimé",
                    icon: "success",
                });
                // Actualise le tableau
                $('.table_cart').load('http://localhost/Jarditou/boutique/read_cart .table_cart');
            }
        });
        e.preventDefault();
    });


    $('#submit_register').click(function (e) {
        var regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if ($('#name').val() == '' || $('#firstname').val() == '' || $('#email').val() == '' || $('#login').val() == '' || $('#password').val() == '' || $('#confirm_password').val() == '') {
            $('.empty_field').text('Remplissez tous les champs du formulaire');
            e.preventDefault();
        } else {
            $('.empty_field').text('');
            if ($('#name').val().length < 2) {
                $('.name').text('Minimum 2 caractères');
                e.preventDefault();
            } else {
                $('.name').text('');
            }
            if ($('#firstname').val().length < 2) {
                $('.firstname').text('Minimum 2 caractères');
                e.preventDefault();
            } else {
                $('.firstname').text('');
            }
            if (!regex.test($('#email').val())) {
                $('.email').text('Format de l\'adresse email non conforme');
                e.preventDefault();
            } else {
                $('.email').text('');
            }
            if ($('#login').val().length < 2) {
                $('.login').text('Minimum 2 caractères');
                e.preventDefault();
            } else {
                $('.login').text('');
            }
            if ($('#password').val() != $('#confirm_password').val()) {
                $('.password_c').text('Les deux mots de passe ne correspondent pas');
                e.preventDefault();
            } else {
                $('.password_c').text('');
            }
        }
    });

});

