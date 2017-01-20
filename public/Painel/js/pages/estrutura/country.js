country = {
    /**
     * @see DataTablesExtensions.js
    * função de "rowCallback" executada via EVAL() na montagem do dataTables
    * */
    findCities: function (event, button, attrs, dataTable, regId, allRowData) {
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

        // function render(data)
        // {
        //     var blockCities = $('#cidades');
        //     $(blockCities).find('div.title span:first-child').html('CIDADES DE '+allRowData[2]);
        //
        //     var info = JSON.parse(data.dataSource);
        //     var table = document.createElement('table');
        //     var where = document.getElementById('dynamic_table');
        //     where.innerHTML = '';
        //     where.appendChild(table);
        //
        //     var cols = data.cols;
        //     DataTablesExtensions.__dataTablesExec(table, info, cols, {});
        //     Script.anchorScroll('#cidades');
        // }
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

    __showCitiesTable: function (data)
    {
        // var table = document.createElement('table');
        // $(table).DataTable({
        //     data: data,
        //     cols: ['n', 'id', 'nome', 'ações'],
        // });
    },

    createPost: function () {

    },

    createCityPost: function (e) {
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
                action: '/blog/cidade',
                method: 'post'
            }
        );
    }
};