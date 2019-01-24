// Dès que la page est complètement chargé
$(document).ready(function () {

    /**
     * AJAX
     * 
     * Affiche les sous catégories pour la page ajouter un produit et modifier un produit
     * @returns {undefined}
     */
    function sub_category() {
        $.ajax({
            type: 'POST',
            // Chemin du controlleur et de la fonction
            url: 'http://localhost/Jarditou/admin/produit/get_sub_category',
            // Données à transmettre
            data: {pro_cat_id: $('#pro_cat_id').val()},
            // Données reçu au format json
            dataType: 'json',
            // Si l'appel ajax à fonctionnée (le paramètre contient les données reçues
            success: function (result) {
                // Ecrase les résultats pour faire place à la nouvelle
                $('#pro_sub_cat').html('');
                // Parcour le tableau contenant les résultats de ma requête SQL
                for (var i = 0; i < result.length; i++) {
                    $('#pro_sub_cat').append('<option value="' + result[i].cat_id + '">' + result[i].cat_nom + '</option');
                }
            },
            // Si la requête n'a pas fonctionnée, affiche un message
            error: function () {
                alert('Veuillez activer javascript pour afficher les sous-catégories');
            }
        });
    }

    /**
     * AJAX
     * 
     * AJOUT D'UN PRODUIT DANS LE PANIER
     * 
     */
    function add_product(e) {
        // La classe form
        var form = $(this);
        // Destination des données, les données, fonction =>
        $.post(form.attr('action'), form.serialize(), function () {
            swal({
                title: "Produit ajouté",
                icon: "success"
            });
        });
        // Empêche la soumission du formulaire
        e.preventDefault();
    }

    /**
     * AJAX
     * 
     * Modifie la quantité d'un produit dans le panier
     * @param {type} e
     * @returns {undefined}
     */
    function update_quantity(e) {
        var form_update_quantity = $(this);
        // Destination des données, les données, fonction =>
        $.post('http://localhost/Jarditou/boutique/update_product', form_update_quantity.serialize(), function () {
            // Alert success
            swal({
                title: "Produit modifié",
                icon: "success"
            });
            // Actualise le tableau
            $('.table_cart').load('http://localhost/Jarditou/boutique/read_cart .table_cart', function () {
                // Update et delete sont sur la même page, donc à la fin, on doit réactiver les évènements
                $('.form_update_quantity').submit(update_quantity);
                $('.form_delete_by_product').submit(delete_by_product);
            });
        });
        // Empêche la soumission du formulaire
        e.preventDefault();
    }

    /**
     * AJAX
     * 
     * Supprime un produit
     * @param {type} e
     * @returns {undefined}
     */
    function delete_by_product(e) {
        var form_delete_by_product = $(this);
        // Destination des données, les données, fonction =>
        $.post('http://localhost/Jarditou/boutique/delete_by_product', form_delete_by_product.serialize(), function () {
            swal({
                title: "Produit supprimé",
                icon: "success"
            });
            // Actualise le tableau
            $('.table_cart').load('http://localhost/Jarditou/boutique/read_cart .table_cart', function () {
                // Update et delete sont sur la même page, donc à la fin, on doit réactiver les évènements
                $('.form_delete_by_product').submit(delete_by_product);
                $('.form_update_quantity').submit(update_quantity);
            });
        });
        e.preventDefault();
    }

    /**
     * AJAX 
     * 
     * Suprime tous les produits du panier
     * @param {type} e
     * @returns {undefined}
     */
    function delete_all_product(e) {
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
    }
// -----------------------------------------------------------------------------
//                      Appel des fonctions ajax
// -----------------------------------------------------------------------------
    // Ajoute un produit dans le panier
    $('.form').submit(add_product);
    // Page add_list et update_list, affiche les sous catégories
    $('#pro_cat_id').change(sub_category);
    // Page panier, modifie la quantité du produit
    $('.form_update_quantity').submit(update_quantity);
    // Page panier, supprime un produits
    $('.form_delete_by_product').submit(delete_by_product);
    // Supprime tous les produits dans le panier
    $('.delete_all_cart').submit(delete_all_product);

// -----------------------------------------------------------------------------
//                  Formulaire inscription
// -----------------------------------------------------------------------------

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

