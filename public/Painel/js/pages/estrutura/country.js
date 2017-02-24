country = {
    regions: {
        article_content: { required: true }
    },

    /**
     * mudar o status de 0,1 para "ativo, inativo" quando lê cidades cadastradas no banco
     */
    changeRegisteredCityStatus: function (tr, array, rowRegId, idx) {
        var td = tr.getElementsByTagName('td')[idx];
        var status;
        // console.log(td);
        switch (td.innerHTML)
        {
            case '1':
                status = 'ativo';
                break;

            case '0':
                status = 'inativo';
                break;

            /*
            * Quando tentar ordenar a tabela, ele recarrega tudo, inclusive esta função de rowCallback.
            * */
            default:
                status = td.innerHTML;
                break;
        }

        td.innerHTML = status;
    },
    /**
     * @see DataTablesExtensions.js
    * função de "rowCallback" executada via EVAL() na montagem do dataTables
    * */
    findCities: function (event, button, attrs, dataTable, regId, allRowData)
    {
        // $("#dynamic_table").html('');

        $.ajax({
            url: '/painel/api/mundo/pais/readCities',
            data: { id: regId, name: allRowData[2] },
            dataType: 'json',
            success: function (data) {
                //render(data);
                country.renderCities(data, allRowData[2]);
            },
            error: function (e) {
                console.log('error!');
            }
        });
    },

    renderCities: function (data, estateName)
    {
        var blockCities = $('#cidades');
        $(blockCities).find('div.title span:first-child').html('CIDADES DE '+estateName);

        var info = JSON.parse(data.dataSource);
        console.log(info);
        var table = document.createElement('table');
        var where = document.getElementById('dynamic_table');
        where.innerHTML = '';
        where.appendChild(table);

        var cols = data.cols;
        DataTablesExtensions.__dataTablesExec(table, info, cols, {});
        Script.anchorScroll('#cidades');
    },

    beforeConfig: function (event, button, attrs, dataTable, regId, allRowData) {
        //alert("ops, esta ciadde não existe");
        swal
        (
            {
                title: 'Ops! Cidade não cadastrada',
                text: 'Esta cidade ainda não esta cadastrada no banco de dados. Para ver e editar suas configurações é necessário criar uma página da cidade ou post de blog.',
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#F8BE86',
                confirmButtonText: 'Fechar',
                cancelButtonText: 'Criar página',
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function(isConfirm){
                if (!isConfirm ) {
                    var parent = button.parentNode;
                    var createPageButton = parent.getElementsByClassName('createPage')[0];
                    createPageButton.click();
                }
            }
        );

    },

    createCountryPost: function () {
        Script.unable('Criação de Posts do pais indisponível.');
    },

    createCountryPage: function ()
    {
        Script.unable('Criação de páginas do pais indisponível.');
    },

    /*
     * Funções executada no ONSAVE do ContentTools dinamicamente para salvar a PÁGINA da cidade.
     * */
    createOrUpdateCountryPage: function (ev)
    {
        ContentToolsExtensions.mountRegions(ev.detail().regions, country.regions);
        if (!ContentToolsExtensions.validateRegions(country.regions)) {
            return false;
        }

        $.ajax({
            method: 'post',
            data: { content_regions: country.regions, _token: window.Laravel.csrfToken, screen_json: Script.screenJson, action: 'createOrUpdateCountryPage' },
            dataType: 'json',
            success: function (data) {
                // if (action == 'activate') { window.location.href = '/cidade/'+data.ascii_name+'/'+Script.screenJson.city.geonameId; }
                // city.confirm(action, data);
            },
            error: function (e) {
                // console.log(e);
                // city.confirm('error', e);
            }
        });
    },
    // update: function (ev)  { ContentToolsExtensions.mountRegions(ev.detail().regions, city.regions); city.action('update'); },

    createCityPage: function (e, paramns)
    {
        if (paramns == undefined) { paramns = {} }

        //Default para criar a página principal da cidade
        var action = e.getAttribute('data-action');

        var json = JSON.parse(e.getAttribute('data-post'));

        var i = 0;
        var estates = Script.screenJson.estates;

        while (i < estates.length)
        {
            var estate = estates[i];

            if (estate.geonameId == json.estate_id) {
                var selectedEstate = estate;
                break;
            }

            i++;
        }

        var POST = { estate: selectedEstate, country: Script.screenJson.country, city: json.city };

        Script.sendPost(
            POST,
            {
                target: '_blank',
                action: action,
                method: 'post'
            }
        );
    },
};