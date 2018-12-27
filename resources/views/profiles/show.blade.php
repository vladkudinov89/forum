@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="pb-2 mt-4 mb-2 border-bottom">
                <h1>{{$profileUser->name}}</h1>
                <p>Since {{$profileUser->created_at->diffForHumans()}}</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-8">



                    @foreach($threads as $thread)
                    <div class="card mb-4">
                        <div class="card-header">
                            {{$profileUser->name}} posted thread: {{$thread->title}}
                            <span class="float-right">{{$thread->created_at->diffForHumans()}}</span>
                        </div>

                        <div class="card-body">
                            <article>
                                <div class="d-flex justify-content-between">
                                    <h4>
                                        <a href="{{$thread->path()}}">{{$thread->title}}</a>
                                    </h4>
                                    <a href="{{$thread->path()}}">{{$thread->replies_count}} {{str_plural('reply' , $thread->replies_count)}}</a>
                                </div>

                                <div class="body">{{$thread->body}}</div>

                            </article>
                        </div>
                    </div>
                @endforeach

                {{$threads->links()}}

            </div>
        </div>
    </div>

@endsection