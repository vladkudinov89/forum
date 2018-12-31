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


                @foreach($activites as $date => $activity)
                    <h3>{{$date}}</h3>
                    @foreach($activity as $record)
                        @include("profiles.activities.{$record->type}" , ['activity' => $record])
                    @endforeach
                @endforeach

            </div>
        </div>
    </div>

@endsection