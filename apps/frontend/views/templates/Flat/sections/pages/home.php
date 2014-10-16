<section class="global">
    <div class="wrap global">
        <?php foreach ($sub_pages as $item) { ?>
            <article>
                <div class="acticle_img">
                    <?php if ($item->image_icon_big) { ?>
                        <img src="<?= url($item->image_icon_big->path); ?>">
                    <?php } ?>
                </div> 
                <p class="categ_title"><a href="<?= $item->url; ?>"><?= $item->title; ?></a> </p>

                <div class="sub_list">
                    <ul >
                        <?php
                        foreach ($item['childrens'] as $k => $chitem) {
                            if ($k < 4) {
                                ?>
                                <li><a href="<?= $chitem->url; ?>"><?= $chitem->title; ?></a> </li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
                <a href="<?= $item->url; ?>" class="more"></a>
            </article>
        <?php } ?>
        <div class="clearfix100"></div>
    </div>
</section>

<div class="prefooter">
    <?php Event::fire('home_right_top', $page); ?>

    <?php if (isset($home_posts) && count($home_posts)) { ?>
        <div class="row1_l">
            <div class="content">
                <div class="fcc">
                    <p class="f_title"><?= varlang('stiri'); ?></p>
                    <?php foreach ($home_posts as $item) { ?>
                        <div class="data"><?= date('d-m-Y', strtotime($item->created_at)); ?></div>
                        <a href="<?= Language::url('topost/' . $item->id); ?>" class="f_artc"><?= $item->title; ?></a>
                        <p><?= Str::words(strip_tags($item->text), 30); ?></p>
                    <?php } ?>
                </div>
                <a href="<?= Language::url('topage/newsList'); ?>" class="more"></a>
            </div>
        </div>
    <?php } ?>
    <?php if (isset($home_ads) && $home_ads) { ?>
        <div class="row1_r">
            <div class="content">
                <div class="fcc">
                    <p class="f_title"><?= varlang('anunturi'); ?></p>
                    <?php foreach ($home_ads as $item) { ?>
                        <div class="data"><?= date('d-m-Y', strtotime($item->created_at)); ?></div>
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