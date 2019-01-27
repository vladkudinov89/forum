@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('threads._list')

                {{$threads->render()}}
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        Search Thread
                    </div>
                    <div class="card-body">
                        <form action="/threads/search" method="GET">
                            <input type="text" class="form-control mb-2" placeholder="Input search words" name="q">
                            <button class="btn btn-info">Search</button>
                        </form>
                    </div>
                </div>

                @if(count($trending))
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
