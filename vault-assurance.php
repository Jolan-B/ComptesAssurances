<?php
/**
 * Plugin Name: Vault Assurances
 * Description: Coffre-fort de credentials pour courtier
 * Version: 1.0
 * Author: Jolan
 */

require_once plugin_dir_path(__FILE__) . 'backend/config.php';
require_once plugin_dir_path(__FILE__) . 'backend/auth.php';

function render_dashboard()
{
  require_once plugin_dir_path(__FILE__) . 'frontend/views/dashboard.html.php';
}

// Connexion à la BdD
register_activation_hook(__FILE__, 'vault_activate');

// Creation des tables avec insertion des données
function activate()
{

  // on récupère la BdD depuis Config.php
  $db = vault_get_db();

  // Destruction des tables si déjà existantes

  $sql = " 
DROP TABLE IF EXISTS Favorite, Propose, Assurance, Category, Type_Category, App_User, Link;";
  $db->exec($sql);

  // Création Table Type Catégorie

  $sql = "CREATE TABLE Type_Category (
    id_type_category INT AUTO_INCREMENT PRIMARY KEY,
    name_type_category VARCHAR(50) NOT NULL UNIQUE
);";
  $db->exec($sql);

  // Création Table Catégorie

  $sql = "CREATE TABLE Category (
    id_category INT AUTO_INCREMENT PRIMARY KEY,
    name_category VARCHAR(50) NOT NULL,
    type_category_id INT NOT NULL,
    FOREIGN KEY (type_category_id) REFERENCES Type_Category(id_type_category) ON DELETE CASCADE
);";
  $db->exec($sql);

  // Création Table Assurance

  $sql = "CREATE TABLE Assurance (
    id_assurance INT AUTO_INCREMENT PRIMARY KEY,
    name_assurance VARCHAR(50) NOT NULL,
    url_assurance VARCHAR(255) NOT NULL,
    username_assurance VARCHAR(255) NOT NULL,
    password_assurance TEXT NOT NULL,  -- AES chiffré
    code_courtage_assurance VARCHAR(255),
    image_assurance VARCHAR(255),
    commentary_assurance TEXT
);";
  $db->exec($sql);

  // Création Table Propose

  $sql = "CREATE TABLE Propose (
    assurance_id INT NOT NULL,
    category_id INT NOT NULL,
    PRIMARY KEY (assurance_id, category_id),
    FOREIGN KEY (assurance_id) REFERENCES Assurance(id_assurance) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES Category(id_category) ON DELETE CASCADE
);";
  $db->exec($sql);

  // Création Table Utilisateur

  $sql = "CREATE TABLE App_User (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    is_admin BOOLEAN NOT NULL DEFAULT FALSE,
    name_user VARCHAR(50) NOT NULL UNIQUE,
    email_user VARCHAR(50) NOT NULL,
    password_user TEXT NOT NULL  -- bcrypt hash
);";
  $db->exec($sql);

  // Création Table Favorie

  $sql = "CREATE TABLE Favorite (
    assurance_id INT NOT NULL,
    user_id INT NOT NULL,
    PRIMARY KEY (assurance_id, user_id),
    FOREIGN KEY (assurance_id) REFERENCES Assurance(id_assurance) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES App_User(id_user) ON DELETE CASCADE
);";
  $db->exec($sql);

  // Création Table Lien
  $sql = "CREATE TABLE Link (
    id_link INT AUTO_INCREMENT PRIMARY KEY,
    name_link VARCHAR(50) NOT NULL,
    url_link VARCHAR(255) NOT NULL, 
    username_link VARCHAR(255),
    password_link TEXT NULL,
    image_link VARCHAR(255),
    commentary_link TEXT
);";
  $db->exec($sql);


  // Créé des Catégories
  $sql = "
INSERT INTO Type_Category VALUES 
(NULL, 'Auto'),
(NULL, 'Habitation'), 
(NULL, 'Santé');
";
  $db->exec($sql);


  // Créé un Utilisateur
  $hash = password_hash('admin123', PASSWORD_BCRYPT);
  $sql = "
INSERT INTO App_User (is_admin, name_user, email_user, password_user) VALUES 
(1, 'admin','admin@sily.fr', :pwd );";

  $req = $db->prepare($sql);
  $req->bindValue(":pwd", $hash);
  $req->execute();

}


//lien pour accéder à la page depuis le site WP

add_action('admin_menu', 'menu');

function menu()
{
  add_menu_page(
    'Accès Assurances',      // balise <title>
    'Accès Assurances',      // texte affiché dans le menu WP
    'manage_options',        // capability WP requise
    'comptes_assurance',     // identifiant unique de la page
    'vault_render_dashboard',// fonction qui affiche le contenu
    'dashicons-lock',        // icône (cadenas)
    6                        // position dans le menu
  );
}
?>