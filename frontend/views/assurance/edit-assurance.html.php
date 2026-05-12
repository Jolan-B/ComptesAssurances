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

    <?php
    $assurance = vault_get_assurance($id);

    $txt_add_button = "Enregistrer";
    $path = 'dashboard';
    $title = "Modifier " . $assurance["name"];
    $form = "form-edit-assurance";
    include_once VAULT_PATH . 'frontend/components/add-edit-bar.html.php';
    ?>

    <form class="form_edit_assurance" id="<?= $form ?>" action="<?= home_url('/?vault=edit-assurance') ?>"
        method="POST">
        <input type="hidden" name="action" value="edit-assurance">

        <section class="edit_assurance_data">
            <section class="left_edit">

                <div class="edit_logo">
                    <label for="image">Logo</label>
                    <div>
                        <input type="image" id="image" name="image"
                            src="<?= $assurance['image'] ? VAULT_URL . "frontend/assets/images/logo/{$assurance['image']}" : VAULT_URL . "frontend/assets/images/logo/default.png" ?>">
                        <img src="<?= VAULT_URL . 'frontend/assets/images/upload_black.png' ?>" />
                    </div>
                </div>

                <div class="bloc_edit_assurance">
                    <label for="name">Nom Assurance</label>
                    <input type="text" id="name" name="name" value="<?= $assurance['name'] ?>">
                </div>

                <div class="bloc_edit_assurance">
                    <label for="url">URL</label>
                    <input type="text" id="url" name="url" value="<?= $assurance['url'] ?>">
                </div>

                <div class="bloc_edit_assurance">
                    <label for="username">Nom Utilisateur</label>
                    <input type="text" id="username" name="username" value="<?= $assurance['username'] ?>">
                </div>

            </section>

            <section class="right_edit">

                <div class="bloc_edit_assurance">
                    <label for="pwd">Mot de passe</label>
                    <input type="password" id="pwd" name="pwd" value="<?= $assurance['pwd'] ?>">
                </div>

                <div class="bloc_edit_assurance">
                    <label for="cc">Code Courtage</label>
                    <input type="text" id="cc" name="cc" value="<?= $assurance['cc'] ?>">
                </div>

                <div class="bloc_edit_assurance">
                    <label for="commentary">Commentaire</label>
                    <input type="text" id="commentary" name="commentary" value="<?= $assurance['commentary'] ?>">
                </div>

            </section>
        </section>

        <?php
        $categories = vault_get_all_categories();
        $types_category = vault_get_all_types_category();

        // var_dump($categories);
        // var_dump($types_category);
        var_dump($assurance['categories']);
        echo $assurance['categories']['category_id'];
        ?>

        <section class="edit_assurance_category_data">
            <?php
            foreach ($types_category as $type) {

                if ($types_category[0] != $type) {
                    echo '<br />';
                }

                // foreach ($assurance['categories'] as $propose) {
                //     if ($propose['categories'] == $type) {
                //         echo "proposé";
                // }
            
                echo "<span class=\"edit_type_category\">{$type['name']}<span>";
                echo '<br /><br />';

                foreach ($categories as $category) {

                    if ($category['id_tc'] == $type['id']) {
                        echo "<input type='checkbox' id='assurance_categories' name='categories' value={$category['id']}>";
                        echo "<span class=\"edit_category\"> {$category['name_c']}<span>";
                        echo '<br />';
                    }
                }
            }

            ?>
        </section>


    </form>

</body>

</html>