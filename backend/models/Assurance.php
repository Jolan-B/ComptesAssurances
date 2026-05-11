<?php

# TABLE PROPOSE #


// Ajouter un id de la catégorie dans la table Propose
function vault_add_propose($id_assurance, $id_categories)
{
    $db = get_db();

    foreach ($id_categories as $id_category) {
        $sql = "INSERT INTO `Propose` (`assurance_id`,`category_id`)
    VALUES (:id_a, :id_c);";
        $req = $db->prepare($sql);
        $req->bindValue(":id_a", $id_assurance);
        $req->bindValue(":id_c", $id_category);
        $req->execute();
    }
}

// Supprimer les entités Propose associées à la table Assurance
function vault_delete_propose($id_assurance)
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
function vault_get_all_assurances()
{
    $id_user = $_SESSION["id_user"] ?? null;

    $db = get_db();

    $sql = "SELECT `id_assurance` AS id, `url_assurance` AS url, `name_assurance` AS name, `image_assurance` AS image, F.assurance_id IS NOT NULL AS is_favorite
    FROM `Assurance` AS A
    LEFT JOIN `Favorite` AS F ON F.assurance_id = A.id_assurance AND F.user_id = :id_u
    ORDER BY F.assurance_id IS NOT NULL ASC, `name_assurance` ASC";
    $req = $db->prepare($sql);
    $req->bindValue(":id_u", $id_user);
    $req->execute();
    return $req->fetchAll();
}

// Récupérer une Assurance
function vault_get_assurance($id_assurance)
{
    $id_user = $_SESSION["id_user"] ?? null;

    $db = get_db();

    $sql = "SELECT `id_assurance`, `name_assurance`, `url_assurance`,`username_assurance`,`password_assurance`,`code_courtage_assurance`,`commentary_assurance`,`image_assurance`, F.assurance_id IS NOT NULL AS is_favorite, P.category_id
    FROM `Assurance` AS A
    LEFT JOIN `Propose` AS P ON P.assurance_id = A.id_assurance
    LEFT JOIN `Favorite` AS F ON F.assurance_id = A.id_assurance AND F.user_id = :id_u
    WHERE `id_assurance` = :id_a
    GROUP BY  `id_assurance`";
    $req = $db->prepare($sql);
    $req->bindValue(":id_a", $id_assurance);
    $req->bindValue(":id_u", $id_user);
    $req->execute();
    return $req->fetch();
}

// Ajouter une Assurance
function vault_add_assurance($name, $url, $username, $pwd, $commentary, $categories, $code_courtage = null, $image = null)
{
    $db = get_db();

    $hash = openssl_encrypt($pwd, 'AES-256-CBC', VAULT_AES_KEY, 0, VAULT_AES_IV);

    $sql = "INSERT INTO `Assurance` (`name_assurance`, `url_assurance`, `username_assurance`, `password_assurance`, `code_courtage_assurance`, `commentary_assurance`, `image_assurance`)
    VALUES (:name, :url, :username, :pwd, :cc, :comm, :image);";
    $req = $db->prepare($sql);
    $req->bindValue(":name", $name);
    $req->bindValue(":url", $url);
    $req->bindValue(":username", $username);
    $req->bindValue(":pwd", $hash);
    $req->bindValue(":cc", $code_courtage);
    $req->bindValue(":comm", $commentary);
    $req->bindValue(":image", $image);
    $req->execute();

    // Récupère l'id de l'Assurance qui vient d'être créée pour l'ajouter dans la table Propose
    $id = $db->lastInsertId();

    vault_add_propose($id, $categories);

}

// Modifier une Assurance
function vault_edit_assurance($id, $name, $url, $username, $pwd, $commentary, $categories, $code_courtage = null, $image = null)
{
    $db = get_db();

    $hash = openssl_encrypt($pwd, 'AES-256-CBC', VAULT_AES_KEY, 0, VAULT_AES_IV);

    $sql = "UPDATE `Assurance`
    SET `name_assurance` = :name,`url_assurance` = :url, `username_assurance` = :username, `password_assurance` = :pwd, `code_courtage_assurance` = :cc, `commentary_assurance` = :comm, `image_assurance` = :image
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
    $req->execute();

    vault_delete_propose($id);
    vault_add_propose($id, $categories);
}

// Supprimer une Assurance
function vault_delete_assurance($id)
{
    $db = get_db();

    $sql = "DELETE FROM `Assurance`
WHERE `id_assurance` = :id";
    $req = $db->prepare($sql);
    $req->bindValue(":id", $id);
    $req->execute();
}

