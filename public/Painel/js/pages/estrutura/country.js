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
                render(data);
            },
            error: function (e) {
                console.log('error!');
            }
        });

        function render(data)
        {
            var blockCities = $('#cidades');
            $(blockCities).find('div.title span:first-child').html('CIDADES DE '+allRowData[2]);

            var info = JSON.parse(data.dataSource);
            var table = document.createElement('table');
            var where = document.getElementById('dynamic_table');
            where.innerHTML = '';
            where.appendChild(table);

            var cols = data.cols;
            DataTablesExtensions.__dataTablesExec(table, info, cols, {});
            Script.anchorScroll('#cidades');
        }
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

    createCityPost: function () {

    }
};