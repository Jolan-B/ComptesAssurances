<section class="bloc_assurance_link">

    <div onclick="otherPage('<?= $assurance['url'] ?>')" class="logo_name_assurance_link">
        <img class="logo_assurance_link pointer"
            src="<?= VAULT_URL . 'frontend/assets/images/logo/' . $assurance['image'] ?>" />

        <span class="pointer"><?= $assurance['name'] ?></span>
    </div>

    <form class="is_favorite" method="POST" action="<?= home_url('/?vault=change-favorite') ?>">
        <input type="hidden" name="id_assurance" value="<?= $assurance['id'] ?>">
        <button type="submit" class="pointer">
            <img
                src="<?= $assurance['is_favorite'] ? VAULT_URL . 'frontend/assets/images/star_fill.png' : VAULT_URL . 'frontend/assets/images/star_empty.png' ?>" />
        </button>
    </form>

    <div class="buttons_edit_delete">
        <a href="<?= home_url("/?vault=edit-assurance&id={$assurance['id']}") ?>">
            <img class="pointer" src="<?= VAULT_URL . 'frontend/assets/images/edit_black.png' ?>" />
        </a>

        <a href="<?= home_url("/?vault=delete-assurance?id={$assurance['id']}") ?>">
            <img class="pointer" src="<?= VAULT_URL . 'frontend/assets/images/delete_red.png' ?>" />
        </a>
    </div>

</section>