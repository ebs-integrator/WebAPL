<section>
    <div class="wrap">
        <div class="left_block">
            <?=
            View::make('sections.pages.blocks.right-menu')->with(array(
                'colevels' => $colevels,
                'top_title' => $top_title,
                'parent' => $parent
            ));
            ?>
        </div>
        <div class="resp_menu"></div>
        <div class="right_block t_block <?=$page->view_mod;?>">
            <?= View::make('sections.elements.breadcrumbs'); ?>

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
    </div>

</section>




