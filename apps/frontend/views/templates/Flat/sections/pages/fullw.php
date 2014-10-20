<section>
    <div class="wrap">
        <div class="left_block">

        </div>
        <div class="resp_menu"></div>
        <div class="right_block <?= $page->view_mod; ?>">

            <?php Event::fire('page_top_container', $page); ?>

            <?= $page->text; ?>

            <?php Event::fire('page_bottom_container', $page); ?>

            <?=
            View::make('sections.pages.blocks.files', array(
                'page' => $page
            ));
            ?>

        </div>
    </div>

</section>




