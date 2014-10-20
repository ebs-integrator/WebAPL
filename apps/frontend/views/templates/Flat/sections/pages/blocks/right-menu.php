<p class="title"><?= $parent ? $parent->title : $page_title; ?></p>
<?php if ($colevels) { ?>
    <ul class="menu">
        <?php
        foreach ($colevels as $item) {
            ?>
            <li class="<?= $active_page_id == $item['id'] ? 'active' : '' ?> <?= in_array('hide_on_mobile', $item['properties']) ? 'hide_on_mobile' : ''; ?> <?= in_array('start-chat', $item['properties']) ? 'firechat-start' : ''; ?>"><a href='<?= $item['url']; ?>'><?= $item['title']; ?></a></li>
            <?php
        }
        ?>
    </ul>
<?php } ?>

<!--nav>
    <a href="javascript:;">
        <p>Întrebări frecvente</p>
        <span>Daca aveti intrebari referirtor la utilizarea sute-ului va rugat sa accesatzi meniul dat</span>
        <div class="more"></div>
    </a>
</nav>
<nav>
    <a href="javascript:;">
        <p>Modele de cereri</p>
        <span>Promit să construiesc case pentru sute de familii. </span>
        <div class="more"></div>
    </a>
</nav>
<nav>
    <a href="javascript:;">
        <p>Ghid de completare</p>
        <span>Promit să fac din acest oras alegerea preferată pentru investiții și crearea de locuri de muncă. </span>
        <div class="more"></div>
    </a>
</nav-->