<?php

unset($_SESSION['username']);
unset($_SESSION['id_user']);
unset($_SESSION['admin']);
header('location:' . site_url('boutique/read_list'));
