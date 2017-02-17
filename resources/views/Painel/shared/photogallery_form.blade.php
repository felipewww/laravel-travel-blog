<section class="block">
    <header>
        <div class="title">
                <span>
                Galeria de Fotos
                </span>
        </div>
        <div class="actions">
            {{--<a href="#" class="button light-blue font-black waves-effect submitter">post</a>--}}
            <a onclick="PhotoGallery.addPhoto()" class="button font-black light-blue waves-effect">+ foto</a>
            <a onclick="document.forms.photoGallery.submit()" class="button font-black green waves-effect">salvar</a>
        </div>
        <div class="cleaner"></div>
    </header>

    <section class="content">
        <form name="photoGallery" method="post">
            @foreach($photoGallery as $photo)
                <div id="photo_{{$photo->id}}" class="w-50">
                    <div class="actions">
                        <span onclick="PhotoGallery.deletePhoto(this, {{$photo->id}})">excluir</span>
                    </div>

                    <div class="headline_img" style="background-image: url('/{{$photo->src}}');">
                    </div>
                    <label>
                        <span>Headline img</span>
                        <input type="file" name="hl[{{$photo->id}}][img]">
                    </label>
                </div>
            @endforeach
            {{--<input type="hidden" name="action" value="{{ ($action) }}">--}}
            <input type="hidden" name="id" value="{{ $reg->id }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
        <div class="cleaner"></div>
    </section>
</section>