<h2><?= $post->title; ?></h2>
<div> 
    <?php if ($post->show_pcomment) { ?>
        <div class='live_comment' data-pid="news<?= $post->id; ?>">
            <?= WebAPL\Shortcodes::execute($post->text, [$post, ['post' => $post]]); ?>
        </div>
    <?php } else { ?>
        <div><?= WebAPL\Shortcodes::execute($post->text, ['post' => $post]); ?></div>
    <?php } ?>
</div>
<?php if (count($posts)) { ?>
    <div class="m_video">
        <p><?= varlang('toate-sedinte'); ?></p>
        <?php
        foreach ($posts as $k => $item) {
            preg_match('#(\.be/|/embed/|/v/|/watch\?v=)([A-Za-z0-9_-]{5,11})#', $item->text, $matches);
            if (isset($matches[2]) && $matches[2]) {
                $YoutubeCode = $matches[2];
            } else {
                $YoutubeCode = false;
            }
            ?>
            <div>
                <a href="<?= $page_url; ?>?item=<?= $item->uri; ?>">
                    <?php if ($YoutubeCode) { ?>
                        <img  alt="" style="max-width: 348px;" src="http://img.youtube.com/vi/<?= $YoutubeCode; ?>/hqdefault.jpg">
                        <?php
                    } else {
                        $cover = Post::coverImage($item->id);
                        if ($cover) {
                            ?>
                            <img  alt="" style="max-width: 348px; height: 261px;" src="<?= url($cover['path']); ?>">
                        <?php } else { ?>
                            <img  alt="" src="<?= res('assets/img/video_s.png'); ?>">
                            <?php
                        }
                    }
                    ?>
                    <?php if (strtotime($item->created_at)) { ?>
                        <p class="video_d"><span><?= date("d-m-Y, H:i", strtotime($item->created_at)); ?></span></p>
                    <?php } ?>
                    <p class="video_i"><?= $item->title; ?></p>
                </a>
            </div>
            <?php if (($k) % 2) { ?>
                <span class="clearfix"></span>
            <?php } ?>
            <?php
        }
        ?>
    </div>
    <div class="clearfix"></div>
    <?php
    if (method_exists($posts, 'links')) {
        echo $posts->links();
    }
}
?>