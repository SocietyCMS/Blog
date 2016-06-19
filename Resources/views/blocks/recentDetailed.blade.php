<div class="list-group blog-recent-block">
    @foreach($data as $article)
        <a href="{{route('blog.show', $article->slug)}}"
           class="list-group-item @if($article->pinned) active @endif">
            <h4 class="list-group-item-heading">
                {{$article->title}}
                <small class="text-muted">{{$article->present()->createdAt}} by
                    <b>{{$article->user->present()->fullname}}</b></small>
            </h4>
            <div class="list-group-item-text">{{$article->present()->summary}}</div>
        </a>
    @endforeach
</div>