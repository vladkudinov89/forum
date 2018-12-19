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
                            <h4>{{$thread->title}}</h4>
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
                    <div class="card-header"><a href="#">{{$reply->owner->name}}</a> said {{$reply->created_at->diffForHumans()}}</div>
                    <div class="card">
                        <div class="card-body">
                            <div class="body">{{$reply->body}}</div>
                        </div>
                    </div>

                @endforeach

            </div>
        </div>

    </div>
@endsection
