@extends('layout')

@section ('title')
    Login
@endsection

@section ('content')

<div class="panel panel-default center-block" style="max-width:600px">
    <div class="panel-body">
    {{ Form::open([ 'action' => 'LoginController@login']) }}

        <div class="row input-group col-xs-12 col-sm-6 col-lg-6 center-block">
            {{ Form::label('username', null, ['for' => 'username']) }}
            {{ Form::text('username', null, ['class' => 'form-control']) }}
        </div>
        <div class="row input-group col-xs-12 col-sm-6 col-lg-6 center-block">
            {{ Form::label('password', null, ['for' => 'password']) }}

            {{-- the below doesn't want to display properly *shrug* --}}
            {{-- Form::password('password', null, ['class' => 'form-control', 'type' => 'password']) --}}
            <input name="password" id="password" type="password" class="form-control">
        </div>
        <div class="row">
            <br>
            {{ Form::submit('Login', ['class' => 'btn btn-default center-block', 'type' => 'submit']) }}
        </div>

    {{ Form::close() }}

    @if ($errors->count() > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    </div>
</div>

@endsection

@section ('scripts')

@endsection
