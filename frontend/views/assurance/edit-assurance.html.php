<!DOCTYPE html>
<html lang="fr">

<?php
$assurance = vault_get_assurance($id);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier
        <?= $assurance["name"] ?>
    </title>

    <link rel="stylesheet" href="<?= VAULT_URL . 'frontend/assets/css/style.css' ?>">
    <link rel="stylesheet" href="<?= VAULT_URL . 'frontend/assets/css/assurance.css' ?>">
    <link rel="stylesheet" href="<?= VAULT_URL . 'frontend/assets/css/components.css' ?>">

    <script type="text/javascript" src="<?= VAULT_URL . 'frontend/assets/js/script.js' ?>"></script>

    <link rel="icon" type="image/svg+xml" href="<?= VAULT_URL . 'frontend/assets/images/logo-sily.png' ?>" />
</head>

<body>

    <?php
    $txt_add_button = "Enregistrer";
    $path = 'dashboard';
    $title = "Modifier " . $assurance["name"];
    $form = "form-edit-assurance";
    include_once VAULT_PATH . 'frontend/components/add-edit-bar.html.php';
    ?>

    <form class="form_edit_add_assurance" id="<?= $form ?>" action="<?= home_url('/?vault=edit-assurance') ?>"
        method="POST">
        <input type="hidden" name="action" value="edit-assurance">
        <input type="hidden" name="id" value="<?= $assurance['id'] ?>">

        <section class="edit_add_assurance_data">
            <section class="left_edit_add">

                <div class="edit_add_logo">
                    <label for="image">Logo</label>
                    <div>
                        <img class="actual_logo"
                            src="<?= $assurance['image'] ? VAULT_URL . "frontend/assets/images/logo/{$assurance['image']}" : VAULT_URL . "frontend/assets/images/logo/default.png" ?>" />
                        <input type="hidden" name="image" value="<?= $assurance['image'] ?>">
                        <img class="upload" src="<?= VAULT_URL . 'frontend/assets/images/upload_black.png' ?>" />
                    </div>
                </div>

                <div class="bloc_edit_add_assurance">
                    <label for="name">Nom Assurance</label>
                    <input type="text" id="name" name="name" value="<?= $assurance['name'] ?>" required>
                </div>

                <div class="bloc_edit_add_assurance">
                    <label for="url">URL</label>
                    <input type="text" id="url" name="url" value="<?= $assurance['url'] ?>" required>
                </div>

                <div class="bloc_edit_add_assurance">
                    <label for="username">Nom Utilisateur</label>
                    <input type="text" id="username" name="username" value="<?= $assurance['username'] ?>" required>
                </div>

            </section>

            <section class="right_edit_add">

                <div class="bloc_edit_add_assurance">
                    <label for="pwd">Mot de passe</label>
                    <input type="password" id="pwd" name="pwd" value="<?= $assurance['pwd'] ?>" required>
                </div>

                <div class="bloc_edit_add_assurance">
                    <label for="cc">Code Courtage</label>
                    <input type="text" id="cc" name="cc" value="<?= $assurance['cc'] ?>">
                </div>

                <div class="bloc_edit_add_assurance">
                    <label for="commentary">Commentaire</label>
                    <textarea rows="10" id="commentary"
                        name="commentary"><?= htmlspecialchars($assurance['commentary'] ?? '') ?></textarea>
                </div>

            </section>
        </section>

        <section class="edit_add_assurance_category_data">

            <?php
            $categories = vault_get_all_categories();
            $types_category = vault_get_all_types_category();

            $assurance_category_ids = array_column($assurance['categories'], 'id');


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

                                        <input type='checkbox' id='assurance_categories' name='categories[]'
                                            value="<?= $category['id'] ?>" <?= in_array($category['id'], $assurance_category_ids) ? 'checked' : '' ?> />

                                        <span class="edit_add_category"><?= $category['name_c'] ?></span>
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