<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié</title>
    <link rel="stylesheet" href="<?= VAULT_URL . 'frontend/assets/css/login.css' ?>">
    <link rel="icon" type="image/svg+xml" href="<?= VAULT_URL . 'frontend/assets/images/logo-sily.png' ?>" />
</head>

<body class="body_login">

    <div>
        <section class="bloc_login">


            <div>
                <img src="<?= VAULT_URL . 'frontend/assets/images/logo-sily.png' ?>">
                <span>Mot de passe oublié</span>
            </div>

            <form action="<?= home_url('/?vault=forgot-password-send') ?>" method="post">

                <div>
                    <label for="email">Email</label>
                    <input type="email" name="email_user" id="email" placeholder="Entrez votre email">
                </div>

                <?php
                $type_add_button = "submit";
                $txt_add_button = "Envoyer";
                include VAULT_PATH . 'frontend/components/add-button.html.php';
                ?>

            </form>

        </section>
    </div>
</body>

</html>