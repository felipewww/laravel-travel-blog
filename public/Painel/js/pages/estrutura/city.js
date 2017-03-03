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

        // verifyAuthorAndActivePost: function (post_id, author_id) {
        //     var obj;
        //     if (author_id == '') {
        //         obj = {
        //             title: 'Ops!',
        //             text: 'Este post não pode ser ativado pois ainda não possui as configurações básicas. Vá para "Configurações"',
        //             type: "warning",
        //             // showCancelButton: true,
        //             confirmButtonColor: '#a5dc86',
        //             confirmButtonText: 'Entendi',
        //             // cancelButtonText: 'Editar configurações',
        //             closeOnConfirm: true,
        //             // closeOnCancel: true
        //         }
        //     }else{
        //         obj = {
        //             title: 'Ops!',
        //             text: 'Função indisponível no sistema no momento. Entre em contato com o administrador.',
        //             type: "info",
        //             // showCancelButton: true,
        //             confirmButtonColor: '#a5dc86',
        //             confirmButtonText: 'Entendi',
        //             // cancelButtonText: 'Editar configurações',
        //             closeOnConfirm: true,
        //             // closeOnCancel: true
        //         }
        //     }
        //     swal(obj);
        // },
        //
        // inactivePost: function () {
        //     swal({
        //         title: 'Ops!',
        //         text: 'Função indisponível no sistema no momento. Entre em contato com o administrador.',
        //         type: "info",
        //         confirmButtonColor: '#a5dc86',
        //         confirmButtonText: 'Entendi',
        //         closeOnConfirm: true
        //     });
        // },

        activeOrDeactiveCity: function (action)
        {

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
            // url: '/painel/api/blog/cidade/save/'+id,
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