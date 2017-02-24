$(document).ready(function () {
    PainelPosts.init();
});

PainelPosts = {
    init: function () {

    },

    verifyAuthorAndActivePost: function (post_id, author_id) {
        var obj;
        if (author_id == '') {
            obj = {
                title: 'Ops!',
                text: 'Este post não pode ser ativado pois ainda não possui as configurações básicas. Vá para "Configurações"',
                type: "warning",
                // showCancelButton: true,
                confirmButtonColor: '#a5dc86',
                confirmButtonText: 'Entendi',
                // cancelButtonText: 'Editar configurações',
                closeOnConfirm: true,
                // closeOnCancel: true
            }
        }else{
            obj = {
                title: 'Ops!',
                text: 'Função indisponível no sistema no momento. Entre em contato com o administrador.',
                type: "info",
                // showCancelButton: true,
                confirmButtonColor: '#a5dc86',
                confirmButtonText: 'Entendi',
                // cancelButtonText: 'Editar configurações',
                closeOnConfirm: true,
                // closeOnCancel: true
            }
        }
        swal(obj);
    },

    inactivePost: function () {
        swal({
            title: 'Ops!',
            text: 'Função indisponível no sistema no momento. Entre em contato com o administrador.',
            type: "info",
            confirmButtonColor: '#a5dc86',
            confirmButtonText: 'Entendi',
            closeOnConfirm: true
        });
    }
};