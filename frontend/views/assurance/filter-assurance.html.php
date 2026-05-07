<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Comptes</title>
    <link rel="stylesheet" href="<?= VAULT_URL . 'frontend/assets/css/style.css' ?>">
    <link rel="icon" type="image/svg+xml" href="<?= VAULT_URL . 'frontend/assets/images/logo-sily.png' ?>" />
</head>

<body>

    <!-- 
    Dans le terminal WSL : php -S localhost:8000
    puis dans le navigateur : http://localhost:8000/frontend/views/assurance/filter-assurance.php
    -->

    <?php include_once VAULT_PATH . 'frontend/components/navigation-bar.html.php'; ?>

    <section class="list_assurance_link_page">

        <form action="<?= home_url('/?vault=dashboard') ?>" class="filter_assurance" method="POST">

            <input type="hidden" name="action" value="save_filter">

            <div>
                <label for="name">Nom de l'assurance</label>
                <input type="text" id="name" name="name" placeholder="Entrez le nom">
            </div>

            <div>
                <input type="checkbox" id="favorite" name="favorite">
                <label for="favorite">Favori</label>
            </div>

            <div class="filter_assurance_categories">

                <label for="assurance_categories">Catégorie proposé</label>


                <div>
                    <?php
                    foreach ($type_categories as $type) {
                        echo '<span class="title_filter_assurance_category">' . htmlspecialchars($type['name']) . '</span>';
                        foreach ($categories as $category) {
                            if ($category['id_tc'] == $type['id']) {
                                echo '<input type="checkbox" name="assurance_categories[]" value="' . htmlspecialchars($category['id_c']) . '">';
                                echo '<span>' . htmlspecialchars($category['name_c']) . '</span>';
                            }
                        }
                    }
                    ?>
                </div>

            </div>

            <div class="buttons_filter_assurances">
                <?php
                $txt_red_button = "Réinitialiser";
                $type_red_button = "submit";
                include VAULT_PATH . 'frontend/components/red-button.html.php';
                ?>

                <?php
                $txt_add_button = "Rechercher";
                $type_add_button = "submit";
                include VAULT_PATH . 'frontend/components/add-button.html.php';
                ?>
            </div>

        </form>

        <section class="list_assurance_link">

            <div class="list_assurance_title_button">

                <span>Liste des Liens</span>

                <?php
                $txt_add_button = "Ajouter un Lien";
                $type_add_button = "button";
                include VAULT_PATH . 'frontend/components/add-button.html.php';
                ?>

            </div>

            <div class="list_assurance_title_button">

                <span>Liste des Assurances</span>

                <?php
                $txt_add_button = "Ajouter un Compte";
                $type_add_button = "button";
                include VAULT_PATH . 'frontend/components/add-button.html.php';
                ?>
            </div>

        </section>

    </section>

</body>

</html>