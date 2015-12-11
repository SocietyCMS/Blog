@extends('layouts.master')

@section('title')
    {{ $article->title }} | @parent
@stop
@section('meta')
    <meta name="title" content="{{ $article->meta_title}}" />
    <meta name="description" content="{{ $article->meta_description }}" />
@stop

@section('content')

    <div class="row">
        <div class="text-center article-title">

            <div class="pull-right">
                @foreach($article->tags as $tag)
                    <span class="label label-primary label-o">{{$tag->name}}</span>
                @endforeach
            </div>

            <div class="clearfix"></div>

            <span class="text-muted"><i class="fa fa-clock-o"></i> {{$article->present()->updatedAt}} by <b>{{$article->user->present()->fullname}}</b></span>
            <h1>{{ $article->title }}</h1>

        </div>


        {!! $article->body !!}

        @if($article->getFirstMedia('images'))
            <hr>

            <div class="row">
                @foreach($article->getMedia('images') as $media)
                    <div class="col-xs-6 col-md-3">
                        <div class="text-center">
                            <a href="{{$media->getUrl()}}" data-lightbox="{{$article->title}}" data-title="{{$article->title}}" >
                                <img alt="100%x180" src="{{$media->getUrl('original180')}}" data-holder-rendered="true" class="img-thumbnail">
                            </a>
                        </div>
                    </div>
                @endforeach

            </div>
        @endif


        @if($article->getFirstMedia('files'))
            <hr>

            <div class="list-group">
                @foreach($article->getMedia('files') as $media)
                    <a href="#" class="list-group-item"><i class="fa fa-file-o"></i> {{$media->file_name}}</a>
                @endforeach
            </div>
        @endif

    </div>
@stop
