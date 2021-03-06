@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <div class="pb-2 mt-4 mb-2 border-bottom">
            <avatar-component :user="{{$profileUser}}"></avatar-component>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-8">


            @foreach($activites as $date => $activity)
            <h3>{{$date}}</h3>
            @foreach($activity as $record)
            @if (view()->exists("profiles.activities.{$record->type}"))
            @include("profiles.activities.{$record->type}" , ['activity' => $record])
            @endif
            @endforeach
            @endforeach

        </div>
    </div>
</div>

@endsection