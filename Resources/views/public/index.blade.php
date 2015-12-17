@extends('layouts.master')

@section('title')
    Blog
@stop

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                @foreach ($articles as $article)
                    @if($article->pinned)
                        <div class="panel panel-success">
                    @else
                        <div class="panel panel-default">
                    @endif


                        @if($article->getFirstMedia('images'))
                            <a href="{{route('blog.show', $article->slug)}}"><img src="{{$article->getFirstMediaUrl('images', 'cover900')}}" class="article-cover-image" data-holder-rendered="true"></a>
                        @endif

                        <div class="panel-body">
                            <span class="text-muted small"><i class="fa fa-clock-o"></i> {{$article->present()->createdAt}} by <b>{{$article->user->present()->fullname}}</b> </span>

                            <div class="pull-right">
                                @foreach($article->tags as $tag)
                                    <span class="label label-primary label-o">{{$tag->name}}</span>
                                @endforeach
                            </div>


                            <h2><a href="{{route('blog.show', $article->slug)}}">{{$article->title}}</a></h2>
                            <p>{!!$article->present()->summary!!}</p>
                            <a href="{{route('blog.show', $article->slug)}}">read more...</a>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>

    </div>


@stop
