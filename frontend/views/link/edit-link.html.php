<!DOCTYPE html>
<html lang="fr">

<?php
$link = vault_get_link($id);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier
        <?= $link["name"] ?>
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
    $title = "Modifier " . $link["name"];
    $form = "form-edit-link";
    include_once VAULT_PATH . 'frontend/components/add-edit-bar.html.php';
    ?>

    <form class="form_edit_add_assurance" id="<?= $form ?>" action="<?= home_url('/?vault=edit-link') ?>" method="POST">
        <input type="hidden" name="action" value="edit-link">
        <input type="hidden" name="id" value="<?= $link['id'] ?>">

        <section class="edit_add_assurance_data">
            <section class="left_edit_add">

                <div class="edit_add_logo">
                    <label for="image">Logo</label>
                    <div>
                        <img class="actual_logo"
                            src="<?= $link['image'] ? VAULT_URL . "frontend/assets/images/logo/{$link['image']}" : VAULT_URL . "frontend/assets/images/logo/default.png" ?>" />
                        <input type="hidden" name="image" value="<?= $link['image'] ?>">
                        <img class="upload" src="<?= VAULT_URL . 'frontend/assets/images/upload_black.png' ?>" />
                    </div>
                </div>

                <div class="bloc_edit_add_assurance">
                    <label for="name">Nom Lien</label>
                    <input type="text" id="name" name="name" value="<?= $link['name'] ?>" required>
                </div>

                <div class="bloc_edit_add_assurance">
                    <label for="url">URL</label>
                    <input type="text" id="url" name="url" value="<?= $link['url'] ?>" required>
                </div>

                <div class="bloc_edit_add_assurance">
                    <label for="username">Nom Utilisateur</label>
                    <input type="text" id="username" name="username" value="<?= $link['username'] ?>">
                </div>

            </section>

            <section class="right_edit_add">

                <div class="bloc_edit_add_assurance">
                    <label for="pwd">Mot de passe</label>
                    <input type="password" id="pwd" name="pwd" value="<?= $link['pwd'] ?>">
                </div>

                <div class="bloc_edit_add_assurance">
                    <label for="commentary">Commentaire</label>
                    <textarea rows="10" id="commentary"
                        name="commentary"><?= htmlspecialchars($link['commentary'] ?? '') ?></textarea>
                </div>

            </section>
        </section>

    </form>

</body>

</html>