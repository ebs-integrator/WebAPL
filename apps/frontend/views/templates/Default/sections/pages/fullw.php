<section>
    <?= View::make('sections.elements.breadcrumbs'); ?>
    <div class='wrap site_map'>
        <p class='c_title'><?= $page->title; ?></p>

        <?php Event::fire('page_top_container', $page); ?>

        <?= $page->text; ?>

        <?php Event::fire('page_bottom_container', $page); ?>

        <?=
        View::make('sections.pages.blocks.files', array(
            'page' => $page
        ));
        ?>


        <div class='clearfix'></div>
    </div>
</section>
