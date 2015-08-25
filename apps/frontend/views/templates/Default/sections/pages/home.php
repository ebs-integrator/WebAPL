<div>
    <div class="logo">
        <?php if (Files::extract('website_logo_' . WebAPL\Language::ext(), 1, 'path')) { ?>
            <img src="<?= url(Files::extract('website_logo_' . WebAPL\Language::ext(), 1, 'path')); ?>" title="<?= Files::extract('website_logo_' . WebAPL\Language::ext(), 1, 'name'); ?>" alt="<?= Files::extract('website_logo_' . WebAPL\Language::ext(), 1, 'name'); ?>">
        <?php } ?>
    </div>
    <div class="menu">

        <?php if ($page->background) { ?>
            <img alt="<?= $page->background->name; ?>" title="<?= $page->background->name; ?>" src="<?= url($page->background->path); ?>" class="backg">
        <?php } ?>
        <div class="wrap">
            <?php foreach ($general_pages as $item) { ?>
                <div class="box">
                    <a href="<?= $item->url; ?>" class="<?= $item->id == $page->id ? 'active' : ''; ?>">
                        <span class="menu_img">
                            <?php if ($item->image_icon_big) { ?>
                                <img alt="<?= $item->title; ?>" title="<?= $item->title; ?>" src="<?= url($item->image_icon_big->path); ?>">
                            <?php } ?>
                        </span>
                        <span class="menu_title"><?= $item->title; ?></span>
                    </a>
                </div>
            <?php } ?>
        </div>

    </div>
</div>
<section id="hm_scroll">
    <div class="wrap">
        <div class="left global">
            <?php foreach ($sub_pages as $item) { ?>
                <article>
                    <h2 class="ttl"> <a href="<?= $item->url; ?>"><?= $item->title; ?></a></h2>
                    <ul>
                        <?php
                        foreach ($item['childrens'] as $k => $chitem) {
                            if ($k < 4) {
                                ?>
                                <li><h3><a href="<?= $chitem->url; ?>"><?= $chitem->title; ?></a></h3></li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                    <a href="<?= $item->url; ?>" class="more"></a>
                </article>
            <?php } ?>
        </div>
        <div class="right global">  

            <?php Event::fire('home_right_top', $page); ?>

            <?php if (isset($home_page) && $home_page) { ?>
                <article style='height: auto;/** trebuie mutat in main.css **/'>
                    <p class="ttl"><a href="<?= Language::url('topost/' . $home_page->id); ?>"><?= $home_page->title; ?></a></p>
                    <div class="hr"></div>
                    <ul>
                        <?php foreach ($home_page->childrens as $item) { ?>
                            <li><a href="<?= $item->url; ?>"><?= $item->title; ?></a></li>
                        <?php } ?>
                    </ul>
                    <a href="<?= Language::url('topost/' . $home_page->id); ?>" class="more"></a>
                </article>
            <?php } ?>

            <?php if (isset($home_ads) && count($home_ads)) { ?>
                <article class="atn">
                    <p class="ttl"><a href="<?= Language::url('topage/adsList'); ?>"><?= varlang('anunturi'); ?></a></p>
                    <div class="hr"></div>
                    <ul class="bxslider2">
                        <?php foreach ($home_ads as $item) { ?>
                            <li><a href='<?= Language::url('topost/' . $item->id); ?>'>
                                    <div class="data">
                                        <?php if (strtotime($item->created_at)) { ?>
                                            <p><?= date('d-m-Y', strtotime($item->created_at)); ?></p>
                                        <?php } ?>
                                        <span><?= $item->title; ?></span>
                                    </div>
                                    <div class="clearfix"></div>
                                    <p class="info"><?= Str::words(strip_tags($item->text), 20); ?></p>
                                </a></li>
                        <?php } ?>
                    </ul>
                </article>
            <?php } ?>

            <?php if (isset($home_posts) && count($home_posts)) { ?>
                <article class="news">
                    <p class="ttl"><img src="<?= res('assets/img/stiri.png'); ?>" alt="" ><a href="<?= Language::url('topage/newsList'); ?>"><?= varlang('stiri'); ?></a></p>
                    <div class="hr"></div>
                    <ul>
                        <?php foreach ($home_posts as $item) { ?>
                            <li>
                                <?php if (strtotime($item->created_at)) { ?>
                                    <span><?= date("d-m-Y", strtotime($item->created_at)); ?></span>
                                <?php } ?>
                                <a href="<?= Language::url('topost/' . $item->id); ?>"><?= $item->title; ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                </article>
            <?php } ?>

            <?php Event::fire('home_right_bottom', $page); ?>
            <?php Event::fire('home_right_partners', $page); ?>
        </div>
    </div>
    <div class="clearfix"></div>
</section>