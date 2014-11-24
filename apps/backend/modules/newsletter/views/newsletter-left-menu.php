<li class="<?= in_array(User::getZone('newsletter'), User::$zones) ? 'active' : ''; ?>">
    <a href="<?= url('newsletter/list'); ?>">
        <i class="fa"></i>
        <span class="link-title"><?= varlang('newsletter-2'); ?></span>
    </a>
</li>