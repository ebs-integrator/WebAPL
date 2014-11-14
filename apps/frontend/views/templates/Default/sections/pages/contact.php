<section>
    <?= View::make('sections.elements.breadcrumbs'); ?>
    <div class="wrap">
        <p class="c_title"><?= $top_title; ?></p>
        <div class="right">
            <ul class='detail'>
                <li class='email'>
                    <a href='mailto:<?= varlang('email-address'); ?>'><?= varlang('email-address'); ?></a>
                </li>
                <li class='fax'>
                    <a href='javascript:;'><?= varlang('nr-fax'); ?></a>
                </li>
                <li class='location'>
                    <a href='<?= Language::url('topage/contactsView'); ?>'><?= varlang('cum-ne-gasiti'); ?></a>
                </li>
                <?php Event::fire('contact_right_list');?>
            </ul>
        </div>
        <div class="left">
            <?php Event::fire('page_top_container', $page); ?>

            <?= $page->text; ?>

            <?php Event::fire('page_bottom_container', $page); ?>

            <?=
            View::make('sections.pages.blocks.files', array(
                'page' => $page
            ));
            ?>

            <?php if ($page->have_socials) { ?>
                <?= View::make('sections.elements.socials', array('url' => $page_url)); ?>
            <?php } ?>
            <?php
            if ($page->have_comments) {
                View::make('sections.elements.comments');
            }
            ?>
        </div>


        <div class="clearfix"></div>
        <div class="hr_grey"></div>
    </div>
</section>
