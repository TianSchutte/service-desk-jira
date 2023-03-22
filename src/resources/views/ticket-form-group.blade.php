@extends('service-desk-jira::layouts.base')
@section('content')
    <label for="group_request_type">Select a Group:</label>

    <div class="card-list">
        @foreach ($requestTypes as $requestType)
            <a href="{{ route('tickets.form.show', ['id' => $requestType->id]) }}" class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $requestType->name }}</h3>
                </div>
                <div class="card-body">
                    <p class="card-text">{{ $requestType->description }}</p>
                </div>
            </a>

        @endforeach
    </div>

@endsection
