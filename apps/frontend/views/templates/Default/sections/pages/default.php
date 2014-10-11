<section>
    <?= View::make('sections.elements.breadcrumbs'); ?>
    <div class="wrap">
        <div class="right">
            <?=
            View::make('sections.pages.blocks.right-menu')->with(array(
                'colevels' => $colevels
            ));
            ?>
        </div>
        <div class='left'>
        <p class='c_title'><?= $top_title; ?></p>
            <?= Core\APL\Actions::call('page_top_container', $page); ?>

            <?= $page->text; ?>

            <?= Core\APL\Actions::call('page_bottom_container', $page); ?>

            <?=
            View::make('sections.pages.blocks.files', array(
                'page' => $page
            ));
            ?>

            <?php 
            if ($page->have_socials) { 
                echo View::make('sections.elements.socials', array('url' => $page_url));  
            } 
            if ($page->have_comments) {
               echo View::make('sections.elements.comments');
            }
            ?>
        </div>
        <div class='clearfix'></div>
        <div class='hr_grey'></div>
    </div>
</section>