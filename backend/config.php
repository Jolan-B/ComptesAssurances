<?php

// Chargement du .env
$env = parse_ini_file(dirname(__DIR__) . '/.env');

define('DB_HOST', $env['DB_HOST']);
define('DB_NAME', $env['DB_NAME']);
define('DB_USER', $env['DB_USER']);
define('DB_PASSWORD', $env['DB_PASSWORD']);
define('VAULT_AES_KEY', $env['VAULT_AES_KEY']);
define('VAULT_AES_IV', $env['VAULT_AES_IV']);

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

function get_db()
{

    static $db = null;

    if ($db === null) {

        // DSN (Date Source Name) de connexion :
        $dsn = "mysql:dbname=" . DB_NAME . ";host=" . DB_HOST . ";charset=utf8mb4";

        try {
            // instancier PDO
            $db = new PDO($dsn, DB_USER, DB_PASSWORD);

            // on définit le mode de fetch par défaut
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log($e->getMessage());
            wp_die('Erreur de connexion');
        }
    }

    return $db;
}