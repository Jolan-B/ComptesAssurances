<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="icon" type="image/svg+xml" href="../../assets/images/logo-sily.png" />
</head>

<body class="body_login">

    <div>
        <section class="bloc_login">


            <div>
                <img src="../../assets/images/logo-sily.png">
                <span>Mot de passe oublié</span>
            </div>

            <form action="<?#= plugin_dir_url(__FILE__) . '../../backend/controllers/ForgotPasswordCtrl.php' ?>"
                method="post">

                <div>
                    <label for="email">Email</label>
                    <input type="email" name="email_user" id="email" placeholder="Entrez votre email">
                </div>

                <?php
                $type_add_button = "submit";
                $txt_add_button = "Envoyer";
                include '../../components/add-button.html.php';
                ?>

            </form>

        </section>
    </div>
</body>

</html>