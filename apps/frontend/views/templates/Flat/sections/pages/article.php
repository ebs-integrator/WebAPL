<section>
    <div class="wrap">
        <div class="left_block">
            <?php if (isset($years_list) && count($years_list)) { ?>
                <p class='title'><?= varlang('arhiva'); ?></p>
                <ul class="menu">
                    <?php foreach ($years_list as $year) { ?>
                        <li class='<?= isset($current_year) && $current_year == $year->year ? 'active' : ''; ?>'><a href="<?= url($page_url . "?year=" . $year->year . "&month=1"); ?>"><?= $year->year; ?></a></li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </div>
        <div class="resp_menu"></div>
        <div class="right_block">
            <?= View::make('sections.elements.breadcrumbs'); ?>
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
            <?php if (isset($current_month) && $current_month) { ?>
                <div class="m_criteria">
                    <?php if (isset($months[intval($current_month) - 1])) { ?>
                        <a href="<?= $page_url; ?>?year=<?= $current_year; ?>&month=<?= intval($current_month) - 1; ?>" class="left"></a>
                    <?php } ?>
                    <span><?= $months[intval($current_month)]; ?> <?= $current_year; ?></span>
                    <?php if (isset($months[intval($current_month) + 1])) { ?>
                        <a href="<?= $page_url; ?>?year=<?= $current_year; ?>&month=<?= intval($current_month) + 1; ?>" class="right"></a>
                    <?php } ?>
                </div> 
            <?php } ?>

            <?php Event::fire('page_top_container', $page); ?>

            <?= $page->text; ?>

            <?php Event::fire('page_bottom_container', $page); ?>

            <div class="clearfix50"></div>
            <?php if ($page->have_socials) { ?>
                <?= View::make('sections.elements.socials', array('url' => $page_url)); ?>
            <?php } ?>

        </div>
    </div>
</section>

