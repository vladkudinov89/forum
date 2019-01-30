@extends('layouts.app')

@section('head')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create New Thread</div>

                    @if (count($errors))
                        <ul class="alert alert-danger" role="alert">
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    @endif

                    <div class="card-body">
                        <form action="/threads" method="POST">

                            {{csrf_field()}}

                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" class="form-control" name="title" id="title"
                                       value="{{old('title')}}" required>
                                @if($errors->has('title'))
                                    <div class="alert alert-danger">{{$errors->first('title')}}</div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="body">Body:</label>
                                {{-- <textarea class="form-control" required name="body" id="body"
                                          rows="8">{{old('body')}}</textarea> --}}
                                          <wysiwyg-component name="body"></wysiwyg-component>
                                @if($errors->has('body'))
                                    <div class="alert alert-danger">{{$errors->first('body')}}</div>
                                @endif
                            </div>

                            <div class="form-group">
                                <select name="channel_id" id="" class="form-control" required>
                                    <option value="">Choose channel...</option>
                                    @foreach($channels as $channel)
                                        <option value='{{ $channel->id }}'
                                                {{old('channel_id') == $channel->id ? 'selected' : ''}}
                                        >{{ $channel->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <div class="g-recaptcha" data-sitekey="6LccTIwUAAAAAE3urB2JRJL2DtRG7djuSaXv1A7n"></div>
                            </div>


                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Publish</button>
                            </div>

                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
