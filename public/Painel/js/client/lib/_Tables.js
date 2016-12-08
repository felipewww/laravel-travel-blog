Tables = {
    paginate: function (paramns) {

        if ( paramns.tableID == undefined ) { paramns.tableID = 'mainTable' }
        if ( paramns.query == undefined ) { paramns.query = '' }

        $.ajax({
            method: 'post',
            dataType: 'json',
            data: { action: 'getTableAjax', pg: paramns.page, query: paramns.query },
            success: function (data) {
                Tables.writeTable(data, paramns.tableID);
                if (typeof paramns.onWrite == 'function') { paramns.onWrite(); }
            },
            error: function (data) {
                swal("Ops, houve um erro!", "Entre em contato com o Administrador do Sistema", "error");
                console.log(data);
            }
        })
    },

    writeTable: function (data, tableID) {
        var table = document.getElementById(tableID);

        if (table == undefined) {
            swal("Ops, houve um erro!", "Entre em contato com o Administrador do Sistema", "error");
            console.log('Não foi possivel encontrar a tabela com id: "'+tableID+'".');
            return false;
        }

        var parent = table.parentNode;

        //Remover Selects de paginação
        var selectsPagination = $(parent).find('div.pagination-box');

        $(selectsPagination).each(function () {
            parent.removeChild(this);
        });

        //Criar nova tabela e novos selects
        $(table).before(data.pagination);
        $(table).after(data.pagination);
        table.innerHTML = data.fulltable;

    }
};