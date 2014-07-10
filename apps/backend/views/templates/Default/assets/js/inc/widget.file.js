var filewidget = {
    filelist: function(module_name, module_id, selector, num) {
        $.post(base_url + "/uploader/filelist", {module_name: module_name, module_id: module_id, num: num}, function(data) {
            $(selector).html(data.html);
        }, 'json');
    },
};

jQuery(document).ready(function($) {

    $('body').on('change', '.select_file', function() {
        var options = {
            success: function(data) {
                console.log(data);
                filewidget.filelist(data.module_name, data.module_id, '.files-' + data.module_name + '-' + data.module_id, data.num);
            },
            dataType: 'json',
            resetForm: true
        };

        $(this).closest('form').ajaxForm(options).submit();
    });

    $('body').on('click', '.delete_file', function() {
        var date = $(this).data();
        $.post(base_url + "/uploader/delete", {id: date.id}, function(data) {
            filewidget.filelist(date.module_name, date.module_id, date.update, date.num);
        }, 'json');
    });

    $("body").on('click', ".click-trigger", function() {
        $($(this).data('for')).click();
    });
});