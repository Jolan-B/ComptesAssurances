<?php

require_once plugin_dir_path(__FILE__) . '../config/auth.php';
require_once plugin_dir_path(__FILE__) . '../models/Assurance.php';
require_once plugin_dir_path(__FILE__) . '../models/Category.php';
require_once plugin_dir_path(__FILE__) . '../models/TypeCategory.php';
require_once plugin_dir_path(__FILE__) . '../models/Link.php';

// Vérifie que l'utilisateur est connecté
check_auth();

// Récupère les assurances selon si un filtre est actif
$assurances = filter_assurance();

// Récupère les types de catégories pour le filtre
$type_categories = get_all_types_category();

// Récupère les catégories pour le filtre
$categories = get_all_categories();

// Récupère les liens
$links = get_all_links();

// Charge la vue
require_once plugin_dir_path(__FILE__) . '../../public/dashboard.php';