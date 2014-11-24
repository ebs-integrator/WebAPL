<li class="<?= in_array(User::getZone('socialc'), User::$zones) ? 'active' : ''; ?>">
    <a href="<?= url('socialcomplaints/list'); ?>">
        <i class="fa"></i>
        <span class="link-title"><?= varlang('social-complaints'); ?></span>
    </a>
</li>