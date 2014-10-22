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


    $("body").on('click', '.click-trigger-sv', function() {
        current_file_instance = $(this).data('for');
        $("#fileModal").modal('show');
        $("#fileModal").find('iframe').each(function() {
            $(this).attr('src', $(this).data('src'));
        });
    });

    $("body").on('change', ".file_name_edit", function() {
        $.post(base_url + "/uploader/editname", {id: $(this).attr('data-id'), name: $(this).val()}, function(data) {
        }, 'json');
    });
});

var current_file_instance;
window.setFilePath = function(file) {
    $(current_file_instance).val(file.fullPath);

    var options = {
        success: function(data) {
            console.log(data);
            filewidget.filelist(data.module_name, data.module_id, '.files-' + data.module_name + '-' + data.module_id, data.num);
        },
        dataType: 'json',
        resetForm: true
    };

    $(current_file_instance).closest('form').ajaxForm(options).submit();

    $("#fileModal").modal('hide');
}