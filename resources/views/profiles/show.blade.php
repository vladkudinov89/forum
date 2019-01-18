@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="pb-2 mt-4 mb-2 border-bottom">
                <h1>{{$profileUser->name}}</h1>
                <p>Since {{$profileUser->created_at->diffForHumans()}}</p>

                @can('update' , $profileUser)
                    <form action="{{route('avatar' ,$profileUser )}}" method="POST"
                    enctype="multipart/form-data">
                        {{csrf_field()}}

                        <input type="file" name="avatar">

                        <button type="submit" class="btn btn-info">Add Avatar</button>
                    </form>
                    @endcan

                <img src="{{asset('storage/' . $profileUser->avatar_path)}}"
                     width="50" height="50" alt="">
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