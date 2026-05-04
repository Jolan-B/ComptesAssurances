<?php

// Démarre la session PHP
session_start();

// Vérifie si l'utilisateur est connecté, sinon redirige vers login
function check_auth($id)
{
    if (!isset($_SESSION[$id]) || !$_SESSION[$id]) {
        wp_redirect(plugin_dir_url(__FILE__) . 'frontend/views/login.html.php');
        exit;
    }
}

// Vérifie si l'utilisateur est admin
function is_admin($id)
{

    check_auth($id);

    $db = get_db();

    $sql = "
        SELECT `is_admin`
        FROM `App_User`
        WHERE `id_user` = :id";

    $req = $db->prepare($sql);
    $req->bindValue(":id", $id);
    $req->execute();
    $is_admin = $req->fetch();

    return $is_admin;
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
            $_SESSION[$p["id_user"]] = true;
            wp_redirect(plugin_dir_url(__FILE__) . 'frontend/views/dashboard.html.php');
            exit;
        }
    }

    //pop up mdp incorrect à faire

}

// Déconnecte l'utilisateur : détruit la session
function logout($id)
{
    $_SESSION[$id] = null;
}