$(document).ready(function () {
    ContentToolsExtensions.init();
});

var myImgUploadr = function () {
    alert("teste");
};

ContentToolsExtensions = {
    init: function () {
        //IMAGEUPLOADER
        ContentTools.IMAGE_UPLOADER = ImageUploader.createImageUploader;
        //ContentTools.StylePalette.add([new ContentTools.Style('By-line', 'article__by-line', ['p']), new ContentTools.Style('Caption', 'article__caption', ['p']), new ContentTools.Style('Example', 'example', ['pre']), new ContentTools.Style('Example + Good', 'example--good', ['pre']), new ContentTools.Style('Example + Bad', 'example--bad', ['pre'])]);

        //Configurar editor
        editor = ContentTools.EditorApp.get();
        editor.init('[data-editable], [data-fixture]', 'data-name');

        /*Retorna qual div foi alterada. Talvez não seja tão importante assim.*/
        editor.addEventListener('saved', function(ev) {
            var saved;
            console.log(ev.detail().regions);
            if (Object.keys(ev.detail().regions).length === 0) {
                return;
            }
            editor.busy(true);
            saved = (function(_this) {
                return function() {
                    editor.busy(false);
                    return new ContentTools.FlashUI('ok');
                };
            })(this);
            return setTimeout(saved, 2000);
        });

        /*Para elementos ditos como fixos*/
        // FIXTURE_TOOLS = [['undo', 'redo', 'remove']];
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

ImageUploader = (function() {
    ImageUploader.imagePath = 'image.png';

    ImageUploader.imageSize = [600, 174];

    function ImageUploader(dialog) {
        this._dialog = dialog;
        this._dialog.addEventListener('cancel', (function(_this) {
            return function() {
                return _this._onCancel();
            };
        })(this));
        this._dialog.addEventListener('imageuploader.cancelupload', (function(_this) {
            return function() {
                return _this._onCancelUpload();
            };
        })(this));
        this._dialog.addEventListener('imageuploader.clear', (function(_this) {
            return function() {
                return _this._onClear();
            };
        })(this));
        this._dialog.addEventListener('imageuploader.fileready', (function(_this) {
            return function(ev) {
                // var input = $('.ct-image-dialog__file-upload');
                // console.log(input);
                // console.log(ev);
                // exit();
                return _this._onFileReady(ev.detail().file);
            };
        })(this));
        this._dialog.addEventListener('imageuploader.mount', (function(_this) {
            return function() {
                // console.log(_this);
                var ipt = _this._dialog._domInput;
                var nipt = document.createElement('input');
                nipt.type = 'file';

                // ipt.onclick = function (e) {
                //     e.preventDefault();
                //     nipt.click();
                //     console.log("prevented");
                // };
                //
                //
                // nipt.onchange=function () {
                //     console.log('changed');
                //     console.log({e:this});
                // };

                //var input = $('.ct-image-dialog__file-upload');
                // console.log(input);
                // input.onChange = function (e) {
                //   console.log(this);
                // };
                return _this._onMount();
            };
        })(this));
        this._dialog.addEventListener('imageuploader.rotateccw', (function(_this) {
            return function() {
                return _this._onRotateCCW();
            };
        })(this));
        this._dialog.addEventListener('imageuploader.rotatecw', (function(_this) {
            return function() {
                return _this._onRotateCW();
            };
        })(this));
        this._dialog.addEventListener('imageuploader.save', (function(_this) {
            return function() {
                return _this._onSave();
            };
        })(this));
        this._dialog.addEventListener('imageuploader.unmount', (function(_this) {
            return function() {
                return _this._onUnmount();
            };
        })(this));
    }

    ImageUploader.prototype._onCancel = function() {};

    ImageUploader.prototype._onCancelUpload = function() {
        clearTimeout(this._uploadingTimeout);
        return this._dialog.state('empty');
    };

    ImageUploader.prototype._onClear = function() {
        return this._dialog.clear();
    };

    ImageUploader.prototype._onFileReady = function(file) {
        var ipt = this._dialog._domInput;
        console.log({e:ipt});
        exit();

        var iUP = this;
        var upload;
        var foto = Script.newHandle(file, function () {
            var ni = document.createElement('input');
            ni.type = 'file';
            ni.files[0] = file;

            var _f = document.getElementById('_files');
            _f.appendChild(ni);
            //var iUP;
            // console.log('foto em Extensions...');
            // console.log({e:Script.foto});

            //return _this._dialog.populate(ImageUploader.imagePath, ImageUploader.imageSize);

            iUP._dialog.progress(0);
            iUP._dialog.state('uploading');
            upload = (function(_this) {
                return function() {
                    var progress;
                    progress = _this._dialog.progress();
                    progress += 1;
                    if (progress <= 100) {
                        _this._dialog.progress(progress);
                        return _this._uploadingTimeout = setTimeout(upload, 25);
                    } else {
                        ImageUploader.imagePath = Script.foto.src;
                        ImageUploader.imageSize = [Script.foto.width, Script.foto.height];
                        return _this._dialog.populate(ImageUploader.imagePath, ImageUploader.imageSize);
                    }
                };
            })(iUP);
            // console.log("upload aqui...");
            // console.log(upload);
            // console.log(iUP);
            return iUP._uploadingTimeout = setTimeout(upload, 25);
            //return upload;
        });

        // console.log('foto em Extensions...');
        // console.log(foto);
        //
        // this._dialog.progress(0);
        // this._dialog.state('uploading');
        // upload = (function(_this) {
        //     return function() {
        //         var progress;
        //         progress = _this._dialog.progress();
        //         progress += 1;
        //         if (progress <= 100) {
        //             _this._dialog.progress(progress);
        //             return _this._uploadingTimeout = setTimeout(upload, 25);
        //         } else {
        //             return _this._dialog.populate(ImageUploader.imagePath, ImageUploader.imageSize);
        //         }
        //     };
        // })(this);

        // console.log('foto aqui...');
        // console.log(foto);

        // return this._uploadingTimeout = setTimeout(foto, 25);
    };

    ImageUploader.prototype._onMount = function() {
        //alert("here");
    };

    ImageUploader.prototype._onRotateCCW = function() {
        var clearBusy;
        this._dialog.busy(true);
        clearBusy = (function(_this) {
            return function() {
                return _this._dialog.busy(false);
            };
        })(this);
        return setTimeout(clearBusy, 1500);
    };

    ImageUploader.prototype._onRotateCW = function() {
        var clearBusy;
        this._dialog.busy(true);
        clearBusy = (function(_this) {
            return function() {
                return _this._dialog.busy(false);
            };
        })(this);
        return setTimeout(clearBusy, 1500);
    };

    ImageUploader.prototype._onSave = function() {
        var clearBusy;
        this._dialog.busy(true);
        clearBusy = (function(_this) {
            return function() {
                alert("save!");
                _this._dialog.busy(false);
                return _this._dialog.save(ImageUploader.imagePath, ImageUploader.imageSize, {
                    alt: 'Example of bad variable names'
                });
            };
        })(this);
        return setTimeout(clearBusy, 1500);
    };

    ImageUploader.prototype._onUnmount = function() {};

    ImageUploader.createImageUploader = function(dialog) {
        return new ImageUploader(dialog);
    };

    return ImageUploader;

})();

window.ImageUploader = ImageUploader;