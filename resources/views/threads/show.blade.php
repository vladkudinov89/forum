@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">Thread</div>

                    <div class="card-body">

                        <article>
                            <a href="{{route('profile' ,$thread->creator->name)}}">{{$thread->creator->name}}</a> posted: {{$thread->title}}
                            <div class="body">{{$thread->body}}</div>
                        </article>

                    </div>
                </div>

                <div class="card-header">Replies</div>

                @foreach($replies as $reply)
                    <div class="mb-3">
                        @include('threads/reply')
                    </div>
                @endforeach

                {{$replies->links()}}

                @if(auth()->check())
                    <form method="POST" action="{{$thread->path() . '/replies'}} ">
                        {{csrf_field()}}

                        <div class="form-group">
                        <textarea name="body" id="body" class="form-control"
                                  placeholder="Have something to say?"
                                  rows="5"></textarea>
                        </div>
                        <button type="submit" class="btn btn-info">Post</button>
                    </form>
                @else
                    <p class="text-center">Please <a href="{{route('login')}}">sing in</a> to participate in this
                        discussion.</p>
                @endif

            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-header">

                            <p>This thread was published {{$thread->created_at->diffForHumans() }}
                                by <a href="#">{{$thread->creator->name}}</a>
                                and has {{$thread->replies_count}}
                                {{str_plural('comment' , $thread->replies_count)}}
                                .
                            </p>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
