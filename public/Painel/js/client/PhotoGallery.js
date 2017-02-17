$(document).ready(function () {
    PhotoGallery.init();
});

PhotoGallery = {

    init: function () {
        // console.log(Script.screenJson);
        // this.cfg = Script.screenJson.headline_morph;
    },

    // headlines: function () {
    //     Script.AjaxForm('headlines', 'updateHeadline', function (status, data) {
    //         console.log(data);
    //         swal('','Headlines Atualizados!','success');
    //     });
    //     // Script.sendFormData('headlines');
    // },

    addPhoto: function () {
        var form    = document.forms.photoGallery;
        var name    = 'photo_new['+this.addedCount+']';
        var id      = 'photo_new_'+this.addedCount;

        var container = Script.createElement('div', '', {
            class: 'w-50',
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

        //Create Image field
        var labelImgField = Script.createElement('label', '');
        var titleImgLabel = Script.createElement('span', 'Photo Img', {});
        var inputImgLabel = Script.createElement('input', '', { type: 'file', name: name+'[img]', required: 'required' });
        labelImgField.appendChild(titleImgLabel);
        labelImgField.appendChild(inputImgLabel);

        //Create Title field
        // var labelTtlField = Script.createElement('label', '');
        // var titleTtlLabel = Script.createElement('span', 'Headline Title', {});
        // var inputTtlLabel = Script.createElement('input', '', { type: 'text', name: name+'[title]', required: 'required' });
        // labelTtlField.appendChild(titleTtlLabel);
        // labelTtlField.appendChild(inputTtlLabel);

        //Create Text field
        // var labelTxtField = Script.createElement('label', '');
        // var titleTxtLabel = Script.createElement('span', 'Headline Text', {});
        // var inputTxtLabel = Script.createElement('input', '', { type: 'text', name: name+'[text]', required: 'required' });
        // labelTxtField.appendChild(titleTxtLabel);
        // labelTxtField.appendChild(inputTxtLabel);

        //End make container
        container.appendChild(divActions);
        container.appendChild(labelImgField);
        // container.appendChild(labelTtlField);
        // container.appendChild(labelTxtField);

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