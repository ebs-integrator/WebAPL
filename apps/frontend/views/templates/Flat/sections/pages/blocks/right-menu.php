
<?php if ($colevels) { ?>
    <ul class='right_menu'>
        <?php
        foreach ($colevels as $item) {
            if ($active_page_id != $item['id']) {
                ?>
                <li class="<?= in_array('hide_on_mobile', $item['properties']) ? 'hide_on_mobile' : ''; ?>"><a href='<?= $item['url']; ?>'><?= $item['title']; ?></a></li>
                <?php
            }
        }
        ?>
    </ul>
<?php } ?>


            <p class="title">Taxe și impozite </p>
            <ul class="menu">
                <li class="active"><a href="javascript:;">Impozite și taxe locale</a></li>
                <li><a href="javascript:;">Taxa pe amenajarea teritoriului</a></li>
                <li><a href="javascript:;">Taxa de publicitate</a></li>
                <li><a href="javascript:;">Taxa de organizare a licitațiilor / loteriilor</a></li>
                <li><a href="javascript:;">Taxa pentru unități comerciale</a></li>
                <li><a href="javascript:;">Taxa de piața</a></li>
                <li><a href="javascript:;">Taxa de cazare</a></li>
                <li><a href="javascript:;">Taxa de parcare</a></li>
                <li><a href="javascript:;">Taxa pentru unități stradale</a></li>
                <li><a href="javascript:;">Taxa pentru evacuarea deșeurilor</a></li>
                <li><a href="javascript:;">Impozitul pe bunuri imobiliare</a></li>
                <li><a href="javascript:;">Întrebări frecvente / Modele de documente / Ghid de taxe și impozitele </a></li>
            </ul>

            <nav>
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
            </nav>