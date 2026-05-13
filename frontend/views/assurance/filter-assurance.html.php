<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Comptes</title>

    <link rel="stylesheet" href="<?= VAULT_URL . 'frontend/assets/css/style.css' ?>">
    <link rel="stylesheet" href="<?= VAULT_URL . 'frontend/assets/css/assurance.css' ?>">
    <link rel="stylesheet" href="<?= VAULT_URL . 'frontend/assets/css/components.css' ?>">

    <script type="text/javascript" src="<?= VAULT_URL . 'frontend/assets/js/script.js' ?>"></script>

    <link rel="icon" type="image/svg+xml" href="<?= VAULT_URL . 'frontend/assets/images/logo-sily.png' ?>" />
</head>

<body>

    <!-- 
    Dans le terminal WSL : php -S localhost:8000
    puis dans le navigateur : http://localhost:8000/frontend/views/assurance/filter-assurance.html.php
    -->

    <?php include_once VAULT_PATH . 'frontend/components/navigation-bar.html.php'; ?>

    <section class="list_assurance_link_page">

        <form action="<?= home_url('/?vault=dashboard') ?>" class="filter_assurance" method="POST">

            <input type="hidden" name="action" value="save-filter">

            <div>
                <label for="name">Nom de l'assurance</label>
                <input type="text" id="name" name="filter_name" placeholder="Entrez le nom"
                    value="<?= $_SESSION['filter_name'] ?>">
            </div>

            <div>
                <input type="checkbox" id="is_favorite" name="filter_is_favorite" <?= $_SESSION['filter_is_favorite'] ? "checked" : "" ?>>
                <label for="is_favorite">Favori</label>
            </div>

            <label for="assurance_categories">Catégorie proposé</label>

            <div class="filter_assurance_categories">

                <?php
                foreach ($types_category as $type) {

                    if ($types_category[0] != $type) {
                        echo '<br/>';
                    }
                    ?>
                    <span class="type_category"><?= $type['name'] ?><span>
                            <br /><br />

                            <?php
                            foreach ($categories as $category) {

                                if ($category['id_tc'] == $type['id']) {
                                    ?>
                                    <input type='checkbox' id='assurance_categories' name='filter_categories[]'
                                        value="<?= $category['id'] ?>" <?= !empty($_SESSION['filter_categories']) && in_array($category['id'], $_SESSION['filter_categories']) ? "checked" : "" ?>>
                                    <span class="category"><?= $category['name_c'] ?></span>
                                    <br />
                                    <?php
                                }
                            }
                }
                ?>

            </div>

            <div class="buttons_filter_assurances">
                <?php
                $txt_red_button = "Réinitialiser";
                $path_red_button = "reset-filter";
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

            <!-- LISTE DES LIENS -->

            <div class="list_assurance_title_button">

                <span>Liste des Liens</span>

                <?php
                $txt_add_button = "Ajouter un Lien";
                $type_add_button = "button";
                $type_add_button = "submit";
                $path_add_button = "add-link";
                include VAULT_PATH . 'frontend/components/add-button.html.php';
                ?>
            </div>

            <div class="list_image">
                <?php
                include_once VAULT_PATH . 'backend/models/Link.php';

                if ($links == null) {
                    ?>
                    <span>Pas de lien pour le moment</span>
                    <?php
                } else {
                    foreach ($links as $link) {

                        // si il n'y a pas d'image de base
                        if ($link['image_link'] == null || $link['image_link'] == '') {
                            $link['image_link'] = "default.png";
                        }

                        include VAULT_PATH . '/frontend/components/bloc-link.html.php';
                    }
                }
                ?>
            </div>

            <!-- LISTE DES ASSURANCES -->

            <div class="list_assurance_title_button">

                <span>Liste des Assurances</span>

                <?php
                $txt_add_button = "Ajouter un Compte";
                $type_add_button = "button";
                $type_add_button = "submit";
                $path_add_button = "add-assurance";
                include VAULT_PATH . 'frontend/components/add-button.html.php';
                ?>
            </div>

            <div class="list_image">

                <?php
                if ($assurances == null) {
                    ?>
                    <span>Pas d'assurance</span>
                    <?php
                } else {
                    foreach ($assurances as $assurance) {

                        // si il n'y a pas d'image de base
                        if ($assurance['image'] == null || $assurance['image'] == '') {
                            $assurance['image'] = "default.png";
                        }

                        include VAULT_PATH . '/frontend/components/bloc-assurance.html.php';
                    }
                }
                ?>

            </div>

        </section>

    </section>

</body>

</html>