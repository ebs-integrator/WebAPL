<section>
    <?= View::make('sections.elements.breadcrumbs'); ?>
    <div class="wrap">
        <p class="c_title"><?= $top_title; ?></p>
        <div class="right">
            <ul class='detail'>
                <li class='email'>
                    <a href='javascript:;'>info@straseni.gov.md</a>
                </li>
                <li class='fax'>
                    <a href='javascript:;'>(0-237) 55-66-77</a>
                </li>
                <li class='chat'>
                    <a href='javascript:;'>chat-online</a>
                </li>
                <li class='location'>
                    <a href='contacte.php'>Cum ne găsiți</a>
                </li>
            </ul>
        </div>
        <div class="left">
            <?= Core\APL\Actions::call('page_top_container', $page); ?>

            <?= $page->text; ?>

            <?= Core\APL\Actions::call('page_bottom_container', $page); ?>

            <?= View::make('sections.pages.blocks.files', array(
                'page' => $page
            ));?>
            
            <?php if ($page->have_socials) { ?>
                <?=View::make('sections.elements.socials', array('url' => $page_url));?>
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
