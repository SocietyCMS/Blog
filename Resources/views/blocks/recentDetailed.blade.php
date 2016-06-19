<div class="list-group blog-recent-block">
    @foreach($data as $article)
        <a href="{{route('blog.show', $article->slug)}}"
           class="list-group-item @if($article->pinned) active @endif">
            <div class="list-group-item-heading">
                {{$article->title}}
            </div>
            <div class="list-group-item-text">{{$article->present()->createdAt}} by
                <b>{{$article->user->present()->fullname}}</b></div>
            <div class="list-group-item-text">{{$article->present()->summary}}</div>
        </a>
    @endforeach
</div>