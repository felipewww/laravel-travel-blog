<section class="block" data-closed="true">
    <header>
        <div class="title">
            <span>Tags de Pesquisa</span>
        </div>
        <div class="actions">
            {{--<a href="javascript:city.painel.tags();" class="button light-blue font-black waves-effect">salvar</a>--}}
            <a onclick="document.forms['tags'].submit()" class="button light-blue font-black waves-effect">salvar</a>
        </div>
        <div class="cleaner"></div>
    </header>

    <section class="content">

        <form name="tags" method="post">
            <div class="w-50">
                <label>
                    <span>Site</span>
                    <input maxlength="255" type="text" name="system" placeholder="Tags para pesquisa no site" value="{{ $reg->search_tags  }}">
                </label>
            </div>

            <div class="w-50">
                <label>
                    <span>SEO</span>
                    <input maxlength="255" type="text" name="seo" placeholder="Tags para SEO" value="{{ $reg->seo_tags  }}">
                </label>
            </div>
            <div class="cleaner"></div>

            <input type="hidden" name="action" value="updateOrCreateTags">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

        </form>
    </section>
</section>