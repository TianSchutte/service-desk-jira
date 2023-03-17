@extends('service-desk-jira::layouts.base')
@section('content')

    <ul>
        <li><a href="{{route('tickets.form.index')}}">Create a Ticket</a></li>
        <li><a href="{{route('tickets.view.index')}}">View a Ticket</a></li>
    </ul>

    @include('service-desk-jira::partials.error-message')
    @include('service-desk-jira::partials.success-message')

@endsection
