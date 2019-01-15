<?php

unset($_SESSION['username']);
header('location:' . site_url('boutique/read_list'));
