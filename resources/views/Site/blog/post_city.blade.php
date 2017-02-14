@extends('Site.layouts.app')

@section('header')
    <link rel="stylesheet" type="text/css" href="{!! asset('/Site/css/default_single.css') !!}">
    @endsection

@if($isAdmin)
    @section('adminScript')
        <script>window.Laravel = JSON.parse('<?php echo json_encode(['csrfToken' => csrf_token()]); ?>');</script>
        <link rel="stylesheet" type="text/css" href="{!! asset('/Painel/js/lib/ContentTools-master/build/content-tools.min.css')  !!}">
        <script type="text/javascript" src="{!! asset('/Painel/js/lib/ContentTools-master/build/content-tools.js')  !!}"></script>
        <script type="text/javascript" src="{!! asset('/Painel/js/client/ContentToolsExtensions.js') !!}"></script>
        <script type="text/javascript" src="{!! asset('/Painel/js/pages/blog/post.js') !!}"></script>

        <!-- sweet alert -->
        <link rel="stylesheet" href="/Painel/js/lib/sweetalert-master/dist/sweetalert.css">
        <script type="text/javascript" src="/Painel/js/lib/sweetalert-master/dist/sweetalert.min.js"></script>
        <!-- sweet alert -->
    @endsection
@endif

@section('content')
    <div class="container">
    {{--@if($isNew)--}}
        <div id="topo">
            <h1 data-test="asd" data-fixture data-name="article_title" class="no-margin">
            @if($isNew)
                O título do novo post....
            @else
                {{ $post->managed_regions['article_title']['content'] }}
            @endif
            </h1>
        </div>
            <article class="article" id="the-article">
                <section class="article__content"  >
                    {{--{{ dd(get_defined_vars()) }}--}}
                    <p class="breadcrumb">{{ $breadcrumb['continent']['name'] }} > {{  $breadcrumb['country']['name'] }} > {{  $breadcrumb['estate']['name'] }} > {{  $breadcrumb['city']['name'] }}</p>

                    @if($isNew)
                        <div data-editable data-name="article_content">
                            <p class="article__by-line">
                                por <b>Anthony Blackshaw</b> · 18th January 2015
                            </p>

                            <h2>Suspendisse quis diam facilisis, laoreet dolor vel</h2>

                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras ut nulla lorem. Etiam sit amet rutrum est. Pellentesque sed aliquet turpis. Etiam vitae quam urna. In quis accumsan sem. Mauris ultricies erat ipsum. Quisque efficitur sollicitudin felis a aliquet. Suspendisse sodales quis magna ut dapibus. Curabitur luctus eget arcu eget dictum. In hac habitasse platea dictumst. Nulla finibus vestibulum feugiat.
                            </p>
                        </div>
                    @else
                        <div data-editable data-name="article_content">
                            {!! $post->managed_regions['article_content']['content'] !!}
                        </div>
                    @endif

                </section>

                @if($isNew)
                    <div data-editable data-name="teste_1">
                        <p>Regions de teste 1</p>
                    </div>
                @else
                    @if( isset($post->managed_regions['teste_1']) )
                        <div data-editable data-name="teste_1">
                            <p>{!! $post->managed_regions['teste_1']['content'] !!}</p>
                        </div>
                    @endif
                @endif

                @if( isset($post->managed_regions['teste_2']) )
                    <div data-editable data-name="teste_2">
                        <p>{!! $post->managed_regions['teste_2']['content'] !!}</p>
                    </div>
                @endif
                {{--<div data-editable>--}}
                    {{--<p data-name="teste_1">region teste_1</p>--}}
                    {{--<p data-name="teste_2">region teste_2</p>--}}
                    {{--<p data-name="teste_3">region teste_3</p>--}}
                {{--</div>--}}
            </article>
        {{--@else--}}
            {{--<div class="article" id="the-article">--}}
                {{--aqui vem o post para editar...--}}
            {{--</div>--}}
        {{--@endif--}}
        <div class="sidebar-right">

        </div>
    </div> <!-- ./container -->
@endsection