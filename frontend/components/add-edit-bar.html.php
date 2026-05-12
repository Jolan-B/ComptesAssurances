<header class="add_edit_bar">

    <section class="menu_buttons_add_edit">

        <a class="menu_back_button pointer" href="<?= home_url("/?vault={$path}") ?>">
            <img src="<?= VAULT_URL . 'frontend/assets/images/arrow_back_black.png' ?>" />
        </a>

        <span><?= $title ?></span>

    </section>

    <?php
    $type_add_button = "submit";
    include_once VAULT_PATH . 'frontend/components/add-button.html.php';
    ?>

</header>