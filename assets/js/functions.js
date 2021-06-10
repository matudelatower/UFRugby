export const modalAlert = (msg) => {
    window.$('#modal-alert .modal-body').html(msg);
    window.$('#modal-alert').modal('toggle');
}
window.modalAlert = modalAlert;

export const modalConfirm = (titulo, body, okButonHref) => {
    window.$('#modal-confirm .modal-body').html(body);
    window.$('#modal-confirm #myModalLabel').html(titulo);
    window.$('#modal-confirm #modal-btn-ok').attr('href', okButonHref);
    window.$('#modal-confirm').modal('toggle');
}
window.modalConfirm = modalConfirm;

export const bootstrapCollectionBorrarItem = (item) => {
    window.$(item).parent().parent().remove();
}
window.bootstrapCollectionBorrarItem = bootstrapCollectionBorrarItem;

export const inicializarPlugins = (item) => {

    if (item) {
        item.find('.select2').select2(
            {language: "es"}
        );
        item.find('.select2entity').select2entity()
    }

}
window.inicializarPlugins = inicializarPlugins;

// window.$.widget.bridge('uibutton', window.$.ui.button)

export const bloquearPantalla = (gif, loadingTitle='') => {
    window.$.blockUI({
            // message: ' <div class="row"><div class="col-md-4"><label>' + loadingTitle + '</label></div><div class="progress progress-striped active"><div class="bar" style="width: 100%;"></div></div></div></div>',
            message: '<div class="spinner-grow text-che" style="width: 3rem; height: 3rem;" role="status">\n' +
                '  <span class="sr-only">Loading...</span>\n' +
                '</div>',
            css: {backgroundColor: 'none', border: 'none'},
            baseZ: 2147483647
        }
    );
}
window.bloquearPantalla = bloquearPantalla;

function desbloquearPantalla() {

    window.$.unblockUI()

}

window.desbloquearPantalla = desbloquearPantalla;