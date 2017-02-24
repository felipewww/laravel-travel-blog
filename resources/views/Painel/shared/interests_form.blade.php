<section class="block">
    <header>
        <div class="title">
            <span>Interesses</span>
        </div>
        <div class="actions">
            {{--<a href="javascript:city.painel.interest();" class="button light-blue font-black waves-effect">salvar</a>--}}
            <a onclick="document.getElementById('submit_interests').click()" class="button light-blue font-black waves-effect">salvar</a>
        </div>
        <div class="cleaner"></div>
    </header>

    <section class="content">
        {{--<form name="interests" method="post" action="/painel/api/mundo/cidade/{{$reg['id']}}">--}}
        <form name="interests" method="post">
            @foreach($interests as $int)
                <div>
                    <label data-notconfigure="true" for="int_{{ $int->id }}" data-color="{{ $int->color }}">{{ $int->name }}
                    </label>
                    <input {{ $int->checked  }} id="int_{{ $int->id }}" type="checkbox" name="ints[]" value="{{ $int->id }}">
                </div>
            @endforeach
            <input type="hidden" name="action" value="updateInterests">
            {{--<input type="hidden" name="reg_id" value="{{$reg['id']}}">--}}
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="submit" class="hidden" id="submit_interests">
        </form>
        <div class="cleaner"></div>
    </section>
</section>