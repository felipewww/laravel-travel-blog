/*
* Funções relacionadas a form da tela
* */

var Forms = {
    dynamicErros: false,
    errors: {},
    
    /*TODO - Reescrever função de clone de inputs file*/
    cloneInputFile: function () {
        if ( !isset(jsname) )
        {
            eval(jsname+" = {};");
            eval(jsname+".count = 0;");
            eval("var obj = "+jsname+";");
        }
        else
        {
            eval("var obj = "+jsname+";");
            obj.count++;
        }
        var cloned = e.cloneNode(true);

        cloned.removeAttribute("onclick");
        e.parentNode.insertBefore(cloned, e);
        ( paramns.cssclass != undefined ) ? cloned.setAttribute('class', paramns.cssclass): '';

        var label       = cloned.getElementsByTagName("label")[0];
        var input       = cloned.getElementsByTagName("input")[0];
        var image       = cloned.getElementsByTagName("img")[0];
        //var btExclude   = cloned.getElementsByClassName("exclude")[0];

        var idx = jsname+"_"+obj.count;

        label.setAttribute("for",'input_'+idx);
        label.setAttribute("id",idx);
        input.setAttribute("id",'input_'+idx);
        input.setAttribute("name",paramns.htmlname+'['+obj.count+'][file]');
        //btExclude.style.display="block";

        //Se o arquivo for tipo IMAGEM, add handlerfield select para exibir miniatura
        if ( type == 'img' ) { input.setAttribute("onchange", "mainScript.handleFileSelect(this, '"+idx+"')"); }
        else { image.setAttribute("src", '/admin/media/images/itens_item_'+type+'.png') }

        input.click();

        mainScript.clone = {
            last: cloned,
            file: undefined,
            jsname: jsname,
            count: obj.count
        };


        if (paramns.action == 'addForm')
        {
            ajaxPages.xclose.addEventListener("click", removeLastCloned = function () {
                cloned.parentNode.removeChild(cloned);
                ajaxPages.xclose.removeEventListener("click", removeLastCloned);
            });

            if (input.type == 'file')
            {
                input.addEventListener("change", function(e){
                    mainScript.clone.file = e.target;
                });
            }
            else if(input.type == 'text')
            {
                mainScript.clone.file = true;
            }
            //Evento que identifica se foi selecionado algum arquivo para UPLOAD
        }
    },

    //Função que verifica se ao utilizar a função CLONEDIV realmente foi selecionado um novo arquivo
    verifyCloned: function()
    {
        if (mainScript.clone.file == undefined)
        {
            mainScript.clone.last.parentNode.removeChild(mainScript.clone.last);
            return false;
        }
        else
        {
            return true;
        }
    },

    validRequired: function(form)
    {
        /*
         * Se os campos não atnederem os requisitos, incluir o elemento HTML
         * em um Array e adicionar +1 no contador de erros
         * */
        function valid(element)
        {
            /*
             * Elementos radio tem que validor CHECKED por grupo
             * */
            if (element.type == 'radio')
            {
                var nome = element.name;
                var elementsRadio = $('input[name="'+nome+'"]');
                var checked = 0;

                var i = 0;
                while(i < elementsRadio.length)
                {
                    e = elementsRadio[i];
                    if (e.checked) { checked = 1; }
                    i++;
                }

                /*
                 * Se nenhum radio do grupo estiver checkado, adicionar aos erros
                 * */
                if (checked == 0)
                {
                    erros['count']++;
                    erros['elements'].push(element);
                }
            }
            else
            {
                var value = element.value;
                if (value == "")
                {
                    erros['count']++;
                    erros['elements'].push(element);
                }
            }
        }

        function showErrors()
        {
            var i = 0;
            while(i < erros['count'])
            {
                var element = erros['elements'][i];

                var type = element.getAttribute("type");
                if (type == 'file')
                {
                    var parent = element.parentNode;
                    parent.setAttribute("data-require-error","true");

                    element.addEventListener("change", function(){
                        parent.removeAttribute("data-require-error");
                    });
                }
                else if (type == 'radio')
                {
                    var parent = element.parentNode.parentNode;
                    parent.setAttribute("data-require-error","true");

                    element.addEventListener("change", function(){
                        parent.removeAttribute("data-require-error");
                    });
                }
                else
                {
                    element.setAttribute("data-require-error","true");
                    element.onfocus=function(){
                        this.removeAttribute("data-require-error");
                    };
                }
                i++;
            }
        }

        var erros = [];
        erros['count'] = 0;
        erros['elements'] = [];

        var tags = ['input', 'select', 'textarea'];
        var y = 0;

        while(y < tags.length)
        {
            var elements = form.getElementsByTagName(tags[y]);
            var i = 0;
            while(i < elements.length)
            {
                var element = elements[i];
                var attr = element.getAttribute("required");
                if (attr != null)
                {
                    valid(element);
                }
                i++;
            }
            y++;
        }

        if (erros['count'] > 0) { showErrors(); }

        //$(mainScript.loading).fadeOut();
        return erros;
    }
};