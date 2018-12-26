

<div class="card-header d-flex justify-content-between">
    <div class="">
        <a href="#">{{$reply->owner->name}}</a> said {{$reply->created_at->diffForHumans()}}
    </div>
    <form method="POST" action="/replies/{{$reply->id}}/favorites">
        {{csrf_field()}}
        <button type="submit" class="btn btn-info" {{$reply->isFavorited() ? "disabled" : ''}}>
            {{$reply->favorites()->count()}} {{str_plural('Favorite' , $reply->favorites()->count())}}
        </button>
    </form>
</div>

<div class="card">
    <div class="card-body">
        <div class="body">{{$reply->body}}</div>
    </div>
</div>