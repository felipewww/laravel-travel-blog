country = {
    regions: {
        article_content: { required: true }
    },

    selectedCity: { },
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

    findACity: function () {
        Script.loader('show');
        var form = document.forms.findACityForm;
        var cityName = form.cityname.value;

        $.ajax({
            url: '/painel/api/mundo/pais/findACity',
            data: { cityName: cityName, countryCode: Script.screenJson.country.iso_2 },
            dataType: 'json',
            success: function (data) {
                country._renderCities(data, cityName);
                console.log(data);
            },
            error: function (e) {
                console.log('error!');
            },
            complete: function () {
                Script.loader('hide');
            }
        });
    },

    _renderCities: function (data, txtFound)
    {
        var info = JSON.parse(data.dataSource);
        var table = document.createElement('table');
        var where = document.getElementById('cities-table');
        where.innerHTML = '';
        where.appendChild(table);

        var cols = data.cols;
        DataTablesExtensions.__dataTablesExec(table, info, cols, {});
    },

    /**
    * DataTablesExtensions Callback
    * */
    loadInMap: function (event, button, attrs, dataTable, regId, allRowData)
    {
        // var info = JSON.parse(button.getAttribute('data-info'));
        var info = JSON.parse( document.getElementById('cityinfo_'+regId).innerHTML );
        this.selectedCity = info;
        this.selectedCity.changed = false;

        // console.log(info);
        var divMap = document.getElementById('newMap');
        divMap.style.height = '400px';

        var myLatLng = { lat: parseFloat(info.lat), lng: parseFloat(info.lng)};


        var map = new google.maps.Map(divMap, {
            zoom: 4,
            center: myLatLng
        });

        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            draggable:true,
            title: 'Hello World!'
        });

        google.maps.event.addListener(marker, 'dragend', function(data) {
            country.selectedCity.lat = data.latLng.lat();
            country.selectedCity.lng = data.latLng.lng();
            country.selectedCity.changed = true;
        })
    },

    /**
     * Botão de Ação
     * Salvar cidade encontrada no banco de dados
     * */
    saveSelectedCity: function (event, button, attrs, dataTable, regId, allRowData)
    {
        var info = JSON.parse( document.getElementById('cityinfo_'+regId).innerHTML );

        save = function () {
            Script.loader('show');
            country.selectedCity._token = window.Laravel.csrfToken;
            country.selectedCity.country_id = Script.screenJson.country.id;

            $.ajax({
                url: '/painel/mundo/cidade/create',
                method: 'post',
                data: country.selectedCity,
                dataType: 'json',
                success: function (data) {
                    console.log('success');
                    console.log(data);
                    if (data.status == false) {
                        swal({
                            title: 'Ops!',
                            text: data.message,
                            type: 'error'
                        });
                    }else{
                        swal({
                            title: 'Feito!',
                            text: 'Cidade cadastrada com sucesso!',
                            type: 'success'
                        }, function (isConfirmed) {
                            window.location.reload();
                        });
                    }
                },
                error: function (data) {
                    swal({
                        title: 'Ops. Houve um erro inesperado.',
                        text: 'Entre em contato com o administrador do sistema.',
                        type: 'error'
                    });
                },
                complete: function () {
                    Script.loader('hide');
                }
            });
        };


        if (this.selectedCity.changed) {
            swal({
                title: 'LatLong alterada',
                text: 'Você alterou a latitude e longitude desde cidade. Deseja salvar com estas alterações?',
                type: 'info',
                confirmButtonText: 'Confirmar e salvar',
                cancelButtonText: 'Cancelar e reverter',
                confirmButtonColor: '#a3b963',
                cancelButtonColor: '#b94554',
                showCancelButton: true,
                closeOnCancel: true,
                closeOnConfirm: true
            }, function (isConfirm) {
                if (isConfirm) {
                    //Timeout para poder fechar o SWAL atual e depois abrir o novo, se não da pau!
                    setTimeout(function () {
                        save();
                    },500)
                }else{
                    country.selectedCity = info;
                    country.selectedCity.changed = false;
                }
            });
        }else{
            if ( country.selectedCity.changed == undefined ) {
                country.selectedCity = info;
            }

            save();
        }
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
                country.done();
            },
            error: function (e) {
                // console.log(e);
                // city.confirm('error', e);
            }
        });
    },

    update: function (ev)  { ContentToolsExtensions.mountRegions(ev.detail().regions, city.regions); city.action('update'); },

    done: function () {
        swal({
            title: 'Feito!',
            text: 'Página do país atualizada com sucesso!',
            type: 'success'
        });
    }
};