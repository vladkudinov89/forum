@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Thread</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <article>
                            <a href="#">{{$thread->creator->name}}</a> posted: {{$thread->title}}
                            <div class="body">{{$thread->body}}</div>
                        </article>

                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card-header">Replies</div>


                @foreach($thread->replies as $reply)
                    <div class="mb-3">
                        @include('threads/reply')
                    </div>
                @endforeach


            </div>
        </div>

        @if(auth()->check())
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <form method="POST" action="{{$thread->path() . '/replies'}} ">
                        {{csrf_field()}}

                        <div class="form-group">
                        <textarea name="body" id="body" class="form-control"
                                  placeholder="Have something to say?"
                                  rows="5"></textarea>
                        </div>
                        <button type="submit" class="btn btn-info">Post</button>
                    </form>

                </div>
            </div>
        @else
            <p class="text-center">Please <a href="{{route('login')}}">sing in</a> to participate in this discussion.</p>
        @endif

    </div>
@endsection
