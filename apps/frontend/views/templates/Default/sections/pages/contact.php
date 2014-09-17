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
                <div class='socials'>
                    <div id="vk_like"></div>
                    <div id="ok_shareWidget"></div>
                    <div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" data-width="125" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
                    <div class="clearfix"></div>
                </div>
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
