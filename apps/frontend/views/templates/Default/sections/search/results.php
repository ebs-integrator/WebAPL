<section>
    <?= View::make('sections.elements.breadcrumbs'); ?>
    <div class="wrap">
        <p class='c_title'><?= varlang('rezultatul-cautarii'); ?></p>

        <div class='left'>
            <div class="search_r">
                <p class="search_t"><?= varlang('rezultatele-cautarii-pentru-'); ?><span>"<?= $words; ?>"</span></p>
                <p class="search_p"><?= varlang('afisate-'); ?> <span><?= $results->getFrom() . " - " . $results->getTo(); ?></span><?= varlang('-din-'); ?><?= number_format($results->getTotal()); ?></p>
                <div class="clearfix"></div>

                <ul class="search_li">
                    <?php foreach ($results as $item) { ?>
                        <li>
                            <a href="<?= Language::url('topost/' . $item->id); ?>">
                                <p>
                                    <span><?= $item->title; ?></span>
                                    <?= Str::words(strip_tags(WebAPL\Shortcodes::strip($item->text)), 20); ?>
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
        <div class="resp_menu"></div>
        <div class="right">
            <ul class='detail'>
                <li class='email'>
                    <a href='mailto:<?= varlang('email-address'); ?>'><?= varlang('email-address'); ?></a>
                </li>
                <li class='fax'>
                    <a href='javascript:;'><?= varlang('nr-fax'); ?></a>
                </li>
                <li class='chat'>
                    <a href='javascript:;'><?= varlang('chat-online'); ?></a>
                </li>
                <li class='location'>
                    <a href='<?= Language::url('topage/contactsView'); ?>'><?= varlang('cum-ne-gasiti'); ?></a>
                </li>
            </ul>
        </div>
        <div class='clearfix50'></div>
    </div>
</section>