<div class="card" v-if="editing" v-cloak>
    <div class="card-header">
        <input type="text" class="form-control" v-model="form.title">
    </div>

    <div class="card-body">
        <div class="body">
            <textarea class="form-control" rows="10" v-model="form.body"></textarea>
        </div>
    </div>

    <div class="card-footer d-flex justify-content-between">
        <div class="">
            <button class="btn btn-outline-primary" @click="update">Update</button>
            <button class="btn btn-outline-secondary" @click="cancel">Cancel</button>
        </div>

        <div class="">
            @can('update' , $thread)
                <form action="{{$thread->path()}}" method="post">
                    {{csrf_field()}}
                    {{method_field('DELETE')}}
                    <button type="submit" class="btn btn-outline-danger">Delete Thread</button>
                </form>
            @endcan
        </div>
    </div>
</div>

<div class="card" v-else>
    <div class="card-header d-flex justify-content-between align-content-center">
                        <span>
                            <img src="{{$thread->creator->avatar_path}}" alt="{{$thread->creator->name}}"
                                 width="25" height="25" class="mr-1">
                            <a href="{{route('profile' ,$thread->creator->name)}}">{{$thread->creator->name}}</a> posted: <span
                                    v-text="title"></span>
                        </span>

    </div>

    <div class="card-body">

        <article>
            <div class="body" v-text="body"></div>
        </article>

    </div>

    <div class="card-footer" v-if="autorize('updateThread', thread)">
        <button class="btn btn-primary" @click="editing = true">Edit</button>
    </div>
</div>