CKEDITOR.plugins.add('addmap', {
    requires: ['dialog'],
    init: function(a) {
        var b = "addmap";
        var c = a.addCommand(b, new CKEDITOR.dialogCommand(b));
        c.modes = {wysiwyg: 1, source: 0};
        c.canUndo = false;
        a.ui.addButton("addmap", {
            label: 'Insert HTML Code',
            command: b,
            icon: this.path + "map.gif"
        });

        CKEDITOR.dialog.add("addmap", function(e) {
            return {
                title: 'HTML Insert',
                resizable: CKEDITOR.DIALOG_RESIZE_BOTH,
                minWidth: 380,
                minHeight: 60,
                onShow: function() {
                },
                onLoad: function() {
                    dialog = this;
                    this.setupContent();
                },
                onOk: function() {
                    var sInsert = this.getValueOf('info', 'insertcode_area');
                    if (sInsert.length > 0) {
                        e.insertHtml(sInsert);
                    }
                },
                contents: [
                    {id: "info",
                        name: 'info',
                        label: 'HTML',
                        elements: [{
                                type: 'vbox',
                                padding: 0,
                                children: [
                                    {type: 'html',
                                        html: '<span>Insereaza codul IFRAME<span>'
                                    },
                                    {type: 'textarea',
                                        id: 'insertcode_area'
                                    }
                                ]
                            }]
                    }
                ]
            };
        });


    }
});