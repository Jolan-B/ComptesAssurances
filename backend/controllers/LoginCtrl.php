<?php

require_once plugin_dir_path(__FILE__) . '../auth.php';
login($_POST['name_user'] ?? '', $_POST['password_user'] ?? '');