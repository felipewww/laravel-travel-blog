$(document).ready(function () {
    city.init();
});

city = {
    init: function () {
        if (Script.screenJson.isPainel) {
            city.painel.init();
        }
    },

    painel: {
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
        }
    },

    /*
    * Funções executada no ONSAVE do ContentTools dinamicamente para salvar a PÁGINA da cidade.
    * */
    create: function (ev)  { city.action('create'); },
    update: function (ev)  { city.action('update'); },

    action: function (action)
    {
        var html = document.getElementById('the-article').innerHTML;
        $.ajax({
            method: 'post',
            url: '/painel/api/blog/cidade/save/'+Script.screenJson.city.geonameId,
            data: { html: html, _token: window.Laravel.csrfToken, screen_json: Script.screenJson, action: action },
            dataType: 'json',
            success: function (data) {
                if (action == 'activate') { window.location.href = '/cidade/'+data.ascii_name+'/'+Script.screenJson.city.geonameId; }
                city.confirm(action, data);
            },
            error: function (e) {
                console.log('Error');
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
                obj = {
                    title: 'Post da cidade alterado com sucesso',
                    type: "success",
                    confirmButtonColor: '#a5dc86',
                    confirmButtonText: 'OK!',
                    closeOnConfirm: true
                };
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