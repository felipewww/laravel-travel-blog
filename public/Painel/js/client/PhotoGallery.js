$(document).ready(function () {
    PhotoGallery.init();
});

PhotoGallery = {

    addedCount: 100,
    init: function () {
        $(function() {
            $("#sortable").sortable();
        });
    },

    addPhoto: function () {
        var form    = document.forms.photoGallery;

        var name    = 'photo['+this.addedCount+']';
        var id      = 'photo_new_'+this.addedCount;

        var container = Script.createElement('div', '', {
            class: 'w-25',
            id: id
        });

        var divActions = Script.createElement('div', { class: 'actions' });
        var actDelete = Script.createElement('span', 'excluir',
            {
                onclick: function () {
                    var child = document.getElementById(id);
                    child.parentNode.removeChild(child);
                }
            });

        divActions.appendChild(actDelete);
        var miniature = Script.createElement('div', '', { class: 'photo_img' }, { backgroundImg: 'url(asd.jpg)' });

        //Create Image field
        var inputImgLabel = Script.createElement('input', '', { type: 'file', name: name+'[img]', required: 'required' });
        var textarea = Script.createElement('textarea', '', { class: 'desc', type: 'text', placeholder: 'Descrição da foto', name: name+'[description]', required: 'required' });


        //End make container
        container.appendChild(divActions);
        container.appendChild(miniature);
        container.appendChild(inputImgLabel);
        container.appendChild(textarea);

        form.appendChild(container);

        this.addedCount++;
    },

    deletePhoto: function (element, id) {
        swal('Função indisponível no momento','warning');
        return false;

        $.ajax({
            // url: '/painel/api/mundo/'+headlines.cfg.path+'/'+Script.screenJson.city_id,
            // url: '/painel/api/headline/'+headlines.cfg.path+'/deleteHeadline',
            url: '/painel/api/photoGallery/deletePhoto',
            method: 'post',
            dataType: 'json',
            data: { from: headlines.cfg.from, hl_id: id, reg_id: headlines.cfg.reg_id, _token: window.Laravel.csrfToken },
            success: function (data) {
                if (data.status) {
                    headlines.swal('success','O Headline foi excluído com sucesso!');
                    var hlDiv = element.parentNode.parentNode;
                    hlDiv.parentNode.removeChild(hlDiv);
                }else{
                    headlines.swal('error', data.msg);
                }
            },
            error: function (error) {
                headlines.swal('bug');
            }
        });
    },

    swal: function (msgType, text) {
        var responses = {
            error: {
                title: 'Ops!',
                text: text,
                type: "info",
                confirmButtonColor: '#2980b9',
                confirmButtonText: 'ok',
                closeOnConfirm: true
            },

            success: {
                title: 'Feito!',
                text: text,
                type: "success",
                confirmButtonColor: '#2980b9',
                confirmButtonText: 'ok',
                closeOnConfirm: true
            },

            bug: {
                title: 'Erro inesperado',
                text: 'Tente novamente, se o erro persistir, entre em contato com o administrador do sistema',
                type: "error",
                confirmButtonColor: '#2980b9',
                confirmButtonText: 'fechar',
                closeOnConfirm: true
            }
        };

        swal(
            responses[msgType],
            function(isConfirm){
                if ( msgType == 'success' )
                {

                }
                else
                {

                }
            }
        );
    }
};