<section>
    <?= View::make('sections.elements.breadcrumbs'); ?>
    <div class="wrap">
        <p class='c_title'><?= $top_title; ?></p>
        <div class='left'>
            <?= Core\APL\Actions::call('page_top_container', $page); ?>
            
            <?= $page->text; ?>

            <?= Core\APL\Actions::call('page_bottom_container', $page); ?>

            <?php if ($page->have_socials) { ?>
            <div class='socials'>
                <div id="vk_like"></div>
                <div id="ok_shareWidget"></div>
                <div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" data-width="125" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
                <div class="clearfix"></div>
            </div>
            <?php } ?>
            <?php if ($page->have_comments) {
                View::make('sections.elements.comments');
            } ?>
        </div>
        <div class="right">
            <?=
            View::make('sections.pages.blocks.right-menu')->with(array(
                'page' => $page,
                'colevels' => $colevels
            ));
            ?>
        </div>
        <div class='clearfix'></div>
        <div class='hr_grey'></div>
    </div>
</section>