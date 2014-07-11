<!-- jqgrid -->
<script src="<?= res('assets/lib/jquery-ui/jquery-ui.min.js'); ?>" type="text/javascript"></script>    
<script src="<?= res('assets/lib/jqgrid/src/i18n/grid.locale-en.js'); ?>" type="text/javascript"></script>   
<script src="<?= res('assets/lib/jqgrid/js/jquery.jqGrid.src.js'); ?>" type="text/javascript"></script>    
<link rel="stylesheet" type="text/css" media="screen" href="<?= res('assets/lib/jquery-ui/jquery-ui.css') ?>" />
<link rel="stylesheet" type="text/css" media="screen" href="<?= res('assets/lib/jqgrid/css/ui.jqgrid.css') ?>" />   
<!-- end  jqgrid --> 

<script type="text/javascript" >

    $(document).ready(function() {

        jQuery("#list").jqGrid(<?= $options; ?>);

        jQuery("#list").jqGrid('navGrid', '#pager', {search: false},
        {width: 400, reloadAfterSubmit: true, closeOnEscape: true, closeAfterEdit: true,
            beforeShowForm: function() {
            },
            afterShowForm: function($form) {
            },
            onclickSubmit: function(params, postdata) {
            }
        },
        {width: 400, reloadAfterSubmit: true, closeOnEscape: true, closeAfterAdd: true, //insert
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


<table id="list" ></table>
<div id="pager"></div>           
