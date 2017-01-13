Multaction = {

    blocks: null,

    init: function () 
    {
        this.blocks = $('.multaction');
        this.cfg();
    },

    cfg: function ()
    {
        var i = 0;
        while (i < this.blocks.length)
        {
            var block = this.blocks[i];
            this.cfgBlock(block);
            i++;
        }
    },

    cfgBlock: function (block)
    {
        var width = 45;
        var lis = $(block).find('li');
        var i = 0;
        while (i < lis.length)
        {
            var li = lis[i];
            li.style.zIndex = lis.length - i;
            li.style.left = 0;

            i++;
        }

        ulWidth = width * i;

        block.onmouseenter = function () { getLisAndToggle(this, 'show'); };
        block.onmouseleave = function () { getLisAndToggle(this, 'hide'); };

        function getLisAndToggle(block, status) {
            var lis = block.getElementsByTagName('li');
            var interval = 0; //600ms

            var i = 0;
            while (i < lis.length)
            {
                var li = lis[i];
                li.style.bottom = '0px';
                var position =  ( status == 'show' ) ? width * i : 0;
                Multaction.toggleOption(li, position, interval);
                interval = interval + 50;

                i++;
            }

            block.style.width = ( status == 'show' ) ? ulWidth + 'px' : width + 'px';
        }
    },

    toggleOption: function (li, position, interval) {
        var t = setTimeout(function () {
            $(li).animate({left: position }, 100);
        }, interval);
    }
};
