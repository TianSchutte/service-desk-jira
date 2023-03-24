@extends('service-desk-jira::layouts.base')
@section('content')

    @if(isset($actions))
        <div class="card-list">
            @foreach($actions as $action)
                <a class="card" href="{{ $action['url'] }}">
                    <div class="card-header">
                        <h3 class="card-title">{{ $action['name'] }}</h3>
                    </div>
                </a>
            @endforeach
        </div>
    @endif

    @include('service-desk-jira::partials.error-message')
    @include('service-desk-jira::partials.success-message')

    <div class="footer-email-container">
        @if($user_email)
            <p class="success-message">(logged in as <strong>{{ $user_email}}</strong>)</p>
        @else
            <p class="error-message">(not logged in)</p>
        @endif
    </div>
@endsection
