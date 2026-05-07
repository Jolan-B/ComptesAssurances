<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connection</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="icon" type="image/svg+xml" href="../../assets/images/logo-sily.png" />
</head>

<body class="body_login">

    <div>
        <section class="bloc_login">


            <div>
                <img src="../../assets/images/logo-sily.png">
                <span>Authentification</span>
            </div>

            <form action="
            <?#=  plugin_dir_url(__FILE__) . '../../backend/controllers/LoginCtrl.php' ?>
            " method="post">

                <div>
                    <label for="username">Nom utilisateur</label>
                    <input type="text" name="name_user" id="username" placeholder="Entrez votre nom d'utilisateur">
                </div>

                <div>
                    <label for="pwd">Mot de passe</label>
                    <input type="password" name="password_user" id="pwd" placeholder="Entrez votre mot de passe">
                    <a href="forgot-password.html.php">Mot de passe oublié ?</a>
                </div>


                <?php
                $type_add_button = "submit";
                $txt_add_button = "Connexion";
                include '../../components/add-button.html.php';
                ?>

            </form>

        </section>
    </div>
</body>

</html>