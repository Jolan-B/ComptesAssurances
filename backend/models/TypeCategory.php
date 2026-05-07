<?php

define('ORDER_BY_NAME_TYPE_CATEGORY_ASC', '`name_type_category` ASC');
define('ORDER_BY_NAME_TYPE_CATEGORY_DESC', '`name_type_category` DESC');
define('ORDER_BY_NB_CATEGORY_ASC', '`nb_category` ASC');
define('ORDER_BY_NB_CATEGORY_DESC', '`nb_category` DESC');


// Récupérer les Types de Catégories
// Trie en fonction des parametres
function get_all_types_category($order_by_name = null, $order_by_nb_category = null)
{
    $order1 = ORDER_BY_NAME_TYPE_CATEGORY_ASC;
    $order2 = ORDER_BY_NB_CATEGORY_ASC;

    if ($order_by_name === false) {
        $order1 = ORDER_BY_NAME_TYPE_CATEGORY_DESC;
    }
    if ($order_by_nb_category === false) {
        $order2 = ORDER_BY_NB_CATEGORY_DESC;
    }

    if (!$order_by_name && $order_by_nb_category) {
        [$order1, $order2] = [$order2, $order1];
    }

    $db = get_db();
    $sql = "SELECT T.id_type_category AS id, T.name_type_category AS name, COUNT(C.id_category) AS nb_category
    FROM `Type_Category` AS T
    LEFT JOIN `Category` AS C ON C.type_category_id = T.id_type_category
    GROUP BY T.id_type_category 
    ORDER BY $order1, $order2";
    $req = $db->query($sql);
    return $req->fetchAll();

}

// Récupérer un Type de Catégorie
function get_type_category($id)
{
    $db = get_db();

    $sql = "SELECT `id_type_category` AS id, `name_type_category` AS name
    FROM Type_Category 
    WHERE `id_type_category` = :id ";

    $req = $db->prepare($sql);
    $req->bindValue(":id", $id);
    $req->execute();
    return $req->fetch();
}

// Ajouter un Type de Catégorie
function add_type_category($name)
{
    $db = get_db();

    $sql = "INSERT INTO `Type_Category` (`name_type_category`)
    VALUES (:name)";
    $req = $db->prepare($sql);
    $req->bindValue(":name", $name);
    $req->execute();
}

// Modifier un Type de Catégorie
function edit_type_category($id, $name)
{
    $db = get_db();

    $sql = "UPDATE `Type_Category`
    SET `name_type_category` = :name
    WHERE `id_type_category` = :id ";
    $req = $db->prepare($sql);
    $req->bindValue(":name", $name);
    $req->bindValue(":id", $id);
    $req->execute();
}

// Supprimer un Type de Catégorie
function delete_type_category($id)
{
    $db = get_db();

    $sql = "DELETE FROM `Type_Category`
    WHERE `id_type_category` = :id";
    $req = $db->prepare($sql);
    $req->bindValue(":id", $id);
    $req->execute();
}