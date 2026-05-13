<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="stylesheet" href="<?= VAULT_URL . 'frontend/assets/css/style.css' ?>">
    <link rel="stylesheet" href="<?= VAULT_URL . 'frontend/assets/css/user.css' ?>">
    <link rel="stylesheet" href="<?= VAULT_URL . 'frontend/assets/css/components.css' ?>">

    <link rel="icon" type="image/svg+xml" href="<?= VAULT_URL . 'frontend/assets/images/logo-sily.png' ?>" />
</head>

<body>

    <?php include_once VAULT_PATH . 'frontend/components/navigation-bar.html.php'; ?>

    <?php
    $titre = "Mon compte";

    if ($_SESSION['id_user'] == $_SESSION['id_user']) {
        $titre = "Compte";
    }
    ?>

    <span>
        <?= $titre ?>
    </span>

    <form action="<?= home_url('/?vault=delete') ?>" method="POST">

        <input type="hidden" name="id_user" value="<?= htmlspecialchars($_PUSH['id_user']) ?>">

        <?php
        $user = vault_get_user($_SESSION['id_user']);
        ?>

        <div>
            <label for="name">Nom</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>">
        </div>

        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>">
        </div>


        <div>
            <label for="pwd">Mot de passe</label>
            <input type="hidden" id="pwd" name="pwd" value="<?= htmlspecialchars($user['pwd']) ?>">
        </div>

        <?php
        $txt_add_button = "Modifier le mot de passe";

        if ($_SESSION['id_user'] == $_SESSION['id_user']) {
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

        if ($_SESSION['id_user'] == $_SESSION['id_user']) {
            $txt_red_button = "Supprimer mon compte";
        }

        $type_red_button = "button";
        include VAULT_PATH . 'frontend/components/red-button.html.php';
        ?>

    </form>

</body>

</html>