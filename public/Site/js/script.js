Script = {
    foto: null,

    newHandle: function (file, callback)
    {
        // console.log(file);
        (function () {
            var reader = new FileReader();
            reader.readAsDataURL(file);

            reader.onload=function(file)
            {
                //Preload da imagem
                var foto = new Image();
                foto.src = file.target.result;

                //Timeout para carregar e pegar dimensões da imagem
                //tm = setTimeout(function(){ return getSize(foto); },1);
                // console.log(foto);
                // Script.pause = false;
                // console.log(Script.pause);
                Script.foto = foto;
                // console.log('script.foto');

                if (typeof callback == 'function') {
                    callback();
                }
                //return foto;
                //return getSize(foto);

            };

            function getSize(foto) {
                var w = foto.width;
                if (w == 0) {
                    // tm = setTimeout(function () {
                    //     getSize(foto);
                    // },500)
                    getSize(foto);
                }else{
                    // console.log(foto);
                    //foto.style.maxHeight="300px";
                    return foto;
                }
            }

        })();
    }
};