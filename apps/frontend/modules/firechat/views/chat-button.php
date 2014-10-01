<button class="home_chat <?= $online ? 'firechat-start active' : ''; ?>">
    <div class="pot"></div>
    <div class="pct">
        <p><?= varlang('discuta'); ?> <span><?= varlang('online'); ?></span></p>
        <span><?= $online ? varlang('online') : varlang('offline'); ?></span>
    </div>
</button>