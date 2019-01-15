<?php

unset($_SESSION['username']);
unset($_SESSION['id_user']);
header('location:' . site_url('boutique/read_list'));
