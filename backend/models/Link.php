<?php

// Récupérer tous les Liens
function vault_get_all_links()
{
    $db = get_db();

    $sql = "SELECT `id_link`,`name_link`,`url_link`,`username_link`,`password_link`,`image_link`
    FROM `Link`
    ORDER BY `name_link` ASC";
    $req = $db->query($sql);
    return $req->fetchAll();
}

// Récupérer un Lien depuis son ID
function vault_get_link($id_link)
{
    $db = get_db();

    $sql = "SELECT `id_link` AS id,`name_link` AS name,`url_link` AS url,`username_link` AS username,`password_link` AS pwd,`image_link` AS image, `commentary_link` AS commentary
    FROM `Link`
    WHERE `id_link` = :id;";
    $req = $db->prepare($sql);
    $req->bindValue(":id", $id_link);
    $req->execute();

    $link = $req->fetch();
    $link["pwd"] = openssl_decrypt($link['pwd'], 'AES-256-CBC', VAULT_AES_KEY, 0, VAULT_AES_IV);

    return $link;
}

// Ajouter un Lien
function vault_add_link($name, $url, $username = null, $password = null, $commentaire = null, $image = null)
{
    $db = get_db();

    $hash = openssl_encrypt($password, 'AES-256-CBC', VAULT_AES_KEY, 0, VAULT_AES_IV);

    $sql = "INSERT INTO `Link` (`name_link`, `url_link`, `username_link`, `password_link`, `commentary_link`, `image_link`)
    VALUES (:name, :url, :username, :pwd, :comm, :img);";
    $req = $db->prepare($sql);
    $req->bindValue(":name", $name);
    $req->bindValue(":url", $url);
    $req->bindValue(":username", $username);
    $req->bindValue(":pwd", $hash);
    $req->bindValue(":comm", $commentaire);
    $req->bindValue(":img", $image);
    $req->execute();
}

// Modifier un Lien
function vault_edit_link($id, $name, $url, $username, $password, $commentaire, $image)
{
    $db = get_db();

    $hash = openssl_encrypt($password, 'AES-256-CBC', VAULT_AES_KEY, 0, VAULT_AES_IV);

    $sql = "UPDATE `Link`
    SET `name_link` = :name, `url_link` = :url, `username_link` = :username, `password_link` = :pwd, `commentary_link` = :comm, `image_link` = :img
    WHERE `id_link` = :id";
    $req = $db->prepare($sql);
    $req->bindValue(":id", $id);
    $req->bindValue(":name", $name);
    $req->bindValue(":url", $url);
    $req->bindValue(":username", $username);
    $req->bindValue(":pwd", $hash);
    $req->bindValue(":comm", $commentaire);
    $req->bindValue(":img", $image);
    $req->execute();

}

// Supprimer un Lien
function vault_delete_link($id)
{
    $db = get_db();

    $sql = "DELETE FROM `Link`
    WHERE `id_link` = :id";
    $req = $db->prepare($sql);
    $req->bindValue(":id", $id);
    $req->execute();
}