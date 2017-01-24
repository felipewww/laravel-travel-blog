// window.ImageUploader = ImageUploader;

$(document).ready(function () {
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
        //ContentTools.IMAGE_UPLOADER = ImageUploader.createImageUploader;
        ContentTools.IMAGE_UPLOADER = imageUploader;

        //Configurar editor
        editor = ContentTools.EditorApp.get();
        editor.init('[data-editable], [data-fixture]', 'data-name');

        /*Retorna qual div foi alterada. Talvez não seja tão importante assim.*/
        editor.addEventListener('saved', function(ev) {
            //alert("SAVED");
            //var saved;
            // console.log(ev);
            // // console.log(ev.detail().regions);
            // if (Object.keys(ev.detail().regions).length === 0) {
            //     return;
            // }
            // editor.busy(true);
            // saved = (function(_this) {
            //     return function() {
            //         editor.busy(false);
            //         return new ContentTools.FlashUI('ok');
            //     };
            // })(this);
            // return setTimeout(saved, 2000);
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
            if (editor.toolbox().tools() !== tools) {
                return editor.toolbox().tools(tools);
            }
        });
    }
};