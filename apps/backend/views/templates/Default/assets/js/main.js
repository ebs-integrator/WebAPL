;
jQuery(document).ready(function ($){
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
});