@extends('layouts.master')

@section('title')
    {{ trans('blog::blog.title.blog') }}
@endsection
@section('subTitle')
    {{trans('core::elements.action.create resource', ['name'=>trans('blog::blog.title.article')])}}
@endsection

@section('content')
    <form class="ui form" role="form" method="POST" action="{{route('backend::blog.article.store')}}" >
        {!! csrf_field() !!}

        @include('blog::backend.forms.article')

        <div class="ui basic clearing segment">
            <a href="{{route('backend::blog.article.index')}}" class="ui right floated button">
                {{ trans('core::elements.button.cancel') }}
            </a>
            <button class="ui primary right floated button" type="submit">
                {{ trans('core::elements.button.create') }}
            </button>
        </div>

    </form>
@endsection