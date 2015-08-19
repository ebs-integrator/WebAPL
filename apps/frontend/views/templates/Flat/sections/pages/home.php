<section class="global">
    <div class="wrap global">
        <?php foreach ($sub_pages as $item) { ?>
            <article>
                <h2 class="categ_title"><a href="<?= $item->url; ?>"><?= $item->title; ?></a> </h2>

                <div class="sub_list">
                    <ul >
                        <?php
                        foreach ($item['childrens'] as $k => $chitem) {
                            if ($k < 4) {
                                ?>
                                <li><a href="<?= $chitem->url; ?>"><?= character_limiter($chitem->title, 35); ?></a> </li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
                <a href="<?= $item->url; ?>" class="more"></a>

            </article>
        <?php } ?>
        <?php Event::fire('home_right_partners', $page); ?>
        <div class="clearfix100"></div>

    </div>
</section>

<div class="prefooter">
    <?php Event::fire('home_right_top', $page); ?>

    <?php if (isset($home_posts[0]) && $home_posts[0]) { ?>
        <div class="row1_l">
            <div class="content">
                <div class="fcc">
                    <p class="f_title"><?= varlang('stiri'); ?></p>
                    <?php foreach ([$home_posts[0]] as $item) { ?>
                        <?php if (strtotime($item->created_at)) { ?>
                            <div class="data"><?= date('d-m-Y', strtotime($item->created_at)); ?></div>
                        <?php } ?>
                        <a href="<?= Language::url('topost/' . $item->id); ?>" class="f_artc"><?= $item->title; ?></a>
                        <p><?= Str::words(strip_tags($item->text), 30); ?></p>
                    <?php } ?>
                </div>
                <a href="<?= Language::url('topage/newsList'); ?>" class="more"></a>
            </div>
        </div>
    <?php } ?>
    <?php if (isset($home_ads[0]) && $home_ads[0]) { ?>
        <div class="row1_r">
            <div class="content">
                <div class="fcc">
                    <p class="f_title"><?= varlang('anunturi'); ?></p>
                    <?php foreach ([$home_ads[0]] as $item) { ?>
                        <?php if (strtotime($item->created_at)) { ?>
                            <div class="data"><?= date('d-m-Y', strtotime($item->created_at)); ?></div>
                        <?php } ?>
                        <a href="<?= Language::url('topost/' . $item->id); ?>" class="f_artc"><?= $item->title; ?></a>
                        <p><?= Str::words(strip_tags($item->text), 30); ?></p>
                    <?php } ?>
                </div>
                <a href="<?= Language::url('topage/adsList'); ?>" class="more"></a>
            </div>
        </div>
    <?php } ?>

    <?php Event::fire('home_right_bottom', $page); ?>
</div>