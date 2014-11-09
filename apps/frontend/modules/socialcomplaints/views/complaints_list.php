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
                        <?php if ($item['response']) { ?><br/>
                            <b><?= varlang('raspuns'); ?>:</b> <font style="color: #7E7D7D; font-style: italic"><?= $item['response']; ?></font>
                        <?php } ?>
                    </p>
                </a>
            </li>
        <?php } ?>
    </ul>

    <?php
    if (method_exists($complaints, 'links')) {
        echo $complaints->links();
    }
    ?>

<?php } ?>
