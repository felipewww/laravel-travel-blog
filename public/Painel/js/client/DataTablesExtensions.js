DataTablesExtensions = {
    init: function ()
    {
        var tables = $('.setDataTables');
        tables.each(function (){
            var paramns = {};
            paramns.columnDefs = [];

            var table = $(this);
            var data = table.find('td.info')[0];
            var columns = table.find('td.columns');

            //Criar tabela
            DataTablesExtensions.__dataTablesExec(
                table,
                JSON.parse(data.innerHTML),
                JSON.parse(columns.html()),
                paramns
            );
        });

    },

    __dataTablesExec: function (table, data, cols, paramns) {
        ( paramns == undefined ) ? paramns = {} : null;
        ( paramns.columnDefs == undefined ) ? paramns.columnDefs = '' : 'null';

        var colIdPosition = findColId(cols);

        T = $(table).DataTable({
            data: data,
            columnDefs: paramns.columnDefs,
            columns: cols,
            keys: true,
            select: true,
            language: DataTablesExtensions.__dataTablesLanguage(),
            dom: 'lftip',
            rowCallback: function (TRHtmlCollection, jsArray, i) {
                isConfigObject(TRHtmlCollection, jsArray, jsArray[colIdPosition]);
            }
        });

        //Encontrar a posição da coluna que representa o ID do registro
        function findColId(cols) {
            for(var n in cols)
            {
                var obj = cols[n];
                if (obj.title == 'id') {
                    return n;
                }
            }
        }

        function isConfigObject(tr, array, rowRegId)
        {
            /*
            * Varrer as celulas, se alguma for JSOBJECT, signifca que exige uma configuração
            * especial para o HTML que será exibido
            */
            for(var celula in array)
            {
                var obj = array[celula];
                if (typeof obj == 'object')
                {
                    /*
                    * Cada nome de objeto deve ter uma configuração.. encontrar esse nome e executar a função dinamicamente
                    * */
                    for(Type in obj){ eval('DataTablesExtensions.__objcfg_'+Type+'(tr, obj, celula, $(this), rowRegId, array);'); }
                }
            }
        }
    },

    /*
    * HTML  = TR e TDS em estrutra html
    * OBJ   = objeto json que contem as informações de configuação
    * IDX   = Posição da celula (TD) dentro da TR (html)
    * */
    __objcfg_rowButtons: function (tr, obj, idx, dataTable, rowRegId, allRowData)
    {
        //Pode haver mais objetos de configuração dentro do mesmo objeto... pegar exatamente rowButtons.
        var rowButtons = obj.rowButtons;

        //encontrar a TD e limpar o html
        var e = $(tr).find('td')[idx];
        $(e).html('');

        var i = 0;
        while (i < rowButtons.length)
        {
            var btn = rowButtons[i];

            var newBtn = Script.createElement('a', btn.html, btn.attributes);
            if ( hasListener(btn.attributes) ) {
                cfgButtonListener(newBtn, btn.attributes, dataTable, rowRegId, allRowData);
            }

            e.appendChild(newBtn);
            i++;
        }

        function hasListener(attrs) {
            var has = false;
            for(var attr in attrs)
            {
                if (attr == 'data-jslistener-click') { has = true }
            }

            return has;
        }

        function cfgButtonListener(button, attrs, dataTable, rowRegId, allRowData) {
            //TODO - configurado apenas para data-listener-click

            var func = attrs['data-jslistener-click'];

            try{
                var e = typeof eval(func);
            }catch (e){
                throw new DevError('A função "'+func+'()" especificada em: Controller/DataTablesConfig não existe', e);
            }

            button.addEventListener('click', function (event) {
                eval(func+"(event, this, attrs, dataTable, rowRegId, allRowData);");
            });
        }
    },

    __objcfg_image: function (tr, obj, idx, dataTable, rowRegId, allRowData)
    {
        var image = obj.image;
        //var src = '/Site/media/images/autores/cortella.jpg';

        //encontrar a TD e limpar o html
        // console.log(image);
        var e = $(tr).find('td')[idx];
        $(e).html('');

        // if (image.src != undefined) {
        //     console.log('ler foto');
        //     src = image.src;
        // }

        var imgTag = Script.createElement('div', '', { class: 'photo-table' }, { backgroundImage: 'url('+image.src+')' });
        // var imgTag = Script.createElement('div', '', { class: 'photo' }, { backgroundImage: 'url("'+src+'");' });
        $(e).html(imgTag);
    },

    __objcfg_bgColor: function (tr, obj, idx, dataTable, rowRegId, allRowData)
    {
        console.log(allRowData);
        cfg = obj.bgColor;

        var rgbString = allRowData[idx].bgColor;

        var e = $(tr).find('td')[idx];
        $(e).html('');

        var divColor = Script.createElement('div', '', {}, {
            width: '50px',
            height: '10px',
            backgroundColor: rgbString,
            display: 'inline-block',
            marginRight: '25px',
            opacity: 0.5,
            float: 'left'
        });

        var divText = Script.createElement('div', rgbString,
            {
                class: 'colorText',
            },
            {
                float: 'left'
            }
        );

        $(e).append(divColor);
        $(e).append(divText);

        // $(e).css("backgroundColor", rgbString);
        // $(e).css("opacity", 0.5);
    },

    /*
    * função de exemplo para explicar formas de callBack setados no PHP
    * */
    __objcfg_anotherObject: function ()
    {
        //console.log('Another object here...');
    },

    __dataTablesLanguage: function ()
    {
        return {
            info: "Exibindo de _START_ até _END_ de _TOTAL_ registros",
            paginate: {
                previous: "anterior",
                next: "próxima",
            },
            infoFiltered: " - Filtro no total de _MAX_ registros",
            search: 'Pesquisar:',
            lengthMenu: 'Exibir <select>'+
            '<option value="10" selected>10</option>'+
            '<option value="20">20</option>'+
            '<option value="20">30</option>'+
            '<option value="20">40</option>'+
            '<option value="50">50</option>'+
            '<option value="-1">Todos</option>'+
            '</select> por página'
        }
    },

    // dataTablesPostAction: function (IDColumnsPosition)
    // {
    //     IDColumnsPosition = (IDColumnsPosition == undefined) ? 2 : IDColumnsPosition;
    //
    //     var form = document.createElement('form');
    //     form.method = 'post';
    //     //form.action = 'teste.html';
    //     //form.submit();
    // },
};