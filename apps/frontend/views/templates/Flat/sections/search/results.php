<section>
    <div class="wrap">
        <div class="left_block">
            <div class="left_details">
                <a href="mailto:<?= varlang('email-address'); ?>" class="l_email"><?= varlang('email-address'); ?></a>
                <a href="javascript:;" class="l_fax"><?= varlang('nr-fax'); ?></a>
                <a href="<?= Language::url('topage/contactsView'); ?>" class="l_map"><?= varlang('cum-ne-gasiti'); ?></a>
                <?php Event::fire('contact_right_list'); ?>
            </div>
        </div>
        <div class="resp_menu"></div>
        <div class="right_block">
            <?= View::make('sections.elements.breadcrumbs'); ?>
            <p class="m_search"><?= varlang('rezultatul-cautarii'); ?></p>
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
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <?= $results->appends(array('words' => $words))->links(); ?>
        </div>
    </div>
</section>