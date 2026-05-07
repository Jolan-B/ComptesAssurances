<?php

require_once plugin_dir_path(__FILE__) . '../config.php';

$email = $_POST["email_user"] ?? null;

if ($email === null) {
    exit;
}

$db = get_db();

$sql = "SELECT `id_user`
FROM `App_User`
WHERE `email_user` = :email";
$req = $db->prepare($sql);
$req->bindValue(":email", $email);
$req->execute();

$id_user = $req->fetchColumn();

if ($id_user == false) {
    exit;
}

$token = bin2hex(random_bytes(32));
$expiry = date('Y-m-d H:i:s', time() + 3600);

$sql = "UPDATE `App_User` 
SET `reset_token` = :token, `reset_token_expiry` = :expiry 
WHERE `id_user` = :id";
$req = $db->prepare($sql);
$req->bindValue(":id", $id_user);
$req->bindValue(":token", $token);
$req->bindValue(":expiry", $expiry);
$req->execute();

$subject = "Réinitialisation de votre mot de passe Comptes Sily";

$msg = "Bonjour,\nVoici le lien (valable 1h) pour réinitiliser votre mot de passe pour accéder aux Comptes Sily : reset-password.php?token=$token";

wp_mail($email, $subject, $msg);

wp_redirect(plugin_dir_url(__FILE__) . '../../frontend/views/login/login.html.php');
exit;