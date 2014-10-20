<?php
    $uniq_id = isset($id) ? $id : uniqid();
?>

<!-- jqgrid -->
<script src="<?= res('assets/lib/jqgrid/src/i18n/grid.locale-en.js'); ?>" type="text/javascript"></script>   
<script src="<?= res('assets/lib/jqgrid/js/jquery.jqGrid.src.js'); ?>" type="text/javascript"></script>    
<link rel="stylesheet" type="text/css" media="screen" href="<?= res('assets/lib/jqgrid/css/ui.jqgrid.css') ?>" />   
<!-- end  jqgrid --> 

<script type="text/javascript" >

    $(document).ready(function() {

        <?= $options; ?>.pager = '#pager-<?=$uniq_id;?>';

        jQuery("#list-<?=$uniq_id;?>").jqGrid(<?= $options; ?>);

        jQuery("#list-<?=$uniq_id;?>").jqGrid('navGrid', '#pager-<?=$uniq_id;?>', {search: false},
        {
            width: 450, 
            reloadAfterSubmit: true, 
            closeOnEscape: true, 
            closeAfterEdit: true, 
            recreateForm: true,
            beforeShowForm: function() {
            },
            afterShowForm: function($form) {
            },
            onclickSubmit: function(params, postdata) {
            }
        },
        {
            width: 450, 
            reloadAfterSubmit: true, 
            closeOnEscape: true, 
            closeAfterAdd: true, 
            recreateForm: true,
            beforeShowForm: function() {
            },
            afterShowForm: function() {
            },
            onclickSubmit: function(params, postdata) {
            }
        },
        {onclickSubmit: function() {
                return {}
            }, closeOnEscape: true}, {});

        $(".center_content .ui-jqgrid-titlebar").remove();
    });
</script>


<table id="list-<?=$uniq_id;?>" ></table>
<div id="pager-<?=$uniq_id;?>"></div>           
