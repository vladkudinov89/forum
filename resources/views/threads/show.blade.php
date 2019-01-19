@extends('layouts.app')

@section('content')
    <thread-view inline-template :initial-replies-count="{{$thread->replies_count}}">
        <div class="container">
            <div class="row">
                <div class="col-md-8">

                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-content-center">
                        <span>
                            <img src="{{$thread->creator->avatar_path}}" alt="{{$thread->creator->name}}"
                                 width="25" height="25" class="mr-1">
                            <a href="{{route('profile' ,$thread->creator->name)}}">{{$thread->creator->name}}</a> posted: {{$thread->title}}
                        </span>
                            @can('update' , $thread)
                                <form action="{{$thread->path()}}" method="post">
                                    {{csrf_field()}}
                                    {{method_field('DELETE')}}
                                    <button type="submit" class="btn btn-danger">Delete Thread</button>
                                </form>
                            @endcan
                        </div>

                        <div class="card-body">

                            <article>

                                <div class="body">{{$thread->body}}</div>
                            </article>

                        </div>
                    </div>

                    <h3 class="text-center mt-4 mb-4">Replies</h3>
                    <replies-component
                            @removed="repliesCount--"
                            @added="repliesCount++"
                    ></replies-component>

                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header">

                                <p>This thread was published {{$thread->created_at->diffForHumans() }}
                                    by
                                    <a href="{{route('profile' , $thread->creator->name)}}">{{$thread->creator->name}}</a>
                                    and has
                                    <span v-text="repliesCount"></span>
                                    {{str_plural('comment' , $thread->replies_count)}}
                                    .
                                </p>

                                <p>
                                    <subscribe-button-component
                                            :active="{{$thread->isSubscribedTo ? 'true' : 'false'}}"></subscribe-button-component>
                                </p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </thread-view>
@endsection
