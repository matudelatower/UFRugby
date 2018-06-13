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
