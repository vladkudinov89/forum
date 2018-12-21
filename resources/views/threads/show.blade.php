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
                    @include('threads/reply')
                @endforeach

            </div>
        </div>

    </div>
@endsection
