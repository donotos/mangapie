@extends ('edit.manga.layout')

@section ('side-top-menu')
    @component ('edit.manga.components.side-top-menu', [
        'manga' => $manga,
        'active' => 'Artist(s)',
        'items' => [
            ['title' => 'Mangaupdates', 'icon' => 'database', 'action' => 'MangaEditController@mangaupdates'],
            ['title' => 'Name(s)', 'icon' => 'globe-americas', 'action' => 'MangaEditController@names'],
            ['title' => 'Description', 'icon' => 'file-text', 'action' => 'MangaEditController@description'],
            ['title' => 'Author(s)', 'icon' => 'pencil', 'action' => 'MangaEditController@authors'],
            ['title' => 'Artist(s)', 'icon' => 'brush', 'action' => 'MangaEditController@artists'],
            ['title' => 'Genre(s)', 'icon' => 'tags', 'action' => 'MangaEditController@genres'],
            ['title' => 'Cover', 'icon' => 'file-image', 'action' => 'MangaEditController@covers'],
            ['title' => 'Type', 'icon' => 'list', 'action' => 'MangaEditController@type'],
            ['title' => 'Year', 'icon' => 'calendar', 'action' => 'MangaEditController@year']
        ]
    ])
    @endcomponent
@endsection

@section ('tab-content')
    <div class="card">
        <div class="card-header">
            Artist(s)
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-6">
                    {{ Form::open(['action' => 'MangaEditController@postArtist']) }}
                    {{ Form::hidden('manga_id', $manga->id) }}
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Name</span>
                        </div>
                        <input class="form-control" name="name" type="text">
                        <div class="input-group-append">
                            <button class="btn btn-primary form-control" type="submit">
                                <span class="fa fa-plus"></span>

                                <span class="d-none d-lg-inline-flex">
                                    &nbsp;Add
                                </span>
                            </button>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>

                <div class="col-12 col-md-6">
                    @if (! empty($manga->artistReferences))
                        <div class="row">
                            @foreach ($manga->artistReferences as $artistReference)
                                <div class="col-12">
                                    {{ Form::open(['action' => 'MangaEditController@deleteArtist', 'method' => 'delete']) }}
                                    {{ Form::hidden('manga_id', $manga->id) }}
                                    {{ Form::hidden('artist_reference_id', $artistReference->id) }}

                                    <div class="input-group form-group">
                                        <div class="input-group-text form-control">
                                            {{ $artistReference->artist->name  }}
                                        </div>
                                        <div class="input-group-append">
                                            <button class="btn btn-danger form-control" type="submit">
                                                <span class="fa fa-times"></span>

                                                <span class="d-none d-lg-inline-flex">
                                                    &nbsp;Remove
                                                </span>
                                            </button>
                                        </div>
                                    </div>

                                    {{ Form::close() }}
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection