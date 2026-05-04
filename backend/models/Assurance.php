<?php


# TABLE PROPOSE #


// Ajouter un id de la catégorie dans la table Propose
function add_propose($id_assurance, $id_categories)
{
    $db = get_db();

    foreach ($id_categories as $id_category) {
        $sql = "INSERT INTO `Propose` (`assurance_id`,`category_id`)
    VALUES (:id_a, :id_c);";
        $req = $db->prepare($sql);
        $req->bindValue(":id_a", $id_assurance);
        $req->bindValue("id_c", $id_category);
        $req->execute();
    }
}

// Supprimer les entités Propose associées à la table Assurance
function delete_propose($id_assurance)
{
    $db = get_db();

    $sql = "DELETE FROM `Propose`
    WHERE `assurance_id` = :id_a";
    $req = $db->prepare($sql);
    $req->bindValue(":id_a", $id_assurance);
    $req->execute();
}


# TABLE ASSURANCE #


// Récupérer toutes les Assurances
function get_all_assurances()
{
    $db = get_db();

    $sql = "SELECT `id_assurance`, `name_assurance`, `image_assurance`, `is_favorite`
    FROM `Assurance`
    ORDER BY `is_favorite` ASC, `name_assurance` ASC";
    $req = $db->query($sql);
    return $req->fetchAll();
}

// Récupérer une Assurance
function get_assurance($id)
{
    $db = get_db();

    $sql = "SELECT `id_assurance`, `name_assurance`, `url_assurance`,`username_assurance`,`password_assurance`,`code_courtage_assurance`,`commentary_assurance`,`image_assurance`, `is_favorite`, P.category_id
    FROM `Assurance` AS A
    JOIN `Propose` AS P ON P.assurance_id = A.id_assurance
    WHERE `id_assurance` = :id
    GROUP BY  `id_assurance`";
    $req = $db->prepare($sql);
    $req->bindValue(":id", $id);
    $req->execute();
    return $req->fetch();
}

// Ajouter une Assurance
function add_assurance($id, $name, $url, $username, $pwd, $commentary, $categories, $favorite, $code_courtage = null, $image = null)
{
    $db = get_db();

    $hash = openssl_encrypt($pwd, 'AES-256-CBC', VAULT_AES_KEY, 0, VAULT_AES_IV);

    $sql = "INSERT INTO `Assurance` (`name_assurance`, `url_assurance`, `username_assurance`, `password_assurance`, `code_courtage_assurance`, `commentary_assurance`, `image_assurance`, `is_favorite`)
    VALUES (:name, :url, :username, :pwd, :cc, :comm, :image, :favorite);";
    $req = $db->prepare($sql);
    $req->bindValue(":name", $name);
    $req->bindValue(":url", $url);
    $req->bindValue(":username", $username);
    $req->bindValue(":pwd", $hash);
    $req->bindValue(":cc", $code_courtage);
    $req->bindValue(":comm", $commentary);
    $req->bindValue(":image", $image);
    $req->bindValue(":favorite", $favorite);
    $req->execute();

    add_propose($id, $categories);

}

// Modifier une Assurance
function edit_assurance($id, $name, $url, $username, $pwd, $commentary, $categories, $favorite, $code_courtage = null, $image = null)
{
    $db = get_db();

    $hash = openssl_encrypt($pwd, 'AES-256-CBC', VAULT_AES_KEY, 0, VAULT_AES_IV);

    $sql = "UPDATE `Assurance`
    SET `name_assurance` = :name,`url_assurance` = :url, `username_assurance` = :username, `password_assurance` = :pwd, `code_courtage_assurance` = :cc, `commentary_assurance` = :comm, `image_assurance` = :image, `is_favorite` = :favorite
    WHERE `id_assurance` = :id";
    $req = $db->prepare($sql);
    $req->bindValue(":id", $id);
    $req->bindValue(":name", $name);
    $req->bindValue(":url", $url);
    $req->bindValue(":username", $username);
    $req->bindValue(":pwd", $hash);
    $req->bindValue(":comm", $commentary);
    $req->bindValue(":cc", $code_courtage);
    $req->bindValue(":image", $image);
    $req->bindValue(":favorite", $favorite);
    $req->execute();

    delete_propose($id);
    add_propose($id, $categories);
}

// Supprimer une Assurance
function delete_assurance($id)
{
    $db = get_db();

    $sql = "DELETE FROM `Assurance`
WHERE `id_assurance` = :id";
    $req = $db->prepare($sql);
    $req->bindValue(":id", $id);
    $req->execute();
}

// Mettre / enlever le favori d'une Assurance
function change_favorite_assurance($id)
{
    $db = get_db();

    $sql = "UPDATE `Assurance`
    SET `is_favorite` = NOT is_favorite
    WHERE `id_assurance` = :id";
    $req = $db->prepare($sql);
    $req->bindValue(":id", $id);
    $req->execute();
}

// Filtrer les Assurances
function filter_assurance($name = "", $favorite = "1=1", $category = "1=1")
{
    $db = get_db();
    $sql = "SELECT `id_assurance`, `name_assurance`, `image_assurance`, `is_favorite`
    FROM `Assurance` AS A
    JOIN `Propose` AS P ON P.assurance_id=A.id_assurance
    WHERE `name_assurance` LIKE :name AND `is_favorite` = :favorite AND P.category_id = :category
    ORDER BY `is_favorite` ASC, `name_assurance` ASC";
    $req = $db->prepare($sql);
    $req->bindValue(":name", '%$name%');
    $req->bindValue(":favorite", $favorite);
    $req->bindValue(":category", $category);
    $req->execute();
    return $req->fetchAll();
}

// Réinitialiser le filtre des Assurances
function reset_filter_assurance()
{
    return get_all_assurances();
}