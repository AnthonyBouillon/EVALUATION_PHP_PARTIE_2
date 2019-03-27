<?php
/**
 * PAGE DE DECONNEXION
 */
// Supprime les sessions
unset($_SESSION['username']);
unset($_SESSION['id_user']);
unset($_SESSION['id_tmp']);
unset($_SESSION['admin']);

// Redirection
header('location:' . site_url('user/login'));
