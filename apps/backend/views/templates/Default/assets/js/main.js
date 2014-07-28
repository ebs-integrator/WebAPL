;
jQuery(document).ready(function($) {
    /*----------- BEGIN toggleButtons CODE -------------------------*/
    $('.make-switch').each(function() {
        $(this).bootstrapSwitch({
            onText: $(this).data('onText'),
            offText: $(this).data('offText'),
            onColor: $(this).data('onColor'),
            offColor: $(this).data('offColor'),
            size: $(this).data('size'),
            labelText: $(this).data('labelText')
        });
    });
    /*----------- END toggleButtons CODE -------------------------*/

    $(".treeview").treeview({
        animated: "fast",
        collapsed: true,
        // unique: true,
        persist: "cookie"
    });

    /*--------Ajax-auto-save---------*/
    function ajax_auto_save() {

        var options = {
            success: function(data) {
                console.log(data);
            },
            dataType: 'json'
        };

        $(this).closest('form').ajaxForm(options).submit();

    }
    $("body").on("change", "form.ajax-auto-submit input, form.ajax-auto-submit select, form.ajax-auto-submit textarea", ajax_auto_save);
    $("body").on("switchChange.bootstrapSwitch", "form.ajax-auto-submit input, form.ajax-auto-submit select, form.ajax-auto-submit textarea", ajax_auto_save);


    $(document).bind("ajaxSend", function() {
        $("#loading").show(200);
    }).bind("ajaxComplete", function() {
        $("#loading").hide(200);
    });
    
    $(".chzn-select").chosen();
    $(".chzn-select-deselect").chosen({
        allow_single_deselect: true
    });
    
    $(".lter").css('min-height', $(window).height() - 90);
});