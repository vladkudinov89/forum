@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create New Thread</div>

                    <div class="card-body">
                        <form action="/threads" method="POST">

                            {{csrf_field()}}

                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" class="form-control" name="title" id="title">
                            </div>

                            <div class="form-group">
                                <label for="body">Body:</label>
                                <textarea class="form-control" name="body" id="body" rows="8"></textarea>
                            </div>

                            {{--<div class="form-group">--}}
                                {{--<label for="body">Slug:</label>--}}
                                {{--<select name="" id="">--}}
                                    {{--<option value="">1</option>--}}
                                    {{--<option value="">2</option>--}}
                                    {{--<option value="">4</option>--}}
                                {{--</select>--}}
                            {{--</div>--}}

                            <button type="submit" class="btn btn-primary">Publish</button>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
