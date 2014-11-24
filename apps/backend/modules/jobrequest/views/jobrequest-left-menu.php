<li class="<?= in_array(User::getZone('jobrequest'), User::$zones) ? 'active' : ''; ?>">
    <a href="<?= url('jobrequest/list'); ?>">
        <i class="fa"></i>
        <span class="link-title"><?= varlang('recrut'); ?></span>
    </a>
</li>