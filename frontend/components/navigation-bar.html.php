<header class="navigation_bar">

    <section class="menu_buttons">

        <a class="menu_button pointer" href="<?= home_url('/?vault=dashboard') ?>">
            <span>Assurance</span>
        </a>

        <a class="menu_button pointer" href="<?= home_url('/?vault=category-management') ?>">
            <span>Service</span>
        </a>

        <a class="menu_button pointer" href="<?= home_url('/?vault=type-category-management') ?>">
            <span>Type de service</span>
        </a>


    </section>

    <section class="profil_section">

        <div class="profil_photo pointer">
            <img src="<?= VAULT_URL . 'frontend/assets/images/account_circle_black.png' ?>" />
        </div>

        <a class="profil_option pointer" href="<?= home_url("/?vault=") ?>">
            <div>
                <span>Mon Compte</span>
            </div>
        </a>

        <!-- LE BOUTON DOIT APPARAITRE POUR L'ADMIN UNIQUEMENT -->

        <a class="profil_option pointer" href="<?= home_url("/?vault=") ?>">
            <div>
                <span>Gérer les utilisateurs</span>
            </div>
        </a>

        <a class="profil_option pointer" href="<?= home_url('/?vault=logout') ?>">
            <div>
                <span>Déconnexion</span>
            </div>
        </a>


    </section>

</header>