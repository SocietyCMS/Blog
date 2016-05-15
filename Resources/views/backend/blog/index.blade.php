@extends('layouts.master')

@section('title')
    {{ trans('blog::blog.title.blog') }}
@endsection
@section('subTitle')
    {{ trans('blog::blog.title.all blog posts') }}
@endsection

@section('content')

    <a class="ui primary button" v-on:click="newArticleModal">
        <i class="newspaper icon"></i>
        {{trans('core::elements.action.create resource', ['name'=>trans('blog::blog.title.article')])}}
    </a>

    <table class="ui selectable very compact celled table">
        <thead>
            <tr>
                <th>{{ trans('blog::blog.table.title') }}</th>
                <th>{{ trans('blog::blog.table.author') }}</th>
                <th>{{ trans('blog::blog.table.modified') }}</th>
                <th>{{ trans('blog::blog.table.status') }}</th>
                <th class="collapsing"></th>
            </tr>
        </thead>
        <tbody>
        @foreach ($articles as $article)
            <tr>
                <td>
                    @if($article->pinned)
                        <div class="ui green ribbon label"><i class="pin icon"></i></div>
                    @endif

                    <b><a href="{{route('backend::blog.article.edit',$article->slug)}}">
                            {{$article->title}}
                        </a></b>

                    @if($article->getMedia('cover')->count() > 0)
                        <div class="ui horizontal right floated small label">
                            <i class="camera retro icon"></i> @lang('blog::blog.title.cover')
                        </div>
                    @endif

                    @if($article->getMedia('images')->count() > 0)
                        <div class="ui horizontal right floated small label">
                            <i class="photo icon"></i> @lang('blog::blog.title.photos')
                        </div>
                    @endif
                    @if($article->getMedia('files')->count() > 0)
                        <div class="ui horizontal right floated small label">
                            <i class="file icon"></i> @lang('blog::blog.title.files')
                        </div>
                    @endif
                </td>
                <td>{{ $article->user->present()->fullname }}</td>
                <td>{{$article->present()->updatedAt}}</td>
                <td>
                    @if($article->published)
                        <span class="ui green label">@lang('core::elements.state.published')</span>
                    @else
                        <span class="ui yellow label">@lang('core::elements.state.draft')</span>
                    @endif
                </td>
                <td>
                    <form class="ui form" role="form" method="POST"
                          action="{{route('backend::blog.article.destroy', $article->slug)}}">
                        <input type="hidden" name="_method" value="DELETE">
                        {!! csrf_field() !!}
                        <div class="ui icon top right pointing dropdown button">
                            <i class="wrench icon"></i>

                            <div class="menu">
                                <a class="item"
                                   href="{{route('backend::blog.article.edit', $article->slug)}}">@lang('core::elements.button.edit')</a>
                                <button class="item">@lang('core::elements.button.delete')</button>
                            </div>
                        </div>
                    </form>
                </td>
            </tr>
        @endforeach
        @if($articles->count() == 0)
            <tr class="center aligned">
                <td colspan="5">@lang('blog::blog.messages.no articles')</td>
            </tr>
        @endif
        </tbody>
    </table>


    <div class="ui modal"  id="newArticleModal">
        <div class="header">{{trans('blog::blog.modal.create article')}}</div>
        <div class="content">
            <div class="ui form">
                <div class="ui field">
                    <label>{{ trans('blog::blog.table.title') }}</label>
                    <input type="text" v-model="newArticle.title">
                </div>

                <div class="ui green inverted fluid button" v-on:click="createNewArticle" v-bind:class="{'disabled':!newArticle.title}">
                    <i class="checkmark icon"></i>
                    {{ trans('core::elements.button.create') }}
                </div>

            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script src="{{\Pingpong\Modules\Facades\Module::asset('blog:js/blog.js')}}"></script>
@endsection