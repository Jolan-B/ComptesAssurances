<?php if (!empty($path_add_button)): ?>
    <a href="<?= home_url('/?vault=' . $path_add_button) ?>" class="add_button pointer">
        <span><?= $txt_add_button ?></span>
    </a>
<?php else: ?>
    <button type="<?= $type_add_button ?>" class="add_button pointer" <?= isset($form) ? 'form="' . $form . '"' : '' ?>>
        <span><?= $txt_add_button ?></span>
    </button>
<?php endif; ?>