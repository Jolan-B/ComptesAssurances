<?php

// Chargement du .env pour les clés AES uniquement
$env_path = dirname(__DIR__) . '/.env';
$env = parse_ini_file($env_path);

if ($env === false) {
    wp_die('Fichier .env non trouvé à : ' . $env_path);
}

// Utiliser les constantes WordPress pour DB (déjà définies)
// Pas besoin de redéfinir DB_HOST, DB_NAME, DB_USER, DB_PASSWORD

define('VAULT_AES_KEY', $env['VAULT_AES_KEY'] ?? '');
define('VAULT_AES_IV', $env['VAULT_AES_IV'] ?? '');

define('VAULT_DB_HOST', $env['DB_HOST_CUSTOM'] ?? '172.20.80.1');
define('VAULT_DB_PORT', $env['DB_PORT'] ?? '3306');

// Connexion à la base de données :

function vault_check_required_fields($tab)
{
    foreach ($tab as $value) {
        if (!isset($value) || empty($value)) {
            return false;
        }
    }
    return true;
}

// Dans le terminal Local : 
// mysql -u root local -e "SHOW VARIABLES LIKE 'port';"

function get_db()
{
    static $db = null;

    if ($db === null) {

        $dsn = "mysql:dbname=" . DB_NAME . ";host=" . VAULT_DB_HOST . ";port=" . VAULT_DB_PORT . ";charset=utf8mb4";
        try {
            $db = new PDO($dsn, DB_USER, DB_PASSWORD);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            wp_die('Erreur de connexion : ' . $e->getMessage());

        }
    }

    return $db;
}