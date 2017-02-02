$(document).ready(function () {
    post.init();
});

post = {
    isAnotherPost: false,

    regions: {
        article_title: { required: true },
        article_content: { required: true },
    },

    content_default: null,
    title_default: 'O Título do Novo Post',

    init: function () {
        Script.store(this, 'regions');
        ContentToolsExtensions.editor._ignition.requiredRegions = post.requiredRegions;

        //Se não for edição. Definir conteudo defualt de RESET da tela
        if (Script.screenJson.post_id == undefined) {
            this.content_default = $('[data-name="article_content"]').html();
            this.setDefaultNewPost();
        }
    },

    setDefaultNewPost: function () {
        $('[data-name="article_title"]').html(this.title_default);
        $('[data-name="article_content"]').html(this.content_default);
    },

    /*
     * Funções executada no ONSAVE do ContentTools dinamicamente para salvar o post da cidade.
     * */
    create: function (ev)
    {
        this.mountRegions(ev.detail().regions);
        post.action('create', ev);
    },
    update: function (ev)
    {
        this.mountRegions(ev.detail().regions);
        post.action('update', ev);
    },

    action: function (action, ev)
    {
        if (action == 'create') {
            if (!this.validateRegions()) {
                return false;
            }
        }

        if (ev.detail().regions == null) {
            swal('Nenhuma alteração', 'Ok, nada foi alterado.', 'warning');
        }else{
            $.ajax({
                method: 'post',
                url: '/painel/api/blog/post/cidade',
                data: { regions: post.regions, _token: window.Laravel.csrfToken, screen_json: Script.screenJson, action: action },
                dataType: 'json',
                success: function (data) {
                    post.confirm(data.message, data)
                },
                error: function (e) {
                    post.confirm('error')
                }
            });
        }

        this.regions = Script.restore('regions');
    },

    mountRegions: function (evregions)
    {
        //Pegar regioes alteradas, salvar no objeto final e validar se for required.
        for (var regionName in evregions)
        {
            if (evregions.hasOwnProperty(regionName))
            {
                if (post.regions[regionName] == undefined) { post.regions[regionName] = {}; }
                post.regions[regionName].content = evregions[regionName];
                if (post.regions[regionName].required)
                {
                    post.regions[regionName].validated = true;
                }
            }
        }
    },

    validateRegions: function () {
        var hasError = false;

        //Ler objeto final e validar as configurações
        for(var region in post.regions)
        {
            if (post.regions.hasOwnProperty(region))
            {
                var cfg = post.regions[region];
                if (cfg.required && !cfg.validated)
                {
                    hasError = true;
                }
            }
        }

        if (hasError) {
            swal('Ops, Nada foi salvo!','Região '+region+' é obrigatório. Em caso de dúvidas, entre em contato com o administrador', 'error');
            return false;
        }

        return true;
    },

    confirm: function (action, data)
    {
        var obj;
        switch (action)
        {
            case 'create':
                obj = {
                    // title: 'Post da cidade criado com sucesso',
                    title: 'Post criado com sucesso!',
                    text: 'Por padrão, este post ainda não está sendo exibido no site. É necessário configurar algumas coisas antes como: Tags, Autor, status e etc. Deseja fazer isso agora?',
                    type: "success",
                    showCancelButton: true,
                    confirmButtonColor: '#a5dc86',
                    confirmButtonText: 'Configurar este post',
                    cancelButtonText: 'Criar novo',
                    closeOnConfirm: false,
                    closeOnCancel: true
                };
                break;

            case 'update':
                if (data.edited) {
                    obj = {
                        title: 'Post alterado com sucesso',
                        type: "success",
                        confirmButtonColor: '#a5dc86',
                        confirmButtonText: 'Legal!',
                        closeOnConfirm: true
                    };
                }else{
                    obj = {
                        title: '',
                        text: 'Nenhum erro, nenhuma alteração.',
                        type: "info",
                        confirmButtonColor: '#a5dc86',
                        confirmButtonText: 'fechar',
                        closeOnConfirm: true
                    };
                }
                break;

            case 'none':
                obj = {
                    // title: 'Post da cidade criado com sucesso',
                    title: '',
                    text: 'Não houve nenhuma alteração.',
                    type: "warning"
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
                    if (isConfirm)
                    {
                        window.location.href='/painel/blog/post/'+Script.screenJson.id;
                    }
                    else
                    {
                        //Reset view para NOVO POST
                        post.setDefaultNewPost();
                    }
                }
            }
        );
    }
};