Selectable = {
    init: function ()
    {
        this.tables = document.getElementsByClassName('selectable');

        var i = 0;
        while (i < this.tables.length)
        {
            var table = this.tables[i];
            this.cfg(table);
            i++;
        }
    },

    cfg: function (table)
    {
        var trs = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        var i = 0;
        while (i < trs.length)
        {
            var tr = trs[i];
            this.setup(tr);
            i++;
        }
    },

    setup: function (tr)
    {
        tr.onclick = function () {
            if ( this.getAttribute('data-selected') ) {
                this.removeAttribute('data-selected')
            }else{
                this.setAttribute('data-selected', 'true');
            }
        }
    },

    action: function (table_id, action)
    {
        var table = document.getElementById(table_id);
        var selecteds = $(table).find('[data-selected="true"]');

        var ref = table.getAttribute('data-columnref');
        var url = table.getAttribute('data-action');

        var data = { action: action, ids: {} };
        var i = 0;
        while (i < selecteds.length)
        {
            var tr = selecteds[i];
            //ID sempre sera na segunda coluna, dentro de um AHREF, com CERQUILHA NA FRENTE
            var id = tr.getElementsByTagName('td')[1].getElementsByTagName('a')[0].innerHTML.split('#')[1];
            data.ids[i] = id;
            i++;
        }

        if ( i == 0 ) {
            swal("Ops!", "Selecione ao menos um registro da tabela", "warning");
            return false;
        }

        swal
        (
            {
                title: "Você tem certeza?",
                text: "Quer deletar "+i+" registros? Isso não poderá ser desfeito.",
                type: "info",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Sim, deletar!',
                cancelButtonText: "Não, cancelar.",
                closeOnConfirm: false,
                closeOnCancel: true
            },
            function(isConfirm){
                if (isConfirm)
                {
                    $.ajax({
                        url: url,
                        method: 'post',
                        data: data,
                        dataType: 'json',
                        success: function (data) {
                            if (data.status) {
                                $(selecteds).each(function () {
                                    var tr = $(this)[0];
                                    tr.parentNode.removeChild(tr);
                                    //$(this).hide();
                                });
                                callbackMsgs('success');
                            }
                            else{
                                callbackMsgs('error');
                                console.log(data);
                            }
                        },
                        error: function (data) {
                            console.log(data);
                            callbackMsgs('error');
                        }
                    });
                }
            }
        );

        function callbackMsgs(type) {
            if ( type == 'cancel' )
            {
                swal("Ok, Nada foi feito!", "os registros não foram excluídos", "success");
            }
            else if( type == 'success' )
            {
                swal("Concluído", "Registros excluídos com sucesso!", "success");
            }
            else if( type == 'error' )
            {
                swal("Ops, houve um erro!", "Entre em contato com o Administrador do sistema", "error");
            }
        }
    }
};