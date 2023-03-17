@extends('service-desk-jira::layouts.base')
@section('content')

    <ul>
        <li><a href="{{route('tickets.form.index')}}">Create a Ticket</a></li>
        <li><a href="{{route('tickets.view.index')}}">View a Ticket</a></li>
    </ul>

    @if(session('error'))
        <div class="error-message">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

@endsection
