<div>
    <div class="logo">
        <img src="<?= res('assets/img/logo.png'); ?>">
    </div>
    <div class="menu">

        <?php if ($page->background) { ?>
            <img src="<?= url($page->background->path); ?>" class="backg">
        <?php } ?>
        <div class="wrap">
            <?php foreach ($general_pages as $item) { ?>
                <div class="box">
                    <a href="<?= $item->url; ?>" class="<?= $item->id == $page->id ? 'active' : ''; ?>">
                        <span class="menu_img">
                            <?php if ($item->image_icon_big) { ?>
                                <img src="<?= url($item->image_icon_big->path); ?>">
                            <?php } ?>
                        </span>
                        <span class="menu_title"><?= $item->title; ?></span>
                    </a>
                </div>
            <?php } ?>
        </div>
        
    </div>
</div>
<section>
    <div class="wrap">
        <div class="left global">
            <?php foreach ($sub_pages as $item) { ?>
                <article>
                    <p class="ttl"> <a href="<?= $item->url; ?>"><?= $item->title; ?></a></p>
                    <ul>
                        <?php
                        foreach ($item['childrens'] as $k => $chitem) {
                            if ($k < 4) {
                                ?>
                                <li><a href="<?= $chitem->url; ?>"><?= $chitem->title; ?></a></li>
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
            <?php if (isset($home_ads) && $home_ads) { ?>
                <article class="atn">
                    <p class="ttl"><a href="javascript:;"><?= varlang('anunturi'); ?></a></p>
                    <div class="hr"></div>
                    <ul class="bxslider2">
                        <?php foreach ($home_ads as $item) { ?>
                            <li><a href='<?= Language::url('topost/' . $item->id); ?>'>
                                    <div class="data">
                                        <p><?= date('d-m-Y', strtotime($item->created_at)); ?></p>
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
                    <p class="ttl"><img src="<?= res('assets/img/stiri.png'); ?>"><a href="javascript:;">Știri</a></p>
                    <div class="hr"></div>
                    <ul>
                        <?php foreach ($home_posts as $item) { ?>
                            <li>
                                <span><?= date("d-m-Y", strtotime($item->created_at)); ?>
                                    <img src="<?= res('assets/img/d_arrow.png'); ?>">
                                </span>
                                <a href="<?= Language::url('topost/' . $item->id); ?>"><?= $item->title; ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                </article>
            <?php } ?>

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
        </div>
    </div>
    <div class="clearfix"></div>
</section>