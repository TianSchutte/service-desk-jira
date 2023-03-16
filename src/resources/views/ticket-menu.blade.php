@extends('service-desk-jira::layouts.base')
@section('content')

    <h2>Jira Service Desk Options:</h2>
    <ul>
        <li><a href="{{route('tickets.form.index')}}">Create a Ticket</a></li>
        <li><a href="{{route('tickets.view.index')}}">View a Tickets</a></li>
    </ul>

    @if(session('error'))
        <div class="error-message">
            {{ session('error') }}
        </div>
    @endif

@endsection
