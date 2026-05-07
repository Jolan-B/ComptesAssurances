<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="icon" type="image/svg+xml" href="../../assets/images/logo-sily.png" />
</head>

<body class="body_login">

    <div>

        <section class="bloc_login">

            <div>
                <img src="../../assets/images/logo-sily.png">
                <span>Mot de Passe</span>
            </div>

            <form action="<?#=  plugin_dir_url(__FILE__) . '../../backend/controllers/ResetPasswordCtrl.php' ?>"
                method="post">

                <div>
                    <label for="pwd">Nouveau mot de passe</label>
                    <input type="password" name="password_user" id="pwd"
                        placeholder="Entrez votre nouveau mot de passe">
                </div>

                <div>
                    <label for="pwd_confirm"></label>
                    <input type="password" name="password_confirm_user" id="pwd_confirm"
                        placeholder="Confirmez votre mot de passe">
                </div>

                <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token'] ?? '') ?>">

                <?php
                $type_add_button = "submit";
                $txt_add_button = "Enregister";
                include '../../components/add-button.html.php';
                ?>

            </form>

        </section>
    </div>
</body>

</html>