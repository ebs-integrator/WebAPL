<?php if (isset($post) && $post) { ?>
    <div class="a_box v_g">
        <p class="title"><a href="javascript:;"><?= $post->title; ?></a></p>
        <p class="data"><?= date("d-m-Y, H:i", strtotime($post->created_at)); ?></p>
        <div class="hr_dbl"></div>
        <div class="left">
            <div class="info unic">
                <div class="img">
                    <?php if ($post->cover) { ?>
                        <img src="<?= url($post->cover['path']); ?>" width="347">
                    <?php } ?>
                </div>
                
                <?= Core\APL\Shortcodes::execute($post->text); ?>
                
                <?php if ($post->have_socials) { ?>
                    <?= View::make('sections.elements.socials'); ?>
                <?php } ?>
            </div>
        </div>
        <div class="clearfix"></div>            
    </div>
<?php } ?>

<?php if (isset($posts) && count($posts)) { ?>
    <ul class="a_n">
        <?php foreach ($posts as $item) { ?>
            <li>
                <a href="<?= $page_url; ?>?item=<?= $item->uri; ?>">
                    <span><?= date('d-m-Y', strtotime($item->created_at)); ?> </span>
                    <p><?= $item->title; ?></p>
                </a>
            </li>
        <?php } ?>
    </ul>
    <?php
    if (method_exists($posts, 'links')) {
        echo $posts->appends(array('year' => $current_year, 'month' => $current_month))->links();
    }
    ?>
<?php } ?>

<?php if (isset($post) && $post->have_comments) { ?>
    <div class="c40"></div>
    <?= View::make('sections.elements.comments'); ?>
<?php } ?>

<?php if (!isset($post) && !isset($posts)) { ?>
    <?= varlang('articole-null'); ?>
<?php } ?>