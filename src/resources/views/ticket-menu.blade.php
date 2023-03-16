@extends('service-desk-jira::layouts.base')
@section('content')

    <h2>Jira Service Desk Options:</h2>
    <ul>
        <li><a href="{{route('tickets.choose')}}">Create a Ticket</a></li>
        <li><a href="{{route('tickets.index')}}">View a Tickets</a></li>
    </ul>

{{--    --}}
{{--    @dump(session('error'))--}}


{{--    @if(isset($error))--}}
{{--        @dump($error)--}}
{{--    @endif--}}

{{--    @if(session('error'))--}}
{{--        <div class="error-message">--}}
{{--            {{ session('error') }}--}}
{{--        </div>--}}
{{--    @endif--}}

@endsection
