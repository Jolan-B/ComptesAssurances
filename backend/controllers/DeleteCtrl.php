<?php

vault_check_auth();

$action = $_POST['action'] ?? null;

if ($action == null || !vault_is_admin()) {
    exit;
}

switch ($action) {

    case 'delete_assurance':
        if (pvault_check_required_fields([$_POST['id_assurance'] ?? null])) {

            $id = intval(strip_tags($_POST['id_assurance']));

            delete_assurance($id);
            wp_redirect(home_url('/?vault=dashboard'));
            exit;
        }
        break;

    case 'delete_link':
        if (pvault_check_required_fields([$_POST['id_link'] ?? null])) {

            $id = intval(strip_tags($_POST['id_link']));

            delete_link($id);
            wp_redirect(home_url('/?vault=dashboard'));
            exit;
        }
        break;

    case 'delete_user':
        if (pvault_check_required_fields([$_POST['id_user'] ?? null])) {

            $id = intval(strip_tags($_POST['id_user']));

            delete_user($id);
            wp_redirect(home_url('/?vault=user-management'));
            exit;
        }
        break;

    case 'delete_category':
        if (pvault_check_required_fields([$_POST['id_category'] ?? null])) {

            $id = intval(strip_tags($_POST['id_category']));

            delete_category($id);
            wp_redirect(home_url('/?vault=category-management'));
            exit;
        }
        break;

    case 'delete_type_category':
        if (pvault_check_required_fields([$_POST['id_type_category'] ?? null])) {

            $id = intval(strip_tags($_POST['id_type_category']));

            delete_type_category($id);
            wp_redirect(home_url('/?vault=type-category-management'));
            exit;
        }
        break;
}