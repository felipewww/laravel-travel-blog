$(document).ready(function () {
    ints.init();
});

ints = {
    init: function () {
        this.form = $('[name="createOrUpdate"]');

        var $color = $('input[name="color"]');
        // alert("Interesses!");
        $color.ColorPicker({
            // flat:true,
            color: '#0000ff',
            onSubmit: function(hsb, hex, rgb, el) {
                //$color.val(hex);
                $color.ColorPickerHide();
            },
            onShow: function (colpkr) {
                // $color.val($color.attr('placeholder'));
                $(colpkr).fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                $(colpkr).fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex, rgb, e) {
                $color.val('#' + hex);
                $color.css('backgroundColor', '#' + hex);
            }
        });
    },

    delete: function (event, btn, attrs, table, id, row) {
        console.log(id);
        $form = $('#interest-delete-form');
        $form.find('[name="id"]').val(id);
        $form.submit();
        // Script._dynclick('', 'interest-delete-form');
    },

    edit: function (event, btn, attrs, table, id, row) {
        this.cancelEdit(); //resetar form de edição

        // console.log(row);
        var input_id = Script.createElement('input', '', {
            class: 'hidden',
            name: 'id',
            value: id
        });

        var actionInput = this.form.find('input[name="action"]');
        actionInput.val('update');

        this.form.append(input_id);

        this.form.find('input[name="name"]').val(row[2]);
        this.form.find('input[name="color"]').val(row[3].bgColor);

        $('#cancelEdit').show();
        $('#tituloBloco').html('Editando '+row[2]);

        // alert('Todo: Criar forma de editar o interesse na tabela de novo! ;)')
    },

    cancelEdit: function () {
        $('#cancelEdit').hide();
        $('#tituloBloco').html('Novo Interesse');
        this.form.find('[name="id"]').remove();
        this.form.find('input[name="action"]').val('create');
        this.form.find('input[name="name"]').val('');
        this.form.find('input[name="color"]').val('');
    }
};