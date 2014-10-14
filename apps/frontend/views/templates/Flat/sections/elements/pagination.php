<?php
$presenter = new Illuminate\Pagination\BootstrapPresenter($paginator);
?>

<?php if ($paginator->getLastPage() > 1): ?>
<div class='pag'>
    <span class='w_p'>Pagina</span>
    <!--<span class='p_n'><a href='javascript:;'>Precedenta</a></span>-->
    <ul>
        <?php echo $presenter->render(); ?>
    </ul>
    <!--<span class='n_p'><a href='javascript:;'>următoarea</a></span>-->
</div>
<?php endif; ?>