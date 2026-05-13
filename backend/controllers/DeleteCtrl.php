<?php

vault_check_auth();

$action = $_POST['action'] ?? null;

if ($action == null || !vault_is_admin()) {
    exit;
}


switch ($action) {

    case 'delete-assurance':
        if (vault_check_required_fields([$_POST['id_assurance'] ?? null])) {

            $id = intval(strip_tags($_POST['id_assurance']));

            vault_delete_assurance($id);
            wp_redirect(home_url('/?vault=dashboard'));
            exit;
        }
        break;

    case 'delete-link':
        if (vault_check_required_fields([$_POST['id_link'] ?? null])) {

            $id = intval(strip_tags($_POST['id_link']));

            vault_delete_link($id);
            wp_redirect(home_url('/?vault=dashboard'));
            exit;
        }
        break;

    case 'delete-user':
        if (vault_check_required_fields([$_POST['id_user'] ?? null])) {

            $id = intval(strip_tags($_POST['id_user']));

            vault_delete_user($id);
            wp_redirect(home_url('/?vault=user-management'));
            exit;
        }
        break;

    case 'delete-category':
        if (vault_check_required_fields([$_POST['id_category'] ?? null])) {

            $id = intval(strip_tags($_POST['id_category']));

            vault_delete_category($id);
            wp_redirect(home_url('/?vault=category-management'));
            exit;
        }
        break;

    case 'delete-type-category':
        if (vault_check_required_fields([$_POST['id_type_category'] ?? null])) {

            $id = intval(strip_tags($_POST['id_type_category']));

            vault_delete_type_category($id);
            wp_redirect(home_url('/?vault=type-category-management'));
            exit;
        }
        break;
}