<section>
    <?= View::make('sections.elements.breadcrumbs'); ?>
    <div class="wrap">
        <p class="c_title"><?= $top_title; ?></p>
        <div class="left">
            <?php
            $months = array(
                1 => 'Ianuarie',
                2 => 'Februarie',
                3 => 'Martie',
                4 => 'Aprilie',
                5 => 'Mai',
                6 => 'Iunie',
                7 => 'Iulie',
                8 => 'August',
                9 => 'Septembrie',
                10 => 'Octombrie',
                11 => 'Noiembrie',
                12 => 'Decembrie'
            );
            ?>
            <div class="m_criteria">
                <?php if (isset($months[intval($current_month) - 1])) { ?>
                    <a href="<?= $page_url; ?>?year=<?= $current_year; ?>&month=<?= intval($current_month) - 1; ?>" class="left"></a>
                <?php } ?>
                <span><?= $months[intval($current_month)]; ?></span>
                <?php if (isset($months[intval($current_month) + 1])) { ?>
                    <a href="<?= $page_url; ?>?year=<?= $current_year; ?>&month=<?= intval($current_month) + 1; ?>" class="right"></a>
                <?php } ?>
            </div> 

            <?= Core\APL\Actions::call('page_top_container', $page); ?>

            <?= $page->text; ?>

            <?= Core\APL\Actions::call('page_bottom_container', $page); ?>

            <div class="clearfix50"></div>
            <?php if ($page->have_socials) { ?>
                <div class='socials'>
                    <div id="vk_like"></div>
                    <div id="ok_shareWidget"></div>
                    <div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" data-width="125" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
                    <div class="clearfix"></div>
                </div>
            <?php } ?>
            <div class="hr_grey"></div>
        </div>
        <?php if (isset($years_list) && count($years_list)) { ?>
            <div class="right m_a">                
                <p class='n_title'>arhivă</p>
                <ul class="right_menu">
                    <?php foreach ($years_list as $year) { ?>
                        <li class='<?= isset($current_year) && $current_year == $year->year ? 'active' : ''; ?>'><a href="<?= url($page_url . "?year=" . $year->year . "&month=1"); ?>"><?= $year->year; ?></a></li>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>
    </div>
    <div class="clearfix"> </div>
</section>
