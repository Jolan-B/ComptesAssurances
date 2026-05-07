<?php

// Démarre la session PHP uniquement si pas déjà démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérifie si l'utilisateur est connecté, sinon redirige vers login
function vault_check_auth()
{
    if (!isset($_SESSION["id_user"]) || !$_SESSION["id_user"]) {
        wp_redirect(home_url('/?vault=login'));
        exit;
    }
}

// Vérifie si l'utilisateur est admin
function vault_is_admin()
{
    $id = $_SESSION["id_user"] ?? null;

    vault_check_auth();

    $db = get_db();

    $sql = "
        SELECT `is_admin`
        FROM `App_User`
        WHERE `id_user` = :id";

    $req = $db->prepare($sql);
    $req->bindValue(":id", $id);
    $req->execute();
    return (bool) $req->fetchColumn();
}

// Connecte l'utilisateur : vérifie nom+mdp en BDD, stocke en session
function vault_login($username, $password)
{
    $db = get_db();
    $sql = "SELECT `password_user`, `id_user`
    FROM `App_User`
    WHERE `name_user` = :username";

    $req = $db->prepare($sql);
    $req->bindValue(":username", $username);
    $req->execute();
    $passwords = $req->fetchAll();

    foreach ($passwords as $p) {
        if (password_verify($password, $p['password_user'])) {
            $_SESSION["id_user"] = $p["id_user"];
            wp_redirect(home_url('/?vault=dashboard'));
            exit;
        }
    }
}

// Déconnecte l'utilisateur : détruit la session
function vault_logout()
{
    $_SESSION["id_user"] = null;
    wp_redirect(home_url('/?vault=login'));
    exit;
}