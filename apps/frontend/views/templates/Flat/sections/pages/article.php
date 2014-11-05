<?php
$months = array(
    1 => varlang('ianuarie'),
    2 => varlang('februarie'),
    3 => varlang('martie'),
    4 => varlang('aprilie'),
    5 => varlang('mai'),
    6 => varlang('iunie'),
    7 => varlang('iulie'),
    8 => varlang('august'),
    9 => varlang('septembrie'),
    10 => varlang('octombrie'),
    11 => varlang('noiembrie'),
    12 => varlang('decembrie')
);
?>

<section>
    <div class="wrap">
        <div class="left_block">
            <?php if (isset($years_list) && count($years_list)) { ?>
                <p class='title'><?= varlang('arhiva'); ?></p>
                <ul class="menu art">
                    <?php foreach ($years_list as $year) { ?>
                        <li class='<?= isset($current_year) && $current_year == $year->year ? 'active' : ''; ?>'>
                            <a href="javascript:;//<?= url($page_url . "?year=" . $year->year . "&month=1"); ?>"><?= $year->year; ?></a>
                            <ul class="months">
                                <li><a href="javascript:;">Ianuarie</a></li>
                                <li><a href="javascript:;">Februarie</a></li>
                                <li><a href="javascript:;">Martie</a></li>
                                <li><a href="javascript:;">Aprilie</a></li>
                                <li><a href="javascript:;">Mai</a></li>
                                <li><a href="javascript:;">Iunie</a></li>
                                <li><a href="javascript:;">Iulie</a></li>
                                <li><a href="javascript:;">August</a></li>
                                <li><a href="javascript:;">Septembrie</a></li>
                                <li><a href="javascript:;">Octombrie</a></li>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </div>
        <div class="resp_menu"></div>
        <div class="right_block">
            <?= View::make('sections.elements.breadcrumbs'); ?>
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

