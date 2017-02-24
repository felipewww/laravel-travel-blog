<section class="block">
    <header>
        <div class="title">
            <span>Posts</span>
        </div>
        <div class="actions">
            {{--<a href="/painel/blog/novo-post/cidade/{{$reg->id}}" target="_blank" class="button green font-black waves-effect">criar post</a>--}}
            <a href="{{$postButtons->createPostButton}}" target="_blank" class="button green font-black waves-effect">criar post</a>
            {{--<a href="javascript:city.painel.tags();" class="button light-blue font-black waves-effect">salvar</a>--}}
        </div>
        <div class="cleaner"></div>
    </header>

    <section class="content">
        @foreach($posts as $post)
            <div class="w-50 inside">
                <form>
                    <div class="w-50">Título: {{ $post->managed_regions['article_title']['content'] }}</div>
                    <div class="w-50">status: {{ $post->status }}</div>
                    <div class="w-50">Por: <strong>{!! $post->author['name'] !!}</strong></div>

                    <div class="w-100 ">
                        <ul class="multaction">
                            <li data-tooltip-str="Editar" class="hasTooltip flaticon-fountain-pen">
                                <a target="_blank" href="{{$postButtons->editPostButton.$post->id}}"></a>
                            </li>

                            @if($post->status == 'ativo')
                                <li data-tooltip-str="Inativar" class="hasTooltip flaticon-warning" onclick="PainelPosts.inactivePost('{{$post->id}}')"><!-- inactive --></li>
                            @else
                                <li data-tooltip-str="Ativar" class="hasTooltip flaticon-checked" onclick="PainelPosts.verifyAuthorAndActivePost('{{$post->id}}', '{{$post->author_id}}')"><!-- active --></li>
                            @endif
                            {{--<li data-tooltip-str="Excluir" class="hasTooltip flaticon-rubbish-bin"><!-- delete --></li>--}}
                            <li data-tooltip-str="Configurações" class="hasTooltip flaticon-expand">
                                <a href="/painel/blog/post/{{$post->id}}"></a>
                            </li>
                        </ul>
                    </div>

                    <input type="hidden" name="id" value="1033">
                    <div class="cleaner"></div>
                </form>
            </div>
        @endforeach
        <div class="cleaner"></div>
    </section>
</section>