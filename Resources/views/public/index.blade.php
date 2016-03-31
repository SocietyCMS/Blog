@extends('layouts.master')

@section('title')
    {{ trans('blog::blog.title.blog') }}
@stop

@section('content')

    @foreach ($articles as $article)
        <div class="blog-post @if($article->pinned) pinned @endif">
            <h2 class="blog-post-title"><a href="{{route('blog.show', $article->slug)}}">{{$article->title}}</a></h2>
            <p class="blog-post-meta">{{$article->present()->createdAt}} by <b>{{$article->user->present()->fullname}}</b></p>

            @if($article->getFirstMedia('cover'))
                <a href="{{route('blog.show', $article->slug)}}"><img src="{{$article->getFirstMediaUrl('cover', 'medium')}}" class="blog-post-image img-fluid img-rounded"></a>
            @endif

            <p>{!!$article->body!!}</p>
        </div>
    @endforeach

@stop
