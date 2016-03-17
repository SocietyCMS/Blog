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

        <div class="ui detail initialize accordion field">
            <div class="title">
                <i class="icon dropdown"></i>
                @lang('core::elements.button.optional details')
            </div>
            <div class="content field">


                <div class="ui segment field">
                    <div class="ui toggle checkbox">
                        <input type='hidden' value='0' name='pinned'>
                        <input type="checkbox" name="pinned" value="1" @if(isset($article) && $article->pinned) checked @endif >
                        <label>@lang('blog::blog.state.pinned')</label>
                    </div>
                </div>

                @include('blog::backend.blog.components.media')
            </div>
        </div>

        <div class="ui basic clearing segment">
            <a href="{{route('backend::blog.article.index')}}" class="ui right floated button">
                {{ trans('core::elements.button.cancel') }}
            </a>
            <button class="ui primary right floated button" type="submit">
                {{ trans('core::elements.button.update') }}
            </button>
        </div>

    </form>


@endsection

@section('javascript')
    <script src="{{\Pingpong\Modules\Facades\Module::asset('blog:js/article.js')}}"></script>
@endsection

@section('styles')
    <link href="{{\Pingpong\Modules\Facades\Module::asset('blog:css/Blog.css')}}" rel="stylesheet" type="text/css">
@endsection
