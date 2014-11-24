<li class="<?= in_array(User::getZone('calendar'), User::$zones) ? 'active' : ''; ?>">
    <a href="<?= url('calendar/list'); ?>">
        <i class="fa"></i>
        <span class="link-title"><?= varlang('calendar-1'); ?></span>
    </a>
</li>