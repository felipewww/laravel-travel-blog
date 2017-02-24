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
            <a onclick="document.getElementById('submit_photogallery').click()" class="button font-black green waves-effect">salvar</a>
        </div>
        <div class="cleaner"></div>
    </header>

    <section class="content">
        <form id="sortable" name="photoGallery" method="post" enctype="multipart/form-data">
            @foreach($photoGallery as $photo)
                <div id="photo_{{$photo->id}}" class="w-25">
                    <div class="actions">
                        <span onclick="PhotoGallery.deletePhoto(this, {{$photo->id}})">excluir</span>
                    </div>

                    <div class="photo_img" style="background-image: url('/{{$photo->path}}');"></div>
                    <input type="file" name="photo[{{$photo->id}}][img]">
                    <textarea class="desc" type="text" placeholder="Descrição da foto..." name="photo[{{$photo->id}}][description]">{{$photo->description}}</textarea>

                    <input type="hidden" name="photo[{{$photo->id}}][id]" value="{{$photo->id}}">
                </div>
            @endforeach
            <input type="hidden" name="action" value="createOrUpdatePhotoGallery">
            <input type="hidden" name="fk_id" value="{{ $reg->id }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="submit" class="hidden" id="submit_photogallery">
        </form>
        <div class="cleaner"></div>
    </section>
</section>