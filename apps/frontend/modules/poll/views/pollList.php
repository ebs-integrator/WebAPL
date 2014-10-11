<?php
if ($voted || $poll->active == 0) {
    echo Template::moduleView('poll', 'views.pollResults', array(
        'poll' => $poll,
        'total_votes' => PollVotesModel::where('poll_id', $poll->id)->count()
    ));
} else {
    echo Template::moduleView('poll', 'views.pollItem', array(
        'poll' => $poll
    ));
}
?>

<?php if ($polls) { ?>
    <div class="hr_grey"></div>
    <p class="e_sond"><?= varlang('alte-sondaje'); ?></p>
    <ul class="a_n">
    <?php foreach ($polls as $item) { ?>
            <li>
                <a href="<?= $page_url; ?>?item=<?= $item->id; ?>">
                    <span> <?= date('d-m-Y', strtotime($item->date_created)); ?> </span>
                    <p><?= $item->title; ?></p>
                </a>
            </li>
    <?php } ?>
    </ul>

    <?php echo $polls->links(); ?> 
<?php } ?>