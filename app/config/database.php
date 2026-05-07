<?php

// Charge les variables d'environnement depuis .env
$dotenv = parse_ini_file(__DIR__ . '/../../.env');
define('VAULT_AES_KEY', $dotenv['VAULT_AES_KEY']);
define('VAULT_AES_IV', $dotenv['VAULT_AES_IV']);

// Connexion à la base de données :
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