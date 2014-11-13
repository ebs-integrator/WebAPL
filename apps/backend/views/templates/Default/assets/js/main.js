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
        persist: "cookie"
    });


    window.lock_window = function() {
        window.onbeforeunload = function() {

            return "ATENTIE !!! \nAcum se petrece salvarea datelor, va rugam sa nu parasiti acum ca riscati sa pierdeti date.";
        };
    }

    window.unlock_window = function() {
        window.onbeforeunload = null;
    }

    /*--------Ajax-auto-save---------*/
    // list of ajax submit form
    var auto_save_tasks = [];
    // execution flag
    var auto_save_execution = false;
    // force stop execution flag
    var auto_save_stop = false;

    /**
     * Execute list of function
     * @returns {undefined}
     */
    function execute_auto_save() {
        // if functions exists and process not force stoped
        if (auto_save_tasks.length > 0 && !auto_save_stop) {
            lock_window();
            auto_save_execution = true;
            // execute function
            auto_save_tasks[0]();
            // delete executed function
            auto_save_tasks.splice(0, 1);
        } else {
            auto_save_execution = false;
            unlock_window();
        }
    }

    /**
     * Add new task
     * @returns {undefined}
     */
    function ajax_auto_save() {
        var form = $(this).closest('form');
        // ad new task to list
        auto_save_tasks.push(function() {

            form.ajaxForm({
                success: function(data) {
                    if (typeof data.redirect_to != 'undefined') {
                        window.location.href = data.redirect_to;
                        auto_save_stop = true;
                    }
                },
                // call next function
                complete: execute_auto_save,
                dataType: 'json'
            }).submit();
        });

        // start process
        if (!auto_save_execution) {
            execute_auto_save();
        }
    }

    // Event listeners
    $("body").on("change", "form.ajax-auto-submit input, form.ajax-auto-submit select, form.ajax-auto-submit textarea", ajax_auto_save);
    $("body").on("dp.change", "form.ajax-auto-submit .datetimepicker", ajax_auto_save);
    $("body").on("switchChange.bootstrapSwitch", "form.ajax-auto-submit input", ajax_auto_save);

    // Save interval for focused elements
    setInterval(function() {
        // Simple inputs
        $("form.ajax-auto-submit input:focus, form.ajax-auto-submit select:focus, form.ajax-auto-submit textarea:focus").change();

        // ckeditor
        if (CKEDITOR.currentInstance !== null && typeof CKEDITOR.currentInstance != 'undefined') {
            CKEDITOR.currentInstance.updateElement();
            $(CKEDITOR.currentInstance.element.$).trigger('change');
        }
    }, 60000);

    // Ajax process indicator
    $(document).bind("ajaxSend", function() {
        $("#loading").show(200);
    }).bind("ajaxComplete", function() {
        $("#loading").hide(200);
    });

    // Initialize chosen selects
    $(".chzn-select").chosen();
    $(".chzn-select-deselect").chosen({
        allow_single_deselect: true
    });

    $(".lter").css('min-height', $(window).height() - 90);


    var roxyFileman = assets_url + '/assets/lib/fileman/index.html';
    $(".ckeditor-run").ckeditor({
        filebrowserBrowseUrl: roxyFileman,
        filebrowserImageBrowseUrl: roxyFileman + '?type=image',
        removeDialogTabs: 'link:upload;image:upload'
    });
    function updateCkeditorElement(obj) {
        lock_window();
        obj.editor.updateElement();
        $(obj.editor.element.$).trigger('change');
    }

    function setUpdateEvents(i) {
        CKEDITOR.instances[i].on('blur', updateCkeditorElement);
        CKEDITOR.instances[i].on('focus', lock_window);
        CKEDITOR.instances[i].on('change', function(obj) {
            obj.editor.updateElement();
        });
    }

    setTimeout(function() {
        for (var i in CKEDITOR.instances) {
            setUpdateEvents(i);
        }
    }, 1000);


    window.init_ckeditor = function(elem) {
        var i = $(elem).attr('name');
        console.log(i, CKEDITOR.instances[i]);
        if (typeof CKEDITOR.instances[i] != 'undefined') {
            CKEDITOR.instances[i].destroy(true);
        }
        $(elem).ckeditor({
            filebrowserBrowseUrl: roxyFileman,
            filebrowserImageBrowseUrl: roxyFileman + '?type=image',
            removeDialogTabs: 'link:upload;image:upload'
        });
        setTimeout(function() {
            setUpdateEvents(i)
        }, 1000);
    }


    $('.datetimepicker').datetimepicker({
        language: 'en',
        pickSeconds: true,
        pick12HourFormat: false
    });

    $("#ccache").click(function() {
        var button = $(this);
        button.text('...');
        $.get('/ccache', {}, function() {
            button.text('Success');
        });
    });

    $("#feedFilds").on('change', function() {
        var val = $(this).val();
        $('.feedField').prop('checked', false);
        if (val) {
            $('.feedField[data-groups*="' + val + '"]').prop('checked', true);
        }
    });

});
