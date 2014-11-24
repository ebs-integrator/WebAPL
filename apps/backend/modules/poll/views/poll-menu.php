<li class="<?= in_array(User::getZone('poll'), User::$zones) ? 'active' : ''; ?>">
    <a href="<?= url('poll/list'); ?>">
        <i class="fa"></i>
        <span class="link-title"><?= varlang('polls'); ?></span>
    </a>
</li>