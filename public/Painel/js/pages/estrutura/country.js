country = {
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
        var table = document.createElement('table');
        var where = document.getElementById('dynamic_table');
        where.innerHTML = '';
        where.appendChild(table);

        var cols = data.cols;
        DataTablesExtensions.__dataTablesExec(table, info, cols, {});
        Script.anchorScroll('#cidades');
    },

    createPost: function () {

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

    createCountryPage: function ()
    {
        swal({
            title: '',
            text: 'Criação de páginas do pais indisponível.',
            type: 'warning'
        });
    },

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

    verifyAuthorAndActive: function () {

    }
};