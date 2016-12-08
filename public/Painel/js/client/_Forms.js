_Forms = {
    init: function ()
    {
        this.labels = document.getElementsByTagName('label');
        this.blocks = document.getElementsByClassName('block');

        this.cfgSize();
        this.cfgBlocks();
        this.checkboxes();
        this.setupOrderBy();
    },


    cfgSize:function ()
    {
        var i = 0;
        while (i < this.labels.length)
        {
            var label = this.labels[i];
            cfg(label);
            i++;
        }

        function cfg(label) {
            var label_w = label.clientWidth;
            var label_padding_hor = parseInt($(label).css('padding-left')) * 2;

            var title = label.children[0];//label.getElementsByTagName('span')[0];
            var title_w = title.clientWidth;

            var input = label.children[1]; //label.getElementsByTagName('input')[0];
            //console.log({e:input});

            var input_padding_hor = parseInt($(input).css('padding-left')) * 2;

            var diff = 0;
            switch (input.localName)
            {
                case 'input':
                    diff = 15;
                    break;

                case 'select':
                    diff = -6;
                    break;
            }

            //TODO 16 eh uma diferença que da, nao sei porque... mas da para esticar ate mais 16
            var total_padding = (label_padding_hor + input_padding_hor + title_w) + (diff);
            var inputsize = label_w - total_padding;

            input.style.width = inputsize + 'px';

            if (input.localName == 'select') {
                $(input).chosen();
            }
        }
    },

    cfgBlocks: function ()
    {
        var i = 0;
        while (i < this.blocks.length)
        {
            var block = this.blocks[i];
            cfg(block);
            i++;
        }

        function cfg(block) {
            var title = block.getElementsByClassName('title')[0];

            var arrow = Script.createElement('span', '', { class: 'flaticon-keyboard-right-arrow-button' });
            title.appendChild(arrow);

            var content = block.getElementsByClassName('content')[0];

            title.onclick = function () {
                $(content).slideToggle(300);
            }
        }
    },

    checkboxes: function ()
    {
        var checks = $('input[type="checkbox"]');
        var i = 0;
        while (i < checks.length)
        {
            var box = checks[i];
            setup(box);
            i++;
        }

        function setup(box) {
            var randid = 'id_'+Script.Random();

            box.setAttribute('id', randid);
            box.style.display = 'none';

            var div = Script.createElement('div', box.getAttribute('data-placeholder'), { 'data-checkboxid': randid, class: 'boxref' });
            var parent = box.parentNode;
            parent.appendChild(div);

            //Mover o input checkbox para fora do label, ele sempre ficara escondido.
            divParent = parent.parentNode;
            divParent.appendChild(box);
        }

        _Forms.setupBoxref();
    },

    Submit: function (name) {
        var jform    = $('form[name="'+name+'"]');
        var form    = jform[0];

        jform.submit();
    },

    setupBoxref: function () {
        var refs = $('div.boxref');
        var i = 0;
        while (i < refs.length)
        {
            var ref = refs[i];
            cfgClick(ref);
            i++;
        }

        function cfgClick(ref){
            ref.addEventListener('click', function () {
                var id = this.getAttribute('data-checkboxid');
                alert(id);
                var box = document.getElementById(id);
                console.log(box);

                if (box.checked) {
                    this.setAttribute('data-boxchecked', 'false');
                    box.checked=false;
                }else{
                    this.setAttribute('data-boxchecked', 'true');
                    box.checked=true;
                }
            })
        }
    },

    setupOrderBy: function ()
    {
        var orderBoxes = document.getElementsByClassName('order-options');
        var i = 0;
        while (i < orderBoxes.length)
        {
            var box = orderBoxes[i];
            setup(box);
            i++;
        }

        function setup(box)
        {
            var button  = $(box).find('span.asc');
            var input   = $(box).find('input.asc');
            cfgClick(button, input, box);

            var button  = $(box).find('span.desc');
            var input   = $(box).find('input.desc');
            cfgClick(button, input, box);
        }

        function cfgClick(btn, ipt, box)
        {
            $(btn).on('click', function () {
                prop = $(ipt).attr('checked');
                //alert(prop);

                if (prop == 'checked') {
                    //$(ipt).attr('checked', false);
                    $(ipt).removeAttr('checked');
                    $(this).removeClass('active');
                }else{

                    $(box).find('.active').click();

                    var ip = $(ipt)[0];
                    ip.checked = true;
                    ip.setAttribute('checked', true);
                    $(this).addClass('active');
                }

            });

        }
    }
};