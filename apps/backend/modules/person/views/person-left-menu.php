<li class="<?= in_array(User::getZone('person'), User::$zones) ? 'active' : ''; ?>">
    <a href="<?= url('person/list'); ?>">
        <i class="fa"></i>
        <span class="link-title"><?= varlang('persons'); ?></span>
    </a>
</li>