@extends('service-desk-jira::layouts.base')
@section('content')
    <label for="group_request_type">Select a Type:</label>

    <div class="card-list">
        @foreach ($typeGroups as $typeGroup)
            <a href="{{ route('tickets.form.index.group', ['groupId' => $typeGroup->id]) }}" class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $typeGroup->name }}</h3>
                </div>
            </a>
        @endforeach
    </div>
@endsection
