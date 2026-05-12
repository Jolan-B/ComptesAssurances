<?php

vault_check_auth();

$action = $_POST['action'] ?? null;

if ($action == null) {
    exit;
}

switch ($action) {

    case 'add-assurance':
        if (vault_check_required_fields([$_POST["name"] ?? null, $_POST["url"] ?? null, $_POST["username"] ?? null, $_POST["pwd"] ?? null])) {
            $name = strip_tags($_POST["name"]);
            $url = strip_tags($_POST["url"]);
            $username = strip_tags($_POST["username"]);
            $pwd = strip_tags($_POST["pwd"]);
            $cc = strip_tags($_POST["cc"] ?? "");
            $img = strip_tags($_POST["image"] ?? "");
            $comm = htmlspecialchars($_POST["commentary"] ?? "");
            $categories = $_POST["categories"] ?? [];

            vault_add_assurance($name, $url, $username, $pwd, $comm, $categories, $cc, $img);

            wp_redirect(home_url('/?vault=dashboard'));
            exit;
        }
        break;

    case 'edit-assurance':
        if (vault_check_required_fields([$_POST["id"] ?? null, $_POST["name"] ?? null, $_POST["url"] ?? null, $_POST["username"] ?? null, $_POST["pwd"] ?? null])) {
            $id = intval(strip_tags($_POST["id"]));
            $name = strip_tags($_POST["name"]);
            $url = strip_tags($_POST["url"]);
            $username = strip_tags($_POST["username"]);
            $pwd = strip_tags($_POST["pwd"]);
            $cc = strip_tags($_POST["cc"] ?? "");
            $img = strip_tags($_POST["image"] ?? "");
            $comm = htmlspecialchars($_POST["commentary"] ?? "");
            $categories = $_POST["categories"] ?? [];

            vault_edit_assurance($id, $name, $url, $username, $pwd, $comm, $categories, $cc, $img);

            wp_redirect(home_url('/?vault=dashboard'));
            exit;
        }
        break;

    case 'add_link':
        if (vault_check_required_fields([$_POST["name_link"] ?? null, $_POST["url_link"] ?? null])) {
            $name = strip_tags($_POST["name_link"]);
            $url = strip_tags($_POST["url_link"]);
            $username = strip_tags($_POST["username_link"] ?? "");
            $pwd = strip_tags($_POST["pwd_link"] ?? "");
            $img = strip_tags($_POST["image_link"] ?? "");
            $comm = strip_tags($_POST["commentary_link"] ?? "");

            vault_add_link($name, $url, $username, $pwd, $comm, $img);

            wp_redirect(home_url('/?vault=dashboard'));
            exit;
        }
        break;

    case 'edit_link':
        if (vault_check_required_fields([$_POST['id_link'] ?? null, $_POST['name_link'] ?? null, $_POST['url_link'] ?? null])) {

            $id = intval(strip_tags($_POST['id_link']));
            $name = strip_tags($_POST['name_link']);
            $url = strip_tags($_POST['url_link']);
            $username = strip_tags($_POST['username_link'] ?? "");
            $pwd = strip_tags($_POST['pwd_link'] ?? "");
            $comm = strip_tags($_POST['commentary_link'] ?? "");
            $img = strip_tags($_POST['image_link'] ?? "");

            vault_edit_link($id, $name, $url, $username, $pwd, $comm, $img);

            wp_redirect(home_url('/?vault=dashboard'));
            exit;
        }
        break;

    case 'add_user':
        if (vault_check_required_fields([$_POST['name_user'] ?? null, $_POST['email_user'] ?? null, $_POST['pwd_user'] ?? null, $_POST['is_admin'] ?? null])) {

            $name = strip_tags($_POST['name_user']);
            $email = strip_tags($_POST['email_user']);
            $pwd = strip_tags($_POST['pwd_user']);
            $is_admin = boolval(strip_tags($_POST['is_admin'] ?? false));

            vault_add_user($name, $email, $pwd, $is_admin);

            wp_redirect(home_url('/?vault=user-management'));
            exit;
        }
        break;

    case 'edit_user':
        if (vault_check_required_fields([$_POST['name_user'] ?? null, $_POST['email_user'] ?? null, $_POST['pwd_user'] ?? null, $_POST['is_admin'] ?? null])) {

            $id = intval(strip_tags($_POST['id_user']));
            $name = strip_tags($_POST['name_user']);
            $email = strip_tags($_POST['email_user']);
            $pwd = strip_tags($_POST['pwd_user']);
            $is_admin = boolval(strip_tags($_POST['is_admin']));

            vault_edit_user($id, $name, $email, $pwd, $is_admin);

            wp_redirect(home_url('/?vault=user-management'));
            exit;
        }
        break;

    case 'save_filter':

        $name = strip_tags($_POST['filter_name'] ?? "");
        $is_favorite = boolval(strip_tags($_POST['filter_is_favorite'] ?? false));
        $categories = $_POST['filter_categories'] ?? [];

        vault_save_filter_assurance($name, $is_favorite, $categories);

        wp_redirect(home_url('/?vault=dashboard'));
        exit;

}

