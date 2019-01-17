$(document).ready(function () {
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


