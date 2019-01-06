{{-- <reply-component :data="{{$reply}}" inline-template v-cloak>
    <div>
        <div id="reply-{{$reply->id}}" class="card-header d-flex justify-content-between">
            <div class="">
                <a href="{{route('profile' , $reply->owner->name)}}">{{$reply->owner->name}}</a>
                said {{$reply->created_at->diffForHumans()}}
            </div>
            @if(Auth::check())
                <favorite-component :reply="{{$reply}}">

                </favorite-component>
            @endif
        </div>

        <div class="card">

            <div class="card-body">
                <div class="body">

                    <div class="body" v-if="editing">

                        <div class="form-group">
                            <textarea v-model="body" class="form-control"></textarea>
                        </div>

                        <button class="btn btn-sm btn-primary" @click="update">Update</button>
                        <button class="btn btn-sm btn-link" @click="editing = false">Cancel</button>

                    </div>

                    <div class="body" v-else v-text="body"></div>
                </div>

            </div>

            @can( 'update' , $reply)
                <div class="card-footer d-flex">
                    <button type="button" class="btn btn-secondary btn-sm mr-2" @click="editing = true">Edit</button>
                    <button type="button" class="btn btn-danger btn-sm" @click="destroy">Delete</button>
                </div>
            @endcan
        </div>
    </div>
</reply-component> --}}