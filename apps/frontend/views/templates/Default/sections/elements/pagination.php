<?php
$presenter = new Illuminate\Pagination\BootstrapPresenter($paginator);
?>

<?php if ($paginator->getLastPage() > 1): ?>
<div class='pag'>
    <span class='w_p'><?= varlang('page-5'); ?></span>
    <ul>
        <?php echo $presenter->render(); ?>
    </ul>
</div>
<?php endif; ?>