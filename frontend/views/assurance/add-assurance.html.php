<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Assurance</title>

    <link rel="stylesheet" href="<?= VAULT_URL . 'frontend/assets/css/style.css' ?>">
    <link rel="stylesheet" href="<?= VAULT_URL . 'frontend/assets/css/assurance.css' ?>">
    <link rel="stylesheet" href="<?= VAULT_URL . 'frontend/assets/css/components.css' ?>">

    <script type="text/javascript" src="<?= VAULT_URL . 'frontend/assets/js/script.js' ?>"></script>

    <link rel="icon" type="image/svg+xml" href="<?= VAULT_URL . 'frontend/assets/images/logo-sily.png' ?>" />
</head>

<body>

    <?php
    $txt_add_button = "Créer";
    $path = 'dashboard';
    $title = "Ajouter une Assurance";
    $form = "form-add-assurance";
    include_once VAULT_PATH . 'frontend/components/add-edit-bar.html.php';
    ?>

    <form class="form_edit_add_assurance" id="<?= $form ?>" action="<?= home_url('/?vault=add-assurance') ?>"
        method="POST">
        <input type="hidden" name="action" value="add-assurance">

        <section class="edit_add_assurance_data">
            <section class="left_edit_add">

                <div class="edit_add_logo">
                    <label for="image">Logo</label>
                    <div>
                        <input type="image" id="image" name="image"
                            src="<?= VAULT_URL . "frontend/assets/images/logo/default.png" ?>">
                        <img class="upload" src="<?= VAULT_URL . 'frontend/assets/images/upload_black.png' ?>" />
                    </div>
                </div>

                <div class="bloc_edit_add_assurance">
                    <label for="name">Nom Assurance</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div class="bloc_edit_add_assurance">
                    <label for="url">URL</label>
                    <input type="text" id="url" name="url" required>
                </div>

                <div class="bloc_edit_add_assurance">
                    <label for="username">Nom Utilisateur</label>
                    <input type="text" id="username" name="username" required>
                </div>

            </section>

            <section class="right_edit_add">

                <div class="bloc_edit_add_assurance">
                    <label for="pwd">Mot de passe</label>
                    <input type="password" id="pwd" name="pwd" required>
                </div>

                <div class="bloc_edit_add_assurance">
                    <label for="cc">Code Courtage</label>
                    <input type="text" id="cc" name="cc">
                </div>

                <div class="bloc_edit_add_assurance">
                    <label for="commentary">Commentaire</label>
                    <textarea rows="10" id="commentary" name="commentary"></textarea>
                </div>

            </section>
        </section>

        <section class="edit_add_assurance_category_data">

            <?php
            $categories = vault_get_all_categories();
            $types_category = vault_get_all_types_category();

            foreach ($types_category as $type) {

                if ($types_category[0] != $type) {
                    echo '<br />';
                }

                ?>
                <div class="bloc_type_category">
                    <span class="edit_add_type_category"><?= $type['name'] ?><span>

                            <?php
                            foreach ($categories as $category) {

                                if ($category['id_tc'] == $type['id']) {
                                    ?>
                                    <div class="bloc_category">
                                        <input type='checkbox' id='assurance_categories' name='categories'
                                            value="<?= $category['id'] ?>">
                                        <span class=" edit_add_category"><?= $category['name_c'] ?></span>
                                    </div>

                                    <?php

                                }
                            }
                            ?>
                </div>
                <?php
            }
            ?>

        </section>


    </form>

</body>

</html>