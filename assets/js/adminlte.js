// try {
//     window.$ = window.jQuery = require('jquery');
//
//     require('bootstrap');
// } catch (e) {}

const $ = require('jquery');
global.$ = global.jQuery = $;

// require('bootstrap');
require('bootstrap/dist/js/bootstrap.bundle.js');

require('select2')
require('select2/dist/js/i18n/es.js')
// require('jquery-ui-dist/jquery-ui.min.js')
// require('daterangepicker')
require('moment')
require('overlayscrollbars')
// require('fastclick')
// require('sweetalert2')
// window.paceOptions = {
//     // Configuration goes here. Example:
//     elements: false,
//     restartOnPushState: false,
//     restartOnRequestAfter: false,
//     startOnPageLoad: false,
//     ajax: false
// }
// require('admin-lte/plugins/pace-progress/pace.min')
require('admin-lte')

$(document).ready(function () {
    // $('[data-toggle="popover"]').popover();
    $('[data-toggle="tooltip"]').tooltip()
    $('.select2').select2(
        {
            language: "es",
            theme: 'bootstrap4'
        }
    );

    $('.reset').click(function () {
        var formNameInputName = $(this).attr('name');
        var formName = formNameInputName.substr(formNameInputName, formNameInputName.indexOf("["))

        var form = $(`form[name="${formName}"]`);

        form.find('input, textarea, input:not([type="submit"])').removeAttr('value');
        form.find('input, textarea, input:not([type="submit"])').val('');
        form.find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');

        form.find('select option').removeAttr('selected').find('option:first').attr('selected', 'selected');
        form.find(".select2").trigger("change");
    })
});
