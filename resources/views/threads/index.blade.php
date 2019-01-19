@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('threads._list')

                {{$threads->render()}}
            </div>
            @if(count($trending))
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header">
                            Trending Threads
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                @foreach($trending as $trend)
                                    <li class="list-group-item">
                                        <a href="{{ url($trend->path) }}">{{$trend->title}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
