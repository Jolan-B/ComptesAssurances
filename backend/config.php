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
    // Utiliser la connexion WordPress existante
    global $wpdb;

    // Retourner un objet qui imite l'interface PDO de notre code
    // Pour compatibilité avec le code existant
    static $db_wrapper = null;

    if ($db_wrapper === null) {
        $db_wrapper = new class {
            public function prepare($sql)
            {
                global $wpdb;
                return new class ($sql) {
                    private $sql;
                    private $bindings = [];

                    public function __construct($sql)
                    {
                        $this->sql = $sql;
                    }

                    public function bindValue($param, $value)
                    {
                        $this->bindings[$param] = $value;
                    }

                    public function execute()
                    {
                        global $wpdb;
                        $sql = $this->sql;
                        foreach ($this->bindings as $param => $value) {
                            $sql = str_replace($param, "'" . esc_sql($value) . "'", $sql);
                        }
                        return $wpdb->get_results($sql, ARRAY_A);
                    }

                    public function fetchAll()
                    {
                        return $this->execute();
                    }

                    public function fetch()
                    {
                        $results = $this->execute();
                        return isset($results[0]) ? $results[0] : null;
                    }

                    public function fetchColumn()
                    {
                        $result = $this->fetch();
                        if ($result && is_array($result)) {
                            return array_shift($result);
                        }
                        return null;
                    }
                };
            }

            public function query($sql)
            {
                global $wpdb;
                return new class ($sql) {
                    private $sql;

                    public function __construct($sql)
                    {
                        $this->sql = $sql;
                    }

                    public function fetchAll()
                    {
                        global $wpdb;
                        return $wpdb->get_results($this->sql, ARRAY_A);
                    }
                };
            }

            public function lastInsertId()
            {
                global $wpdb;
                return $wpdb->insert_id;
            }

            public function setAttribute($name, $value)
            {
                // WordPress gère cela automatiquement
            }
        };
    }

    return $db_wrapper;
}

return $db;
