@foreach($threads as $thread)
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <div class="">
                    <h4>
                        <a href="{{$thread->path()}}">
                            @if(auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                                <strong>{{$thread->title}}</strong>
                            @else
                                {{$thread->title}}
                            @endif
                        </a>
                    </h4>
                    <h6>Posted by:
                        <a href="{{route('profile' , $thread->creator)}}">{{ $thread->creator->name }}</a>
                    </h6>
                </div>
                <a href="{{$thread->path()}}">{{$thread->replies_count}} {{str_plural('reply' , $thread->replies_count)}}</a>
            </div>

        </div>

        <div class="card-body">


            <article>

                <div class="body">{{$thread->body}}</div>

            </article>

        </div>

        <div class="card-footer">
            {{ $thread->visits() }} Visits
        </div>
    </div>
@endforeach