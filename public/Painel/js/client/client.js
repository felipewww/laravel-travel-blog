Client = {
    init: function () {
        _Forms.init();
        _Menu.init();
        Multaction.init();
        DataTablesExtensions.init();
        Tooltip.init();

        jQuery('.scrollbar-inner').scrollbar();
    }
};