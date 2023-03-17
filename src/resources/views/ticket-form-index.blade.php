@extends('service-desk-jira::layouts.base')
@section('content')
    <label for="group_request_type">Select a Group Type:</label>

    <ul>
        @foreach($typeGroups as $typeGroup)
            <li>
                <a href="{{ route('tickets.form.index.group', ['groupId' => $typeGroup->id]) }}">{{ $typeGroup->name }}</a>
            </li>
        @endforeach

    </ul>

@endsection