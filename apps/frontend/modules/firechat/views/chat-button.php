<button class="home_chat <?= $online ? 'firechat-start active' : 'firechat-inactive'; ?>">
    <span class="pot"></span>
    <span class="pct">
        <p><?= varlang('discuta'); ?> <span><?= varlang('online'); ?></span></p>
        <span><?= $online ? varlang('online') : varlang('offline'); ?></span>
    </span>
</button>