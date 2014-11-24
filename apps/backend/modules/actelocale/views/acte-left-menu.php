<li class="<?= in_array(User::getZone('actelocale'), User::$zones) ? 'active' : ''; ?>">
    <a href="<?= url('actelocale/list'); ?>">
        <i class="fa"></i>
        <span class="link-title"><?= varlang('acte-locale'); ?></span>
    </a>
</li>