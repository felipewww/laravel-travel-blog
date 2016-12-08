_Menu = {
    menu_sidebar:   null,
    menu:           null,

    init: function ()
    {
        this.menu_sidebar   = document.getElementById('menu-sidebar');
        this.menu           = this.menu_sidebar.getElementsByClassName('menu')[0];
        this.btn_modulos    = this.menu.getElementsByClassName('has-submenu');//this.menu.getElementsByTagName('span');
        
        this.config();
    },
    
    /*
     * Configurar itens do menu que possuem SUBMENU
     * */
    config: function ()
    {
        var i = 0;
        while (i < this.btn_modulos.length)
        {
            var btn = this.btn_modulos[i];
            CfgOnClick(btn);
            i++;
        }

        function CfgOnClick(btn)
        {
            var arrow = Script.createElement('span', '', { class: 'flaticon-keyboard-right-arrow-button' });

            btn.appendChild(arrow);
            btn.onclick = function ()
            {
                var parent = this.parentNode;
                var nextUL = parent.getElementsByTagName('ul')[0];
                //nextUL.style.display = 'block';
                $(nextUL).slideToggle(500);
            }
        }
    }
};