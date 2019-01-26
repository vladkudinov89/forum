@extends('layouts.app')

@section('content')
    <thread-view inline-template :thread="{{$thread}}">
        <div class="container">
            <div class="row">
                <div class="col-md-8">

                    @include('threads._thread_view')

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
                                            v-if="signedIn"
                                            :active="{{$thread->isSubscribedTo ? 'true' : 'false'}}"></subscribe-button-component>

                                    <button
                                            v-if="autorize('isAdmin')"
                                            @click="toogleLock"
                                            class="btn btn-outline-info"
                                            v-text="locked ? 'Unlock' : 'Lock'"></button>
                                </p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </thread-view>
@endsection