// Mettre / enlever le favori d'une Assurance
function vault_change_favorite_assurance($id_assurance)
{
    $id_user = $_SESSION["id_user"] ?? null;

    $db = get_db();

    // On vérifie si l'Assurance est déjà dans les favoris de l'Utilisateur
    $sql = "SELECT `user_id`
    FROM `Favorite`
    WHERE `user_id` = :id_u AND `assurance_id` = :id_a";
    $req = $db->prepare($sql);
    $req->bindValue(":id_u", $id_user);
    $req->bindValue(":id_a", $id_assurance);
    $req->execute();

    $is_favorite = ($req->fetch() == $id_user);

    // Si l'Assurance est déjà en favori, on la supprime de la table Favorite, sinon on l'ajoute
    if ($is_favorite) {
        $sql = "DELETE FROM `Favorite`
        WHERE `user_id` = :id_u AND `assurance_id` = :id_a";
    } else {
        $sql = "INSERT INTO `Favorite` (`user_id`,`assurance_id`) 
        VALUES (:id_u, :id_a)";
    }

    $req = $db->prepare($sql);
    $req->bindValue(":id_u", $id_user);
    $req->bindValue(":id_a", $id_assurance);
    $req->execute();
}

// Sauvegarder le filtre en session
function vault_save_filter_assurance($name, $is_favorite, $categories)
{
    $_SESSION['filter_name'] = $name;
    $_SESSION['filter_is_favorite'] = $is_favorite;
    $_SESSION['filter_categories'] = $categories;
}

// Filtrer les Assurances
function vault_filter_assurance()
{
    $id_user = $_SESSION["id_user"] ?? null;
    $name = $_SESSION['filter_name'] ?? null;
    $favorite = $_SESSION['filter_is_favorite'] ?? null;
    $categories = $_SESSION['filter_categories'] ?? null;

    $db = get_db();
    $sql = "SELECT `id_assurance`, `name_assurance`, `image_assurance`, F.assurance_id IS NOT NULL AS is_favorite
    FROM `Assurance` AS A
    LEFT JOIN `Propose` AS P ON P.assurance_id=A.id_assurance
    LEFT JOIN `Favorite` AS F ON F.assurance_id=A.id_assurance AND F.user_id=:id_u
    WHERE 1=1";

    if ($name !== null && $name !== "") {
        $sql .= " AND `name_assurance` LIKE :name";
    }
    if ($favorite !== null) {
        $sql .= " AND `is_favorite` = :favorite";
    }
    if ($categories !== null) {
        $sql .= " AND (";
        foreach ($categories as $i => $category) {
            $sql .= ($i === 0 ? "" : " OR") . " P.category_id = :category_$i";
        }
        $sql .= ")";
    }

    $sql .= " ORDER BY F.assurance_id IS NOT NULL ASC, `name_assurance` ASC";
    $req = $db->prepare($sql);
    $req->bindValue(":id_u", $id_user);
    if ($name !== null && $name !== "") {
        $req->bindValue(":name", "%$name%");
    }
    if ($favorite !== null) {
        $req->bindValue(":favorite", $favorite);
    }
    if ($categories !== null) {
        foreach ($categories as $i => $category) {
            $req->bindValue(":category_$i", $category);
        }
    }
    $req->execute();
    return $req->fetchAll();
}

// Réinitialiser le filtre des Assurances
function vault_reset_filter_assurance()
{
    $_SESSION['filter_name'] = null;
    $_SESSION['filter_is_favorite'] = null;
    $_SESSION['filter_categories'] = null;
    return vault_get_all_assurances();
}

// Exporter les Assurances en CSV
function vault_export_assurances_to_csv()
{
    $db = get_db();

    $sql = "SELECT A.name_assurance, A.url_assurance, A.username_assurance, A.password_assurance, A.code_courtage_assurance,C.name_category,T.name_type_category
    FROM `Assurance` AS A
    JOIN `Propose` AS P ON P.assurance_id=A.id_assurance
    JOIN `Category` AS C ON C.id_category=P.category_id
    JOIN `Type_Category` AS T ON T.id_type_category=C.type_category_id";
    $req = $db->query($sql);
    $data = $req->fetchAll();

    # EXPORTER #

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=assurances.csv');

    $output = fopen('php://output', 'w');
    fputcsv($output, array('Nom', 'URL', 'Identifiant', 'Mot de passe', 'Code courtage', 'Catégorie', 'Type de catégorie'));

    foreach ($data as $row) {
        $row['password_assurance'] = openssl_decrypt($row['password_assurance'], 'AES-256-CBC', VAULT_AES_KEY, 0, VAULT_AES_IV);
        fputcsv($output, $row);
    }

    fclose($output);
    exit;
}