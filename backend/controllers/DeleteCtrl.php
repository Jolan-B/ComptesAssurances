<?php

require_once plugin_dir_path(__FILE__) . '../models/Assurance.php';
require_once plugin_dir_path(__FILE__) . '../models/User.php';
require_once plugin_dir_path(__FILE__) . '../models/Category.php';
require_once plugin_dir_path(__FILE__) . '../models/Link.php';
require_once plugin_dir_path(__FILE__) . '../models/TypeCategory.php';
require_once plugin_dir_path(__FILE__) . '../auth.php';

function pcheck_post_action($tab)
{
    foreach ($tab as $value) {
        if (!isset($value) || empty($value)) {
            return false;
        }
    }
    return true;
}

check_auth();

$action = $_POST['action'] ?? null;

if ($action == null || !is_admin()) {
    exit;
}

switch ($action) {

    case 'delete_assurance':
        if (pcheck_post_action([$_POST['id_assurance'] ?? null])) {

            $id = intval(strip_tags($_POST['id_assurance']));

            delete_assurance($id);
            wp_redirect(plugin_dir_url(__FILE__) . '../../frontend/views/assurance/filter-assurance.html.php');
            exit;
        }
        break;

    case 'delete_link':
        if (pcheck_post_action([$_POST['id_link'] ?? null])) {

            $id = intval(strip_tags($_POST['id_link']));

            delete_link($id);
            wp_redirect(plugin_dir_url(__FILE__) . '../../frontend/views/assurance/filter-assurance.html.php');
            exit;
        }
        break;

    case 'delete_user':
        if (pcheck_post_action([$_POST['id_user'] ?? null])) {

            $id = intval(strip_tags($_POST['id_user']));

            delete_user($id);
            wp_redirect(plugin_dir_url(__FILE__) . '../../frontend/views/user/show-user.html.php');
            exit;
        }
        break;

    case 'delete_category':
        if (pcheck_post_action([$_POST['id_category'] ?? null])) {

            $id = intval(strip_tags($_POST['id_category']));

            delete_category($id);
            wp_redirect(plugin_dir_url(__FILE__) . '../../frontend/views/category/show-category.html.php');
            exit;
        }
        break;

    case 'delete_type_category':
        if (pcheck_post_action([$_POST['id_type_category'] ?? null])) {

            $id = intval(strip_tags($_POST['id_type_category']));

            delete_type_category($id);
            wp_redirect(plugin_dir_url(__FILE__) . '../../frontend/views/type_category/show-type-category.html.php');
            exit;
        }
        break;
}