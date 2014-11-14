<section>
    <div class="wrap">
        <div class="left_block">
            <div class="left_details">
                <a href="mail:<?= varlang('email-address'); ?>" class="l_email"><?= varlang('email-address'); ?></a>
                <a href="javascript:;" class="l_fax"><?= varlang('nr-fax'); ?></a>
                <a href="<?= Language::url('topage/contactsView'); ?>" class="l_map"><?= varlang('cum-ne-gasiti'); ?></a>
                <?php Event::fire('contact_right_list'); ?>
            </div>
        </div>
        <div class="resp_menu"></div>
        <div class="right_block">
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




