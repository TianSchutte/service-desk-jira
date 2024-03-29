@extends('service-desk-jira::layouts.base')
@section('content')
    <label for="group_request_type">Select a Type:</label>

    <div class="card-list">
        @foreach ($requestTypes as $requestType)
            <a href="{{ route('tickets.form.show', ['id' => $requestType->id]) }}" class="card">

                <div class="card-header">
                    <img src="{{$requestType->icon->_links->iconUrls->{'16x16'} }}" class="card-image" alt="">

                    <h3 class="card-title">{{ $requestType->name }}</h3>
                </div>
                <div class="card-body">
                    <p class="card-text">{{ $requestType->description }}</p>
                </div>
            </a>

        @endforeach
    </div>

@endsection
