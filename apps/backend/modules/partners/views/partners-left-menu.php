<li class="<?= in_array(User::getZone('partners'), User::$zones) ? 'active' : ''; ?>">
    <a href="<?= url('partners'); ?>">
        <i class="fa"></i>
        <span class="link-title"><?= varlang('parteneri'); ?></span>
    </a>
</li>