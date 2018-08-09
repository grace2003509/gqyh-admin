var require = {
    "baseUrl" : "/js/",
    "paths"   : {
        "app"             : "app.min",
        "common"          : "common",
        "jQuery"          : "../vendor/jquery/dist/jquery.min",
        "bootstrap"       : "../vendor/bootstrap/dist/js/bootstrap.min",
        "underscore"      : "../vendor/underscore/underscore-min",
        "datepicker"      : "../vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min",
        "moment"          : "../vendor/moment/min/moment-with-locales.min",
        "daterangepicker" : "../vendor/bootstrap-daterangepicker/daterangepicker",
        "datatables"      : "../vendor/datatables/media/js/jquery.dataTables.min",
        "treeview"        : "../vendor/bootstrap-treeview/dist/bootstrap-treeview.min",
        "jqvalidation"    : "../vendor/jquery-validation/dist/jquery.validate.min",
        "autocomplete"    : "../vendor/devbridge-autocomplete/dist/jquery.autocomplete",
        "jquery-metadata" : "../vendor/jquery-metadata/jquery.metadata",
        "ueditor"         : "../laravel-u-editor/ueditor.all",
        "ueditor-config"  : "../laravel-u-editor/ueditor.config",
        "ZeroClipboard"   : "../laravel-u-editor/third-party/zeroclipboard/ZeroClipboard.min",
        "crel"            : "../vendor/crel/crel.min",
    },
    "shim"  : {
        "crel" : {
            "export" : 'crel'
        },
        "app" : {
            "deps" : ['jQuery','bootstrap']
        },
        "ueditor" : {
            "deps" : ['ueditor-config']
        },
        "autocomplete" : {
            "deps" : ['jQuery']
        },
        "bootstrap" : {
            "deps" : ['jQuery']
        },
        "datatables" : {
            "deps" : ['jQuery']
        },
        "daterangepicker" : {
            "deps" : ['jQuery','bootstrap','moment']
        },
        "datepicker" : {
            "deps" : ['jQuery','bootstrap']
        },
        "treeview" : {
            "deps" : ['jQuery','bootstrap']
        },
        "icheck" : {
            "deps" : ['jQuery']
        },
        "jqvalidation" : {
            "deps" : ['jQuery']
        },
        "jquery-metadata" : {
            "deps" : ['jQuery']
        }
    }
}