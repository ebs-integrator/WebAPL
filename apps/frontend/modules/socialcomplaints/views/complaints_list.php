<?php if ($complaints) { ?>
    <ul class='compl_list'>
        <?php foreach ($complaints as $item) { ?>
            <li>
                <a href='javascript:;'>
                    <span><?= date('Y-m-d', strtotime($item['date_created'])); ?><img src="<?= res('assets/img/p_gr_arrow.png'); ?>"></span>
                    <p class="compl_title"><?= $item['title']; ?></p>
                    <p class="compl_info"><?= $item['text']; ?></p>
                </a>
            </li>
        <?php } ?>
    </ul>
<?php } ?>

<!--div class="pag">
    <span class="w_p">Pagina</span>
    <span class="p_n"><a href="javascript:;">Precedenta</a></span>
    <ul>
        <li><a href="javascript:;">1</a></li>
        <li class="active"><a href="javascript:;">2</a></li>
        <li><a href="javascript:;">3</a></li>
        <li><a href="javascript:;">4</a></li>
        <li><a href="javascript:;">5</a></li>
    </ul>
    <span class="n_p"><a href="javascript:;">următoarea</a></span>
</div-->