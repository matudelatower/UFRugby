// functions
modalAlert = (msg) => {
    window.$('#modal-alert .modal-body').html(msg);
    window.$('#modal-alert').modal('toggle');
}

modalConfirm = (titulo, body, okButonHref) => {
    window.$('#modal-confirm .modal-body').html(body);
    window.$('#modal-confirm #myModalLabel').html(titulo);
    window.$('#modal-confirm #modal-confirm-btn-ok').attr('href', okButonHref);
    window.$('#modal-confirm').modal('toggle');
}

bootstrapCollectionBorrarItem = (item) => {
    window.$(item).parent().parent().remove();
}

// ui stuff

window.$('button[type="reset"]').click(function () {
    var form = window.$(this).parents().find('form');

    form.find('input, textarea, input:not([type="submit"])').removeAttr('value');
    form.find('input, textarea, input:not([type="submit"])').val('');
    form.find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');

    form.find('select option').removeAttr('selected').find('option:first').attr('selected', 'selected');
});

window.$( "form" ).has( ".btn-guardar" ).submit(function (e) {
    window.$(".btn-guardar").addClass('disabled');
    window.$(".btn-guardar").html('<i class="fa fa-circle-o-notch fa-spin"></i> Guardando');
});
