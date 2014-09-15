<section>
    <?= View::make('sections.elements.breadcrumbs'); ?>
    <div class="wrap">
        <p class='c_title'>Rezultatul căutării</p>

        <div class='left'>
            <div class="search_r">
                <p class="search_t">Rezultatele căutării pentru <span>"<?= $words; ?>"</span></p>
                <p class="search_p">Afisate <span><?= $results->getFrom() . " - " . $results->getTo(); ?></span> din <?= number_format($results->getTotal()); ?></p>
                <div class="clearfix"></div>

                <ul class="search_li">
                    <?php foreach ($results as $item) { ?>
                        <li>
                            <a href="<?= Language::url('topost/' . $item->id); ?>">
                                <!--<div class="search_img"><img src="<?= res('assets/img/edu2.png'); ?>"></div>-->
                                <p>
                                    <span><?= $item->title; ?></span>
                                    <?= Str::words(strip_tags(Core\APL\Shortcodes::strip($item->text)), 20); ?>
                                </p>
                                <div class="more"></div>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="clearfix50"></div>
            <?= $results->appends(array('words' => $words))->links(); ?>
        </div>
        <div class="right">

            <ul class='detail'>
                <li class='email'>
                    <a href='javascript:;'>info@straseni.gov.md</a>
                </li>
                <li class='fax'>
                    <a href='javascript:;'>(0-237) 55-66-77</a>
                </li>
                <li class='chat'>
                    <a href='javascript:;'>chat-online</a>
                </li>
                <li class='location'>
                    <a href='javascript:;'>Cum ne găsiți</a>
                </li>
            </ul>
        </div>
        <div class='clearfix50'></div>
    </div>
</section>