<div id="reply-{{$reply->id}}" class="card-header d-flex justify-content-between">
    <div class="">
        <a href="{{route('profile' , $reply->owner->name)}}">{{$reply->owner->name}}</a>
        said {{$reply->created_at->diffForHumans()}}
    </div>
    <form method="POST" action="/replies/{{$reply->id}}/favorites">
        {{csrf_field()}}
        <button type="submit" class="btn btn-info" {{$reply->isFavorited() ? "disabled" : ''}}>
            {{$reply->favorites_count}} {{str_plural('Favorite' , $reply->favorites_count)}}
        </button>
    </form>
</div>

<div class="card">
    <div class="card-body">
        <div class="body">{{$reply->body}}</div>
    </div>
    @can( 'update' , $reply)
        <div class="card-footer">
            <form method="post" action="/replies/{{$reply->id}}">
                {{csrf_field()}}
                {{method_field('DELETE')}}

                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            </form>
        </div>
    @endcan
</div>