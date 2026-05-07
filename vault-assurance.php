<?php
/**
 * Plugin Name: Vault Assurances
 * Description: Coffre-fort de credentials pour courtier
 * Version: 1.0
 * Author: Jolan
 */

if (!defined('ABSPATH'))
  exit;

// Constantes
define('VAULT_PATH', plugin_dir_path(__FILE__));
define('VAULT_URL', plugin_dir_url(__FILE__));

// Includes
require_once VAULT_PATH . 'backend/config.php';
require_once VAULT_PATH . 'backend/auth.php';
require_once VAULT_PATH . 'backend/models/Category.php';
require_once VAULT_PATH . 'backend/models/TypeCategory.php';
require_once VAULT_PATH . 'backend/models/Assurance.php';
require_once VAULT_PATH . 'backend/models/User.php';

// Activation
register_activation_hook(__FILE__, 'vault_activate');
function vault_activate()
{
  $db = get_db();
  // votre SQL existant — rien ne change ici
}

// Shortcode pour le bouton sur sily.fr
add_shortcode('vault_bouton', 'vault_render_bouton');
function vault_render_bouton()
{
  $url = home_url('/?vault=login');
  return '<a href="' . esc_url($url) . '" class="vault-btn">Se connecter à Vault</a>';
}

// Intercepter les requêtes publiques
add_action('template_redirect', 'vault_router');
function vault_router()
{
  $page = isset($_GET['vault']) ? sanitize_text_field($_GET['vault']) : null;

  if (!$page)
    return; // pas une requête vault, WordPress continue normalement

  switch ($page) {
    case 'login':
      require_once VAULT_PATH . 'frontend/views/login/login.html.php';
      exit;
    case 'forgot-password':
      require_once VAULT_PATH . 'frontend/views/login/forgot-password.html.php';
      exit;
    case 'reset-password':
      require_once VAULT_PATH . 'frontend/views/login/reset-password.html.php';
      exit;
    case 'dashboard':
      vault_check_auth(); // vérifier la session avant
      require_once VAULT_PATH . 'frontend/views/assurance/filter-assurance.html.php';
      exit;
    case 'category-management':
      vault_check_auth(); // vérifier la session avant
      require_once VAULT_PATH . 'frontend/views/category/show-category.html.php';
      exit;
    case 'type-category-management':
      vault_check_auth(); // vérifier la session avant
      require_once VAULT_PATH . 'frontend/views/type_category/show-type-category.html.php';
      exit;
    case 'user-management':
      vault_check_auth(); // vérifier la session avant
      if (!vault_is_admin()) {
        wp_redirect(home_url('/?vault=dashboard'));
        exit;
      }
      require_once VAULT_PATH . 'frontend/views/user/show-user.html.php';
      exit;
    default:
      wp_redirect(home_url('/?vault=login'));
      exit;
  }
}

// Enqueue CSS/JS uniquement sur les pages vault
add_action('wp_enqueue_scripts', 'vault_enqueue_assets');
function vault_enqueue_assets()
{
  if (!isset($_GET['vault']))
    return;
  wp_enqueue_style('vault-style', VAULT_URL . 'frontend/assets/css/style.css');
  wp_enqueue_script('vault-js', VAULT_URL . 'frontend/assets/js/app.js', [], null, true);
}