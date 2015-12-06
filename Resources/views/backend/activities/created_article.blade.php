@if($activity->subject->published)
    <div class="event">
        <div class="label">
            <i class="newspaper icon"></i>
        </div>
        <div class="content">
            <div class="summary">
                <a href="#">{{$activity->user->present()->fullname}}</a> published an article, <a href="{{route('blog.show', $activity->subject->slug)}}">{{$activity->subject->title}}</a>
                <div class="date">
                    {{$activity->created_at->diffForHumans()}}
                </div>
            </div>
            <div class="extra text">
                {!! $activity->subject->present()->summary !!}
            </div>
            <div class="meta">
                <a class="info" target="_blank" href="{{route('blog.show', $activity->subject->slug)}}">
                    <i class="info icon"></i> Read more
                </a>
            </div>
        </div>
    </div>
@endif