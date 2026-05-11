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

  $sql = "DROP TABLE IF EXISTS `Favorite`, `Propose`, `Assurance`, `Link`, `Category`, `Type_Category`, `App_User`;";
  $db->exec($sql);

  // Table App_User
  $sql = "CREATE TABLE IF NOT EXISTS `App_User` (
  `id_user` INT AUTO_INCREMENT PRIMARY KEY,
  `name_user` VARCHAR(255) NOT NULL UNIQUE,
  `email_user` VARCHAR(255) NOT NULL UNIQUE,
  `password_user` VARCHAR(255) NOT NULL,
  `is_admin` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
  $db->exec($sql);

  // Table Type Category
  $sql = "CREATE TABLE IF NOT EXISTS `Type_Category` (
  `id_type_category` INT AUTO_INCREMENT PRIMARY KEY,
  `name_type_category` VARCHAR(255) NOT NULL UNIQUE,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
  $db->exec($sql);

  // Table Category
  $sql = "CREATE TABLE IF NOT EXISTS `Category` (
  `id_category` INT AUTO_INCREMENT PRIMARY KEY,
  `name_category` VARCHAR(255) NOT NULL,
  `type_category_id` INT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`type_category_id`) REFERENCES `Type_Category`(`id_type_category`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
  $db->exec($sql);

  // Table Link
  $sql = "CREATE TABLE IF NOT EXISTS `Link` (
  `id_link` INT AUTO_INCREMENT PRIMARY KEY,
  `name_link` VARCHAR(255) NOT NULL,
  `url_link` VARCHAR(255) NOT NULL,
  `username_link` VARCHAR(255),
  `password_link` LONGTEXT,
  `commentary_link` TEXT,
  `image_link` LONGBLOB,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
  $db->exec($sql);

  // Table Assurance
  $sql = "CREATE TABLE IF NOT EXISTS `Assurance` (
  `id_assurance` INT AUTO_INCREMENT PRIMARY KEY,
  `name_assurance` VARCHAR(255) NOT NULL,
  `url_assurance` TEXT,
  `username_assurance` VARCHAR(255),
  `password_assurance` LONGTEXT,
  `code_courtage_assurance` VARCHAR(255),
  `commentary_assurance` TEXT,
  `image_assurance` LONGBLOB,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
  $db->exec($sql);

  // Table Propose (relation Assurance <-> Category)
  $sql = "CREATE TABLE IF NOT EXISTS `Propose` (
  `id_propose` INT AUTO_INCREMENT PRIMARY KEY,
  `assurance_id` INT NOT NULL,
  `category_id` INT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`assurance_id`) REFERENCES `Assurance`(`id_assurance`) ON DELETE CASCADE,
  FOREIGN KEY (`category_id`) REFERENCES `Category`(`id_category`) ON DELETE CASCADE,
  UNIQUE KEY `unique_propose` (`assurance_id`, `category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
  $db->exec($sql);

  // Table Favorite (relation User <-> Assurance)
  $sql = "CREATE TABLE IF NOT EXISTS `Favorite` (
  `id_favorite` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `assurance_id` INT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `App_User`(`id_user`) ON DELETE CASCADE,
  FOREIGN KEY (`assurance_id`) REFERENCES `Assurance`(`id_assurance`) ON DELETE CASCADE,
  UNIQUE KEY `unique_favorite` (`user_id`, `assurance_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

  $db->exec($sql);



  // Créer un utilisateur admin par défaut
  $name_admin = 'admin';

  $email_admin = 'jolan.bertin2002@gmail.com';
  $password_admin = password_hash('admin123', PASSWORD_BCRYPT);

  $sql = "INSERT INTO `App_User` (`name_user`, `email_user`, `password_user`, `is_admin`) 
  VALUES (:name, :email, :pwd, 1)";
  $req = $db->prepare($sql);
  $req->bindValue(":name", $name_admin);
  $req->bindValue(":email", $email_admin);
  $req->bindValue(":pwd", $password_admin);
  $req->execute();

  // Créer des Assurances et des Categories par défaut
  $sql = "INSERT INTO Type_Category (`name_type_category`) 
  VALUES ('Auto'), ('Habitation'), ('Santé');";
  $db->exec($sql);

  $sql = "INSERT INTO Category (`name_category`, `type_category_id`)
  VALUES 
  ('Assurance auto', 1), 
  ('Assurance moto', 1), 
  ('Assurance maison', 2), 
  ('Assurance appartement', 2), 
  ('Assurance santé individuelle', 3), 
  ('Assurance santé familiale', 3);";

  $db->exec($sql);

  $sql = "INSERT INTO Assurance (`name_assurance`,`url_assurance`,`username_assurance`,`password_assurance`,`code_courtage_assurance`,`commentary_assurance`,`image_assurance`) VALUES 
  ('Groupama','https://authentification.groupama.fr/auth/realms/groupama/protocol/openid-connect/auth?response_type=code&client_id=ecli-groupama-web&scope=openid%20profile%20email&state=rb2Imr81K0_X2ctY2ruqH7GKf7JmRpozh8-vN_bYuHs%3D&redirect_uri=https://espaceclient.groupama.fr/login/oauth2/code/gateway&nonce=eUDqY8yjvo1dY_DbztgfyNtevHZYna0uVEitLXbMdu4','user','pwd', NULL,'Toujours toujours là pour moi','groupama.png'),
  ('Axa','https://www.axa.fr/espace-client.html','user','pwd', NULL,'Superbe assurance pour les voiture','axa.png'),
  ('Apivia','https://adherents.apivia.fr/identity/account/login?returnUrl=%2Fidentity%2Fconnect%2Fauthorize%2Fcallback%3Fclient_id%3Dapivia-adherent%26redirect_uri%3Dhttps%253A%252F%252Fadherents.apivia.fr%252Fsignin-oidc%26response_type%3Dcode%26scope%3Dopenid%2520profile%26code_challenge%3Dzz5F6geR2nRSr6AwNV65vt043DyGPTJ-IwRlSMg0de0%26code_challenge_method%3DS256%26response_mode%3Dform_post%26nonce%3D639140877811392420.YmJiZGMyZjktZjczMC00MWE4LWIzZGQtZmI1YjdhM2M4YTY4MDNlYjNlNjAtZjAzOS00NTZhLThiNmItZjUxMjI3YjNhYzRj%26state%3DCfDJ8ONfNHN5pYBNol7eb0L1AXrJxVS4ep93iZ6PqZP7T6oBXhDdK1jE052XWfP-5aj7Roda-AHsqSL_bxdCUEjKZwsK_8NMDKBF4BmUDYLc3vuT52adAdqRDDejKu5-AJPMCD0vMbA_D8Dace4GpYklG_S1YFWjB7hlD6Yxqm_AL9lMNdrSepQ909K3kulTDQO8NsxF0tRvDMbYi4azFDwaCe-3tsH0JCvlGqTRu8YwK7PvdorH5oJGdCJ56vvW2EkiHQ92f7AxQa8Qzj-71PdAYWcOOfgnhYkjTyQnVFzPMm4VkhwEWvuCj90YQZFsyW50qCpJS0DqhbdA6RY_QFpNDTdeS0SLx3GRJ6Y4y5p6KI_wBLxtkvXDdPNuvX8h9j9YnA%26x-client-SKU%3DID_NET6_0%26x-client-ver%3D6.35.0.0','user','pwd', NULL,'Pas top pour les gros cilyndrés','apivia.png'),
  ('Allianz', 'https://espace-client.allianz.fr/', 'user', 'pwd', NULL, NULL, 'allianz.png'),
  ('Macif','sily.fr','user','pwd', NULL,'Pas d\'image', NULL);";
  $db->exec($sql);

  $sql = "INSERT INTO `Propose` (`assurance_id`,`category_id`) VALUES
  (1,3),
  (2,1),
  (3,2),
  (4,1),
  (5,2);";

  $db->exec($sql);

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
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once VAULT_PATH . 'backend/controllers/LoginCtrl.php';
      } else {
        require_once VAULT_PATH . 'frontend/views/login/login.html.php';
      }
      exit;

    case 'forgot-password':
      require_once VAULT_PATH . 'frontend/views/login/forgot-password.html.php';
      exit;

    case 'forgot-password-send':
      require_once VAULT_PATH . 'backend/controllers/ForgotPasswordCtrl.php';
      exit;

    case 'reset-password':
      require_once VAULT_PATH . 'frontend/views/login/reset-password.html.php';
      exit;

    case 'login-after-reset-password':
      require_once VAULT_PATH . 'backend/controllers/ResetPasswordCtrl.php';
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

add_action('admin_menu', 'vault_add_admin_menu');
function vault_add_admin_menu()
{
  add_menu_page(
    'Accès Assurances',
    'Accès Assurances',
    'manage_options',
    'comptes_assurance',
    'vault_render_dashboard',
    'dashicons-lock',
    6
  );
}

function vault_render_dashboard()
{
  echo '<script>window.location.href="' . home_url('/?vault=dashboard') . '";</script>';
}