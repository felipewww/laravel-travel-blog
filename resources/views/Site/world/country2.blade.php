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
        <script type="text/javascript" src="{!! asset('/Painel/js/pages/estrutura/country.js') !!}"></script>

        <!-- sweet alert -->
        <link rel="stylesheet" href="/Painel/js/lib/sweetalert-master/dist/sweetalert.css">
        <script type="text/javascript" src="/Painel/js/lib/sweetalert-master/dist/sweetalert.min.js"></script>
        <!-- sweet alert -->
    @endsection
@endif

@section('content')
    <div class="container">
            <article class="article" id="the-article">
                <section class="article__content"  >

                    <h1 data-fixture data-name="article_title" class="no-margin">
                        @if( isset($reg->content_regions['article_title']['content']) )
                            {{$reg->content_regions['article_title']['content']}}
                        @else
                            {{ $reg['name'] }}
                        @endif
                    </h1>

                    <p class="breadcrumb">{{ $breadcrumb['continent']['name'] }} > {{  $breadcrumb['country']['name'] }} </p>

                    <div data-editable data-name="article_content">
                        @if( isset($reg->content_regions['article_content']['content']) )
                        {!! $reg->content_regions['article_content']['content'] !!}
                        @else
                            <p>
                                País sem conteúdo.
                            </p>
                        @endif
                    </div>

                </section>
            </article>
        <div class="sidebar-right">
            Sidebar
        </div>
    </div> <!-- ./container -->
@endsection