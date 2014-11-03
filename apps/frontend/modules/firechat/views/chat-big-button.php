<div class="chat"> 
    <a href="javascript:;" class="<?= $online ? 'firechat-start' : 'firechat-inactive'; ?>">
        <div class="mn"></div>
        <span class="chat_dot <?= $online ? 'active' : ''; ?>"></span>
        <span class="green"><?= varlang('discuta'); ?>-</span><span class="violet"><?= varlang('online'); ?></span>
        <hr>
        <p class="center"><?= varlang('vorbeste-direct'); ?></p>
    </a>
</div>