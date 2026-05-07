<?php

// Démarre la session PHP
session_start();

// Vérifie si l'utilisateur est connecté, sinon redirige vers login
function check_auth()
{
    if (!isset($_SESSION["id_user"]) || !$_SESSION["id_user"]) {
        wp_redirect(plugin_dir_url(__FILE__) . 'app/views/login/login.html.php');
        exit;
    }
}

// Vérifie si l'utilisateur est admin
function is_admin()
{
    $id = $_SESSION["id_user"] ?? null;

    check_auth();

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
function login($username, $password)
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
            wp_redirect(plugin_dir_url(__FILE__) . 'app/public/dashboard.php');
            exit;
        }
    }

    //pop up mdp incorrect à faire

}

// Déconnecte l'utilisateur : détruit la session
function logout()
{
    $_SESSION["id_user"] = null;
    wp_redirect(plugin_dir_url(__FILE__) . 'app/views/login/login.html.php');
    exit;
}