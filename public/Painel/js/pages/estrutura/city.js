$(document).ready(function () {
    city.init();
});

city = {
    regions: {
        article_content: { required: true }
    },

    init: function () {
        if (Script.screenJson.isPainel) {
            city.painel.init();
        }
    },

    painel: {
        newHeadlinesCount: 0,

        init: function () {
            //alert('city.painel');
        },

        interest: function () {
            Script.AjaxForm('interests', 'updateInterests', function (status, data) {
                console.log(data);
                swal('','Interesses Atualizados!','success');
            });
        },

        tags: function () {
            Script.AjaxForm('tags', 'updateTags', function (status, data) {
                console.log(data);
                swal('','Tags de pesquisa Atualizadas!','success');
            });
        },

        headlines: function () {
            Script.AjaxForm('headlines', 'updateHeadline', function (status, data) {
                console.log(data);
                swal('','Headlines Atualizados!','success');
            });
            // Script.sendFormData('headlines');
        },

        addHeadLine: function () {
            var form    = document.forms.headlines;
            var name    = 'hl_new['+city.painel.newHeadlinesCount+']';
            var id      = 'hl_new_'+city.painel.newHeadlinesCount;

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
                var titleImgLabel = Script.createElement('span', 'Headline Img', {});
                var inputImgLabel = Script.createElement('input', '', { type: 'file', name: name+'[img]' });
            labelImgField.appendChild(titleImgLabel);
            labelImgField.appendChild(inputImgLabel);

            //Create Title field
            var labelTtlField = Script.createElement('label', '');
                var titleTtlLabel = Script.createElement('span', 'Headline Title', {});
                var inputTtlLabel = Script.createElement('input', '', { type: 'text', name: name+'[title]' });
            labelTtlField.appendChild(titleTtlLabel);
            labelTtlField.appendChild(inputTtlLabel);

            //Create Text field
            var labelTxtField = Script.createElement('label', '');
                var titleTxtLabel = Script.createElement('span', 'Headline Text', {});
                var inputTxtLabel = Script.createElement('input', '', { type: 'text', name: name+'[text]' });
            labelTxtField.appendChild(titleTxtLabel);
            labelTxtField.appendChild(inputTxtLabel);

            //End make container
            container.appendChild(divActions);
            container.appendChild(labelImgField);
            container.appendChild(labelTtlField);
            container.appendChild(labelTxtField);

            form.appendChild(container);

            city.painel.newHeadlinesCount++;
        },

        deleteHeadline: function (id) {
            $.ajax({
                url: '/painel/api/mundo/cidade/'+Script.screenJson.city_id,
                method: 'post',
                dataType: 'json',
                data: { action: 'deleteHeadline', id: id, _token: window.Laravel.csrfToken },
                success: function (data) {
                    console.log(data);
                    // swal('Headline excluído com sucesso!!');
                },
                error: function (error) {
                    console.log(error);
                    // swal('Erro!');
                }
            });
        }
    },

    /*
    * Funções executada no ONSAVE do ContentTools dinamicamente para salvar a PÁGINA da cidade.
    * */
    create: function (ev)  { ContentToolsExtensions.mountRegions(ev.detail().regions, city.regions); city.action('create'); },
    update: function (ev)  { ContentToolsExtensions.mountRegions(ev.detail().regions, city.regions); city.action('update'); },

    action: function (action)
    {
        var id;
        if (action == 'create') {
            id = Script.screenJson.city.geonameId;
            if (!ContentToolsExtensions.validateRegions(city.regions)) {
                return false;
            }
        }else{
            id = Script.screenJson.city_id;
        }

        //var html = document.getElementById('the-article').innerHTML;
        $.ajax({
            method: 'post',
            url: '/painel/api/blog/cidade/save/'+id,
            data: { content_regions: city.regions, _token: window.Laravel.csrfToken, screen_json: Script.screenJson, action: action },
            dataType: 'json',
            success: function (data) {
                if (action == 'activate') { window.location.href = '/cidade/'+data.ascii_name+'/'+Script.screenJson.city.geonameId; }
                city.confirm(action, data);
            },
            error: function (e) {
                console.log(e);
                city.confirm('error', e);
            }
        });
    },

    confirm: function (action, data)
    {
        var obj, title, text, confirmButtonText, cancelButtonText;
        switch (action)
        {
            case 'create':
                obj = {
                    title: 'Post da cidade criado com sucesso',
                    text: 'Por padrão, esta cidade ainda não está sendo exibida no site. Deseja ativar sua exibição ou editar suas configurações?',
                    type: "success",
                    showCancelButton: true,
                    confirmButtonColor: '#a5dc86',
                    confirmButtonText: 'Ativar agora',
                    cancelButtonText: 'Editar configurações',
                    closeOnConfirm: true,
                    closeOnCancel: true
                };
                break;

            case 'update':
                if (data.edited) {
                    obj = {
                        title: 'Post da cidade alterado com sucesso',
                        type: "success",
                        confirmButtonColor: '#a5dc86',
                        confirmButtonText: 'OK!',
                        closeOnConfirm: true
                    };
                }else{
                    obj = {
                        title: '',
                        text: 'Nenhum erro, nenhuma alteração.',
                        type: "info",
                        confirmButtonColor: '#a5dc86',
                        confirmButtonText: 'OK!',
                        closeOnConfirm: true
                    };
                }
                break;

            case 'error':
                obj = {
                    title: 'Ops, Houve um erro!',
                    text: 'Tente novamente, se o erro persistir, entre em contato com o administrador do sistema.',
                    type: "error",
                    confirmButtonColor: '#2980b9',
                    confirmButtonText: 'ok',
                    closeOnConfirm: true
                };
                break;
        }

        swal
        (
            obj,
            function(isConfirm){
                if (action == 'create')
                {
                    if (isConfirm) {
                        city.action('activate');
                    }else{
                        window.location.href = '/painel/mundo/cidade/'+Script.screenJson.city.geonameId;
                    }
                }
                else if(action == 'update')
                {
                    window.location.href = '/painel/mundo/cidade/'+Script.screenJson.city_id;
                }
            }
        );
    }
};