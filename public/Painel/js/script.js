$(document).ready(function() {
	Script.init();

    //Previnir submit com ENTER
    $(window).keydown(function(event){
        if(event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });
});


Script = {

    //Getbyid representativo, não funciona
    submitValidator: false,
    clickToEnable: {},

	init: function () {
        this.responseajax   = document.getElementById("responseajax");
        this.loading        = document.getElementById("loading");

        this.todayDate();
        this.actionMessage();
        this.setMasks();
        Tooltip.init();

        //Plugins
        Client.init();
    },

    setMasks: function()
    {
        $('.mask-moeda').mask('0000.00', {reverse: true});
        $('.mask-percent').mask('00.00', {reverse: true});
    },

    loadingGif: function(act)
    {
        if (act == 'show')
        {
            $(Script.loading).fadeIn();
        }
        else
        {
            $(Script.loading).fadeOut();
        }
    },

    actionMessage: function ()
    {
        /*
        * Essa DIV é escrita dinamicamente pelo PHP (HeadBase) e seu conteudo será um JSON
        * Só é retornado após alguma ação do CRUD para exibir msgs personalizadas
        * */
        var message = document.getElementById("scriptmessage");
        ( message != undefined ) ? exibeMensagem(message): false;

        function exibeMensagem(div)
        {
            var obj = JSON.parse(div.innerHTML);

            var paramns = {
                tabela: obj.tabela,
                id: obj.id,
                coluna: obj.coluna,
                apelido: obj.apelido,
                action: obj.action,
                deleted: obj.deleted
            };

            $.ajax({
                type: "post",
                url: "",
                data: { setSystemRoute: 'ajaxfunc', act: 'unsetScript', paramns: paramns },
                dataType: 'json',
                success: function (data)
                {
                    Script.showResponseAjax(data.titulo, data.content);
                },
                error: function (erro)
                {
                    console.log(erro);
                    Script.showResponseAjax("UNSETSCRIPT FALHOU!", "Entre em contato com o administrador do sistema.", { cssclass: 'error' });
                }
            });
        }
    },

    showResponseAjax: function (title, content, paramns)
    {
        if (paramns == undefined) { paramns = {}; }
        if (paramns.cssclass != undefined) { Script.responseajax.setAttribute("class", paramns.cssclass); }

        var T = document.getElementById("ra_titulo");
        var C = document.getElementById("ra_content");

        T.innerHTML = title;
        C.innerHTML = content;

        $(Script.responseajax).show('bounce', {}, 1000);

        setTimeout(function () {
            $(Script.responseajax).hide('bounce', {}, 700, function () {
                Script.responseajax.removeAttribute("class");
            });
        },6000);
    },

    //Validador da lightbox para executar evento HISTORY.BACK ou não... Geralmente usado para requisições AJAX para não executar history.back()
    goBack: true,

    dynamicClick: function(bt, element)
    {
        bt.addEventListener('click', function () {
            element.click();
        });
    },

    validateDate: false,
    todayDate: function()
    {
        if (Script.validateDate == false)
        {
            obj = {
                day: null,
                month: null,
                dayNumber: null,
                y: null,
                h: null,
                m: null,
                s: null,
                validateDate: false,
                theDate: null
            };

            obj.theDate = new Date();

            //função de teste de datas personalziadas
            //Script.testDate();
            var dia = { 0: "Domingo",  1:"Segunda-feira",  2:"Terça-feira",  3:"Quarta-feira",  4:"Quinta-feira",  5:"Sexta-feira",  6:"Sábado" };
            obj.day = dia[obj.theDate.getDay()];

            var mes = { 0: "Janeiro", 1: "Fevereiro", 2: "Março", 3: "Abril", 4: "Maio", 5:"Junho", 6:"Julho", 7:"Agosto", 8:"Setembro", 9:"Outubro", 10: "Novembro", 11: "Dezembro" };
            obj.month = mes[obj.theDate.getMonth()];


            obj.dayNumber   = obj.theDate.getDate();
            obj.y           = obj.theDate.getFullYear();

            //obj.theDate.setHours("23");
            obj.h           = obj.theDate.getHours();
            obj.h           = verifyZero(obj.h);

            //obj.theDate.setMinutes("59");
            obj.m           = obj.theDate.getMinutes();
            obj.m           = verifyZero(obj.m);

            obj.s           = obj.theDate.getSeconds();
        } //fecha if

        obj.s = parseInt(obj.s)+1;
        obj.s = verifyZero(obj.s);

        //Se os SEGUNDOS chegarem a 59, verificar MINUTOS, se tbm for 59, verificar horas, SE for 24, remontar novo DATE
        if (obj.s == 60)
        {
            obj.m = parseInt(obj.m)+1;
            obj.m = verifyZero(obj.m);

            obj.s = "00";

            if (obj.m == 60)
            {
                obj.h = parseInt(obj.h)+1;
                obj.h = verifyZero(obj.h);

                obj.m = "00";

                if (obj.h == 24 && obj.m == "00" && obj.s == "00")
                {
                    Script.validateDate = false;
                    setTimeout(Script.todayDate,1);
                    return;
                } // if HORAS
            } //if MINUTOS
        }//if SEGUNDOS

        function verifyZero(t)
        {
            if (t.toString().length == 1)
            {
                t = "0"+t;
            }

            return t;
        }

        //document.getElementById("horas").innerHTML= obj.day+", "+obj.dayNumber+" de "+obj.month+" de "+obj.y+" - "+obj.h+":"+obj.m+":"+obj.s;

        Script.validateDate = true;
        setTimeout(Script.todayDate,1000);
    },

    foto: null,
    parent: null,

    handleFileSelect: function(e, id)
    {
        //parent = document.getElementById(parent);
        Script.parent = e.parentNode;

        var files = e.files; // FileList object
        var f = files[0];

        //Se não for imagem, sair!
        if(f.type.search("image") < 0){ return false; }

        var reader = new FileReader();
        reader.readAsDataURL(f);

        reader.onload=function(f)
        {
            //Preload da imagem
            Script.foto = new Image();
            Script.foto.src = f.target.result;

            //Timeout para carregar e pegar dimensões da imagem
            tm = setTimeout(function(){ Script.getImgSize(id); },1);
        }
    },

    getImgSize: function(id)
    {
        var w = Script.foto.width;

        if (w == 0)
        {
            tm = setTimeout(function(){ Script.getImgSize(); },1000);
        }
        else
        {
            Script.foto.style.maxHeight="300px";

            var defaultimg = document.getElementById(id);
            var img = defaultimg.getElementsByTagName("img")[0];

            defaultimg.removeChild(img);

            defaultimg.appendChild(Script.foto);
            clearTimeout(tm);
        }
    },

    createElement: function (element, innerHTML, attrs)
    {
        if (typeof attrs != 'object') { attrs = {} }

        var e = document.createElement(element);
        e.innerHTML = innerHTML;

        for(attr in attrs)
        {
            e.setAttribute(attr, attrs[attr]);
        }

        return e;
    },

    Random: function (end, start) {
        if ( start == undefined ) { start = 1; }
        if ( end == undefined ) { end = 100; }

        return Math.floor(Math.random() * end) + start;
    },

};