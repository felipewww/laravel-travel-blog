@extends('Site.layouts.app')

@section('header')
    <link rel="stylesheet" type="text/css" href="{!! asset('/Site/css/default_single.css') !!}">
    @endsection

@if($isAdmin)
    @section('adminScript')
        <script>
            window.Laravel = JSON.parse('<?php echo json_encode(['csrfToken' => csrf_token()]); ?>');
        </script>
        <link rel="stylesheet" type="text/css" href="{!! asset('/Painel/js/lib/ContentTools-master/build/content-tools.min.css')  !!}">
        <script type="text/javascript" src="{!! asset('/Painel/js/lib/ContentTools-master/build/content-tools.js')  !!}"></script>
        <script type="text/javascript" src="{!! asset('/Painel/js/client/ContentToolsExtensions.js') !!}"></script>
        <script type="text/javascript" src="{!! asset('/Painel/js/pages/estrutura/city.js') !!}"></script>

        <!-- sweet alert -->
        <link rel="stylesheet" href="/Painel/js/lib/sweetalert-master/dist/sweetalert.css">
        <script type="text/javascript" src="/Painel/js/lib/sweetalert-master/dist/sweetalert.min.js"></script>
        <!-- sweet alert -->
    @endsection
@endif

@section('content')
    {{--{{ dd($reg) }}--}}
    <div class="container">
    {{--@if($isNew)--}}
            <article class="article" id="the-article">
                <section class="article__content"  >

                    <h1 data-fixture data-name="article_title" class="no-margin">
                        @if($isNew)
                            {{ $reg['name'] }}
                        @else
                            @if( isset($reg->content_regions['article_title']['content']) )
                                {{$reg->content_regions['article_title']['content']}}
                            @else
                                {{ $reg['name'] }}
                            @endif
                        @endif
                    </h1>


                    {{--@if($isNew)--}}
                        {{--<p class="breadcrumb">{{ $breadcrumb['continent']['name'] }} > {{  $breadcrumb['country']['name'] }} > {{  $breadcrumb['estate']['name'] }} > {{  $breadcrumb['city']['name'] }} </p>--}}
                    {{--@else--}}
                        {{--<p class="breadcrumb">{{ $breadcrumb['continent']['name'] }} > {{  $breadcrumb['country']['name'] }} > {{  $breadcrumb['estate']['name'] }} > {{  $reg->name }} </p>--}}
                    {{--@endif--}}

                    @if($isNew)
                        <div data-editable data-name="article_content">

                            <h2>Suspendisse quis diam facilisis, laoreet dolor vel</h2>

                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras ut nulla lorem. Etiam sit amet rutrum est. Pellentesque sed aliquet turpis. Etiam vitae quam urna. In quis accumsan sem. Mauris ultricies erat ipsum. Quisque efficitur sollicitudin felis a aliquet. Suspendisse sodales quis magna ut dapibus. Curabitur luctus eget arcu eget dictum. In hac habitasse platea dictumst. Nulla finibus vestibulum feugiat.
                            </p>
                        </div>
                    @else
                        {{--{{dd($reg)}}--}}
                        <div data-editable data-name="article_content">
                            @if( isset($reg->content_regions['article_content']['content']) )
                            {!! $reg->content_regions['article_content']['content'] !!}
                            @else
                            Cidade sem conteúdo.
                            @endif
                        </div>
                    @endif

                </section>
            </article>
        <div class="sidebar-right">
            Sidebar
        </div>
    </div> <!-- ./container -->
@endsection