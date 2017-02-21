master =
{
    functions: null,
    pathname: null,
    explodepath: null,//

    init: function ()
    {
        this.pathname       = window.location.pathname;
        this.explodepath    = window.location.pathname.split('/');

        if (this.explodepath[1] == 'painel') {
            master.functions = this.painel();
            this.routes();
        }
    },

    routes: function () {
        //TODO
    },

    help: function () {
        //todo
    },

    painel: function () { return AdminPainelFuncs; }
};

var AdminPainelFuncs =
{
    password: null,
    countryInfo:
    {
        isTest: true,
        /**
         * Ler cidades de um condado, caso quando carregar cidades de um estado, sejam condados! Exemplo: Flórida
         * EX: master.functions.countryInfo.readCityFromCounty('florida', 4155751, 'Orange County', 4167060);
         *
         * No caso do Canada é diferente.
         * Se pegamos a PROVINCIA Alberta, ela carrega apenas um Estado. As cidades de Alberta são considerados
         * como PPL (Populated Places e não como cidades (children), por isso foi criado o FORCE.
         *
         * Se não encontrar children do estado/condado, buscar todos os PPL (populated places) de um determinado
         * PAIS > CONDADO. dúvida, ver sobre PPL geonames.org
         **/
        readCityFromCounty: function (estate, estate_id, county, county_id, force)
        {
            if (force) {
                paramnsToForce = {};
                paramnsToForce.countryCode = Script.screenJson.country.iso_2;
                paramnsToForce.countyName = estate;
            }else{
                paramnsToForce = false;
            }

            $.ajax({
                url: '/painel/api/mundo/pais/readCountyCities',
                data: {
                    estate: estate, county: county, id: estate_id, county_id: county_id,
                    password: AdminPainelFuncs.password,
                    force: paramnsToForce,
                    isTest: AdminPainelFuncs.countryInfo.isTest
                },
                dataType: 'json',
                success: function (data) {
                    // console.log(data);
                    country.renderCities(data, estate);
                },
                error: function (e) {
                    console.log(e);
                    console.log('error!');
                }
            });
        },

        /*
        *
        * */
        // readCityFromCountyForce: function (estate, estate_id, county, county_id)
        // {
        //     $.ajax({
        //         url: '/painel/api/mundo/pais/readCountyCities',
        //         data: { estate: estate, county: county, id: estate_id, county_id: county_id },
        //         dataType: 'json',
        //         success: function (data) {
        //             console.log(data);
        //             country.renderCities(data, estate);
        //         },
        //         error: function (e) {
        //             console.log(e);
        //             console.log('error!');
        //         }
        //     });
        // }
    }
};

(function () {
    master.init();
})();