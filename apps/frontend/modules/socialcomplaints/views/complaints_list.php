<?php if ($complaints) { ?>
    <ul class='compl_list'>
        <?php foreach ($complaints as $item) { ?>
            <li>
                <a href='javascript:;'>
                    <span><?= date('Y-m-d', strtotime($item['date_created'])); ?></span>
                    <p class="compl_title"><?= $item['title']; ?></p>
                    <p class="compl_info">
                        <?= $item['text']; ?>
                        <br/>
                        <?php if ($item['response']) { ?>
                            <i>RASPUNS:</i> <?= $item['response']; ?>
                        <?php } ?>
                    </p>
                </a>
            </li>
        <?php } ?>
    </ul>
<?php } ?>
