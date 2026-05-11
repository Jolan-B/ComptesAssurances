<div class="bloc_assurance_link">

    <div onclick="otherPage('<?= $assurance['url'] ?>')" class="logo_name_assurance_link">
        <img class="logo_assurance_link pointer"
            src="<?= VAULT_URL . 'frontend/assets/images/logo/' . $assurance['image'] ?>" />

        <span class="pointer"><?= $assurance['name'] ?></span>
    </div>

    <div onclick="vault_change_favorite_assurance('<?= $assurance['id'] ?>')" class="is_favorite">
        <img class="pointer"
            src="<?= $assurance['is_favorite'] ? VAULT_URL . 'frontend/assets/images/star_fill.png' : VAULT_URL . 'frontend/assets/images/star_empty.png' ?>" />
    </div>

    <div class="buttons_edit_delete">

        <img class="pointer" src="<?= VAULT_URL . 'frontend/assets/images/edit_black.png' ?>" />

        <img class="pointer" src="<?= VAULT_URL . 'frontend/assets/images/delete_red.png' ?>" />
    </div>
</div>