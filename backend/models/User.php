<?php

// Récupérer tous les utilisateurs
function vault_get_all_users($by_name = true)
{
    // Pour filtrer en fonction du nom (ASC / DESC)
    $name_order = "ASC";

    if (!$by_name) {
        $name_order = "DESC";
    }

    $db = get_db();

    $sql = "SELECT `id_user` AS id ,`name_user` AS name,`email_user` AS email
    FROM `App_User`
    ORDER BY `name_user` $name_order ";
    $req = $db->query($sql);
    return $req->fetchAll();
}

// Récupérer un utilisateur par son id
function vault_get_user($id)
{
    $db = get_db();
    $sql = "SELECT `id_user` AS id ,`name_user` AS name,`email_user` AS email, `password_user` AS pwd
    FROM `App_User`
    WHERE `id_user` = :id ";
    $req = $db->prepare($sql);
    $req->bindValue(":id", $id);
    $req->execute();

    return $req->fetch();
}

// Ajouter un utilisateur
function vault_add_user($name, $email, $password, $is_admin)
{
    $db = get_db();
    $pwd_hash = password_hash($password, PASSWORD_BCRYPT);
    $sql = "INSERT INTO `App_User` (`name_user`,`email_user`,`password_user`,`is_admin`) VALUES 
    (:name,:email,:pwd,:admin);";
    $req = $db->prepare($sql);
    $req->bindValue(":name", $name);
    $req->bindValue(":email", $email);
    $req->bindValue(":pwd", $pwd_hash);
    $req->bindValue(":admin", $is_admin);
    $req->execute();
}

// Modifier un utilisateur
function vault_edit_user($id, $name, $email, $password, $is_admin)
{
    $db = get_db();
    $pwd_hash = password_hash($password, PASSWORD_BCRYPT);
    $sql = "UPDATE `App_User`
    SET `name_user` = :name, `email_user` = :email, `password_user` = :pwd, `is_admin` = :admin
    WHERE `id_user` = :id";
    $req = $db->prepare($sql);
    $req->bindValue(":id", $id);
    $req->bindValue(":email", $email);
    $req->bindValue(":name", $name);
    $req->bindValue(":pwd", $pwd_hash);
    $req->bindValue(":admin", $is_admin);
    $req->execute();

}

// Modifier le mdp utilisateur
function vault_update_password_user($id, $ex_input_pwd, $new_pwd, $retype_pwd)
{
    $db = get_db();

    // Récupère le mdp actuel
    $sql = "SELECT `password_user` AS pwd
    FROM `App_User`
    WHERE `id_user` = :id";
    $req = $db->prepare($sql);
    $req->bindValue(":id", $id);
    $req->execute();
    $ex_pwd = $req->fetch();

    if (!password_verify($ex_input_pwd, $ex_pwd['pwd'])) {
        return ['error' => 'Le mot de passe actuel n\'est pas bon'];
    }

    if ($new_pwd != $retype_pwd) {
        return ['error' => 'Les deux saisies du nouveau mot de passe sont différentes'];
    }

    $hash = password_hash($new_pwd, PASSWORD_BCRYPT);

    $sql = "UPDATE `App_User`
    SET `password_user` = :pwd
    WHERE `id_user` = :id";
    $req = $db->prepare($sql);
    $req->bindValue(":id", $id);
    $req->bindValue(":pwd", $hash);
    $req->execute();

}

// Supprimer un utilisateur
function vault_delete_user($id)
{
    $db = get_db();
    $sql = "DELETE FROM `App_User`
    WHERE `id_user` = :id";
    $req = $db->prepare($sql);
    $req->bindValue(":id", $id);
    $req->execute();

}