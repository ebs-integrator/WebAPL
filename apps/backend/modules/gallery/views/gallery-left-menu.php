<li class="<?= in_array(User::getZone('gallery'), User::$zones) ? 'active' : ''; ?>">
    <a href="<?= url('gallery/list'); ?>">
        <i class="fa"></i>
        <span class="link-title"><?= varlang('gallery'); ?></span>
    </a>
</li>