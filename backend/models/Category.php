<?php

define('ORDER_BY_NAME_CATEGORY_ASC', '`name_category` ASC');
define('ORDER_BY_NAME_CATEGORY_DESC', '`name_category` DESC');


// Récupérer toutes les Catégories
function get_all_categories($order_by_category_name = null, $order_by_type_category_name = null)
{

    // De même que dans TypeCategorie.php
    $order1 = ORDER_BY_NAME_CATEGORY_ASC;
    $order2 = ORDER_BY_NAME_TYPE_CATEGORY_ASC;

    if ($order_by_category_name === false) {
        $order1 = ORDER_BY_NAME_CATEGORY_DESC;
    }

    if ($order_by_type_category_name === false) {
        $order2 = ORDER_BY_NAME_TYPE_CATEGORY_DESC;
    }

    if (!$order_by_category_name && $order_by_type_category_name) {
        [$order1, $order2] = [$order2, $order1];
    }

    $db = get_db();

    $sql = "SELECT C.id_category AS id, T.id_type_category AS id_tc, C.name_category AS name_c, T.name_type_category
    FROM `Category` AS C
    JOIN `Type_Category` AS T ON T.id_type_category = C.type_category_id
    GROUP BY C.id_category
    ORDER BY $order1, $order2";
    $req = $db->query($sql);
    return $req->fetchAll();
}

// Récupérer une Catégorie
function get_category($id)
{
    $db = get_db();

    $sql = "SELECT C.id_category AS id_c, C.name_category AS name_c, T.id_type_category AS id_tc, T.name_type_category AS name_tc
    FROM `Category` AS C
    JOIN `Type_Category` AS T ON C.type_category_id = T.id_type_category
    WHERE C.id_category = :id";
    $req = $db->prepare($sql);
    $req->bindValue(":id", $id);
    $req->execute();
    return $req->fetch();
}

// Ajouter une Catégorie
function add_category($name, $id_type_category)
{
    $db = get_db();

    $sql = "INSERT INTO `Category` (name_category, type_category_id)
    VALUES (:name, :id)";
    $req = $db->prepare($sql);
    $req->bindValue(":name", $name);
    $req->bindValue(":id", $id_type_category);
    $req->execute();
}

//Modifier une Catégorie
function edit_category($id_category, $name, $id_type_category)
{
    $db = get_db();
    $sql = "UPDATE `Category`
    SET `name_category` = :name, `type_category_id` = :id_tc
    WHERE `id_category` = :id_c";
    $req = $db->prepare($sql);
    $req->bindValue(":id_c", $id_category);
    $req->bindValue(":name", $name);
    $req->bindValue(":id_tc", $id_type_category);
    $req->execute();
}

// Supprimer une Catégorie
function delete_category($id)
{
    $db = get_db();

    $sql = "DELETE FROM `Category`
    WHERE `id_category` = :id";
    $req = $db->prepare($sql);
    $req->bindValue(":id", $id);
    $req->execute();
}
