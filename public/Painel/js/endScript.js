/*
* Tudo o que deve ser executado ao final de todos os script.
* */
$(document).ready(function () {
    endScript.init();
});

endScript = {
    init: function () {
        this.hideBlocks();
    },

    /*
    * Esconder blocos que tem a opção data-closed="true";
    *  Isso porque alguns JSs que trabalham com dimensões não conseguem calcular se o bloco estiver fechado
    * */
    hideBlocks: function () {
        var blocksInitClosed = $('section[data-closed="true"]');

        blocksInitClosed.each(function () {
            $this = $(this)[0];
            var content = $this.getElementsByClassName('content')[0];
            $(content).hide();
        });
    }
};