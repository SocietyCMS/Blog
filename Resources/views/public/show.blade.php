@extends('layouts.master')

@section('title')
    {{ $article->title }}
@stop
@section('description')
    {{$article->present()->createdAt}} by <b>{{$article->user->present()->fullname}}</b>
@stop
@section('meta')
    <meta name="title" content="{{ $article->meta_title}}"/>
    <meta name="description" content="{{ $article->meta_description }}"/>
@stop

@if($article->getFirstMedia('cover'))
@section('header')
    <div class="site-header blog-post-header">

        <div class="header-gradient"></div>
        <div class="header-image"
             style="background-image: url({{$article->getFirstMediaUrl('cover', 'large')}}); opacity: 0.7;"></div>

        <div class="container">
            <h1 class="site-title">{{ $article->title }}</h1>
            <p class="lead site-description">{{$article->present()->createdAt}} by
                <b>{{$article->user->present()->fullname}}</b></p>
        </div>
    </div>
@stop
@endif

@section('content')

    <div class="blog-post">

        <p>{!!$article->body!!}</p>

        @if($article->getFirstMedia('files'))
            <div class="list-group">
                @foreach($article->getMedia('files') as $media)
                    <a href="{{$media->getURL()}}" target="_blank" class="list-group-item"><i class="fa fa-file-o"></i> {{$media->file_name}}</a>
                @endforeach
            </div>
        @endif

    </div>
@endsection
