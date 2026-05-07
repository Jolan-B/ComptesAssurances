<?php

require_once plugin_dir_path(__FILE__) . '../config/auth.php';

$token = $_POST['token'] ?? null;
$pwd = $_POST['password_user'] ?? null;
$pwd_confirm = $_POST['password_confirm_user'] ?? null;

if ($token == null || $pwd == null || $pwd == "" || $pwd_confirm == null || $pwd != $pwd_confirm) {
    exit;
}

$pwd_hash = password_hash($pwd, PASSWORD_BCRYPT);

$db = get_db();

$sql = "UPDATE `App_User`
SET `password_user`=:pwd
WHERE `reset_token`=:token AND reset_token_expiry > NOW()";
$req = $db->prepare($sql);
$req->bindValue(":pwd", $pwd_hash);
$req->bindValue(":token", $token);
$req->execute();

wp_redirect(plugin_dir_url(__FILE__) . '../../public/login.php');
exit;