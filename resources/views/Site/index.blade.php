@extends('Site.template')

@section('content')
    <?php if ( isset($nome) ): ?>
    Olá {{ $nome }}
    {!! $html !!}
    <?php else: ?>
    Home comum
    <?php endif; ?>
@stop