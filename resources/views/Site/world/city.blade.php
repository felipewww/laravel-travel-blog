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
    {{--{{ dd($city) }}--}}
    <div class="container">
    @if($isNew)
            <article class="article" id="the-article">
                <section class="article__content"  >

                    <h1 data-fixture data-name="article-title" class="no-margin">
                        {{ $city['name'] }}
                    </h1>

                    <p class="breadcrumb">{{  $continent['name'] }} > {{  $country['name'] }} > {{  $estate['name'] }} > {{  $city['name'] }}</p>

                    <div data-editable data-name="article">
                        <p class="article__by-line">
                            por <b>Anthony Blackshaw</b> · 18th January 2015
                        </p>

                        <h2>Suspendisse quis diam facilisis, laoreet dolor vel</h2>

                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras ut nulla lorem. Etiam sit amet rutrum est. Pellentesque sed aliquet turpis. Etiam vitae quam urna. In quis accumsan sem. Mauris ultricies erat ipsum. Quisque efficitur sollicitudin felis a aliquet. Suspendisse sodales quis magna ut dapibus. Curabitur luctus eget arcu eget dictum. In hac habitasse platea dictumst. Nulla finibus vestibulum feugiat.
                        </p>
                    </div>

                </section>
            </article>
        @else
            <div class="article" id="the-article">
                {!! $city['content'] !!}
            </div>
        @endif
        <div class="sidebar-right">

        </div>
    </div> <!-- ./container -->
@endsection