<?php

require_once plugin_dir_path(__FILE__) . '../models/Assurance.php';
require_once plugin_dir_path(__FILE__) . '../models/Link.php';
require_once plugin_dir_path(__FILE__) . '../models/User.php';
require_once plugin_dir_path(__FILE__) . '../config/auth.php';


function check_post_get_action($tab)
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

if ($action == null) {
    exit;
}

switch ($action) {

    case 'add_assurance':
        if (check_post_get_action([$_POST["name_assurance"] ?? null, $_POST["url_assurance"] ?? null, $_POST["username_assurance"] ?? null, $_POST["password_assurance"] ?? null])) {
            $name = strip_tags($_POST["name_assurance"]);
            $url = strip_tags($_POST["url_assurance"]);
            $username = strip_tags($_POST["username_assurance"]);
            $pwd = strip_tags($_POST["password_assurance"]);
            $cc = strip_tags($_POST["code_courtage_assurance"] ?? "");
            $img = strip_tags($_POST["image_assurance"] ?? "");
            $comm = htmlspecialchars($_POST["commentary_assurance"] ?? "");
            $categories = $_POST["categories_assurance"] ?? [];

            add_assurance($name, $url, $username, $pwd, $comm, $categories, $cc, $img);

            wp_redirect(plugin_dir_url(__FILE__) . '../../public/dashboard.php');
            exit;
        }
        break;

    case 'edit_assurance':
        if (check_post_get_action([$_POST["id_assurance"] ?? null, $_POST["name_assurance"] ?? null, $_POST["url_assurance"] ?? null, $_POST["username_assurance"] ?? null, $_POST["password_assurance"] ?? null])) {
            $id = intval(strip_tags($_POST["id_assurance"]));
            $name = strip_tags($_POST["name_assurance"]);
            $url = strip_tags($_POST["url_assurance"]);
            $username = strip_tags($_POST["username_assurance"]);
            $pwd = strip_tags($_POST["password_assurance"]);
            $cc = strip_tags($_POST["code_courtage_assurance"] ?? "");
            $img = strip_tags($_POST["image_assurance"] ?? "");
            $comm = htmlspecialchars($_POST["commentary_assurance"] ?? "");
            $categories = $_POST["categories_assurance"] ?? [];

            edit_assurance($id, $name, $url, $username, $pwd, $comm, $categories, $cc, $img);

            wp_redirect(plugin_dir_url(__FILE__) . '../../public/dashboard.php');
            exit;
        }
        break;

    case 'add_link':
        if (check_post_get_action([$_POST["name_link"] ?? null, $_POST["url_link"] ?? null])) {
            $name = strip_tags($_POST["name_link"]);
            $url = strip_tags($_POST["url_link"]);
            $username = strip_tags($_POST["username_link"] ?? "");
            $pwd = strip_tags($_POST["password_link"] ?? "");
            $img = strip_tags($_POST["image_link"] ?? "");
            $comm = strip_tags($_POST["commentary_link"] ?? "");

            add_link($name, $url, $username, $pwd, $comm, $img);

            wp_redirect(plugin_dir_url(__FILE__) . '../../public/dashboard.php');
            exit;
        }
        break;

    case 'edit_link':
        if (check_post_get_action([$_POST['id_link'] ?? null, $_POST['name_link'] ?? null, $_POST['url_link'] ?? null])) {

            $id = intval(strip_tags($_POST['id_link']));
            $name = strip_tags($_POST['name_link']);
            $url = strip_tags($_POST['url_link']);
            $username = strip_tags($_POST['username_link'] ?? "");
            $pwd = strip_tags($_POST['password_link'] ?? "");
            $comm = strip_tags($_POST['commentary_link'] ?? "");
            $img = strip_tags($_POST['image_link'] ?? "");

            edit_link($id, $name, $url, $username, $pwd, $comm, $img);

            wp_redirect(plugin_dir_url(__FILE__) . '../../public/dashboard.php');
            exit;
        }
        break;

    case 'add_user':
        if (check_post_get_action([$_POST['name_user'] ?? null, $_POST['email_user'] ?? null, $_POST['password_user'] ?? null, $_POST['is_admin'] ?? null])) {

            $name = strip_tags($_POST['name_user']);
            $email = strip_tags($_POST['email_user']);
            $pwd = strip_tags($_POST['password_user']);
            $is_admin = boolval(strip_tags($_POST['is_admin'] ?? false));

            add_user($name, $email, $pwd, $is_admin);

            wp_redirect(plugin_dir_url(__FILE__) . '../../public/dashboard.php');
            exit;
        }
        break;

    case 'edit_user':
        if (check_post_get_action([$_POST['name_user'] ?? null, $_POST['email_user'] ?? null, $_POST['password_user'] ?? null, $_POST['is_admin'] ?? null])) {

            $id = intval(strip_tags($_POST['id_user']));
            $name = strip_tags($_POST['name_user']);
            $email = strip_tags($_POST['email_user']);
            $pwd = strip_tags($_POST['password_user']);
            $is_admin = boolval(strip_tags($_POST['is_admin']));

            edit_user($id, $name, $email, $pwd, $is_admin);

            wp_redirect(plugin_dir_url(__FILE__) . '../../public/dashboard.php');
            exit;
        }
        break;

    case 'save_filter':

        $name = strip_tags($_POST['filter_name'] ?? "");
        $is_favorite = boolval(strip_tags($_POST['filter_is_favorite'] ?? false));
        $categories = $_POST['filter_categories'] ?? [];

        save_filter_assurance($name, $is_favorite, $categories);

        wp_redirect(plugin_dir_url(__FILE__) . '../../public/dashboard.php');
        exit;

}

