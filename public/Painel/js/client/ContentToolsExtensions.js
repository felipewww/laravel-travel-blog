$(document).ready(function () {
    ContentTools.Event('beforeSave', {});
    ContentTools.StylePalette.add(
        [
            new ContentTools.Style('By-line', 'article__by-line'),
            new ContentTools.Style('Caption', 'article__caption', ['p']),
            new ContentTools.Style('Example', 'example', ['pre']),
            new ContentTools.Style('Example + Good', 'example--good', ['pre']),
            new ContentTools.Style('Example + Bad', 'example--bad', ['pre'])
        ]
    );
    // ContentTools.StylePalette.add([
    //     new ContentTools.Style('Author', 'author', ['p'])
    // ]);
    ContentToolsExtensions.init();

    // Disable refresh message
    window.removeEventListener('beforeunload', ContentToolsExtensions.editor._handleBeforeUnload);
});

function imageUploader(dialog) {
    var image, xhr, xhrComplete, xhrProgress;

    dialog.addEventListener('imageuploader.fileready', function (ev) {

        // Upload a file to the server
        var formData;
        var file = ev.detail().file;
        console.log(ev);

        // Define functions to handle upload progress and completion
        xhrProgress = function (ev) {
            // Set the progress for the upload
            dialog.progress((ev.loaded / ev.total) * 100);
        };

        xhrComplete = function (ev) {
            var response;

            // Check the request is complete
            if (ev.target.readyState != 4) {
                return;
            }

            // Clear the request
            xhr = null;
            xhrProgress = null;
            xhrComplete = null;

            // Handle the result of the upload
            if (parseInt(ev.target.status) == 200) {
                // Unpack the response (from JSON)
                response = JSON.parse(ev.target.responseText);

                // Store the image details
                image = {
                    size: response.size,
                    url: response.url
                };

                // Populate the dialog
                dialog.populate(image.url, image.size);

            } else {
                // The request failed, notify the user
                new ContentTools.FlashUI('no');
                alert("Ops! Houve um erro. Se o erro persistir, entre em contato com o administrador");
            }
        };

        // Set the dialog state to uploading and reset the progress bar to 0
        dialog.state('uploading');
        dialog.progress(0);

        // Build the form data to post to the server
        formData = new FormData();

        //formData = document.getElementById('_files');
        formData.append('_token', window.Laravel.csrfToken);
        formData.append('image', file);

        // Make the request
        xhr = new XMLHttpRequest();
        xhr.upload.addEventListener('progress', xhrProgress);
        xhr.addEventListener('readystatechange', xhrComplete);
        xhr.open('POST', '/upload-image', true);
        xhr.send(formData);
    });

    dialog.addEventListener('imageuploader.save', function() {
        this.save(this._imageURL, this._imageSize);
    });
}

ContentToolsExtensions = {

    init: function () {
        ContentTools.IMAGE_UPLOADER = imageUploader;

        //Configurar editor
        this.editor = ContentTools.EditorApp.get();
        this.editor.init('[data-editable], [data-fixture]', 'data-name');

        this.editor.addEventListener('saved', function(ev) {
            eval(Script.screenJson['contentToolsOnSave']+"(ev)");
        });

        /*Para elementos ditos como fixos*/
        FIXTURE_TOOLS = [['undo', 'redo']];
        ContentEdit.Root.get().bind('focus', function(element) {
            var tools;
            if (element.isFixed()) {
                tools = FIXTURE_TOOLS;
            } else {
                tools = ContentTools.DEFAULT_TOOLS;
            }
            if (ContentToolsExtensions.editor.toolbox().tools() !== tools) {
                return ContentToolsExtensions.editor.toolbox().tools(tools);
            }
        });
    },

    mountRegions: function (evregions, objregions)
    {
        //Pegar regioes alteradas, salvar no objeto final e validar se for required.
        for (var regionName in evregions)
        {
            if (evregions.hasOwnProperty(regionName))
            {
                if (objregions[regionName] == undefined) { objregions[regionName] = {}; }
                objregions[regionName].content = evregions[regionName];
                if (objregions[regionName].required)
                {
                    objregions[regionName].validated = true;
                }
            }
        }
    },

    validateRegions: function (objregions) {
        var hasError = false;

        var regionsErrors = '';
        var errorsCount = 0;

        //Ler objeto final e validar as configurações
        for(var region in objregions)
        {
            if (objregions.hasOwnProperty(region))
            {
                var cfg = objregions[region];
                if (cfg.required && !cfg.validated)
                {
                    regionsErrors += ( regionsErrors == '' ) ? '"'+region+'"' : ', "'+region+'"';
                    errorsCount = errorsCount+1;
                    hasError = true;
                }
            }
        }

        if (hasError) {
            var texts = { 1: '', 2: '' };
            switch (errorsCount)
            {
                //Singular
                case 1:
                    texts[1] = 'Região';
                    texts[2] = 'é obrigatória';
                    break;

                //Plural
                default:
                    texts[1] = 'Regiões';
                    texts[2] = 'são obrigatórias';
                    break;
            }
            swal('Ops, Nada foi salvo!', texts[1]+' ['+regionsErrors+'] '+texts[2]+'. Em caso de dúvidas, entre em contato com o administrador', 'error');
            return false;
        }

        return true;
    },
};