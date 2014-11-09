<p class="adv"><?= varlang('poll-msg-succ'); ?></p>
<p class="snd_title"><?= $poll->title; ?></p>

<table class="sondaje">
    <tbody>
        <?php foreach ($poll->answers as $answer) { ?>
            <tr>
                <td><?= $answer->title; ?></td>
                <td>
                    <progress value="<?= (int) ($total_votes ? $answer->count / $total_votes * 100 : 0); ?>" max="100"></progress>
                    <span><?= (int) ($total_votes ? $answer->count / $total_votes * 100 : 0); ?>%</span>
                </td><td><?= $answer->count ? $answer->count : 0; ?> <?= varlang('poll-raspunsuri'); ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<table class="sondaje">
    <tbody>
        <tr>
            <td>&nbsp;</td>
            <td>
                <span class='t_right'><?= varlang('total'); ?></span>
            </td>
            <td><?= $total_votes; ?> <?= varlang('poll-raspunsuri'); ?></td>
        </tr>
    </tbody>
</table>