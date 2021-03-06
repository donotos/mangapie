@section ('title')
    Profile Settings :: Mangapie
@endsection

@extends ('settings.layout')

@section ('tab-content')
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-pills card-header-pills">
                <li class="nav-item">
                    <a class="nav-link" href="{{ URL::action('UserSettingsController@account') }}">Account</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ URL::action('UserSettingsController@visuals') }}">Visuals</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" href="{{ URL::action('UserSettingsController@profile') }}">Profile</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-6">
                    {{ Form::open(['action' => 'AvatarController@put', 'files' => true, 'method' => 'put']) }}

                    <div class="input-group">
                        <div class="custom-file">
                            <input class="custom-file-input" type="file" id="avatar" name="avatar">
                            <label class="custom-file-label" for="avatar">Avatar</label>
                        </div>
                        <div class="input-group-append">
                            <button class="btn btn-primary form-control">
                                <span class="fa fa-check"></span>
                                &nbsp;Set
                            </button>
                        </div>
                    </div>

                    {{ Form::close() }}
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-6">
                    {{ Form::open(['action' => 'UserSettingsController@putAbout', 'method' => 'put']) }}

                    <div class="form-group">
                        <label for="about">About</label>
                        <textarea class="form-control" id="about" name="about" placeholder="Describe yourself..." maxlength="1024" cols="1" rows="5">
                            @if (! empty($user->about))
                                {{ $user->about }}
                            @endif
                        </textarea>

                        <button class="btn btn-primary form-control mt-2" type="submit">
                            <span class="fa fa-check"></span>
                            &nbsp;Set
                        </button>
                    </div>

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section ('scripts')
    {{-- shamelessly copied from https://github.com/twbs/bootstrap/issues/20813#issuecomment-400565761 --}}
    {{--TODO: Truncate with ellipsis on long file name--}}
    <script type="text/javascript">
        $(document).on('change', '.custom-file-input', function () {
            let fileName = $(this).val().replace(/\\/g, '/').replace(/.*\//, '');
            $(this).parent('.custom-file').find('.custom-file-label').text(fileName);
        });
    </script>
@endsection
