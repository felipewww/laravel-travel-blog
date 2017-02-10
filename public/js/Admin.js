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
    countryInfo:
    {
        /**
         * Ler cidades de um condado, caso quando carregar cidades de um estado, sejam condados! Exemplo: Flórida
         * EX: master.functions.countryInfo.readCityFromCounty('florida', 4155751, 'Orange County', 4167060);
         **/
        readCityFromCounty: function (estate, estate_id, county, county_id)
        {
            $.ajax({
                url: '/painel/api/mundo/pais/readCountyCities',
                data: { estate: estate, county: county, id: estate_id, county_id: county_id },
                dataType: 'json',
                success: function (data) {
                    country.renderCities(data, estate);
                },
                error: function (e) {
                    console.log(e);
                    console.log('error!');
                }
            });
        }
    }
};

(function () {
    master.init();
})();