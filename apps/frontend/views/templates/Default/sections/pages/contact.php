<section>
    <?= View::make('sections.elements.breadcrumbs'); ?>
    <div class="wrap">
        <div class="right">
            <ul class='detail'>
                <li class='email'>
                    <a href='<?= varlang('email-address'); ?>'><?= varlang('email-address'); ?></a>
                </li>
                <li class='fax'>
                    <a href='<?= varlang('nr-fax'); ?>'><?= varlang('nr-fax'); ?></a>
                </li>
                <li class='location'>
                    <a href='<?= Language::url('topage/contactsView'); ?>'><?= varlang('cum-ne-gasiti'); ?></a>
                </li>
                <?php Actions::call('contact_right_list');?>
            </ul>
        </div>
        <div class="left">
        <p class="c_title"><?= $top_title; ?></p>
            <?= Core\APL\Actions::call('page_top_container', $page); ?>

            <?= $page->text; ?>

            <?= Core\APL\Actions::call('page_bottom_container', $page); ?>

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
