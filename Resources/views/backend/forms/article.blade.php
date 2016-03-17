<div class="required field {{ $errors->has('title') ? 'error' : '' }}">
    <label>@lang('blog::blog.form.title')</label>
    <input type="text"
           id="title"
           name="title"
           value="{{ old('title', isset($article)?$article->title:null) }}">

    {!! $errors->first('title', '<div class="ui error message">:message</div>') !!}

</div>

<div class="required field {{ $errors->has('body') ? 'error' : '' }}">
    <label>@lang('blog::blog.form.content')</label>
    <div id="editor">
        {!! old('content', isset($article)?$article->body:null) !!}
    </div>
    {!! $errors->first('body', '<div class="ui error message">:message</div>') !!}
</div>

<div class="ui segment field">
    <div class="ui toggle checkbox">
        <input type="checkbox" name="published" value="1" @if(isset($article) && $article->published) checked @endif >
        <label>@lang('core::elements.change state.publish')</label>
    </div>
</div>
