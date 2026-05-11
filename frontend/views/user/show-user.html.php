<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voir Compte</title>
    <link rel="stylesheet" href="<?= VAULT_URL . 'frontend/assets/css/style.css' ?>">
    <link rel="icon" type="image/svg+xml" href="<?= VAULT_URL . 'frontend/assets/images/logo-sily.png' ?>" />
</head>

<body>

    <?php include_once VAULT_PATH . 'frontend/components/navigation-bar.html.php'; ?>

    <?php
    $titre = "Mon compte";

    if ($_PUSH['id_user'] == vault_get_current_user()['id']) {
        $titre = "Compte";
    }
    ?>

    <span>
        <?= $titre ?>
    </span>

    <form action="<?= home_url('/?vault=delete') ?>" method="POST">

        <input type="hidden" name="id_user" value="<?= htmlspecialchars($_PUSH['id_user']) ?>">

        <?php
        $user = vault_get_user($_PUSH['id_user']);
        ?>

        <div>
            <span>Nom : </span>
            <span>
                <?= htmlspecialchars($user['name']) ?>
            </span>
        </div>

        <div>
            <span>Email : </span>
            <span>
                <?= htmlspecialchars($user['email']) ?>
            </span>
        </div>


        <div>
            <span>Mot de passe : </span>
            <span>
                <?= htmlspecialchars($user['password']) ?>
            </span>
        </div>

        <?php
        $txt_add_button = "Modifier le mot de passe";

        if ($_PUSH['id_user'] == vault_get_current_user()['id']) {
            $txt_add_button = "Modifier mon mot de passe";
        }

        $type_add_button = "button";
        include VAULT_PATH . 'frontend/components/add-button.html.php';
        ?>

        <?php
        $txt_add_button = "Enregister";
        $type_add_button = "submit";
        include VAULT_PATH . 'frontend/components/add-button.html.php';
        ?>

        <?php
        $txt_red_button = "Supprimer le compte";

        if ($_PUSH['id_user'] == vault_get_current_user()['id']) {
            $txt_red_button = "Supprimer mon compte";
        }

        $type_red_button = "button";
        include VAULT_PATH . 'frontend/components/red-button.html.php';
        ?>

    </form>

</body>

</html>