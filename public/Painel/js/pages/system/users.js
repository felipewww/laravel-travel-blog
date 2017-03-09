$(document).ready(function () {
    users.init();
});


users = {
    form: null,

    init: function () {
        this.form = document.forms['user'];
        this.updated();
    },

    updated: function () {
        var hasUpdated = Script.screenJson.updated;
        if (hasUpdated != undefined)
        {
            if (hasUpdated)
            {
                swal('','Usuário Atualizado!','success');
            }
            else
            {
                swal('Ops!','Houve um erro ao atualizar o usuário. Tente novamente e se o erro persistir, entre com contato com o administrador','error');
            }
        }

        var hasCreated = Script.screenJson.created;
        if (hasCreated != undefined)
        {
            if (hasCreated)
            {
                swal('','Usuário registrado!','success');
            }
            else
            {
                swal('Ops!','Houve um erro ao criar o usuário. Tente novamente e se o erro persistir, entre com contato com o administrador','error');
            }
        }
    },

    edit: function (event, button, attrs, dataTable, id, row) {
        this.form.name.value = row[3];
        this.form.email.value = row[4];
        this.form.id.value = id;

        for(var i = 0; i < this.form.type.length; i++){
            var opt = this.form.type.options[i];
            if (opt.value == row[5]) {
                opt.selected = 'selected';
                $(this.form.type).trigger("chosen:updated");
            }
        }
    },

    asAuthor: function (event, button, attrs, dataTable, id, row) {
        $.ajax({
            url: '/painel/api/usuarios',
            data: { id: id, _token: window.Laravel.csrfToken, action: 'defineAuthor' },
            method: 'post',
            dataType: 'json',
            success: function (data) {
                //$(button).class('is_author');
                button.innerHTML = 'config. autor';
                var currClass = button.getAttribute('class');
                button.setAttribute('class', currClass+' is_autor');
                button.setAttribute('href','/painel/blog/autores/'+data.author.id);
                itsOk(data.author);
            },
            error: function (data) {
                console.log(data);
                swal('Ops!','Houve um erro ao criar o autor. Tente novamente e se o erro persistir, entre com contato com o administrador','error');
            }
        });

        function itsOk(author) {
            swal
            (
                {
                    title: "Autor cadastrado com sucesso.",
                    text: "É necessário configurar a descrição do autor e foto. Deseja fazer isso agora?",
                    type: "success",
                    showCancelButton: true,
                    confirmButtonColor: '#a5dc86',
                    confirmButtonText: 'Sim, editar autor.',
                    cancelButtonText: "Deixar para depois.",
                    closeOnConfirm: false,
                    closeOnCancel: true
                },
                function(isConfirm){
                    Script.unable('Página do autor indisponível por enquanto. Entre em contato com o administrador');
                    //if (isConfirm) { window.location.href = '/painel/blog/autores/'+author.id }
                }
            );
        }
    }
};