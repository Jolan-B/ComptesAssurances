<section class="bloc_assurance_link">

    <div onclick="otherPage('<?= $link['url_link'] ?>')" class="logo_name_assurance_link">
        <img class="logo_assurance_link pointer"
            src="<?= VAULT_URL . 'frontend/assets/images/logo/' . $link['image_link'] ?>" />

        <span class="pointer"><?= $link['name_link'] ?></span>
    </div>

    <div class="buttons_edit_delete">
        <a href="<?= home_url("/?vault=edit-link&id={$link['id_link']}") ?>">
            <img class="pointer" src="<?= VAULT_URL . 'frontend/assets/images/edit_black.png' ?>" />
        </a>

        <form method="POST" action="<?= home_url('/?vault=delete-link') ?>">
            <input type="hidden" name="action" value="delete-link">
            <input type="hidden" name="id_link" value="<?= $link['id_link'] ?>">
            <input class="image_delete" type="image" src="<?= VAULT_URL . 'frontend/assets/images/delete_red.png' ?>" />
        </form>
    </div>

</section>