$(document).ready(function () {
    admin.init();
});

admin = {
    buttons:{},

    init: function () {
        this.editButton();
        this.saveButton();
        this.cfgBox();

        this.form = $('form[name="getheadlines"]');

        var boxes = $(this.form).find('.searchBox');
        $(boxes).each(function () {
            var select  = $(this).find('select');
            $(select).chosen();

            var searchBtn = $(this).find('.searchBtn');
            $(searchBtn).on('click', function () {
                admin.search($(select));
            })

        });

        this.dd();
    },

    //setup drag and drop
    dd: function () {
        $( ".sortable" ).droppable({
            hoverClass: "ui-state-highlight",
            opacity: 0.5,
            accept: '.draggable',
            drop: function (current, dropped) {
                var target  = current.target;
                var element = dropped.draggable.context;

                $(element).addClass('used');

                /*
                * Pegar o id atual e verificar se o elemento removido estava listado,
                 * se sim, ativá-lo para poder colocar na home.
                */
                var id = $(target).attr('id').split('_');
                id = id[1]+'_'+id[2]+"_"+id[3]; //remove string "inside_"

                isListed = (function (id) {
                    return document.getElementById(id);
                })(id);

                //se estava na lista ao lado, estava bloqueado. Então, desbloquear!
                if (isListed) {
                    $(isListed).removeClass('used');
                    $(isListed).addClass('draggable');
                }

                /*
                * Definir novo conteúdo
                * */
                console.log(element);
                $(target).find('.title').html(
                    $(element).find('.title').html()
                );

                $(target).find('.content').html(
                    $(element).find('.content').html()
                );

                $(target).attr('id',
                    'inside_'+$(element).attr('id')
                );

                console.log($(element).find('.img').css('backgroundImage'));

                $(target).find('.img').css('backgroundImage',
                    // 'url(asdasdas)'
                    $(element).find('.img').css('backgroundImage')
                );

                //Rodar novamente a configuração dos DragAndDrops
                admin.dd();
            }
        });

        $( ".draggable" ).draggable({
            helper: "clone",
            revert: "invalid"
        });
    },

    search: function (select) {
        var from    = $(select).attr('id');
        var id      = $(select).val();

        $.ajax({
            url: '/painel/api/home/getHeadlines',
            method: 'post',
            data: { from: from, id: id, _token: window.Laravel.csrfToken },
            dataType: 'json',
            success: function (data) {
                console.log(data.status);
                if (data.status) {
                    // console.log('success!');
                    // console.log(data);
                    admin.showHeadlines(data.hls, from);
                }
            },
            error:function (e) {
                console.log(e);
            }
        });
    },

    showHeadlines: function (headlines, from) {
        // console.log(headlines);
        var idx, hl, img, container, textContainer, title, content, mainDiv, status, currentStatus, draggable;

        mainDiv = document.getElementById('searchResults');
        mainDiv.innerHTML = '';

        for(idx in headlines)
        {
            hl = headlines[idx];
            var elementId = 'hl_'+from+'_'+hl.id;
            var ifUsed = function () {
                return document.getElementById('inside_'+elementId)
            };

            currentStatus = (ifUsed()) ? 'used' : '';
            draggable = (ifUsed()) ? 'used' : 'draggable';
            // alert(ifUsed());
            container = Script.createElement('div', { class: 'result '+draggable, id: elementId });
            img = Script.createElement('div', '', { class: 'img' }, { backgroundImage: 'url('+hl.src+')' })

            textContainer = Script.createElement('div', { class: 'fullContent' });
            title = Script.createElement('div', hl.title, { class: 'title' });
            content = Script.createElement('div', hl.content, { class: 'content' });
            status = Script.createElement('div', { class: 'status '+currentStatus });

            textContainer.appendChild(title);
            textContainer.appendChild(content);
            textContainer.appendChild(status);

            container.appendChild(img);
            container.appendChild(textContainer);

            mainDiv.appendChild(container);
            mainDiv.appendChild(Script.createElement('div', { class: 'cleaner' }));
        }

        this.dd();
    },

    cfgBox: function () {
        this.box = $('#cfgbox');
        this.arrowBox = $(this.box).find('.arrow');

        this.arrowBox.on('click', function () {
            if ($(this).hasClass('closed')) {
                $(admin.box).animate({right: 0});
                $(this).removeClass('closed');
            }else{
                $(admin.box).animate({right: -300});
                $(this).addClass('closed');
            }
        });

        // $(this.box).hide();
    },

    editButton: function () {
        this.buttons.edit = $('#edit');
        $(this.buttons.edit).on('click', function () {
            // alert('click');
            $(admin.box).show();
            $(admin.arrowBox).click();
        })
    },

    saveButton: function ()
    {
        var $this, regions;
        var ids = {};

        this.buttons.save = $('#save');
        $(this.buttons.save).on('click', function () {

            regions = $('.region');
            $(regions).each(function (i) {
                $this = $(this);
                var id = $this.parent().attr('id');
                console.log(id);
                ids[i] = id;
                // console.log($this);
            });

            $.ajax({
                url: '/painel/api/home/updateHeadlines',
                data: { ids: ids, _token: window.Laravel.csrfToken },
                dataType: 'json',
                method: 'post',
                success: function (data) {
                    console.log('success');
                },
                error: function (error) {
                    console.log('Error!');

                }
            })

        })
    },
};