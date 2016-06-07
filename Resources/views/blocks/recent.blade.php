<ul class="list-group">
    @foreach($data as $article)
        <li class="list-group-item"><a href="{{route('blog.show', $article->slug)}}">{{$article->title}}</a></li>
    @endforeach
</ul>