@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @foreach($threads as $thread)
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h4>
                                <a href="{{$thread->path()}}">{{$thread->title}}</a>
                            </h4>
                            <a href="{{$thread->path()}}">{{$thread->replies_count}} {{str_plural('reply' , $thread->replies_count)}}</a>
                        </div>

                    </div>

                    <div class="card-body">



                            <article>

                                <div class="body">{{$thread->body}}</div>

                            </article>

                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
