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

function AjaxExceptions(data){
    var msg = 'Erro de Requisição ajax';

    if (data.responseJSON == undefined) {
        msg = 'Requisição não retornou um JSON. Verifique o backend.';
    }

    this.message    = msg;
    this.name       = 'AjaxExceptions';
    this.response   = data;

    return this.message;
}

function DevError(msg, obj) {
    //console.error(msg, obj);
    this.message = msg;
    this.e = obj;
    return this;
}

Script = {
    stored: {},
    pageScript: [],
    submitValidator: false,
    clickToEnable: {},


    //Iniciar funções em comum entre "painel" e "site"
	init: function () {

        this.todayDate();
        this.getScreenJson();
        this.PostMessage();

        //Código criado por ARDUO para extensões ou plugins do PAINEL.
        Client.init();
    },

    PostMessage: function ()
    {
        $msg = $('#PostMessage');
        // alert($msg[0]);
        // if ( this.screenJson.PostMessage != undefined )
        if ( $msg[0] )
        {
            var text, title, type;
            // var msg = this.screenJson.PostMessage;
            var msg = JSON.parse($msg.html());

            switch (msg.type)
            {
                case undefined:
                    msg.type = 'error';
                    title = 'Falta TYPE!';
                    text = 'Dev. Coloque o status(TYPE) do PostMessage';
                    break;

                case 'info':
                    title   = (msg.title == undefined) ? 'Info' : msg.title;
                    text    = (msg.text == undefined) ? 'Parece que algo deu errado. Entre em contato com o administrador.' : msg.text;
                    break;

                case 'error':
                    title   = (msg.title == undefined) ? 'Ops, houve um erro.' : msg.title;
                    text    = (msg.text == undefined) ? 'Tente novamente. Se o erro persistir, entre em contato com o administrador do sistema.' : msg.text;
                    break;

                case 'success':
                    type = 'success';
                    title   = (msg.title == undefined) ? 'Ok!' : msg.title;
                    text    = (msg.text == undefined) ? 'Ação executada com sucesso.' : msg.text;
                    break;
            }

            swal({
                text:   text,
                title:  title,
                type:   msg.type
            });
        }
    },

    store: function (obj, itemName)
    {
        if ( typeof obj[itemName] != 'object' ) {
            console.error(itemName+' não existe para ser armazendo');
            return false;
        }

        if ( this.stored[itemName] != undefined ) {
            console.error(itemName+' já existe. Verifique se existe outro script que executa o store do mesmo nome.');
            return false;
        }

        this.stored[itemName] = $.extend(true, {}, obj[itemName]);
        return true;
    },

    restore: function (name)
    {
        //return a new copy of copy withou alters
        return $.extend(true, {}, this.stored[name]);
    },

    sendPost: function (elements, paramns)
    {
        var form = this.createElement('form', paramns);
        elements['_token'] = window.Laravel.csrfToken;

        /*
        * es: Objeto javascript { name: value }
        * prefix: Se es.value = Object, cairá em RECURSIVIDADE até encontrar um VALUE que seja STRING, então neste caso, NAME
        * será o prefixo para evitar sobreposição de INPUT NAME, caso vários objetos tenham o mesmo name
        * */
        (function createInput(es, prefix) {
            for(var attr in es)
            {
                if(typeof es[attr] != 'object'){
                    var input = document.createElement('input');
                    var value = es[attr];
                    input.type = 'text';
                    input.name = (prefix == undefined) ? attr : prefix+'['+attr+']';
                    input.value = value;
                    form.appendChild(input);
                }else{
                    var obj = es[attr];
                    if (prefix != undefined) {
                        //attr = prefix+"_"+attr;
                        attr = prefix+"["+attr+"]";
                    }
                    createInput(obj, attr);
                }
            }
        })(elements);

        form.style.display="none";
        document.body.appendChild(form);

        form.submit();
    },

    AjaxForm: function (nameOrId, action, callback) {
        var form = document.forms[nameOrId];
        if (form == undefined) {
            form = document.getElementById(nameOrId);
            if (form == undefined) {
                throw 'O ID informado não pertence a nenhua formulário da tela.';
            }
        }

        var url     = form.getAttribute('action');
        var method  = form.getAttribute('method');

        var status;

        $.ajax({
            url: url,
            method: ( method == undefined ) ? 'get' : method,
            data: $(form).serialize()+'&action='+action,
            dataType: 'json',
            success: function (data) {
                status = true;
            },
            error: function (error) {
                status = false;
                throw new AjaxExceptions(error);
                //throw('Erro ao enviar form via ajax.');
                //console.log(error);
            },
            complete: function (data) {
                if (typeof callback == 'function') {
                    if (status) { data = data.responseJSON; }
                    callback(status, data);
                }else{
                    //console.log(data);
                }
            }
        });
    },

    /*
    * Objeto json da tela renderizada para comunicação via BACK e FRONT
    * */
    getScreenJson: function () {
        var meta = $('meta[name="screen-json"]');

        if ( meta[0] != undefined ) {
            this.screenJson = JSON.parse(meta[0].getAttribute('content'));
        }else{
            this.screenJson = {};
        }
    },

    unable: function (text) {
        if (text == undefined) {
            text = 'Função indisponível. Entre em contato com o administrador.';
        }

        swal({
            title: '',
            text: text,
            type: 'error'
        });
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

    _dynclick: function ($this, id) {
        document.getElementById(id).click();
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

    createElement: function (element, innerHTML, attrs, styles)
    {
        if (typeof innerHTML == 'object') {
            attrs = innerHTML;
            innerHTML = '';
        }

        if (typeof attrs    != 'object' ) { attrs = {} }
        if (typeof styles   != 'object' ) { styles = {} }

        var e = document.createElement(element);
        e.innerHTML = innerHTML;

        for(attr in attrs)
        {
            if (attr == 'onclick' && typeof attrs[attr] == 'function') {
                e.addEventListener('click', function (ev) {
                    return ev;
                }(attrs[attr]))
            }else{
                e.setAttribute(attr, attrs[attr]);
            }
        }

        for(css in styles)
        {
            e.style[css] = styles[css];
        }

        return e;
    },

    Random: function (end, start)
    {
        if ( start == undefined ) { start = 1; }
        if ( end == undefined ) { end = 100; }

        return Math.floor(Math.random() * end) + start;
    },

    anchorScroll: function (id)
    {
        var tag = $(id);
        $('html,body').animate({scrollTop: tag.offset().top}, 1300);
    }
};