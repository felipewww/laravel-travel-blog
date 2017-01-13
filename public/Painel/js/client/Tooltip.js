Tooltip = {
    init: function () {
        this.div = document.getElementById('tooltip');

        this.setup();
    },

    setup: function ()
    {
        this.hasTooltip = document.getElementsByClassName('hasTooltip');
        var i = 0;
        while (i < this.hasTooltip.length)
        {
            var item = this.hasTooltip[i];
            if ( !validation(item) ) {
                alert('Atenção programador. O elemento com BORDER RED da tela que possui TOOLTIP nao tem o texto correto ou o atributo data-tooltip-str');
                item.style.border = '2px solid red';
                return false;
            }else{
                Tooltip.cfg(item);
            }
            i++;
        }

        function validation(item) {
            var tooltipstr = item.getAttribute('data-tooltip-str');

            if ( tooltipstr == undefined || tooltipstr == '' ) {
                return false;
            }else{
                return true;
            }
        }
    },

    setStr: function (element) {
        Tooltip.div.getElementsByClassName('tooltip-content')[0].innerHTML = element.getAttribute('data-tooltip-str');
    },

    cfg: function (item)
    {
        item.addEventListener('mouseenter', function () {
            //Se o elemento que tem tooltip ja possui position,nao mudar essa configuração para nao quebrar layout
            style = window.getComputedStyle(this);
            var curPos = style.getPropertyValue('position');
            if ( curPos != 'fixed' && curPos != 'absolute' ) {
                this.style.position = 'relative';
            }

            //Inserir o texto do tooltip
            Tooltip.setStr(this);
            item.appendChild(Tooltip.div);

            //Apos inserir o elemento, exibir com visibility hidden para pegar o WIDTH e calcular o ponto central com margem negativa
            Tooltip.div.style.visibility = 'hidden';
            Tooltip.div.style.display = 'block';
            Tooltip.div.style.marginLeft = ((Tooltip.div.clientWidth/2) *-1) + 'px';
            Tooltip.div.style.visibility = 'visible';

        });

        item.addEventListener('mouseleave', function () {
            Tooltip.div.style.display = 'none';
        })
    }
};