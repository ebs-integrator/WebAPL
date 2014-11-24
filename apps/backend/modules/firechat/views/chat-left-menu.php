<li class="<?= in_array(User::getZone('chat'), User::$zones) ? 'active' : ''; ?>">
    <a href="<?= url('firechat'); ?>">
        <i class="fa"></i>
        <span class="link-title"><?= varlang('chat-2'); ?></span>
    </a>
</li>