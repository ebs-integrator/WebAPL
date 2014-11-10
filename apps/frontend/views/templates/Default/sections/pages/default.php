<section>
    <?= View::make('sections.elements.breadcrumbs'); ?>
    <div class="wrap">
        <p class='c_title'><?= $top_title; ?></p>
        <div class="right">
            <?=
            View::make('sections.pages.blocks.right-menu')->with(array(
                'colevels' => $colevels
            ));
            ?>
        </div>
        <div class="resp_menu"></div>
        <div class='left t_block'>
            <?php Event::fire('page_top_container', $page); ?>

            <?= $page->text; ?>

            <?php Event::fire('page_bottom_container', $page); ?>

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