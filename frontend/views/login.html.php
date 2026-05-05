<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Comptes</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="icon" type="image/svg+xml" href="../assets/images/logo-sily.png" />
</head>

<body>
    <section class="bloc-login">

        <div>
            <span>Authentification</span>
        </div>

        <form action="../controllers/LoginCtrl.php" method="post">

            <div>
                <label for="username">Nom utilisateur</label>
                <input type="text" name="name_user" id="username">
            </div>

            <div>
                <label for="pwd">Mot de passe</label>
                <input type="password" name="password_user" id="pwd">
            </div>

            <button class="submit_button" type="submit">
                <?php
                $txt_add_button = "Connexion";
                @include '../components/add-button.php';
                ?>
            </button>

        </form>

    </section>
</body>