@extends('layouts.master')

@section('title')
    {{ trans('blog::blog.title.blog') }}
@endsection
@section('subTitle')
    {{trans('core::elements.action.edit resource', ['name'=>trans('blog::blog.title.article')])}}
@endsection

@section('content')
    <form class="ui form" role="form" method="POST" action="{{route('backend::blog.article.update', $article->slug)}}">
        <input type="hidden" name="_method" value="PUT">
        {!! csrf_field() !!}

        @include('blog::backend.forms.article')

        <div class="ui basic clearing segment">
            <a href="{{route('backend::blog.article.index')}}" class="ui right floated button">
                {{ trans('core::elements.button.cancel') }}
            </a>
            <button class="ui primary right floated button" type="submit">
                {{ trans('core::elements.button.update') }}
            </button>
        </div>

    </form>

    @include('blog::backend.forms.images')
    @include('blog::backend.forms.files')
@endsection
