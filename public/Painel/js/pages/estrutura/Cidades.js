$(document).ready(function () {
    Cidades.init();
});

Cidades = {
    init: function () {
        this.vars();
        this.setupSelectPagination();

        $("#sortable").sortable({
            revert: true
        });
    },

    vars: function () {
        this.selectPages = $('select.pagination');
    },

    setupSelectPagination: function ()
    {
        $('select.pagination').each(function () {
            $(this).on('change', function () {

                Tables.paginate({
                    page: this.children[this.selectedIndex].value,
                    query: this.getAttribute('data-json-search'),
                    onWrite: function () {
                        Cidades.setupSelectPagination();
                    }
                });

            })
        });
    }
};